<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ChatRoomUsers;
use App\Models\Media;
use App\Models\RoomUser;
use App\Models\User;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ChatController extends Controller
{

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
    public function uploadTemp(Request $request)
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
                $thumbnailPathName = 'thumb_' . $uniqId . '.' . $thumbnail->getClientOriginalExtension();
                $thumbnailPath = $thumbnail->storeAs('temp', $thumbnailPathName, 'public');
            }

            //  file
            $file = $request->file('file');
            $filePathName = $uniqId . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('temp', $filePathName, 'public');
            $user = Auth::guard('api')->user();
            $media = Media::create([
                'type' => $request->input('type'),
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $this->formatBytes($file->getSize()),
                'file_mime' => $file->getClientMimeType(),
                'file_thumbnail' => $thumbnailPath,
                'user_id' => $user->id ?? null,
                'audio_duration'=>request('audio_duration'),
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
}
