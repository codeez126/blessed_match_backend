<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function uploadChatFile(Request $request)
    {
        if ($request->header('M2Logix-chat-KEY') !== 'M2Logix-Upload-chat-files_Secure_10298#!*+++OP') {
            return $this->apiResponse(
                [],
                'Unauthorized access',
                401
            );
        }
        if ($request->hasFile('file')) {
            $front_image_file = $request->file('file');
            $front_image_file_path = 'assets/chat/files/';
            $front_image_file_name = time() . '_' . $front_image_file->getClientOriginalName();
            $front_image_file->move(($front_image_file_path), $front_image_file_name);
            $imagePath =$front_image_file_path.$front_image_file_name;
            return $this->apiResponse(
                ['file_path' => $imagePath],
                'File uploaded successfully'
            );
        }
        return $this->apiResponse(
            [],
            'Invalid or missing image file',
            422
        );
    }
}
