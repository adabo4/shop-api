<?php

namespace App\Models;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_code',
        'name',
        'slug',
        'ean',
        'sukl_code',
        'product_type',
        'price',
        'is_active',
        'description',
        'composition',
        'dosage',
        'usage',
        'warnings',
    ];

    protected function casts(): array
    {
        return [
            'product_type' => ProductType::class,
            'price' =>  'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}
