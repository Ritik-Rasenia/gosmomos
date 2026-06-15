<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markRead($id)
    {
        $notif = Notification::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $notif->markAsRead();
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $notif = Notification::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $notif->delete();
        return response()->json(['success' => true]);
    }

    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())->whereNull('read_at')->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }
}
