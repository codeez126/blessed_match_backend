<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ClientAbout;
use App\Models\ClientBackground;
use App\Models\ClientFamilyInfo;
use App\Models\ClientFamilyMember;
use App\Models\ClientHobby;
use App\Models\ClientImage;
use App\Models\ClientIslamicValue;
use App\Models\ClientLanguage;
use App\Models\ClientLifeStyle;
use App\Models\ClientNationality;
use App\Models\ClientProfession;
use App\Models\Country;
use App\Models\DeviceToken;
use App\Models\Hobby;
use App\Models\MmProfile;
use App\Models\Religion;
use App\Models\UserBusiness;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Common validation rules
        $rules = [
            'auth_type' => 'required|in:email,phone,google,facebook',
            'type' => 'required',

        ];

        // Conditional validation based on auth_type
        if ($request->auth_type === 'email') {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['phone'] = 'nullable|regex:/^\+92[0-9]{10}$/|unique:users,phone';
            $rules['password'] = 'nullable|min:6';
            $rules['password_confirmation'] = 'nullable|same:password';
        }elseif($request->auth_type === 'phone'){
            $rules['email'] = 'nullable|email|unique:users,email';
            $rules['phone'] = 'required|regex:/^\+92[0-9]{10}$/|unique:users,phone';
            $rules['password'] = 'nullable|min:6';
            $rules['password_confirmation'] = 'nullable|same:password';
        } else {
            $rules['email'] = 'required|email';
            $rules['auth_id'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);

        // Referral code validation
        if ($request->filled('referal_code')) {
            $validator->after(function ($validator) use ($request) {
                if (!MmProfile::where('my_refral_code', $request->referal_code)->exists()) {
                    $validator->errors()->add('referal_code', 'Invalid referral code');
                }
            });
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }


        DB::beginTransaction();

        try {
            $user = User::where(function ($q) use ($request) {
                if ($request->filled('phone')) {
                    $q->where('phone', $request->phone);
                }
                if ($request->filled('email')) {
                    $q->orWhere('email', $request->email);
                }
            })->first();

            if ($user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User already exists. Please login'
                ], 409);
            }

            // For social login, also check by auth_id
            if ($request->auth_type !== 'email' && $request->auth_type !== 'phone') {
                $socialUser = User::where('auth_id', $request->auth_id)
                    ->where('auth_type', $request->auth_type)
                    ->first();
                if ($socialUser) {
                    DB::commit(); // No changes made
                    return response()->json([
                        'status' => false,
                        'message' => 'User already exists. Please login.'
                    ], 409);
                }
            }

            // Create new user
            $userData = [
                'type' => $request->type,
                'auth_type' => $request->auth_type,
                'email' => $request->email ?? null,
                'phone' => $request->phone ?? null,
                'status' => 0,
                'referal_code'=>$request->referal_code ?? null,
                'platform' => $request->header('X-Platform'), // Get from header
                'region' => $request->header('X-Region'), // Get from header
            ];

            if ($request->auth_type === 'email' || $request->auth_type === 'phone') {
                $userData['password'] = bcrypt($request->password);
                $userData['phone'] = $request->phone;
                $userData['otp'] = '123456';
            } else {
                $userData['auth_id'] = $request->auth_id;
            }

            $user = User::create($userData);

            // Only generate token for non-email auth types
            $response = [
                'status' => true,
                'message' => $request->auth_type === 'email' || $request->auth_type === 'phone'
                    ? 'Registration successful. OTP sent.'
                    : 'Registration successful.',
                'user' => $user->makeHidden(['password', 'otp'])
            ];

            if ($request->auth_type !== 'email' || $request->auth_type !== 'phone') {
                $response['token'] = $user->createToken('authToken')->accessToken;
            }

            DB::commit();

            return response()->json($response, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $rules = [
            'auth_type' => 'required|in:email,phone,google,facebook',
        ];
        if ($request->auth_type === 'phone') {
            $rules['phone'] = 'required|regex:/^\+92[0-9]{10}$/';
            $rules['password'] = 'nullable|min:6';
        }else {
            $rules['auth_id'] = 'required';
            $rules['email'] = 'nullable|email'; // Optional for social login
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            if($request->auth_type === 'phone'){
                $user = User::where('phone', $request->phone)->first();
                // Check if user exists
                if (!$user) {
                    return response()->json([
                        'status' => false,
                        'message' => 'User not found. Please register first.'
                    ], 404);
                }
                // Check if account is active
                if ($user->status != 1) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Your account is not active please contact your matchmaker',
                        'user' => $user->makeHidden(['password', 'otp'])
                    ], 403);
                }

                $user->update(["otp"=>123456]);

                return response()->json([
                    'status' => true,
                    'message' => 'Otp Send to your number',
                    'user' => null
                ], 200);
            }

            // Handle Social Login (Google/Facebook)
            else {
                $user = User::where('auth_id', $request->auth_id)
                    ->where('auth_type', $request->auth_type)
                    ->first();

                if (!$user && $request->filled('email')) {
                    // Check by email only (any auth_type)
                    $existingByEmail = User::where('email', $request->email)->first();

                    if ($existingByEmail) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Email already registered with another login method.',
                        ], 403);
                    }
                }

                if (!$user) {
                    $user = User::create([
                        'email' => $request->email,
                        'auth_type' => $request->auth_type,
                        'auth_id' => $request->auth_id,
                        'status' => 1,
                    ]);
                }

                if ($user->status != '1') {
                    return response()->json([
                        'status' => false,
                        'message' => 'Account not active. Please contact support.',
                        'user' => $user->makeHidden(['password', 'otp']),
                    ], 403);
                }

                $token = $user->createToken('authToken')->accessToken;

                return response()->json([
                    'status' => true,
                    'message' => 'Login successful',
                    'token' => $token,
                    'user' => $user->makeHidden(['password', 'otp']),
                ], 200);
            }


        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Login failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function verifyOtp(Request $request)
    {

        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'phone' => 'nullable',
            'otp' => 'required|numeric|digits:6',   // OTP should be 6 digits
        ]);

        if ($validator->fails()) {
            return $this->apiResponse([], 'Your Otp is Invalid', 422, $validator->errors());
        }

        // Find the user by email
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return $this->apiResponse([], 'User not found', 404);
        }

        // Check if the OTP matches
        if ($user->otp != $request->otp) {
            return $this->apiResponse([], 'Invalid OTP', 400);
        }

        // OTP is valid - proceed with login
        $user->otp = null; // Clear the OTP after successful verification
        $user->status = 1; // Activate user
        $user->save();

        // Generate access token
        $token = $user->createToken('authToken')->accessToken;

        // Prepare response data
        $responseData = [
            'user' => $user->makeHidden(['password', 'otp']),
            'token' => $token
        ];
        return $this->apiResponse($responseData, 'OTP verified successfully');
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ], 404);
        }

        $user->otp = '123456'; // Static OTP (or generate dynamically)
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'OTP resent successfully.',
            'user' => $user->makeHidden(['password', 'otp']) // Optional: return user
        ]);
    }

    public function mmRegistration(Request $request)
    {
        // Get the authenticated user
        $user = auth()->user();

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'business_card' => 'nullable|string|max:255',
            'gender_id' => 'required|exists:genders,id',
            'dob' => 'required|date',
            'experience_years' => 'required|integer|min:0',
            'address' => 'required|string',
            'office_type_id' => 'required|exists:office_types,id',
            'business_email' => 'required|email',
            'business_contact' => 'required|string',
            'is_registered' => 'required|boolean',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'data' => [],
                'errors' => $validator->errors()->messages() // This shows all validation errors
            ], 422);
        }

        try {
            // Create the MM profile
            $mmProfile = MmProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'full_name' => $request->full_name,
                    'business_name' => $request->business_name,
                    'business_card' => $request->business_card,
                    'gender_id' => $request->gender_id,
                    'dob' => $request->dob,
                    'experience_years' => $request->experience_years,
                    'address' => $request->address,
                    'office_type_id' => $request->office_type_id,
                    'my_refral_code' => $user->phone ?? null,
                    'business_email' => $request->business_email,
                    'business_contact' => $request->business_contact,
                    'is_registered' => $request->is_registered,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'platform' => $request->header('X-Platform'),
                    'region' => $request->header('X-Region'),
                ]
            );


            // Update user type to matchmaker if not already set
            if ($user->type != '1') {
                $user->type = '1';
                $user->save();
            }

            return $this->apiResponse([
                'mm_profile' => $mmProfile
            ], 'Matchmaker profile Updated successfully');

        } catch (\Exception $e) {
            return $this->apiResponse([], 'Profile creation failed: ' . $e->getMessage(), 500);
        }
    }

    private function updateOnboardingProgress($userId, $stepNumber, array $fields)
    {
        $totalFields = count($fields);
        $filledFields = 0;

        foreach ($fields as $key => $value) {
            if ($key === 'children') {
                if (is_array($value) && count($value)) {
                    $filledFields++;
                }
            } elseif (!is_null($value) && $value !== '') {
                $filledFields++;
            }
        }

        $percentage = $totalFields > 0 ? round(($filledFields / $totalFields) * 100, 2) : 0;

        $column = 'onboarding' . $stepNumber;

        $userProfileAvg = \App\Models\UserProfileAvg::firstOrNew(['user_id' => $userId]);
        $userProfileAvg->$column = $percentage;

        // Calculate total avg
        $total = 0;
        $count = 0;
        for ($i = 1; $i <= 6; $i++) {
            $col = 'onboarding' . $i;
            if (!is_null($userProfileAvg->$col)) {
                $total += $userProfileAvg->$col;
                $count++;
            }
        }

        $userProfileAvg->total_avg = $count > 0 ? round($total / 6, 2) : 0;
        $userProfileAvg->save();
    }

    public function onBoarding1(Request $request)
    {
        DB::beginTransaction(); // Start the database transaction

        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'nullable|exists:users,id', //only for edit

                'full_name' => 'nullable|string|max:255',
                'profile_image' => 'nullable|string|max:255',
                'gender_id' => 'nullable|exists:genders,id',
                'date_of_birth' => 'nullable|date',
                'marital_status_id' => 'nullable|exists:marital_statuses,id',
                'profile_managed_by' => 'nullable|in:1,2,3,4,5',
                'status' => 'nullable',
                'reason_txt' => 'nullable|string|max:255',
                'client_contact' => 'nullable',
                'number_of_children' => 'nullable|integer|min:0',
                'children' => 'nullable|array',
                'children.*.name' => 'nullable|string',
                'children.*.age' => 'nullable|integer',
                'children.*.gender_id' => 'nullable|exists:genders,id',
                'children.*.martial_status' => 'nullable|in:1,2,3,4,5',
                'children.*.description' => 'nullable|string',
                'children.*.designation' => 'nullable|string',
                'children.*.guardian_info' => 'nullable|string',
                'children.*.status' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->first()
                ], 422);
            }

            $loginUser = Auth::user();

            if (!$loginUser) {
                return $this->apiResponse([], 'Unauthorized', 401);
            }

            $newUser = null;

            if ($loginUser->type == '1') {
                if ($request->user_id){
                    $newUser = User::find($request->user_id);

                    if ($newUser->match_maker_id !== $loginUser->id){
                        return $this->apiResponse([], 'This User is not Associated with You', 401);
                    }

                }else{
                    $newUser = User::create([
                        'type' => '0',
                        'auth_type' => 'email',
                        'match_maker_id' => $loginUser->id,
                        'status' => '0',
                    ]);
                }
            }elseif ($loginUser->type == '0'){
                $newUser = $loginUser;
            }

            $user = $newUser ?? $loginUser;

            if (!$user) {
                DB::rollBack();
                return $this->apiResponse([], 'User not found', 404);
            }

            // Update or create client about info
            ClientAbout::updateOrCreate(
                ['user_id' => $user->id],
                array_filter([
                    'full_name' => $request->full_name,
                    'profile_image' => $request->profile_image,
                    'gender_id' => $request->gender_id,
                    'dob' => $request->date_of_birth,
                    'marital_status_id' => $request->marital_status_id,
                    'profile_managed_by' => $request->profile_managed_by,
                    'status' => $request->status,
                    'reason_txt' => $request->reason_txt,
                    'client_contact' => $request->client_contact,
                    'platform' => $request->header('X-Platform'),
                    'region' => $request->header('X-Region'),
                ], fn($value) => !is_null($value))
            );


            // Handle children data
            if ($request->has('children') && is_array($request->children)) {
                // First, delete existing children records to avoid duplicates
                ClientFamilyMember::where('user_id', $user->id)
                    ->where('type', '1')
                    ->delete();

                foreach ($request->children as $childData) {
                    // Check if all child fields are empty
                    $allEmpty = empty($childData['name']) &&
                        empty($childData['age']) &&
                        empty($childData['gender_id']) &&
                        empty($childData['martial_status']) &&
                        empty($childData['description']) &&
                        empty($childData['designation']) &&
                        empty($childData['guardian_info']);

                    if (!$allEmpty) {
                        // Create record with child data
                        ClientFamilyMember::create([
                            'user_id' => $user->id,
                            'type' => '1',
                            'full_name' => $childData['name'] ?? null,
                            'age' => $childData['age'] ?? null,
                            'gender_id' => $childData['gender_id'] ?? 0,
                            'martial_status' => $childData['martial_status'] ?? null,
                            'description' => $childData['description'] ?? null,
                            'designation' => $childData['designation'] ?? null,
                            'guardian_info' => $childData['guardian_info'] ?? null,
                            'status' => $childData['status'] ?? null,
                            'platform' => $request->header('X-Platform'),
                            'region' => $request->header('X-Region'),
                        ]);
                    } else {
                        // Create minimal record with just user_id if all fields are empty
                        ClientFamilyMember::create([
                            'user_id' => $user->id,
                            'type' => '1',
                            'status' => '0',
                            'platform' => $request->header('X-Platform'),
                            'region' => $request->header('X-Region'),
                        ]);
                    }
                }
            }
//            saving avg
            $this->updateOnboardingProgress($user->id, 1, [
                'full_name' => $request->full_name,
                'gender_id' => $request->gender_id,
                'dob' => $request->date_of_birth,
                'marital_status_id' => $request->marital_status_id,
                'profile_managed_by' => $request->profile_managed_by,
                'client_contact' => $request->client_contact,
            ]);

            DB::commit(); // Commit the transaction if everything succeeded
            $user = User::with('clientAbout', 'clientFamilyMembers')->where(['id' => $user->id])->first();
            return $this->apiResponse(['user' => $user], 'Onboarding data saved successfully');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            \Log::error('OnBoarding1 Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            return $this->apiResponse([], 'Failed to save onboarding data', 500, [
                'error' => $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTrace() : null
            ]);
        }
    }
    public function onBoarding23(Request $request)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                // onBoarding2 fields
                'province' => 'nullable|exists:provinces,id',
                'city' => 'nullable|exists:cities,id',
                'area' => 'nullable|exists:areas,id',
                'permanent_address' => 'nullable|string',
                'current_address' => 'nullable|string',
                'house_status_id' => 'nullable|exists:house_statuses,id',
                'house_size' => 'nullable|string',
                'background_description' => 'nullable|string',
                'nationalities' => 'nullable|array',
                'nationalities.*' => 'exists:nationalities,id',
                // onBoarding3 fields
                'father_occupation' => 'nullable|string',
                'mother_occupation' => 'nullable|string',
                'family_class_id' => 'nullable|exists:family_classes,id',
                'is_father_alive' => 'nullable|in:0,1',
                'is_mother_alive' => 'nullable|in:0,1',

                'siblings' => 'nullable|array',
                'siblings.*.name' => 'nullable|string',
                'siblings.*.age' => 'nullable|integer',
                'siblings.*.gender_id' => 'nullable|exists:genders,id',
                'siblings.*.martial_status' => 'nullable|in:1,2,3,4,5',
                'siblings.*.description' => 'nullable|string',
                'siblings.*.designation' => 'nullable|string',
                'siblings.*.guardian_info' => 'nullable|string',
                'siblings.*.status' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->first()
                ], 422);
            }

            $user = User::find($request->user_id);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $progressData = [];
            $stepCompleted = 0;

            // Handle onBoarding2 data if any of its fields are present
            if ($request->hasAny(['province', 'city', 'area', 'permanent_address', 'current_address',
                'house_status_id', 'house_size', 'background_description', 'nationalities'])) {

                // Save background information
                $background = ClientBackground::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'province' => $request->province,
                        'city' => $request->city,
                        'area' => $request->area ?? null,
                        'permanent_address' => $request->permanent_address,
                        'current_address' => $request->current_address,
                        'house_status_id' => $request->house_status_id,
                        'house_size' => $request->house_size,
                        'background_description' => $request->background_description,
                        'platform' => $request->header('X-Platform'),
                        'region' => $request->header('X-Region'),
                    ]
                );

                // Handle nationalities
                if ($request->has('nationalities')) {
                    // Delete existing nationalities
                    ClientNationality::where('user_id', $user->id)->delete();

                    // Add new nationalities
                    foreach ($request->nationalities as $nationalityId) {
                        ClientNationality::create([
                            'user_id' => $user->id,
                            'nationality_id' => $nationalityId,
                            'platform' => $request->header('X-Platform'),
                            'region' => $request->header('X-Region'),
                        ]);
                    }
                }

                $progressData = array_merge($progressData, [
                    'province' => $request->province,
                    'city' => $request->city,
                    'area' => $request->area,
                    'permanent_address' => $request->permanent_address,
                    'current_address' => $request->current_address,
                    'house_status_id' => $request->house_status_id,
                    'house_size' => $request->house_size,
                    'background_description' => $request->background_description,
                    'nationalities' => $request->nationalities,
                ]);

                $stepCompleted = 2;
            }

            // Handle onBoarding3 data if any of its fields are present
            if ($request->hasAny(['father_occupation', 'mother_occupation', 'family_class_id',
                'is_father_alive', 'is_mother_alive', 'siblings'])) {

                // Save family information
                $familyInfo = ClientFamilyInfo::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'father_occupation' => $request->father_occupation,
                        'mother_occupation' => $request->mother_occupation,
                        'family_class_id' => $request->family_class_id,
                        'is_father_alive' => $request->is_father_alive,
                        'is_mother_alive' => $request->is_mother_alive,
                        'platform' => $request->header('X-Platform'),
                        'region' => $request->header('X-Region'),
                    ]
                );

                // Handle siblings data (type = 2 for siblings)
                if ($request->has('siblings') && is_array($request->siblings)) {
                    // First delete existing siblings records
                    ClientFamilyMember::where('user_id', $user->id)
                        ->where('type', 2) // 2 for siblings
                        ->delete();

                    foreach ($request->siblings as $siblingData) {
                        // Check if all sibling fields are empty
                        $allEmpty = empty($siblingData['name']) &&
                            empty($siblingData['age']) &&
                            empty($siblingData['gender_id']) &&
                            empty($siblingData['martial_status']) &&
                            empty($siblingData['description']) &&
                            empty($siblingData['designation']) &&
                            empty($siblingData['guardian_info']);

                        if (!$allEmpty) {
                            ClientFamilyMember::create([
                                'user_id' => $user->id,
                                'type' => 2, // 2 for siblings
                                'full_name' => $siblingData['name'] ?? null,
                                'age' => $siblingData['age'] ?? null,
                                'gender_id' => $siblingData['gender_id'] ?? 0,
                                'martial_status' => $siblingData['martial_status'] ?? null,
                                'description' => $siblingData['description'] ?? null,
                                'designation' => $siblingData['designation'] ?? null,
                                'guardian_info' => $siblingData['guardian_info'] ?? null,
                                'status' => $siblingData['status'] ?? null,
                                'platform' => $request->header('X-Platform'),
                                'region' => $request->header('X-Region'),
                            ]);
                        } else {
                            // Minimal record if all fields are empty
                            ClientFamilyMember::create([
                                'user_id' => $user->id,
                                'type' => 2,
                                'platform' => $request->header('X-Platform'),
                                'region' => $request->header('X-Region'),
                            ]);
                        }
                    }
                }

                $progressData = array_merge($progressData, [
                    'father_occupation' => $request->father_occupation,
                    'mother_occupation' => $request->mother_occupation,
                    'family_class_id' => $request->family_class_id,
                    'is_father_alive' => $request->is_father_alive,
                    'is_mother_alive' => $request->is_mother_alive,
                    'siblings' => $request->siblings,
                ]);

                $stepCompleted = max($stepCompleted, 3);
            }

            // Update progress if any data was processed
            if ($stepCompleted > 0) {
                $this->updateOnboardingProgress($user->id, $stepCompleted, $progressData);
            }

            DB::commit();

            $user = User::with([
                'clientFamilyMembers',
                'clientBackground',
                'clientBackground.province',
                'clientBackground.city',
                'clientBackground.area',
                'clientFamilyInfo',
                'nationalities'
            ])->find($request->user_id);


            return response()->json([
                'status' => true,
                'message' => 'Information saved successfully',
                'data' => $user
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Failed to save information',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
    public function onBoarding4(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'occupation' => 'nullable|exists:occupations,id',
                'occupation_grade' => 'nullable|string|max:255',
                'education_id' => 'nullable|exists:educations,id',
                'employment_status_id' => 'nullable|exists:employment_statuses,id',
                'businesses' => 'nullable|array',
                'businesses.*.job_title' => 'nullable|string|max:255',
                'businesses.*.business_name' => 'nullable|string|max:255',
                'businesses.*.grade' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->first()
                ], 422);
            }

            $user = User::find($request->user_id);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Save profession information
            $profession = ClientProfession::with(['education','occupation'])->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'occupation' => $request->occupation,
                    'education_id' => $request->education_id,
                    'occupation_grade' => $request->occupation_grade,
                    'employment_status_id' => $request->employment_status_id,
                    'avg_income' => $request->avg_income,
                    'platform' => $request->header('X-Platform'),
                    'region' => $request->header('X-Region'),
                ]
            );

            // Handle businesses data
            if ($request->has('businesses') && is_array($request->businesses)) {
                // First delete existing businesses
                UserBusiness::where('user_id', $user->id)->delete();

                foreach ($request->businesses as $businessData) {
                    UserBusiness::create([
                        'user_id' => $user->id,
                        'job_title' => $businessData['job_title'] ?? null,
                        'business_name' => $businessData['business_name'] ?? null,
                        'grade' => $businessData['grade'] ?? null,
                        'platform' => $request->header('X-Platform'),
                        'region' => $request->header('X-Region'),
                    ]);
                }
            }
            $UserBussinesses= UserBusiness::where('user_id', $user->id)->get();

            $this->updateOnboardingProgress($user->id, 4, [
                'occupation' => $request->occupation,
                'education_id' => $request->education_id,
                'employment_status_id' => $request->employment_status_id,
                'businesses' => $request->businesses,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Profession information saved successfully',
                'data' => [
                    'profession' => $profession,
                    'businesses' => $UserBussinesses
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Failed to save profession information',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
    public function onBoarding5(Request $request)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'religion_id' => 'nullable|exists:religions,id',
                'sect_id' => 'nullable|exists:sects,id',
                'cast_id' => 'nullable|exists:casts,id',
                'sub_cast_name' => 'nullable',
                'prayer_frequency' => 'nullable|in:1,2,3,4,5',
                'is_wear_hijab' => 'nullable',
                'is_wear_nikab' => 'nullable',
                'is_have_beard' => 'nullable',
                'quran_memorization' => 'nullable',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->first()
                ], 422);
            }

            $user = User::find($request->user_id);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Save Islamic values information
            $islamicValues = ClientIslamicValue::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'religion_id' => $request->religion_id,
                    'sect_id' => $request->sect_id,
                    'cast_id' => $request->cast_id,
                    'sub_cast_name' => $request->sub_cast_name,
                    'prayer_frequency' => $request->prayer_frequency,
                    'is_where_hijab' => $request->is_wear_hijab,
                    'is_where_nikab' => $request->is_wear_nikab,
                    'is_have_beared' => $request->is_have_beard,
                    'quran_memorization' => $request->quran_memorization,
                    'platform' => $request->header('X-Platform'),
                    'region' => $request->header('X-Region'),
                ]
            );
            $this->updateOnboardingProgress($user->id, 5, [
                'religion_id' => $request->religion_id,
                'sect_id' => $request->sect_id,
                'cast_id' => $request->cast_id,
                'sub_cast_name' => $request->sub_cast_name,
                'prayer_frequency' => $request->prayer_frequency,
                'is_wear_hijab' => $request->is_wear_hijab,
                'is_wear_nikab' => $request->is_wear_nikab,
                'is_have_beard' => $request->is_have_beard,
                'quran_memorization' => $request->quran_memorization,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Islamic values saved successfully',
                 'data' => [
                     'IslamicValues' => $islamicValues->load(['religion', 'sect', 'cast'])
                 ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Failed to save Islamic values',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function onBoarding6(Request $request)
    {
        DB::beginTransaction();

        try {
            // Use input() method to safely access request data
            $languages = $request->input('languages', []); // Default to empty array if null

            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'height' => 'nullable|string|max:10',
                'weight' => 'nullable|integer',
                'skin_color_id' => 'nullable|integer|exists:skin_types,id',
                'hair' => 'nullable|integer|between:1,9',
                'disability' => 'nullable',
                'disability_details' => 'nullable|string|max:255',
                'health_issue' => 'nullable',
                'health_issue_details' => 'nullable|string|max:255',
                'is_smoking' => 'nullable',
                'is_alcoholic' => 'nullable',
                'is_tobaco_habit' => 'nullable',
                'willing_to_relocate' => 'nullable',
                'languages' => 'nullable|array',
                'languages.*' => 'exists:languages,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->first()
                ], 422);
            }

            $user = User::find($request->user_id);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Save lifestyle information
            $lifestyle = ClientLifeStyle::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'height' => $request->height,
                    'weight' => $request->weight,
                    'skin_color_id' => $request->skin_color_id,
                    'hair' => $request->hair,
                    'disability' => $request->disability,
                    'disability_details' => $request->disability_details,
                    'health_issue' => $request->health_issue,
                    'health_issue_details' => $request->health_issue_details,
                    'is_smoking' => $request->is_smoking,
                    'is_alcoholic' => $request->is_alcoholic,
                    'is_tobaco_habit' => $request->is_tobaco_habit,
                    'willing_to_relocate' => $request->willing_to_relocate,
                    'platform' => $request->header('X-Platform'),
                    'region' => $request->header('X-Region'),
                ]
            );

            // Handle languages - with null check
            if (!empty($languages)) {
                ClientLanguage::where('user_id', $user->id)->delete();
                foreach ($languages as $languageId) {
                    ClientLanguage::create([
                        'user_id' => $user->id,
                        'language_id' => $languageId,
                        'platform' => $request->header('X-Platform'),
                        'region' => $request->header('X-Region'),
                    ]);
                }
            }

            $this->updateOnboardingProgress($user->id, 6, [
                'height' => $request->height,
                'weight' => $request->weight,
                'skin_color_id' => $request->skin_color_id,
                'hair' => $request->hair,
                'disability' => $request->disability,
                'disability_details' => $request->disability_details,
                'health_issue' => $request->health_issue,
                'health_issue_details' => $request->health_issue_details,
                'is_smoking' => $request->is_smoking,
                'is_alcoholic' => $request->is_alcoholic,
                'is_tobaco_habit' => $request->is_tobaco_habit,
                'willing_to_relocate' => $request->willing_to_relocate,
                'languages' => $languages,
            ]);

            DB::commit();
           $clientLanguages= ClientLanguage::with('language')->where('user_id', $user->id)->get();

            return response()->json([
                'status' => true,
                'message' => 'Lifestyle information saved successfully',
                'data' => [
                    'lifestyle' => $lifestyle,
                    'client_languages' => $clientLanguages,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Failed to save lifestyle information',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
    public function onBoarding7(Request $request)
    {
        DB::beginTransaction();

        try {
            $hobbies = $request->input('hobbies', []);

            $validator = Validator::make($request->all(), [
                'user_id'       => 'required|exists:users,id',
                'hobbies'       => 'nullable|array',
                'hobbies.*'     => 'exists:hobbies,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validation failed',
                    'errors'  => $validator->errors()->first()
                ], 422);
            }

            $user = User::findOrFail($request->user_id);

            // 1) delete all existing hobbies
            ClientHobby::where('user_id', $user->id)->delete();

            // 2) re-create for each hobby ID (if any)
            foreach ($hobbies as $hobbyId) {
                ClientHobby::create([
                    'user_id'  => $user->id,
                    'hobby_id' => $hobbyId,
                    'platform' => $request->header('X-Platform'),
                    'region'   => $request->header('X-Region'),
                ]);
            }

            DB::commit();

            $userHobbyIds = ClientHobby::where('user_id', $user->id)->pluck('hobby_id');

            $hobbies = Hobby::with(['subHobbies' => function ($query) use ($userHobbyIds) {
                $query->whereIn('id', $userHobbyIds);
            }])
                ->where('type', 0)
                ->whereHas('subHobbies', function ($query) use ($userHobbyIds) {
                    $query->whereIn('id', $userHobbyIds);
                })
                ->get();


            return response()->json([
                'status'  => true,
                'message' => 'Hobbies information saved successfully',
                'data'    => [
                    'hobbies' => $hobbies,
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Failed to save hobbies information',
                'error'   => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ], 500);
        }
    }
    public function mmProfile(Request $request)
    {
        if ($request->has('mm_id')) {
            $mmUser = User::with(['mmProfile', 'associatedUsers'])->find($request->mm_id);
        } else {
            $mmUser = Auth::user()?->load('mmProfile', 'associatedUsers');
        }

        if (!$mmUser || $mmUser->type !== 1) {
            return response()->json([
                'status' => false,
                'message' => 'You are not a Match makker'
            ], 404);
        }
        $associatedUserCards = $mmUser->associatedUsers->map(function ($user) {
            return $user->clientProfileCard();
        });
        $mmUser->unsetRelation('associatedUsers');

        return response()->json([
            'status' => true,
            'message' => 'Match maker information Get successfully',
            'data' => [
                'mmUser' => $mmUser,
                'associated_users' => $associatedUserCards,
            ]
        ]);
    }

    public function mmClientToggleStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'user' => null
            ], 400);
        }

        $mmUser = auth()->user();
        $client = User::where('type', 0)->find($request->client_id);

        // Client existence check
        if (!$client) {
            return response()->json([
                'status' => false,
                'message' => 'Client not found',
                'user' => null
            ], 404);
        }

        // Ownership verification
        if ($client->match_maker_id != $mmUser->id) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access to client profile',
                'user' => null
            ], 403);
        }

        // Toggle status
        $newStatus = (int) !$client->status;
        $client->update(['status' => $newStatus]);

        return response()->json([
            'status' => true,
            'message' => 'Client status updated successfully',
            'user' => $client->fresh()->makeHidden(['password', 'otp'])
        ], 200);
    }
    public function mmProfileImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $front_image_file = $request->file('image');
            $front_image_file_path = 'assets/images/match-makers/';
            $front_image_file_name = time() . '_' . $front_image_file->getClientOriginalName();
            $front_image_file->move(($front_image_file_path), $front_image_file_name);

            $imagePath =$front_image_file_path.$front_image_file_name;
            return $this->apiResponse(
                ['image_path' => $imagePath],
                'Image uploaded successfully'
            );
        }
        return $this->apiResponse(
            [],
            'Invalid or missing image file',
            422
        );
    }
    public function clientImageSave(Request $request)
    {
        if ($request->hasFile('image')) {
            $front_image_file = $request->file('image');
            $front_image_file_path = 'assets/images/client/';
            $front_image_file_name = time() . '_' . $front_image_file->getClientOriginalName();
            $front_image_file->move(($front_image_file_path), $front_image_file_name);
            $imagePath =$front_image_file_path.$front_image_file_name;
            return $this->apiResponse(
                ['image_path' => $imagePath],
                'Image uploaded successfully'
            );
        }
        return $this->apiResponse(
            [],
            'Invalid or missing image file',
            422
        );
    }
    public function storeClientImages(Request $request)
    {
        Log::info('Client image upload furqan', [
            $request->save_images,
            $request->user_id,
            $request->all()
        ]);

        if ($request->hasFile('save_images')) {
            foreach ($request->file('save_images') as $index => $file) {
                Log::info("Image #$index", [
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        } else {
            Log::info('No save_images found in request.');
        }

        $userId = $request->user_id;

        if (!$userId) {
            return $this->apiResponse([], 'user_id is required', 422);
        }

        $saveImages = $request->file('save_images', []);
        $deleteImages = $request->input('delete_images', []);

        $saved = [];
        $deleted = [];

        // Save new images directly
        if (!empty($saveImages)) {
            foreach ($saveImages as $imageFile) {
                $front_image_file_path = 'assets/images/client/';
                $front_image_file_name = time() . '_' . $imageFile->getClientOriginalName();

                // Ensure folder exists
                if (!file_exists($front_image_file_path)) {
                    mkdir($front_image_file_path, 0775, true);
                }

                $imageFile->move($front_image_file_path, $front_image_file_name);
                $imagePath = $front_image_file_path . $front_image_file_name;

                $clientImage = new ClientImage();
                $clientImage->user_id = $userId;
                $clientImage->image = $imagePath;
                $clientImage->save();

                $saved[] = $imagePath;
            }
        }

        // Delete images
        foreach ($deleteImages as $imagePath) {
            $deletedFromDB = ClientImage::where('user_id', $userId)
                ->where('image', $imagePath)
                ->delete();

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            if ($deletedFromDB) {
                $deleted[] = $imagePath;
            }
        }

        return $this->apiResponse([
            'saved_images' => $saved,
            'deleted_images' => $deleted,
        ], 'Images processed successfully');
    }


    public function clientParagraph($id)
    {

        $user = User::with('clientAbout')->find($id);
        if (!$user->clientAbout) {
            return '';
        }

        $about = $user->clientAbout;
        $parts = [];

        // Gender-based greeting
        $genderText = $about->gender_id == 1 ? 'Boy' : 'Girl';
        $pronoun = $about->gender_id == 1 ? 'He' : 'She';
        $possessive = $about->gender_id == 1 ? 'His' : 'Her';

        // Name and basic info
        if ($about->full_name) {
            $parts[] = "{$genderText} name is {$about->full_name}.";
        }

        // Age calculation
        if ($about->dob) {
            $age = Carbon::parse($about->dob)->age;
            $parts[] = "{$pronoun} is {$age} years old.";
        }

        // Marital status
        if ($about->martial_status) {
            $maritalStatusText = $about->martial_status;
            $maritalStatusMap = [
                1 => 'Single',
                2 => 'Married',
                3 => 'Divorced',
                4 => 'Widowed',
            ];
            $maritalStatusLabel = $maritalStatusMap[$maritalStatusText] ?? 'Unknown';
            $parts[] = "{$possessive} marital status is {$maritalStatusLabel}.";
        }

        // Reason for joining (if divorced/widowed)
        if ($about->reason_txt && $about->martial_status != 1) {
            $parts[] = "{$possessive} help full information are: {$about->reason_txt}.";
        }

        return response()->json([
            'status' => true,
            'message' => 'About Paragraph',
            'data' => implode(' ', $parts)
        ]);
    }

    public function clientProfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::with([
                'clientAbout',
                'clientFamilyMembers',

                'clientBackground',
                'clientBackground.province',
                'clientBackground.city',
                'clientBackground.area',

                'clientFamilyInfo',

                'clientProfession',
                'clientProfession.education',
                'clientProfession.occupation',

                'userBusinesses',

                'clientIslamicValue',
                'clientIslamicValue.religion',
                'clientIslamicValue.sect',
                'clientIslamicValue.cast',

                'clientLifeStyle',
                'nationalities',
                'clientLanguages.language',
                'clientImages',
            ])->find($request->user_id);
            $user->client_hobbies = $user->groupedHobbies();

            return $this->apiResponse(['user' => $user], 'User Profile Fetched');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => null,
                'data' => [],
                'errors' => [
                    'error' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]
            ], 500);
        }
    }

    public function updateToken(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string|unique:device_tokens,device_token,' . auth()->id() . ',user_id',
            'platform' => 'nullable|integer',
            'region' => 'nullable|string',
        ]);

        $token = DeviceToken::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'device_token' => $request->device_token,
                'platform' => $request->platform,
                'region' => $request->region,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Device token saved successfully',
            'data' => $token
        ]);
    }

    public function getSetting()
    {
        $user = auth()->user();
        $setting = UserSetting::where('user_id', $user->id)->first();
        return response()->json([
            'status' => true,
            'message' => 'User settings get successfully',
            'data' => $setting,
        ]);
    }
    public function updateSetting(Request $request)
    {
        $request->validate([
            'is_notifiable' => 'nullable|boolean',
            'dark_theme' => 'nullable|boolean',
            'language' => 'nullable|string',
            'show_online_status' => 'nullable|boolean',
            'receive_promotions' => 'nullable|boolean',
        ]);
        $user = auth()->user();
        $setting = UserSetting::updateOrCreate(
            ['user_id' => $user->id],
            $request->only([
                'is_notifiable',
                'dark_theme',
                'language',
                'show_online_status',
                'receive_promotions',
            ])
        );
        return response()->json([
            'status' => true,
            'message' => 'User settings updated successfully',
            'data' => $setting,
        ]);
    }


    public function logout(Request $request)
    {
        try {
            if (!auth()->check()) {
                return $this->apiResponse(null, 'User not authenticated', 401);
            }
            $request->user()->token()->revoke();
            return $this->apiResponse(null, 'User logged out successfully', 200);
        } catch (\Exception $e) {
            return $this->apiResponse(null, 'Something went wrong: ' . $e->getMessage(), 500);
        }
    }
}
