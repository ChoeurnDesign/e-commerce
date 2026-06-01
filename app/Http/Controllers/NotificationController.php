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

        // Exclude chat_message type — those belong in the chat section
        $notifications = $user->notifications()
            ->whereRaw("COALESCE(JSON_UNQUOTE(JSON_EXTRACT(data, '$.type')), '') != 'chat_message'")
            ->latest()
            ->paginate(20);

        $unreadCount = $user->unreadNotifications()
            ->whereRaw("COALESCE(JSON_UNQUOTE(JSON_EXTRACT(data, '$.type')), '') != 'chat_message'")
            ->count();

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

        $url = $notification->data['url'] ?? null;
        return $url ? redirect($url) : back()->with('status', 'Notification marked as read.');
    }
}
