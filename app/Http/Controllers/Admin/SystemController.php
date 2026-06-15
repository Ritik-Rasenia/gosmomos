<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\ApiToken;
use Illuminate\Support\Str;

class SystemController extends Controller
{
    /**
     * Clear application cache.
     */
    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');

        return back()->with('success', 'System cache, configuration, routes, and compiled views cleared successfully!');
    }

    /**
     * Export complete database backup in SQL format.
     */
    public function exportBackup()
    {
        try {
            $tables = [];
            $result = DB::select('SHOW TABLES');
            
            foreach ($result as $row) {
                $rowArray = (array)$row;
                $tables[] = reset($rowArray);
            }

            $sql = "-- Gosmomos Production Database Backup\n";
            $sql .= "-- Generated: " . now()->toDateTimeString() . "\n";
            $sql .= "-- PHP Version: " . phpversion() . "\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

            foreach ($tables as $table) {
                $sql .= "-- --------------------------------------------------------\n";
                $sql .= "-- Table structure for table `{$table}`\n";
                $sql .= "-- --------------------------------------------------------\n";
                $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
                
                $createTable = DB::select("SHOW CREATE TABLE `{$table}`");
                $createTableArray = (array)$createTable[0];
                $sql .= $createTableArray['Create Table'] . ";\n\n";

                $sql .= "-- Dumping data for table `{$table}`\n";
                $rows = DB::table($table)->get();
                
                if ($rows->count() > 0) {
                    foreach ($rows as $row) {
                        $rowArray = (array)$row;
                        $keys = array_map(function($key) { return "`{$key}`"; }, array_keys($rowArray));
                        $values = array_map(function($value) {
                            if (is_null($value)) return "NULL";
                            // Avoid escaping issues
                            $escaped = str_replace(array("\\", "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $value);
                            return "'{$escaped}'";
                        }, array_values($rowArray));

                        $sql .= "INSERT INTO `{$table}` (" . implode(', ', $keys) . ") VALUES (" . implode(', ', $values) . ");\n";
                    }
                }
                $sql .= "\n\n";
            }

            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
            $filename = 'gosmomos-backup-' . now()->format('Y-m-d-His') . '.sql';

            return response($sql, 200, [
                'Content-Type' => 'application/sql',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    /**
     * Toggle application maintenance mode.
     */
    public function toggleMaintenance(Request $request)
    {
        $isDown = app()->isDownForMaintenance();

        if ($isDown) {
            Artisan::call('up');
            $status = 'disabled';
        } else {
            // Lock down with a secret token for admins to access
            Artisan::call('down', [
                '--secret' => 'gosadmin123',
            ]);
            $status = 'enabled';
        }

        return back()->with('success', "Maintenance mode {$status} successfully! (Admin bypass secret: 'gosadmin123')");
    }

    /**
     * Display API Tokens interface.
     */
    public function apiTokens()
    {
        $tokens = ApiToken::latest()->get();
        return view('admin.system.tokens', compact('tokens'));
    }

    /**
     * Generate a new API token.
     */
    public function generateApiToken(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $rawToken = 'gos_' . Str::random(40);

        ApiToken::create([
            'name' => $request->name,
            'token' => hash('sha256', $rawToken),
            'is_active' => true,
        ]);

        // Flashing raw token to user only once!
        return back()->with([
            'success' => 'API Token generated successfully!',
            'raw_token' => $rawToken,
        ]);
    }

    /**
     * Revoke / Delete API token.
     */
    public function revokeApiToken($id)
    {
        $token = ApiToken::findOrFail($id);
        $token->delete();

        return back()->with('success', 'API Token revoked and deleted successfully!');
    }

    /**
     * Display all notifications for the authenticated admin.
     */
    public function notifications(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $query = \App\Models\Notification::where('user_id', auth()->id());

        if ($filter === 'unread') {
            $query->unread();
        } elseif ($filter === 'read') {
            $query->read();
        }

        $notifications = $query->latest()->paginate(15);
        return view('admin.notifications.index', compact('notifications', 'filter'));
    }
}
