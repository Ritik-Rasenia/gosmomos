<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings');
    }

    public function update(Request $request)
    {
        $settings = $request->except(['_token', 'logo', 'logo_dark', 'favicon', 'og_image']);

        // 1. Process Text-Based Settings
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
            
            // Bust cache
            Cache::forget("settings.{$key}");
        }

        // 2. Process File Uploads (Logo, Favicon, OG Image)
        $fileKeys = ['logo', 'logo_dark', 'favicon', 'og_image'];
        foreach ($fileKeys as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                
                // Store in public/uploads/branding folder
                $filename = $fileKey . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/branding'), $filename);
                $filePath = '/uploads/branding/' . $filename;

                // Save old path to delete if exists
                $oldSetting = Setting::where('key', $fileKey)->first();
                if ($oldSetting && $oldSetting->value && file_exists(public_path($oldSetting->value))) {
                    @unlink(public_path($oldSetting->value));
                }

                Setting::updateOrCreate(
                    ['key' => $fileKey],
                    [
                        'value' => $filePath,
                        'type' => 'file',
                        'group' => $fileKey === 'og_image' ? 'seo' : 'general'
                    ]
                );

                // Bust cache
                Cache::forget("settings.{$fileKey}");
            }
        }

        return back()->with('success', 'System settings updated successfully!');
    }
}
