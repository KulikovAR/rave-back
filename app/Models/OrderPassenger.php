<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderPassenger extends Model
{
    use  HasUuids, HasFactory;

    protected $guarded = [];

    protected $casts = [
        'firstname'        => 'encrypted',
        'lastname'         => 'encrypted',
        'document_number'  => 'encrypted',
        'document_expires' => 'encrypted',
        'birthday'         => 'encrypted',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
