<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Log;

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
     * Send notification to device(s) or topic
     */
    public function sendNotification(
        $target, // Changed to mixed type to accept string or collection
        string $title,
        string $body,
        array $payload = [],
        bool $isTopic = false
    ): bool {
        Log::info('FirebaseService: Starting notification send', [
            'target_type' => gettype($target),
            'target_value' => $target,
            'title' => $title,
            'is_topic' => $isTopic
        ]);

        // Handle multiple tokens (collection/array)
        if (is_array($target) || $target instanceof \Illuminate\Support\Collection) {
            return $this->sendToMultipleTokens($target, $title, $body, $payload);
        }

        // Handle single token or topic
        return $this->sendToSingleTarget($target, $title, $body, $payload, $isTopic);
    }

    /**
     * Send notification to multiple device tokens
     */
    private function sendToMultipleTokens($tokens, string $title, string $body, array $payload = []): bool
    {
        $tokens = is_array($tokens) ? $tokens : $tokens->toArray();

        Log::info('FirebaseService: Sending to multiple tokens', [
            'token_count' => count($tokens),
            'tokens' => $tokens
        ]);

        $successCount = 0;
        $failureCount = 0;

        foreach ($tokens as $token) {
            if (empty($token)) {
                Log::warning('FirebaseService: Empty token skipped');
                continue;
            }

            $success = $this->sendToSingleTarget($token, $title, $body, $payload, false);

            if ($success) {
                $successCount++;
            } else {
                $failureCount++;
            }
        }

        Log::info('FirebaseService: Multiple token send completed', [
            'success_count' => $successCount,
            'failure_count' => $failureCount,
            'total_tokens' => count($tokens)
        ]);

        return $successCount > 0; // Return true if at least one succeeded
    }

    /**
     * Send notification to single target (token or topic)
     */
    private function sendToSingleTarget(string $target, string $title, string $body, array $payload = [], bool $isTopic = false): bool
    {
        Log::info('FirebaseService: Sending to single target', [
            'target' => $target,
            'target_length' => strlen($target),
            'is_topic' => $isTopic,
            'title' => $title
        ]);

        $message = CloudMessage::new()
            ->withNotification(Notification::create($title, $body))
            ->withData($payload);

        // Set target (device token or topic)
        if ($isTopic) {
            $message = $message->withChangedTarget('topic', $target);
        } else {
            $message = $message->withChangedTarget('token', $target);
        }

        try {
            $result = $this->messaging->send($message);

            Log::info('FirebaseService: Message sent successfully', [
                'target' => $target,
                'result' => $result
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('FirebaseService: FCM Error', [
                'target' => $target,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'target_length' => strlen($target)
            ]);
            return false;
        }
    }
}
