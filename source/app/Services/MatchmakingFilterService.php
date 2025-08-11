<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class MatchmakingFilterService
{
    protected $activeFilters = [];
    protected $filterableAttributes = [
        'age' => [
            'type' => 'range',
            'field' => 'dob',
            'min_key' => 'min_age',
            'max_key' => 'max_age',
            'calculate' => true
        ],
        'marital_status_id' => [
            'type' => 'exact',
            'field' => 'marital_status_id',
            'any_value' => 'any',
            'calculate' => true
        ],
        'gender' => [
            'type' => 'exact',
            'field' => 'gender',
            'calculate' => false // Gender doesn't affect percentage
        ],
//        'nationalities' => [
//            'type' => 'array',
//            'relation' => 'nationalities',
//            'field' => 'id',
//            'calculate' => true
//        ],
        'house_status' => [
            'type' => 'exact',
            'relation' => 'clientBackground',
            'field' => 'house_status',
            'calculate' => true
        ],

        'city_id' => [
            'type' => 'array',
            'relation' => 'clientBackground',
            'field' => 'city',
            'calculate' => true
        ],
        'education_id' => [
            'type' => 'exact',
            'relation' => 'clientProfession',
            'field' => 'education_id',
            'calculate' => true
        ],

//        'employment_status' => [
//            'type' => 'exact',
//            'relation' => 'clientProfession',
//            'field' => 'employment_status',
//            'calculate' => true
//        ],

        'salary' => [
            'type' => 'range',
            'relation' => 'clientProfession',
            'field' => 'avg_income',
            'min_key' => 'min_salary',
            'max_key' => 'max_salary',
            'calculate' => true
        ],

        'occupations' => [
            'type' => 'array',
            'relation' => 'clientProfession',
            'field' => 'occupation',
            'calculate' => true
        ],
        'religion_id' => [
            'type' => 'exact',
            'relation' => 'clientIslamicValue',
            'field' => 'religion_id',
            'calculate' => true
        ],
        'sect_id' => [
            'type' => 'array',
            'relation' => 'clientIslamicValue',
            'field' => 'sect_id',
            'calculate' => true
        ],
        'cast_id' => [
            'type' => 'array',
            'relation' => 'clientIslamicValue',
            'field' => 'cast_id',
            'calculate' => true
        ],
//        'prayer_frequency' => [
//            'type' => 'exact',
//            'relation' => 'clientIslamicValue',
//            'field' => 'prayer_frequency',
//            'calculate' => true
//        ],
//        'where_hijab' => [
//            'type' => 'exact',
//            'relation' => 'clientIslamicValue',
//            'field' => 'is_where_hijab',
//            'calculate' => true,
//        ],
//        'keep_beared' => [
//            'type' => 'exact',
//            'relation' => 'clientIslamicValue',
//            'field' => 'is_have_beared',
//            'calculate' => true,
//        ],

    ];

    public function getFilteredUsers(array $filters)
    {
        $this->activeFilters = $filters;

        // Eager load all necessary relationships
        $query = User::with([
            'clientAbout',
            'clientBackground',
            'nationalities',
            'clientProfession',
            'clientIslamicValue'
        ]);

        // Apply gender filter first (special case - hard filter)
        if (isset($filters['gender'])) {
            $query->whereHas('clientAbout', fn($q) =>
            $q->where('gender', $filters['gender'])
            );
        }

        // Get all users (after hard filters)
        $users = $query->get();
        // Generate user cards with match percentage
        $userCards = $users->map(function ($user) {
            $matchPercentage = $this->calculateMatchPercentage($user);
            return $user->clientProfileCard($matchPercentage);
        });

// Sort by match percentage (descending)
        $sortedCards = $userCards->sortByDesc('match_percentage')->values();

// Paginate results
        return $this->paginateResults(
            $sortedCards,
            $filters['page'] ?? 1,
            $filters['per_page'] ?? 10
        );

    }
    protected function calculateMatchPercentage($user)
    {
        $matchedCount = 0;
        $totalFilters = 0;

        foreach ($this->filterableAttributes as $key => $config) {
            if (!$config['calculate']) continue;

            $isActive = isset($this->activeFilters[$key]) ||
                isset($this->activeFilters[$config['min_key'] ?? '']) ||
                isset($this->activeFilters[$config['max_key'] ?? '']);

            if ($isActive) {
                $totalFilters++;
                $isMatch = $this->isAttributeMatch($user, $key);
                if ($isMatch) {
                    $matchedCount++;
                }
            }
        }
        $percentage = $totalFilters > 0 ? round(($matchedCount / $totalFilters) * 100) : 0;
        return $percentage;
    }

    protected function isAttributeMatch($user, $attributeKey)
    {
        $config = $this->filterableAttributes[$attributeKey];
        $value = $this->activeFilters[$attributeKey] ?? null;

        // Skip if no filter value and no range parameters
        if (is_null($value)) {
            $hasRangeParams = isset($this->activeFilters[$config['min_key'] ?? '']) ||
                isset($this->activeFilters[$config['max_key'] ?? '']);
            if (!$hasRangeParams) return false;
        }

        // Handle exact matches
        if ($config['type'] === 'exact') {
            if ($value === ($config['any_value'] ?? null)) {
                return true;
            }

            $fieldValue = optional($user->{$config['relation'] ?? 'clientAbout'})->{$config['field']};
            return !is_null($fieldValue) && $fieldValue == $value;
        }

        // Handle range filters (age, salary)
        if ($config['type'] === 'range') {
            $fieldValue = optional($user->{$config['relation'] ?? 'clientAbout'})->{$config['field']};
            if (is_null($fieldValue)) return false;

            $min = $this->activeFilters[$config['min_key']] ?? null;
            $max = $this->activeFilters[$config['max_key']] ?? null;

            // Special handling for age range
            if ($attributeKey === 'age') {
                try {
                    $age = Carbon::parse($fieldValue)->age;
                    \Log::debug("Age Filter Check", [
                        'user_id' => $user->id,
                        'dob' => $fieldValue,
                        'calculated_age' => $age,
                        'min_age' => $min,
                        'max_age' => $max,
                        'passes_min' => is_null($min) || $age >= $min,
                        'passes_max' => is_null($max) || $age <= $max
                    ]);

                    $minValid = is_null($min) || $age >= $min;
                    $maxValid = is_null($max) || $age <= $max;
                    return $minValid && $maxValid;
                } catch (\Exception $e) {
                    \Log::error("Age calculation failed for user {$user->id}", [
                        'dob' => $fieldValue,
                        'error' => $e->getMessage()
                    ]);
                    return false;
                }
            }

            // Original handling for other range filters (salary)
            if ($attributeKey === 'salary') {
                \Log::debug("Salary Check", [
                    'user_id' => $user->id,
                    'salary' => $fieldValue,
                    'min_salary' => $min,
                    'max_salary' => $max
                ]);
            }

            $minValid = is_null($min) || $fieldValue >= $min;
            $maxValid = is_null($max) || $fieldValue <= $max;
            return $minValid && $maxValid;
        }

        // Handle array filters (nationalities, occupations)
        if ($config['type'] === 'array') {
            if (empty($value)) return false;

            $relation = $user->{$config['relation']} ?? null;
            if (!$relation) return false;

            // For occupations (stored as single ID)
            if ($config['relation'] === 'clientProfession') {
                $occupationId = optional($relation)->{$config['field']};
                $result = $occupationId && in_array($occupationId, $value);
                \Log::debug("Occupation Check", [
                    'user_id' => $user->id,
                    'occupation_id' => $occupationId,
                    'requested_occupations' => $value,
                    'match' => $result
                ]);
                return $result;
            }

            // For nationalities (many-to-many)
            $result = $relation->pluck($config['field'])->intersect($value)->isNotEmpty();
            \Log::debug("Nationality Check", [
                'user_id' => $user->id,
                'user_nationalities' => $relation->pluck($config['field']),
                'requested_nationalities' => $value,
                'match' => $result
            ]);
            return $result;
        }

        return false;
    }
    protected function paginateResults($collection, $page, $perPage)
    {
        $offset = ($page - 1) * $perPage;
        $items = $collection->slice($offset, $perPage)->all();

        return new LengthAwarePaginator(
            $items,
            $collection->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
