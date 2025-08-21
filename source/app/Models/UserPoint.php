<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'points',
        'transaction_type',
        'transaction_id',
        'who_add_referal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function whoAddedReferral()
    {
        return $this->belongsTo(User::class, 'who_add_referal');
    }
}
