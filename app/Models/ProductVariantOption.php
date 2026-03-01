<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_variant_id
 * @property int $variant_option_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariantOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariantOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariantOption query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariantOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariantOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariantOption whereProductVariantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariantOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariantOption whereVariantOptionId($value)
 * @mixin \Eloquent
 */
class ProductVariantOption extends Model
{
    protected $fillable = [
        'product_variant_id',
        'variant_option_id'
    ];
}
