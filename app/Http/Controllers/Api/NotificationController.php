<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(Request $request)
{
    try {
        $notifications = Notification::paginate(10);

        if ($notifications->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'success' => true,
                'message' => 'No notifications found',
                'data' => []
            ], 200);
        }

        return successResponse('Notifications retrieved successfully', $notifications);
    } catch (\Exception $e) {
        return queryErrorResponse('Failed to retrieve notifications', $e->getMessage());
    }
}

    public function markAsRead(Request $request, $notificationId)
    {
        try {
            $notification = $request->user()->notifications()->findOrFail($notificationId);
            $notification->markAsRead();

            return successResponse('Notification marked as read');
        } catch (\Exception $e) {
            return queryErrorResponse('Failed to mark notification as read', $e->getMessage());
        }
    }

    public function markAsUnread(Request $request, $notificationId)
    {
        try {
            $notification = $request->user()->notifications()->findOrFail($notificationId);
            $notification->markAsUnread();

            return successResponse('Notification marked as unread');
        } catch (\Exception $e) {
            return queryErrorResponse('Failed to mark notification as unread', $e->getMessage());
        }
    }

    public function destroy(Request $request, $notificationId)
    {
        try {
            $notification = $request->user()->notifications()->findOrFail($notificationId);
            $notification->delete();

            return deleteResponse('Notification deleted successfully');
        } catch (\Exception $e) {
            return queryErrorResponse('Failed to delete notification', $e->getMessage());
        }
    }
}
