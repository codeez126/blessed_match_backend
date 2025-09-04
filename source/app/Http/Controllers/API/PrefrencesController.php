<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ClientPreference;
use App\Models\MmProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrefrencesController extends Controller
{
    public function storeClientPreferences(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user){
            return response()->json([
                'status'  => false,
                'message' =>  'User Not Found',
                'data'    => [],
                'errors'  => 'User Not Found'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'preferences'   => 'required|array|min:1',
            'preferences.*.preference_type' => 'required|exists:preferences,id',
            'preferences.*.type_id'        => 'nullable|integer',
            'preferences.*.min_value'      => 'nullable|integer',
            'preferences.*.max_value'      => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'data'    => [],
                'errors'  => $validator->errors()->messages()
            ], 422);
        }

        try {
            $validated = $validator->validated();

            // delete old preferences once, not inside loop
            ClientPreference::where('user_id', $user->id)->delete();

            foreach ($validated['preferences'] as $pref) {
                ClientPreference::create([
                    'user_id'         => $user->id,
                    'preference_type' => $pref['preference_type'],
                    'type_id'         => $pref['type_id'] ?? null,
                    'min_value'       => $pref['min_value'] ?? null,
                    'max_value'       => $pref['max_value'] ?? null,
                ]);
            }
            $preferences = ClientPreference::with('preference')
                ->where('user_id', $user->id)
                ->get()
                ->map(function ($pref) {
                    $pref->setRelation('type_model', $pref->typeModel()->first());
                    return $pref;
                });


            return $this->apiResponse([
                'preferences' => $preferences
            ], 'Preferences updated successfully');

        } catch (\Exception $e) {
            return $this->apiResponse([], 'Preferences update failed: ' . $e->getMessage(), 500);
        }
    }
    public function removeClientPreferences(Request $request)
    {
        try {
            $user = User::find($request->user_id);

            if (!$user) {
                return response()->json([
                    'status'  => false,
                    'message' => 'User Not Found',
                    'data'    => [],
                    'errors'  => 'User Not Found'
                ], 422);
            }

            ClientPreference::where('user_id', $user->id)->delete();

            return $this->apiResponse([
                null,
            ], 'Preferences Deleted successfully');

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'data'    => [],
                'errors'  => $e->getMessage()
            ], 500);
        }
    }


}
