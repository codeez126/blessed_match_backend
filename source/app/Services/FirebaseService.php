<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(storage_path('app/firebase/asan-match-firebase-adminsdk-fbsvc-ccab44d0b4.json'));

        $this->messaging = $firebase->createMessaging();
    }

    /**
     * Send notification to a device or topic
     */
    public function sendNotification(
        string $target,
        string $title,
        string $body,
        array $payload = [],
        bool $isTopic = false
    ): bool {
        $message = CloudMessage::new()
            ->withNotification(Notification::create($title, $body))
            ->withData($payload);

        // Set target (device token or topic)
        if ($isTopic) {
            $message = $message->withChangedTarget('topic', $target); // For topics
        } else {
            $message = $message->withChangedTarget('token', $target); // For device tokens
        }

        try {
            $this->messaging->send($message);
            return true;
        } catch (\Exception $e) {
            logger()->error('FCM Error: ' . $e->getMessage());
            return false;
        }
    }
}
