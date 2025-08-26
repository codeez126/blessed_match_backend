<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchRequest extends Model
{
    protected $fillable = [
        'requesting_user_id',
        'requesting_mm_id',
        'receiving_user_id',
        'receiving_mm_id',
        'status', // See STATUS_* constants below
    ];
    protected $hidden = ['created_at', 'updated_at'];

    const STATUS_REQUESTING_MM_REVIEW = 0;
    const STATUS_RECEIVING_MM_REVIEW = 1;
    const STATUS_RECEIVING_USER_REVIEW = 2;
    const STATUS_REJECTED_BY_REQUESTER = 3;
    const STATUS_REJECTED_BY_RECEIVER = 4;
    const STATUS_ACCEPTED = 5;
    const STATUS_MATCH_COMPLETED = 6;

    // Relationships
    public function requestingUser()
    {
        return $this->belongsTo(User::class, 'requesting_user_id');
    }

    public function requestingMm()
    {
        return $this->belongsTo(User::class, 'requesting_mm_id');
    }

    public function receivingUser()
    {
        return $this->belongsTo(User::class, 'receiving_user_id');
    }

    public function receivingMm()
    {
        return $this->belongsTo(User::class, 'receiving_mm_id');
    }

    /**
     * Helper method to get status as human-readable text
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            self::STATUS_REQUESTING_MM_REVIEW => 'Pending Requesting MM Approval',
            self::STATUS_RECEIVING_MM_REVIEW => 'Pending Receiving MM Approval',
            self::STATUS_RECEIVING_USER_REVIEW => 'Pending User Approval',
            self::STATUS_REJECTED_BY_REQUESTER => 'Rejected by Requesting Side',
            self::STATUS_REJECTED_BY_RECEIVER => 'Rejected by Receiving Side',
            self::STATUS_ACCEPTED => 'Accepted',
            self::STATUS_MATCH_COMPLETED => 'Match Completed',
            default => 'Unknown Status',
        };
    }

    public function scopeWithFullUserDetails($query)
    {
        $userRelations = [
            'profileAvg',
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
        ];

        $mmRelations = [
            'mmProfile',
        ];

        return $query->with([
            'requestingUser' => function($query) use ($userRelations) {
                $query->with($userRelations);
            },
            'requestingMm' => function($query) use ($mmRelations) {
                $query->with($mmRelations);
            },
            'receivingUser' => function($query) use ($userRelations) {
                $query->with($userRelations);
            },
            'receivingMm' => function($query) use ($mmRelations) {
                $query->with($mmRelations);
            }
        ]);
    }}
