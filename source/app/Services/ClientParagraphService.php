<?php
namespace App\Services;

use App\Models\ClientAudioInfo;
use App\Models\User;
use Carbon\Carbon;

class ClientParagraphService
{
    protected $user;
    protected $about;
    protected $genderText;
    protected $pronoun;
    protected $possessive;

    public function generateFirstParagraph($userId)
    {
        $this->user = User::with('clientAbout')->find($userId);

        if (!$this->user || !$this->user->clientAbout) {
            return '';
        }

        $this->about = $this->user->clientAbout;
        $this->setGenderTerms($this->about->gender);

        $parts = [];

        // Full name
        if ($this->about->full_name) {
            $parts[] = "{$this->genderText} name is {$this->about->full_name}.";
        }

        // Age
        if ($this->about->dob) {
            $age = Carbon::parse($this->about->dob)->age;
            $parts[] = "{$this->pronoun} is {$age} years old.";
        }

        // Marital status
        if ($this->about->martial_status) {
            $maritalStatusLabel = $this->getMaritalStatusText($this->about->martial_status);
            $parts[] = "{$this->possessive} marital status is {$maritalStatusLabel}.";
        }

        // Reason for joining
        if ($this->about->reason_txt && $this->about->martial_status != 1) {
            $parts[] = "{$this->possessive} help full information are: {$this->about->reason_txt}.";
        }

        $paragraph = implode(' ', $parts);

        // Save to client_audio_infos table
        ClientAudioInfo::updateOrCreate(
            ['user_id' => $userId],
            ['onboarding_1' => $paragraph]
        );

        return $paragraph;
    }
    public function generateSecondParagraph($userId)
    {
        $user = User::with([
            'clientBackground.province',
            'clientBackground.city',
            'clientBackground.area',
            'clientFamilyInfo',
            'clientFamilyMembers',
            'nationalities'
        ])->find($userId);

        if (!$user || !$user->clientBackground || !$user->clientFamilyInfo) {
            return '';
        }

        $bg = $user->clientBackground;
        $fi = $user->clientFamilyInfo;
        $parts = [];

        if ($bg->province || $bg->city || $bg->area) {
            $province = $bg->province->name ?? '';
            $city = $bg->city->name ?? '';
            $area = $bg->area->name ?? '';

            $location = trim("{$area}, {$city}, {$province}", ', ');
            if ($location) {
                $parts[] = "Lives in {$location}.";
            }
        }

        if ($bg->house_status) {
            $houseMap = [
                1 => 'owns a house',
                2 => 'lives on rent',
                3 => 'lives in a government house',
                4 => 'lives in a joint family system',
            ];
            $statusText = $this->pronoun.' '. $houseMap[$bg->house_status] ?? null;
            if ($statusText) {
                $parts[] = ucfirst($statusText) . '.';
            }
        }

        if ($bg->house_size) {
            $parts[] = "The house size is {$bg->house_size} Marla.";
        }

        if ($user->nationalities && $user->nationalities->count() > 0) {
            $nationalityList = $user->nationalities->pluck('name')->implode(', ');
            $parts[] = "$this->pronoun has nationality of {$nationalityList}.";
        }

        if ($fi->father_occupation) {
            $parts[] = "Father's occupation is {$fi->father_occupation}.";
        }

        if ($fi->mother_occupation) {
            $parts[] = "Mother's occupation is {$fi->mother_occupation}.";
        }

        // Count siblings
        $brothers = $user->clientFamilyMembers->where('type', 2)->where('gender', 1)->count();
        $sisters = $user->clientFamilyMembers->where('type', 2)->where('gender', 2)->count();

        if ($brothers || $sisters) {
            $siblingText = [];
            if ($brothers) $siblingText[] = "{$brothers} brother" . ($brothers > 1 ? 's' : '');
            if ($sisters) $siblingText[] = "{$sisters} sister" . ($sisters > 1 ? 's' : '');
            $parts[] = "Has " . implode(' and ', $siblingText) . ".";
        } else {
            $parts[] = "Has no siblings.";
        }

        $paragraph = implode(' ', $parts);

        // Save to onboarding_2
        ClientAudioInfo::updateOrCreate(
            ['user_id' => $userId],
            ['onboarding_2' => $paragraph]
        );

        return $paragraph;
    }
    public function generateThirdParagraph($userId)
    {
        $user = User::with([
            'clientProfession',
            'clientProfession.education',
            'clientProfession.occupation',
            'userBusinesses'
        ])->find($userId);


        if (!$user || !$user->clientProfession) {
            return '';
        }

        $profession = $user->clientProfession;
        $this->setGenderTerms($profession->gender ?? $user->clientAbout->gender ?? 1);

        $parts = [];

        if ($profession->occupationRelation && $profession->occupationRelation->name) {
            $parts[] = "{$this->pronoun} works as a {$profession->occupationRelation->name}.";
        }

        if ($profession->occupation_grade) {
            $parts[] = "and holds the grade of {$profession->occupation_grade}.";
        }

        if ($profession->employment_status) {
            $employmentStatuses = [
                1 => 'Own Business',
                2 => 'Employed',
                3 => 'Un Employed',
                4 => 'Government Employee',
                5 => 'Business & Employed',
                0 => 'Other'
            ];
            $employmentText = $employmentStatuses[$profession->employment_status] ?? '';
            if ($employmentText) {
                $parts[] = "{$this->pronoun} is a {$employmentText}.";
            }
        }

        if ($profession->education && $profession->education->name) {
            $parts[] = "{$this->possessive} education is {$profession->education->name}.";
        }

        if ($user->userBusinesses && $user->userBusinesses->count() > 0) {
            foreach ($user->userBusinesses as $business) {
                $title = $business->job_title ?? '';
                $name = $business->business_name ?? '';
                $grade = $business->grade ?? '';

                $businessParts = [];
                if ($title) $businessParts[] = "job title is {$title}";
                if ($name) $businessParts[] = "business name is {$name}";
                if ($grade) $businessParts[] = "grade is {$grade}";

                if (!empty($businessParts)) {
                    $parts[] = "{$this->possessive} " . implode(', ', $businessParts) . ".";
                }
            }
        }

        $paragraph = implode(' ', $parts);

        ClientAudioInfo::updateOrCreate(
            ['user_id' => $userId],
            ['onboarding_3' => $paragraph]
        );

        return $paragraph;
    }
    public function generateFourthParagraph($userId)
    {
        $user = User::with([
            'clientIslamicValue.religion',
            'clientIslamicValue.sect',
            'clientIslamicValue.cast',
            'clientAbout',
        ])->find($userId);

        if (!$user || !$user->clientIslamicValue) {
            return '';
        }

        $value = $user->clientIslamicValue;

        // Set gender terms from clientAbout or fallback to 1
        $this->setGenderTerms($user->clientAbout->gender ?? 1);

        $parts = [];

        if ($value->religion && $value->religion->name) {
            $parts[] = "{$this->pronoun} follows the religion of {$value->religion->name}.";
        }

        if ($value->sect && $value->sect->name) {
            $parts[] = "{$this->pronoun} belongs to the sect of {$value->sect->name}.";
        }

        if ($value->cast && $value->cast->name) {
            $parts[] = "{$this->pronoun} is from the {$value->cast->name} caste.";
        }

        if ($value->sub_cast_name) {
            $parts[] = "The sub-caste is {$value->sub_cast_name}.";
        }

        // ✅ Fix gender check (0 is likely male, 1 or 2 is female)
        if ($user->clientAbout->gender == 0){
            if ($value->is_where_hijab) {
                $parts[] = "{$this->pronoun} wears hijab.";
            }

            if ($value->is_where_nikab) {
                $parts[] = "{$this->pronoun} also wears a nikab.";
            }
        } else {
            if ($value->is_have_beared) {
                $parts[] = "{$this->pronoun} has a beard.";
            }
        }

        if ($value->quran_memorization && $value->quran_memorization == 1) {
            $parts[] = "{$this->pronoun} is Hafiz-e-Quran.";
        }

        $paragraph = implode(' ', $parts);

        ClientAudioInfo::updateOrCreate(
            ['user_id' => $userId],
            ['onboarding_4' => $paragraph]
        );

        return $paragraph;
    }



    protected function setGenderTerms($gender)
    {
        $this->genderText = $gender == 1 ? 'Boy' : 'Girl';
        $this->pronoun = $gender == 1 ? 'He' : 'She';
        $this->possessive = $gender == 1 ? 'His' : 'Her';
    }

    protected function getMaritalStatusText($status)
    {
        $map = [
            1 => 'Single',
            2 => 'Married',
            3 => 'Divorced',
            4 => 'Widowed',
        ];

        return $map[$status] ?? 'Unknown';
    }

    // Expose gender variables if needed in other paragraphs
    public function getPronoun()     { return $this->pronoun; }
    public function getPossessive()  { return $this->possessive; }
    public function getGenderText()  { return $this->genderText; }
}
