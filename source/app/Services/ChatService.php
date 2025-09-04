<?php

namespace App\Services;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\DeviceToken;
use App\Models\Media;
use App\Models\Notification;
use App\Models\RoomUser;
use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Workerman\Mqtt\Client;


class ChatService
{
    protected FirebaseService $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }


    public function joinRoom(mixed $data, Client $mqtt)
    {
        $validator = Validator::make($data, [
            'room_id' => 'required_without_all:auth_user_id,receiver_id',
            'auth_user_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'token' => 'required'
        ]);
        if ($validator->fails()) {
            $mqtt->publish("chat/{$data['auth_user_id']}/error", json_encode([
                'success' => false,
                'message' => $validator->errors()->first()
            ]));
            return;
        }
        try {
            $user = User::find($data['auth_user_id']);
            $receiver = User::find($data['receiver_id']);


            //ChatRoom
            if (!empty($data['room_id'])) {
                $chatRoom = ChatRoom::find($data['room_id']);
            } else {
                $chatRoom = ChatRoom::where(function ($query) use ($user, $receiver) {
                    $query->where(function ($subQuery) use ($user, $receiver) {
                        $subQuery->where('auth_user_id', $user->id)
                            ->where('receiver_id', $receiver->id);
                    })->orWhere(function ($subQuery) use ($user, $receiver) {
                        $subQuery->where('auth_user_id', $receiver->id)
                            ->where('receiver_id', $user->id);
                    });
                })->first();

                if (empty($chatRoom)) {
                    $chatRoom = ChatRoom::create([
                        'auth_user_id' => $data['auth_user_id'],
                        'receiver_id' => $data['receiver_id'],
                        'name' => $data['auth_user_id'] . '-' . $data['receiver_id'],
                    ]);
                }
            }
            $mqtt->publish("chat/{$data['auth_user_id']}/room-joined", json_encode([
                'success' => true,
                'message' => 'Room ' . $chatRoom->id . ' joined',
                'topic' => "chat/rooms/{$chatRoom->id}",
                'data' => $chatRoom
            ]));
            echo "joined " . $chatRoom->id . "\n";

            RoomUser::updateOrCreate([
                'user_id' => $user->id,
                'chat_room_id' => $chatRoom->id
            ], ['is_online' => 1]);
            $receiverOnlineStatus = RoomUser::firstOrCreate([
                'user_id' => $receiver->id,
                'chat_room_id' => $chatRoom->id
            ]);
            ChatRoom::find($chatRoom->id)
                ->chatMessages()
                ->where('receiver_id', $user->id)
                ->update(['is_read' => 1]);

            $mqtt->publish("chat/presence/{$user->id}", json_encode([
                'is_online' => 1
            ]));
            $mqtt->publish("chat/presence/{$receiver->id}", json_encode([
                'is_online' => $receiverOnlineStatus->is_online
            ]));

            $receiverConversations = $this->getConversations($receiver->id);
            $senderConversations = $this->getConversations($user->id);

            $mqtt->publish("chat/{$user->id}/conversations", json_encode($senderConversations));
            $mqtt->publish("chat/{$receiver->id}/conversations", json_encode($receiverConversations));

            $mqtt->publish("chat/{$receiver->id}/seen", json_encode(['is_read' => 1]));

        } catch (\Exception $e) {
            Log::emergency($e->getMessage());
            echo $e->getMessage() . $e->getLine() . "\n";
            $mqtt->publish("chat/{$data['auth_user_id']}/error", json_encode([
                'success' => false,
                'message' => $e->getMessage() . ' Line ' . $e->getLine() . "\n"
            ]));
        }
    }

    public function sendMessage(mixed $data, Client $mqtt)
    {
        $validator = Validator::make($data, [
            'room_id' => 'required|integer|exists:chat_rooms,id',
            'type' => 'required|integer',
            'message' => 'required_without:attachment_id|string',
            'attachment_id' => 'required_without:message',
            'sender_id' => 'required|integer|exists:users,id',
            'receiver_id' => 'nullable|integer|exists:users,id'
        ]);
        if ($validator->fails()) {
            $mqtt->publish("chat/{$data['sender_id']}/error", json_encode([
                'success' => false,
                'message' => $validator->errors()->first()
            ]));
            return;
        }
        try {
            $chatRoom = ChatRoom::find($data['room_id']);
            if (!$chatRoom) {
                $mqtt->publish("chat/{$data['sender_id']}/error", json_encode([
                    'success' => false,
                    'message' => 'Chat room not found'
                ]));
                return;
            }
            $offlineUsers = RoomUser::where('chat_room_id', $data['room_id'])
                ->where('is_online', 0)
                ->count();

            $message = ChatMessage::create([
                'chat_room_id' => $chatRoom->id,
                "type" => $data['type'],
                'sender_id' => $data['sender_id'],
                'receiver_id' => $data['receiver_id'] ?? null,
                'message' => $data['message'],
                'is_read' => $offlineUsers == 0,
            ]);

            if (!empty($data['attachment_id'])) {
                Media::where('id', $data['attachment_id'])->update([
                    'user_id' => $data['sender_id'],
                    'mediaable_type' => ChatMessage::class,
                    'mediaable_id' => $message->id
                ]);
            }



            $messageData = [
                'success' => true,
                'message' => 'New Message Received',
                'messageText' => $data['message'],
                'data' => ChatMessage::with(['sender', 'receiver'])->with('media')->find($message->id)
            ];
            $mqtt->publish("chat/rooms/{$chatRoom->id}", json_encode($messageData));

            $receiverConversations = $this->getConversations($data['receiver_id']);
            $senderConversations = $this->getConversations($data['sender_id']);

            $mqtt->publish("chat/{$data['sender_id']}/conversations", json_encode($senderConversations));
            $mqtt->publish("chat/{$data['receiver_id']}/conversations", json_encode($receiverConversations));

        } catch (\Exception $e) {
            Log::emergency($e->getMessage());
            echo $e->getMessage() . $e->getLine() . "\n";
            $mqtt->publish("chat/{$data['sender_id']}/error", json_encode([
                'success' => false,
                'message' => $e->getMessage() . ' Line ' . $e->getLine() . "\n"
            ]));
            return;
        }
    }

    public function presence(mixed $data, Client $mqtt)
    {
        echo json_encode($data);
        $validator = Validator::make($data, [
            'user_id' => 'required|integer|exists:users,id',
            'is_online' => 'required|integer|between:0,1',
        ]);

        if ($validator->fails()) {
            $mqtt->publish("chat/{$data['user_id']}/error", json_encode([
                'success' => false,
                'message' => $validator->errors()->first()
            ]));
            return;
        }

        $uId = $data['user_id'] ?? null;
        RoomUser::where('user_id', $uId)->update([
            'is_online' => $data['is_online'],
        ]);
    }

    public function getConversations(mixed $userId)
    {
        $user = User::find($userId);

        return ChatRoom::query()
            ->has('chatMessages')
            ->where(function ($query) use ($user) {
                $query->where('auth_user_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->withCount(['unreadChatMessages' => function ($query) use ($user) {
                $query->where('receiver_id', $user->id);
            }])
            ->with(['senderWithProfile', 'receiverWithProfile', 'lastMessageForApi'])
            ->withMax('chatMessages', 'created_at')
            ->orderByDesc('chat_messages_max_created_at')
            ->get();
    }


    public function deleteMessage(mixed $data, Client $mqtt)
    {
        $validator = Validator::make($data, [
            'message_id' => 'required|integer|exists:chat_messages,id',
            'user_id' => 'required|integer|exists:users,id'
        ]);
        if ($validator->fails()) {
            $mqtt->publish("chat/{$data['user_id']}/error", json_encode([
                'success' => false,
                'message' => $validator->errors()->first()
            ]));
            return;
        }

        $chatMessage = ChatMessage::find($data['message_id']);
        $chatRoomId = (string)$chatMessage->chat_room_id;
        $chatMessage->delete();

        $mqtt->publish("chat/{$data['user_id']}/message-deleted", json_encode([
            'success' => true,
            'message' => 'Message deleted successfully'
        ]));

        $mqtt->publish("chat/rooms/{$chatRoomId}", json_encode([
            'success' => true,
            'message' => 'Message deleted successfully',
            'data' => [
                'message_id' => $data['message_id'],
                'chat_room_id' => $chatRoomId
            ]
        ]));
    }


//    notification
    private function sendNotification(array $data)
    {
        try {
            // Get device tokens for the receiver
            $notificationReceiver = DeviceToken::where('user_id', $data['receiver_id'])
                ->pluck('device_token');

            if ($notificationReceiver->isEmpty()) {
                Log::error('No device token found for user ID: ' . $data['receiver_id']);
                return false;
            }
            $receiverUser = User::with(['mmProfile', 'clientAbout'])->find($data['receiver_id'] ?? null);
            if ($receiverUser->type === 1) {
                $receiverName = $receiverUser->mmProfile->business_name ?? $receiverUser->mmProfile->full_name;
                $otherUserImage = $receiverUser->mmProfile->business_card;
            }else{
                $receiverName= $receiverUser->clientAbout->full_name;
                $otherUserImage = $receiverUser->clientAbout->profile_image;
            }
            $payload = [
                'userId' => $data['sender_id'],
                'receiverId' => $data['receiver_id'],
                'chatRoomId' => $data['type_id'],
                'otherUserName' => $receiverName ?? 'Match Maker ' . $data['receiver_id'],
                'otherUserImage' => $otherUserImage,
            ];
            $firebaseResult = $this->firebaseService->sendNotification(
                target: $notificationReceiver,
                title: $data['title'],
                body: $data['body'],
                payload: $payload
            );
            // Create notification record in database
            $notification = Notification::create([
                'user_id' => $data['receiver_id'],
                'title' => $data['title'],
                'body' => $data['body'],
                'payload' => $payload,
                'status' => 0
            ]);
            return true;

        } catch (\Exception $e) {
            Log::error('Error in sendNotification process', [
                'sender_id' => $data['sender_id'] ?? null,
                'receiver_id' => $data['receiver_id'] ?? null,
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'stack_trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

}
