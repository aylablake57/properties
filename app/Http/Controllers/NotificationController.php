<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $user = Auth::user();

        $notification = $user->notifications()->find($id);
        if ($notification && $notification->read_at) {
            return response()->json(['isAlreadyMarked' => true, 'count' => $user->unreadNotifications->count()]);
        }

        if ($notification) {
            $notification->markAsRead();
            return redirect()->back()->with(['success', 'Notification marked as read.', 'isAlreadyMarked' => false, 'count' => $user->unreadNotifications->count()]);
        }

        return redirect()->back()->with('error', 'Notification not found.');
    }

    public function clearAll()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'Read all notifications.');
    }
}
