<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the notifications for the current shop.
     */
    public function index()
    {
        $notifications = Notification::orderBy('id', 'desc')->get();
        $unreadCount = Notification::where('is_read', false)->count();

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'unreadCount' => Notification::where('is_read', false)->count()
        ]);
    }

    /**
     * Delete a single notification.
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json([
            'success' => true,
            'unreadCount' => Notification::where('is_read', false)->count()
        ]);
    }

    /**
     * Delete all notifications for the current shop.
     */
    public function destroyAll()
    {
        Notification::query()->delete();

        return response()->json([
            'success' => true,
            'unreadCount' => 0
        ]);
    }
}
