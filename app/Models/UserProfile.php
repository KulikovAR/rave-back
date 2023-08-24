<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory, HasUuids;

    const MALE   = 'male';
    const FEMALE = 'female';

    protected $guarded = [];

    protected $casts = [
        'firstname'        => 'encrypted',
        'lastname'         => 'encrypted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
