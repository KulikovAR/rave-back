<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use  HasUuids, SoftDeletes;

    const CREATED    = 'created';
    const PROCESSING = 'processing';
    const FINISHED   = 'finished';
    const CANCELED   = 'canceled';
    const EXPIRED    = 'expired';
    const ERROR      = 'error';
    const PAYED      = 'payed';

    const NORMAL  = 'normal';
    const VIP     = 'vip';
    const PREMIUM = 'premium';


    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
