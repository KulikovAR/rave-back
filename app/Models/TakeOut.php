<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TakeOut extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    const TAKEOUT_CARD = 'credit-card';
    const TAKEOUT_BANK = 'bank';
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent model.
     */
    public function takeoutable()
    {
        return $this->morphTo();
    }
}
