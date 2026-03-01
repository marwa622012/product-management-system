<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property string $sku
 * @property array<array-key, mixed> $name
 * @property array<array-key, mixed>|null $description
 * @property int $product_id
 * @property numeric $price
 * @property int $is_active
 * @property string|null $image
 * @property int $stock
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CartItem> $cartItems
 * @property-read int|null $cart_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderProduct> $orderedItems
 * @property-read int|null $ordered_items_count
 * @property-read \App\Models\Product $product
 * @property-read mixed $translations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VariantOption> $variantOptions
 * @property-read int|null $variant_options_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WishList> $wishlist
 * @property-read int|null $wishlist_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductVariant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductVariant extends Model
{
    use HasTranslations;
    public $translatable =['name','description'];
    protected $fillable = [
        'sku',
        'name',
        'product_id',
        'description',
        'price',
        'is_active',
        'image',
        'stock'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id', 'id');
    }
    public function variantOptions()
{
    return $this->belongsToMany(
        VariantOption::class,
        'product_variant_options',   
        'product_variant_id',   
        'variant_option_id'    
    );
}
    // public function  variantOptions()
    // {
    //     return $this->belongsToMany(VariantOptions::class,
    //         'product_variant_option'
    //     );
    // }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orderedItems()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
