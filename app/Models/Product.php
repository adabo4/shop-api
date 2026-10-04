<?php

namespace App\Models;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'product_code',
        'name',
        'slug',
        'ean',
        'sukl_code',
        'product_type',
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
            'is_active' => 'boolean',
        ];
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
