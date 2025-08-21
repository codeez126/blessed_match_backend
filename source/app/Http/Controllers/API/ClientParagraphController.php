<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ClientParagraphService;

class ClientParagraphController extends Controller
{
    protected $clientParagraphService;

    public function __construct(ClientParagraphService $clientParagraphService)
    {
        $this->clientParagraphService = $clientParagraphService;
    }

    public function generate(Request $request)
    {
        $userId = $request->input('user_id');

        $paragraph1 = $this->clientParagraphService->generateFirstParagraph($userId);
        $paragraph2 = $this->clientParagraphService->generateSecondParagraph($userId);
        $paragraph3 = $this->clientParagraphService->generateThirdParagraph($userId);
        $paragraph4 = $this->clientParagraphService->generateFourthParagraph($userId);

        return response()->json([
            'paragraph_1' => $paragraph1,
            'paragraph_2' => $paragraph2,
            'paragraph_3' => $paragraph3,
            'paragraph_4' => $paragraph4,
        ]);
    }


}
