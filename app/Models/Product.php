<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'quantity'];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'product_property')
            ->withPivot('value');
    }

    public function scopeFilterByProperties(Builder $query, array $filters = [])
    {
        foreach ($filters as $propertyName => $values) {
            $values = array_filter((array) $values, fn($value) => !is_null($value) && $value !== '');

            if (!empty($values)) {
                $query->whereHas('properties', function (Builder $q) use ($propertyName, $values) {
                    $q->where('name', $propertyName)
                        ->whereIn('product_property.value', $values);
                });
            }
        }

        return $query;
    }
}