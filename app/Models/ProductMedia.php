<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMedia extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'product_id',
        'path',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
