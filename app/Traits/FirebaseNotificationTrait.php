<?php

namespace App\Traits;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use App\Models\User;

trait FirebaseNotificationTrait
{
    /**
     * Gửi thông báo đến người dùng thông qua Firebase Cloud Messaging.
     *
     * @param int $userId
     * @param string $title
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendNotification($userId, $title, $message)
    {
        // Tìm người dùng theo ID
        $user = User::find($userId);

        // Kiểm tra người dùng và token FCM
        if (!$user || !$user->fcm_token) {
            return response()->json(['message' => 'User not found or FCM token missing'], 404);
        }

        // Tạo đối tượng Factory và Messaging
        $factory = (new Factory)->withServiceAccount('D:\\web\\OSPanel\\domains\\firebase\\firebase_credentials.json');

        $messaging = $factory->createMessaging();

        // Tạo thông báo CloudMessage
        $notification = CloudMessage::withTarget('token', $user->fcm_token)
            ->withNotification([
                'title' => $title,
                'body' => $message
            ])
            ->withData([
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
            ]);

        try {
            // Gửi thông báo đến Firebase
            $messaging->send($notification);

            return response()->json(['message' => 'Notification sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send notification', 'error' => $e->getMessage()], 500);
        }
    }
}
