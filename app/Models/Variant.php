<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property array<array-key, mixed> $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $translations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VariantOption> $variantOptions
 * @property-read int|null $variant_options_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Variant extends Model
{
    use HasTranslations;
    public $translatable =['name'];
    protected $fillable = [
        'name',
    ];
    public function variantOptions()
{
    return $this->hasMany(VariantOption::class);
}

}
