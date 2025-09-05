<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ChatRoomUsers;
use App\Models\Media;
use App\Models\RoomUser;
use App\Models\User;
use App\Services\ChatService;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    protected FirebaseService $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function createRoom(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'nullable|exists:users,id|different:user_id',
            'room_name' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        $receiverId = $request->receiver_id;

        // check if group already exists (in both directions)
        $existingRoom = ChatRoom::where(function ($q) use ($user, $receiverId) {
            $q->where('auth_user_id', $user->id)
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($q) use ($user, $receiverId) {
            $q->where('auth_user_id', $receiverId)
                ->where('receiver_id', $user->id);
        })->first();

        if ($existingRoom) {
            return response()->json([
                'status' => true,
                'message' => 'Group is already available',
                'data' => $existingRoom,
            ]);
        }

        // create new chat room if not exists
        $chatRoom = ChatRoom::create([
            'name' => $request->room_name ?? 'Chat',
            'auth_user_id' => $user->id,
            'receiver_id' => $receiverId ?? null,
        ]);

        // attach users
        RoomUser::updateOrCreate([
            'chat_room_id' => $chatRoom->id,
            'user_id' => $user->id,
        ]);

        if ($receiverId) {
            RoomUser::updateOrCreate([
                'chat_room_id' => $chatRoom->id,
                'user_id' => $receiverId,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => "Room {$chatRoom->name} Created Successfully",
            'data' => $chatRoom,
        ]);
    }
    public function chatHistory(Request $request)
    {
        try {
            if (empty($request->room_id)) {
                return response()->json([
                    'message' => 'room_id is required',
                    'success' => false,
                ]);
            }
            $user = Auth::user();
            ChatRoom::findOrFail($request->room_id)
                ->chatMessages()
                ->where('receiver_id', $user->id)
                ->update(['is_read' => 1]);

            $allMsg = ChatRoom::findOrFail($request->room_id)
                ->chatMessages()
                ->with('media')
                ->when($request->type, function ($q, $type) {
                    $q->where('type', $type);
                })->get();
            return response()->json([
                'message' => 'chat history fetched successfully',
                'success' => true,
                'data' => $allMsg
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
            ]);
        }
    }

    public function chatConversions(Request $request, ChatService $chatService)
    {
        $data = $chatService->getConversations(Auth::id());
        return response()->json([
            'success' => true,
            'message' => 'Chat Conversions fetched successfully',
            'data' => $data
        ]);
    }
    public function uploadChatFile(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file',
                'file_thumbnail' => 'nullable|file',
                'type' => 'required|string',
            ]);

            $uniqId = uniqid();
            $thumbnailPath = null;

            // file_thumbnail
            $thumbnail = $request->file('file_thumbnail');
            if ($thumbnail) {
                    $thumbnailPath = 'assets/images/chat/';
                    $thumbnailFileName = 'thumb_' . $uniqId . '.' . $thumbnail->getClientOriginalExtension();
                    $thumbnail->move($thumbnailPath, $thumbnailFileName);

                    $thumbnailPath = $thumbnailPath . $thumbnailFileName;
            }

            //  file
            $file = $request->file('file');

            $fileOriginalName = $file->getClientOriginalName();
            $fileSize = $this->formatBytes($file->getSize());
            $fileMime = $file->getClientMimeType();

            $filePath = 'assets/images/chat/';
            $filePathName = $uniqId . '.' . $file->getClientOriginalExtension();
            $file->move($filePath, $filePathName);

            $fullPath = $filePath . $filePathName;

            $user = Auth::guard('api')->user();
            $media = Media::create([
                'type' => $request->input('type'),
                'file_path' => $fullPath,
                'file_name' => $fileOriginalName,
                'file_size' => $fileSize,
                'file_mime' => $fileMime,
                'file_thumbnail' => $thumbnailPath,
                'user_id' => $user->id ?? null,
                'audio_duration' => $request->input('audio_duration'),
            ]);


            return response()->json([
                'message' => 'File uploadZed successfully',
                'data' => Media::find($media->id)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Upload failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function sendFirebaseNotification(Request $request)
    {
        try {
            // Validate incoming request
            $request->validate([
                'target' => 'required', // token, tokens array, or topic
                'title' => 'required|string|max:255',
                'body' => 'required|string|max:10000',
                'payload' => 'nullable|array',
                'is_topic' => 'nullable|boolean'
            ]);

            $body = $request->input('body');

// log with unicode preserved
            Log::info('Notification body check', [
                'raw' => $body,
                'json_unescaped' => json_encode($body, JSON_UNESCAPED_UNICODE)
            ]);


            // Get validated data
            $target = $request->input('target');
            $title = $request->input('title');
            $body = $request->input('body');
            $payload = $request->input('payload', []);
            $isTopic = $request->input('is_topic', false);

            Log::info('Firebase notification request received', [
                'target_type' => is_array($target) ? 'multiple_tokens' : 'single_target',
                'target_count' => is_array($target) ? count($target) : 1,
                'title' => $title,
                'is_topic' => $isTopic
            ]);

            // Send notification via Firebase service
            $success = $this->firebaseService->sendNotification(
                target: $target,
                title: $title,
                body: $body,
                payload: $payload,
                isTopic: $isTopic
            );

            if ($success) {
                Log::info('Firebase notification sent successfully', [
                    'target_count' => is_array($target) ? count($target) : 1
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Notification sent successfully',
                    'data' => [
                        'title' => $title,
                        'body' => $body,
                        'target_count' => is_array($target) ? count($target) : 1
                    ]
                ], 200);
            } else {
                Log::warning('Firebase notification failed to send');

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send notification'
                ], 400);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Firebase notification validation failed', [
                'errors' => $e->errors()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Firebase notification exception', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error: ' . $e->getMessage()
            ], 500);
        }
    }
}
