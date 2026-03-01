<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property string|null $sku
 * @property array<array-key, mixed> $name
 * @property int $category_id
 * @property array<array-key, mixed>|null $description
 * @property numeric|null $price
 * @property bool $is_active
 * @property string|null $image
 * @property int|null $stock
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CartItem> $cart_items
 * @property-read int|null $cart_items_count
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderProduct> $order_items
 * @property-read int|null $order_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductVariant> $product_variants
 * @property-read int|null $product_variants_count
 * @property-read mixed $translations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WishList> $wishlist
 * @property-read int|null $wishlist_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasTranslations;
    public $translatable =['name','description'];
    protected $fillable = [
        'sku',
        'name',
        'category_id',
        'description',
        'price',
        'is_active',
        'stock',
        'image',
        'type'
    ];
    protected $casts = [
    'name' => 'array',
    'is_active' => 'boolean',
];
public function getTotalStockAttribute()
{
    if ($this->type == 'simple') {
        return $this->stock;
    }

    return $this->product_variants->sum('stock');
}

        public function category(){
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'No Category',
        ]);
    }
        public function product_variants(){
        return $this->hasMany(ProductVariant::class);
    }

    public function cart_items(){
        return $this->hasMany(CartItem::class);
    }
    public function wishlist(){
        return $this->hasMany(WishList::class);
    }
    public function order_items(){
        return $this->hasMany(OrderProduct::class);
    }
}
