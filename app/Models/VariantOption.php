<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property int $variant_id
 * @property array<array-key, mixed> $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductVariant> $productVariants
 * @property-read int|null $product_variants_count
 * @property-read mixed $translations
 * @property-read \App\Models\Variant $variant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantOption query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantOption whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantOption whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantOption whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantOption whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantOption whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VariantOption whereVariantId($value)
 * @mixin \Eloquent
 */
class VariantOption extends Model
{
    use HasTranslations;
    public $translatable =['name'];
    protected $fillable = [
        'variant_id',
        'name'
    ];
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
    public function productVariants()
    {return $this->belongsToMany(ProductVariant::class,'product_variant_options'
        );
    }
}
