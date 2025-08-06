<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Display a paginated list of user notifications.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications()->latest()->paginate(20);
        $unreadCount = $user->unreadNotifications()->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Mark all unread notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        $user = $request->user();
        $user->unreadNotifications->markAsRead();

        return back()->with('status', 'All notifications marked as read.');
    }

    /**
     * Mark a single notification as read.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        // If your notification has an action URL, you can redirect:
        // $redirectUrl = $notification->data['action_url'] ?? null;
        // return $redirectUrl ? redirect($redirectUrl) : back()->with('status', 'Notification marked as read.');

        return back()->with('status', 'Notification marked as read.');
    }
}
