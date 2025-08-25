<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use App\Models\MmProfile;
use App\Models\Notification;
use App\Models\PaymentMethod;
use App\Models\PaymentPlan;
use App\Models\User;
use App\Models\UserPayment;
use App\Models\UserPoint;
use App\Services\FirebaseService;
use App\Services\MatchmakingFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    protected FirebaseService $firebaseService;

    public function __construct(
        FirebaseService $firebaseService
    ) {
        $this->firebaseService = $firebaseService;
    }
    public function paymentMethods()
    {
        $methods = PaymentMethod::all();
        if (!$methods){
            return $this->apiResponse(['PaymentMethods' => null], 'PaymentMethods not found', 404);
        }
        return $this->apiResponse(['PaymentMethods' => $methods], 'PaymentMethods get successfully');
    }
    public function paymentPlans()
    {
        $plans = PaymentPlan::with('variations')->get();
        if (!$plans){
            return $this->apiResponse(['PaymentPlans' => null], 'PaymentPlans not found', 404);
        }
        return $this->apiResponse(['PaymentPlans' => $plans], 'PaymentPlans get successfully');
    }
    public function myPaymentHistory()
    {
        $paymentHistory = UserPayment::where('user_id', Auth::id())->orderby('id', 'desc')->get();
        if (!$paymentHistory){
            return $this->apiResponse(['PaymentHistory' => null], 'PaymentHistory not found', 404);
        }
        return $this->apiResponse(['PaymentHistory' => $paymentHistory], 'PaymentHistory get successfully');
    }
    public function userCreatePayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'required|integer|in:1,2',
                'type_id' => 'required_if:type,1|exists:payment_plans,id',
                'amount' => 'required|numeric|min:0.01',
                'payment_method' => 'required|integer|in:1,2,3,4',
                'user_note' => 'nullable|string|max:500',
                'payment_proof' => 'file|image',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(
                    [],
                    $validator->errors()->first(),
                    422,
                    $validator->errors()->toArray()
                );
            }

            if ($request->type == 1) {
                $plan = PaymentPlan::find($request->type_id);
                if (!$plan) {
                    return $this->apiResponse(
                        [],
                        'Payment plan not found',
                        404
                    );
                }
            }

            $payment = UserPayment::create([
                'user_id' => Auth::id(),
                'type' => $request->type,
                'type_id' => $request->type_id,
                'amount' => $request->amount,
                'currency' => 'PKR',
                'payment_method' => $request->payment_method,
                'user_note' => $request->user_note,
                'paid_at' => now(),
                'status' => 0,
            ]);

            if ($request->hasFile('payment_proof')) {
                $front_image_file = $request->file('payment_proof');
                $front_image_file_path = 'assets/images/payments/';
                $front_image_file_name = time() . '_' . $front_image_file->getClientOriginalName();
                $front_image_file->move(($front_image_file_path), $front_image_file_name);

                $imagePath = $front_image_file_path . $front_image_file_name;
                $payment->update(['payment_proof' => $imagePath]);
            }

            return $this->apiResponse(
                $payment->fresh(),
                'Payment created successfully',
                201
            );

        } catch (\Exception $e) {
            return $this->apiResponse(
                [],
                'Payment creation failed: ' . $e->getMessage(),
                500
            );
        }
    }

    public function adminActionOnPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'payment_id' => 'required|exists:user_payments,id',
                'admin_note' => 'nullable|string|max:500',
                'status' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return $this->apiResponse(
                    [],
                    $validator->errors()->first(),
                    422,
                    $validator->errors()->toArray()
                );
            }
            if ($request->status === 1) {
                $userPayment = UserPayment::with('user')->find($request->payment_id);
                $paymentAmount = $userPayment->amount;

                if (!empty($userPayment->user->referal_code)) {
                    // Platform gets 25%
                    $platformFees = $paymentAmount * 0.25;

                    // Direct referral gets 50%
                    $directReferralAmount = $paymentAmount * 0.50;

                    // Indirect referrals share 25%
                    $indirectReferralAmount = $paymentAmount * 0.25;

                    $directReferrer = MmProfile::where('my_refral_code', $userPayment->user->referal_code)->first();
                    if ($directReferrer) {
                        // Give 50% points to direct referrer
                        $this->addPointsToUser(
                            $directReferrer->user_id,
                            $directReferralAmount,
                            $userPayment->user_id, // The user who made the payment
                            $request->payment_id
                        );

                        // Build the referral chain for indirect referrals (25%)
                        $referralChain = $this->buildReferralChain($directReferrer);

                        if (count($referralChain) > 0) {
                            // Calculate points per person in the chain
                            $pointsPerPerson = $indirectReferralAmount / count($referralChain);
                            // Distribute points to each person in the referral chain
                            foreach ($referralChain as $referrer) {
                                $this->addPointsToUser(
                                    $referrer->user_id,
                                    $pointsPerPerson,
                                    $userPayment->user_id, // The user who made the payment
                                    $request->payment_id
                                );
                            }
                        }
                    }

                } else {
                    // No referral code, platform gets 100%
                    $platformFees = $paymentAmount * 1.00;

                    // Give all points to admin (user_id = 1)
                    $this->addPointsToUser(
                        1, // Admin user ID
                        $platformFees,
                        $userPayment->user_id, // The user who made the payment
                        $request->payment_id
                    );
                }

                // Log the transaction or update payment status
                $userPayment->update(['status' =>$request->status]);
            }


            return $this->apiResponse(
                $userPayment->fresh(),
                'Payment created successfully',
                201
            );

        } catch (\Exception $e) {
            return $this->apiResponse(
                [],
                'Payment creation failed: ' . $e->getMessage(),
                500
            );
        }
    }
    private function buildReferralChain($startUser, $visited = []) {
        $chain = [];
        $currentUser = $startUser;
        // Prevent infinite loops by tracking visited users
        if (in_array($currentUser->id, $visited)) {
            return $chain;
        }
        $visited[] = $currentUser->id;

        // Keep following the chain until no more referral codes

        while ($currentUser && !empty($currentUser->user->referal_code)) {
            $nextReferrer = MmProfile::where('my_refral_code', $currentUser->user->referal_code)->first();
            if ($nextReferrer && !in_array($nextReferrer->id, $visited)) {
                $chain[] = $nextReferrer;
                $visited[] = $nextReferrer->id;
                $currentUser = $nextReferrer;
            } else {
                break; // Break if no referrer found or circular reference detected
            }
        }

        return $chain;
    }

    private function addPointsToUser($userId, $points, $whoAddReferalId = null, $transactionId = null) {
        $Userpoints =UserPoint::create([
            'user_id' => $userId,
            'type' => 1, // 1 = IN (points coming in)
            'points' => $points,
            'transaction_type' => 1, // 1 = referral_points
            'transaction_id' => $transactionId, // You can pass payment_id here
            'who_add_referal' => $whoAddReferalId, // ID of the user who made the payment
        ]);

        if ($Userpoints){
        try {
            // Get device tokens for the receiver
            $notificationReceiver = DeviceToken::where('user_id', $userId)
                ->pluck('device_token');

            if ($notificationReceiver->isEmpty()) {
                Log::error('No device token found for user ID: ' .$userId);
                return false;
            }

            $payload =[
                'type' => 'referral_points_received',
                'type_id' => $Userpoints->id,
                'status' => 0,
                'sender_id' => $whoAddReferalId,
                'receiving_user_id' => $userId
            ];
            // Send notification via Firebase
            $this->firebaseService->sendNotification(
                target: $notificationReceiver,
                title: 'Congrats! you have got '.$points.' Rs',
                body: 'you have got '.$points.' from your Referral code ',
                payload: $payload
            );
            Notification::create([
                'user_id' => $userId,
                'title' => 'Congrats! you have got '.$points.' Rs',
                'body' => 'you have got '.$points.' from your Referral code ',
                'payload' => $payload,
                'status' => 0
            ]);
            return true;

        } catch (\Exception $e) {
            Log::error('Error sending notification: ' . $e->getMessage());
            return false;
        }
        }
    }

    public function myWallet()
    {
        $userPoints = UserPoint::with('whoAddedReferral.mmProfile')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        $totalIn  = $userPoints->where('type', 1)->sum('points');
        $totalOut = $userPoints->where('type', 2)->sum('points');

        $remainingAmount = $totalIn - $totalOut;

        return $this->apiResponse([
            'transactions'     => $userPoints,
            'remaining_amount' => $remainingAmount,
        ], 'Wallet fetched successfully', 200);
    }

}
