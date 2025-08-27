<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

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
            'type' => 'array',
            'relation' => 'clientAbout',
            'field' => 'marital_status_id',
            'calculate' => true
        ],
        'gender_id' => [
            'type' => 'exact',
            'field' => 'gender',
            'calculate' => false
        ],
        'house_status_id' => [
            'type' => 'exact',
            'relation' => 'clientBackground',
            'field' => 'house_status_id',
            'calculate' => true
        ],

        'city_id' => [
            'type' => 'array',
            'relation' => 'clientBackground',
            'field' => 'city',
            'calculate' => true
        ],
        'education_id' => [
            'type' => 'array',
            'relation' => 'clientProfession',
            'field' => 'education_id',
            'calculate' => true
        ],

        'employment_status_id' => [
            'type' => 'array',
            'relation' => 'clientProfession',
            'field' => 'employment_status_id',
            'calculate' => true
        ],

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
        'nationalities' => [
            'type' => 'array',
            'relation' => 'nationalities',
            'field' => 'id',
            'calculate' => true
        ],
        'height' => [
            'type' => 'range',
            'relation' => 'clientLifeStyle',
            'field' => 'height',
            'min_key' => 'min_height',
            'max_key' => 'max_height',
            'calculate' => true
        ],
        'weight' => [
            'type' => 'range',
            'relation' => 'clientLifeStyle',
            'field' => 'weight',
            'min_key' => 'min_weight',
            'max_key' => 'max_weight',
            'calculate' => true
        ],
        'family_class_id' => [
            'type' => 'array',
            'relation' => 'clientFamilyInfo',
            'field' => 'family_class_id',
            'calculate' => true
        ],
        'house_size' => [
            'type' => 'range',
            'relation' => 'clientBackground',
            'field' => 'house_size',
            'min_key' => 'min_house_size',
            'max_key' => 'max_house_size',
            'calculate' => true
        ],

    ];

    public function getFilteredUsers(array $filters)
    {
        $this->activeFilters = $filters;
        $requestingUserId = $filters['requestingUserID'] ?? null;
        Log::info('Furqang Requesting User ID in Filter Service', ['requestingUserId' => $requestingUserId]);

        // Eager load all necessary relationships
        $query = User::with([
            'clientAbout',
            'clientBackground',
            'nationalities',
            'clientProfession',
            'clientIslamicValue',
            'clientLifeStyle',
            'clientFamilyInfo',
            'sentMatchRequests',
            'receivedMatchRequests'
        ]);

        // Apply gender filter first (special case - hard filter)
        if (isset($filters['gender_id'])) {
            $query->whereHas('clientAbout', fn($q) =>
            $q->where('gender_id', $filters['gender_id'])
            );
        }


        // Get all users (after hard filters)
        $users = $query->get();
        // Generate user cards with match percentage
        $userCards = $users->map(function ($user) use ($requestingUserId) {
            $matchPercentage = $this->calculateMatchPercentage($user);
            return $user->clientProfileCard($matchPercentage, $requestingUserId);
        });

// Sort by match percentage (descending)
        $sortedCards = $userCards->sortByDesc('match_percentage')->values();

// Paginate results
        return $this->paginateResults(
            $sortedCards,
            $filters['page'] ?? 1,
            $filters['per_page'] ?? 50
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

                    $minValid = is_null($min) || $age >= $min;
                    $maxValid = is_null($max) || $age <= $max;
                    return $minValid && $maxValid;
                } catch (\Exception $e) {
                    return false;
                }
            }

            if ($attributeKey === 'height') {
                try {
                    $userHeight = (float)$fieldValue;  // Convert "5.4" to 5.4

                    $minValid = is_null($min) || $userHeight >= (float)$min;
                    $maxValid = is_null($max) || $userHeight <= (float)$max;
                    return $minValid && $maxValid;
                } catch (\Exception $e) {
                    return false;
                }
            }

            if ($attributeKey === 'weight') {

                $minValid = is_null($min) || $fieldValue >= $min;
                $maxValid = is_null($max) || $fieldValue <= $max;
                return $minValid && $maxValid;
            }

            if ($attributeKey === 'salary') {
                \Log::debug("Salary Check", [
                    'user_id' => $user->id,
                    'salary' => $fieldValue,
                    'min_salary' => $min,
                    'max_salary' => $max
                ]);
            }

            // Special handling for house size range (stored as integer marla)
            if ($attributeKey === 'house_size') {
                try {
                    $houseSize = (int)$fieldValue;  // Convert string to integer
                    $minValid = is_null($min) || $houseSize >= (int)$min;
                    $maxValid = is_null($max) || $houseSize <= (int)$max;
                    return $minValid && $maxValid;
                } catch (\Exception $e) {
                    return false;
                }
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
                return $result;
            }

            // For cities (stored as single ID in clientBackground.city column)
            if ($config['relation'] === 'clientBackground' && $attributeKey === 'city_id') {
                $cityId = optional($relation)->{$config['field']};
                $result = $cityId && in_array($cityId, $value);
                return $result;
            }

            if ($config['relation'] === 'clientProfession' && $attributeKey === 'education_id') {
                $educationId = optional($relation)->{$config['field']};
                $result = $educationId && in_array($educationId, $value);
                return $result;
            }

            if ($config['relation'] === 'clientProfession' && $attributeKey === 'employment_status_id') {
                $employmentStatusId = optional($relation)->{$config['field']};
                $result = $employmentStatusId && in_array($employmentStatusId, $value);
                return $result;
            }

            if ($config['relation'] === 'clientAbout' && $attributeKey === 'marital_status_id') {
                $maritalStatusId = optional($relation)->{$config['field']};
                $result = $maritalStatusId && in_array($maritalStatusId, $value);
                return $result;
            }

            if ($config['relation'] === 'clientFamilyInfo' && $attributeKey === 'family_class_id') {
                $familyClassId = optional($relation)->{$config['field']};
                $result = $familyClassId && in_array($familyClassId, $value);
                return $result;
            }

            $result = $relation->pluck($config['field'])->intersect($value)->isNotEmpty();
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
