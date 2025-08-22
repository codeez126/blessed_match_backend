<?php

namespace App\Http\Controllers\API;
use App\Models\DeviceToken;
use App\Models\MatchRequest;
use App\Models\Notification;
use App\Models\User;
use App\Services\FirebaseService;
use App\Services\MatchmakingFilterService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MatchmakingController extends Controller
{
    private MatchmakingFilterService $filterService;
    protected FirebaseService $firebaseService;

    public function __construct(
        MatchmakingFilterService $filterService,
        FirebaseService $firebaseService
    ) {
        $this->filterService = $filterService;
        $this->firebaseService = $firebaseService;
    }

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

            $payload =[
                'type' => $data['type'],
                'type_id' => $data['type_id'],
                'status' => 0,
                'sender_id' => $data['sender_id'],
                'receiving_user_id' => $data['receiver_id']
            ];
            // Send notification via Firebase
            $this->firebaseService->sendNotification(
                target: $notificationReceiver,
                title: $data['title'],
                body: $data['body'],
                payload: $payload
            );
            Notification::create([
                'user_id' => $data['receiver_id'],
                'title' => $data['title'],
                'body' => $data['body'],
                'payload' => $payload,
                'status' => 0
            ]);
            return true;

        } catch (\Exception $e) {
            Log::error('Error sending notification: ' . $e->getMessage());
            return false;
        }
    }

    public function findMatches(Request $request)
    {
        try {
            $validated = $request->validate([
                'gender_id' => 'required',

                'min_house_size' => 'sometimes|integer|min:1',

                'min_age' => 'sometimes|integer|min:18|max:100',
                'max_age' => 'sometimes|integer|min:18|max:100',

                'marital_status_id' => 'sometimes|array',
                'marital_status_id.*' => 'exists:marital_statuses,id',

                'nationalities' => 'sometimes|array',
                'nationalities.*' => 'integer|exists:nationalities,id',

                'house_status_id' => 'sometimes|exists:house_statuses,id',

                'city_id' => 'sometimes|array',
                'city_id.*' => 'integer|exists:cities,id',

                'education_id' => 'sometimes|array',
                'education_id.*' => 'exists:educations,id',

                'family_class_id' => 'sometimes|array',
                'family_class_id.*' => 'exists:family_classes,id',

                'employment_status_id' => 'sometimes|array',
                'employment_status_id.*' => 'exists:employment_statuses,id',

                'min_salary' => 'sometimes|integer|min:0',
                'max_salary' => 'sometimes|integer|gte:min_salary',

                'occupations' => 'sometimes|array',
                'occupations.*' => 'exists:occupations,id',

                'religion_id' => 'sometimes|exists:religions,id',

                'sect_id' => 'sometimes|array',
                'sect_id.*' => 'exists:sects,id',

                'cast_id' => 'sometimes|array',
                'cast_id.*' => 'exists:casts,id',

                'min_height' => 'sometimes|numeric',
                'max_height' => 'sometimes|numeric',
                'min_weight' => 'sometimes|integer|min:1',
                'max_weight' => 'sometimes|integer|min:1',

                'page' => 'sometimes|integer|min:1',
                'per_page' => 'sometimes|integer|min:1|max:100'
            ]);

            $results = $this->filterService->getFilteredUsers($validated);

            // Get logged-in user info (same as simpleHome)
            $loggedInUser = User::with('deviceToken')->find(auth('api')->id());
            if ($loggedInUser) {
                $deviceToken = optional($loggedInUser->deviceToken)->device_token;
                $is_login = true;
            } else {
                $deviceToken = null;
                $is_login = false;
            }

            if (empty($results)) {
                return $this->apiResponse([
                    'cards' => [],
                    'pagination' => [
                        'per_page' => $validated['per_page'] ?? 50,
                        'total_users' => 0,
                        'current_page' => $validated['page'] ?? 1,
                        'next_page_url' => null,
                    ],
                    'device_token' => $deviceToken,
                    'is_login' => $is_login,
                ], 'No matches found');
            }

            return $this->apiResponse([
                'cards' => $results->values(),
                'pagination' => [
                    'per_page' => $results->perPage(),
                    'total_users' => $results->total(),
                    'current_page' => $results->currentPage(),
                    'next_page_url' => $results->nextPageUrl(),
                ],
                'device_token' => $deviceToken,
                'is_login' => $is_login,
            ], 'Cards get successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function findUserMatches(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'page' => 'sometimes|integer|min:1',
            'per_page' => 'sometimes|integer|min:1|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()->first()
            ], 422);
        }

        try {
            $user = User::with([
                'clientAbout',
                'clientBackground',
                'nationalities',
                'clientProfession',
                'clientIslamicValue',
                'clientLifeStyle',
                'clientFamilyInfo',
            ])->find($request->user_id);

            // Create a new request with the filters
            // Start with basic required fields
            $requestData = [
                'gender_id' => $user->clientAbout->gender_id == 1 ? 2 : 1,
                'page' => $request->page ?? 1,
                'per_page' => $request->per_page ?? 50,
            ];

// Conditionally add fields only when they're not null
            if ($user->clientAbout->marital_status_id) {
                $requestData['marital_status_id'] = [$user->clientAbout->marital_status_id];
            }

            if ($user->clientBackground->house_status_id) {
                $requestData['house_status_id'] = $user->clientBackground->house_status_id;
            }

            if ($user->clientBackground->city_id) {
                $requestData['city_id'] = [$user->clientBackground->city_id];
            }

            if ($user->clientProfession->education_id) {
                $requestData['education_id'] = [$user->clientProfession->education_id];
            }

            if ($user->clientProfession->employment_status_id) {
                $requestData['employment_status_id'] = [$user->clientProfession->employment_status_id];
            }

            if ($user->clientProfession->occupations) {
                $requestData['occupations'] = [$user->clientProfession->occupations];
            }

            if ($user->clientIslamicValue->religion_id) {
                $requestData['religion_id'] = $user->clientIslamicValue->religion_id;
            }

            if ($user->clientIslamicValue->sect_id) {
                $requestData['sect_id'] = [$user->clientIslamicValue->sect_id];
            }

            if ($user->clientIslamicValue->cast_id) {
                $requestData['cast_id'] = [$user->clientIslamicValue->cast_id];
            }

            if ($user->nationalities->isNotEmpty()) {
                $requestData['nationalities'] = $user->nationalities->pluck('id')->toArray();
            }

            $filterRequest = new Request($requestData);

            // Add age filters if available
            if ($user->clientAbout && $user->clientAbout->dob) {
                $userAge = Carbon::parse($user->clientAbout->dob)->age;
                $userGender = $user->clientAbout->gender_id;

                if ($userGender == 1) { // Male user
                    $filterRequest->merge(['max_age' => $userAge]);

                    if ($user->clientLifeStyle) {
                        if ($user->clientLifeStyle->height) {
                            $filterRequest->merge(['max_height' => $user->clientLifeStyle->height]);
                        }
                        if ($user->clientLifeStyle->weight) {
                            $filterRequest->merge(['max_weight' => $user->clientLifeStyle->weight]);
                        }
                    }
                } else { // Female user
                    $filterRequest->merge(['min_age' => $userAge]);

                    if ($user->clientLifeStyle) {
                        if ($user->clientLifeStyle->height) {
                            $filterRequest->merge(['min_height' => $user->clientLifeStyle->height]);
                        }
                        if ($user->clientLifeStyle->weight) {
                            $filterRequest->merge(['min_weight' => $user->clientLifeStyle->weight]);
                        }
                    }
                }
            }
//            dd($filterRequest);exit();
            // Call findMatches with the prepared request
            return $this->findMatches($filterRequest);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function sendMatchRequest(Request $request)
    {
        // 1. Validate input
        $validator = Validator::make($request->all(), [
            'receiving_user_id' => 'required|exists:users,id',
            'receiving_mm_id' => 'nullable|exists:users,id',
            'requesting_user_id' => 'nullable|exists:users,id'
        ], [
            'receiving_user_id.required' => 'The receiving user is required',
            'receiving_user_id.exists' => 'The selected receiving user is invalid',
            'requesting_user_id.exists' => 'The selected requesting user is invalid'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()->first()
            ], 422);
        }

        $validated = $validator->validated();

        // 2. Determine requesters
        $authUser = Auth::user(); // Get once to avoid multiple queries

        if ($authUser->type == 1) { // If matchmaker
            $requestingUser = $validated['requesting_user_id'] ?? $authUser->id;
            $requestingMatchMaker = $authUser->id;
            $status = 1;
        } else { // If regular user
            $requestingUser = $authUser->id;
            $requestingMatchMaker = $authUser->matchmaker_id;
            $status = 0;
        }
        $receiverMm = User::where('id', $validated['receiving_user_id'])
            ->value('match_maker_id');

        $exists = MatchRequest::where('requesting_user_id', $requestingUser)
            ->where('receiving_user_id', $validated['receiving_user_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Match request already exists between these users.'
            ], 409);
        }
        // 3. Create match request
        $matchRequest = MatchRequest::create([
            'requesting_user_id' => $requestingUser,
            'requesting_mm_id' => $requestingMatchMaker,
            'receiving_user_id' => $validated['receiving_user_id'],
            'receiving_mm_id' => $receiverMm,
            'status' => $status,
        ]);

        if ($authUser->type == 1) {
//            if requester is a match maker then first send request to next matchmaker
            $data = [
                'sender_id' => $authUser->id,
                'receiver_id' => $receiverMm,
                'type' => 'match_request_from_ReqMm_to_ResMm',
                'type_id' => $matchRequest->id,
                'title' => 'New Match from Match Maker',
                'body' => "You have a new match request from Match Maker"
            ];
            $this->sendNotification($data);
        }
        else{
//            sending notification to my own matchmaker
            $data = [
                'sender_id' => $authUser->id,
                'receiver_id' => $requestingMatchMaker,
                'type' => 'match_request_from_reqUser_to_reqMm',
                'type_id' => $matchRequest->id,
                'title' => 'Your Client found a Match',
                'body' => "You have a new match request from your client"
            ];
            $this->sendNotification($data);
        }

            return response()->json([
            'success' => true,
            'message' => 'Match request sent for review',
            'data' => $matchRequest->load('requestingUser', 'receivingUser')
        ]);
    }
    public function matchRequestDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'match_id' => 'required|exists:match_requests,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()->first()
            ], 422);
        }
        $matchRequest = MatchRequest::with(['requestingUser', 'requestingMm', 'receivingUser', 'receivingMm'])->find($request->match_id);
        return response()->json([
            'success' => true,
            'message' => 'Match request featched',
            'data' => $matchRequest
        ]);
    }
    public function myMatchRequests(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|integer|in:1,2',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()->first()
            ], 422);
        }

        if ($request->type == 1) {
            $matchRequest = MatchRequest::with(['requestingUser.clientAbout', 'requestingMm.mmProfile', 'receivingUser.clientAbout', 'receivingMm.mmProfile'])
                ->where(function ($q) {
                    $q->where('requesting_mm_id', Auth::id())
                        ->orWhere('requesting_user_id', Auth::id());
                })
                ->orderBy('id','desc')
                ->get();
        } else {
            $matchRequest = MatchRequest::with(['requestingUser.clientAbout', 'requestingMm.mmProfile', 'receivingUser.clientAbout', 'receivingMm.mmProfile'])
                ->where(function ($q) {
                    $q->where('receiving_mm_id', Auth::id())
                        ->orWhere('receiving_user_id', Auth::id());
                })
                ->orderBy('id','desc')
                ->get();
        }

        return response()->json([
            'success' => true,
            'message' => 'Match requests fetched',
            'data' => $matchRequest
        ]);
    }
    public function matchRequestStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'match_id' => 'required|exists:match_requests,id',
            'status' => 'required|integer|in:0,1,2,3,4,5,6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()->first()
            ], 422);
        }

        try {
            $matchRequest = MatchRequest::find($request->match_id);
            if (!$matchRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Match Request not found'
                ], 404);
            }

            $matchRequest->status = $request->status;
            $matchRequest->save();

            $authUser = Auth::user();
            if ($request->status == 1){
//                request sending to receiving matchmaker
                $data = [
                    'sender_id' => $authUser->id,
                    'receiver_id' => $matchRequest->receiving_mm_id,
                    'type' => 'match_request_from_ReqMm_to_ResMm',
                    'type_id' => $matchRequest->id,
                    'title' => 'New Match from Match Maker',
                    'body' => "You have a new match request from Match Maker"
                ];
                $this->sendNotification($data);
            }
            elseif($request->status == 2){
//                request sending to receiving matchmaker
                $data = [
                    'sender_id' => $authUser->id,
                    'receiver_id' => $matchRequest->receiving_user_id,
                    'type' => 'match_request_from_ResMm_to_ResUser',
                    'type_id' => $matchRequest->id,
                    'title' => 'New Match from Match Maker',
                    'body' => "You have a new match request from Match Maker"
                ];
                $this->sendNotification($data);
            }

            return response()->json([
                'success' => true,
                'message' => 'Match request status updated',
                'data' => $matchRequest->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update match status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
