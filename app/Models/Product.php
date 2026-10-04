<?php

namespace App\Models;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
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

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            $product->slug = static::generateUniqueSlug($product->name);
        });

        static::updating(function (Product $product) {
            if ($product->isDirty('name')) {
                $product->slug = static::generateUniqueSlug(
                    $product->name,
                    $product->id
                );
            }
        });

        static::created(function (Product $product) {
            $product->product_code = 'VIT-' . str_pad(
                (string) $product->id,
                6,
                '0',
                STR_PAD_LEFT
            );

            $product->saveQuietly();
        });
    }

    private static function generateUniqueSlug(
        string $name,
        ?int $ignoreProductId = null
    ): string {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 2;

        while (
            static::query()
            ->where('slug', $slug)
            ->when(
                $ignoreProductId,
                fn($query) => $query->where('id', '!=', $ignoreProductId)
            )
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
