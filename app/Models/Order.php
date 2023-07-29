<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use  HasUuids, HasFactory, SoftDeletes;

    const CREATED      = 'created';
    const PROCESSING   = 'processing';
    const FINISHED     = 'finished';
    const CANCELED     = 'canceled';
    const PRICE_NORMAL = 999;
    const PRICE_HOTEL  = 999;
    const PRICE_VIP    = 1499;
    const TYPE_NORMAL  = 'normal';
    const TYPE_VIP     = 'vip';
    const PAYED        = 'payed';
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function promocode(): BelongsTo
    {
        return $this->belongsTo(Promocode::class);
    }

    public function orderPassenger(): HasMany
    {
        return $this->hasMany(OrderPassenger::class, 'order_id');
    }
}
