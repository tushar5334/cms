<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ColumnFillable;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory;
    use ColumnFillable;
    protected $table = 'product_categories';
    protected $primaryKey = 'product_category_id';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        ProductCategory::creating(function ($model) {
            $model->product_category_id
                = Str::uuid();
        });
    }

    public static function createManyProductCategories(array $productCategoryData = [])
    {
        return ProductCategory::insert($productCategoryData);
    }
}
