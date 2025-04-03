<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'price',
        'stock',
        'sub_category_id',
    ];

    /**
     * Verificar si esta presente la familia para traer sus respectivos productos
     */
    public function scopeVerifyProduct($query, $family_id)
    {
        $query->when($family_id, function ($query, $family_id) {
            $query->whereHas('subCategory.category', function ($query) use ($family_id) {
                $query->where('family_id', $family_id);
            });
        });
    }
    
    /**
     * Verificar si esta presente la categoria para traer sus respectivos productos
     */
    public function scopeVerifyCategory($query, $category_id)
    {
        $query->when($category_id, function ($query, $category_id) {
            $query->whereHas('subCategory', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });
        });
    }
    
    /**
     * Verificar si esta presente la subcategoria para traer sus respectivos productos
     */
    public function scopeVerifySubCategory($query, $subcategory_id)
    {
        $query->when($subcategory_id, function ($query, $subcategory_id) {
            $query->where('sub_category_id', $subcategory_id);
        });
    }

    /**
     * Aplica los filtros segun el select de ordenar por:
     */
    public function scopeCustomOrder($query, $orderBy)
    {
        $query->when($orderBy == 1, function ($query) {
            $query->orderBy('created_at', 'desc');
        })
        ->when($orderBy == 2, function ($query) {
            $query->join('variants', 'variants.product_id', '=', 'products.id')
                ->orderBy('variants.price', 'desc');
        })
        ->when($orderBy == 3, function ($query) {
            $query->join('variants', 'variants.product_id', '=', 'products.id')
                ->orderBy('variants.price', 'asc');
        });
    }

    /**
     * Filtros segun los features de las variantes
     */
    public function scopeSelectFeatures($query, $select_features)
    {
        $query->when($select_features, function ($query, $select_features) {
            $query->whereHas('variants.features', function ($query) use ($select_features) {
                $query->whereIn('features.id', $select_features);
            });
        });
    }

    /**
     * Filtro del buscador
     */
    public function scopeSearch($query, $search)
    {
        $query->when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }

    //relationShips
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable')->chaperone();
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Option::class)
                    ->using(OptionProduct::class)
                    ->withPivot('features')
                    ->withTimestamps();
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class)->chaperone();
    }
}
