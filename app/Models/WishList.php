<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int|null $product_variant_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $user
 * @property-read \App\Models\ProductVariant|null $variant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WishList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WishList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WishList query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WishList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WishList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WishList whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WishList whereProductVariantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WishList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WishList whereUserId($value)
 * @mixin \Eloquent
 */
class WishList extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'product_variant_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }

    // public function productVariant()
    // {
    //     return $this->belongsTo(ProductVariant::class);
    // }
}
