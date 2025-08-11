<?php

namespace App\Http\Controllers\API;
use App\Services\MatchmakingFilterService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MatchmakingController extends Controller
{
    private $filterService;

    public function __construct(MatchmakingFilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function findMatches(Request $request)
    {
        try {
            $validated = $request->validate([
                'min_age' => 'sometimes|integer|min:18|max:100',
                'max_age' => 'sometimes|integer|min:18|max:100|gte:min_age',
                'marital_status_id' => 'sometimes|exists:marital_statuses,id',
                'gender' => 'required',

                'nationalities' => 'sometimes|array',
                'nationalities.*' => 'integer|exists:nationalities,id',
                'house_status' => 'sometimes|in:1,2,3,4',
                'city_id' => 'sometimes|exists:cities,id',

                'education_id' => 'sometimes|exists:educations,id',
                'employment_status' => 'sometimes|in:1,2,3,4,5,6,7',
                'min_salary' => 'sometimes|integer|min:0',
                'max_salary' => 'sometimes|integer|gte:min_salary',
                'occupations' => 'sometimes|array',
                'occupations.*' => 'exists:occupations,id',

                'religion_id' => 'sometimes|exists:religions,id',
                'sect_id' => 'sometimes|array',
                'sect_id.*' => 'exists:sects,id',
                'cast_id' => 'sometimes|array',
                'cast_id.*' => 'exists:casts,id',
                'prayer_frequency' => 'sometimes|integer|min:1|max:5',
                'where_hijab' => 'sometimes|boolean',
                'keep_beared' => 'sometimes|boolean',
                'where_nikab' => 'sometimes|boolean',

                'page' => 'sometimes|integer|min:1',
                'per_page' => 'sometimes|integer|min:1|max:100'
            ]);

            $results = $this->filterService->getFilteredUsers($validated);

            // Check if results are empty (if that's a concern)
            if (empty($results)) {
                return $this->apiResponse([
                    'data' => [
                        'users' => [],
                        'total_possible_filters' => 0
                    ]
                ], 'No matches found');
            }

            return $this->apiResponse([
                'data' => [
                    'users' => $results,
                    'total_possible_filters' => count(array_filter($validated, function($value, $key) {
                        $excludedKeys = ['gender', 'page', 'per_page'];
                        return !in_array($key, $excludedKeys) && !is_null($value);
                    }, ARRAY_FILTER_USE_BOTH))
                ]
            ], 'Matches retrieved successfully');

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
}
