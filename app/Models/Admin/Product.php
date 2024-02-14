<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ColumnFillable;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Models\Admin\ProductSegment;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductCompany;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use ColumnFillable;
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    public $incrementing = false;
    //protected $with = ['product_segments'];
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return new ProductFactory();
    }

    protected static function boot()
    {
        parent::boot();
        Product::creating(function ($model) {
            $model->product_id
                = Str::uuid();
        });
    }

    public static function createOrUpdateProduct(array $request, string $product_id): string
    {
        $product = Product::updateOrCreate(
            ['product_id' => $product_id],
            $request
        );
        if ($product_id === '') {
            $product_id = $product->product_id->toString();
        }
        return $product_id;
    }

    /**
     * Get the product segment for the product
     */
    public function product_segments(): HasMany
    {
        return $this->hasMany(ProductSegment::class, 'product_id', 'product_id')->select('segment_id');
    }

    /**
     * Get the product segment for the product
     */
    public function product_categories(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'product_id', 'product_id')->select('category_id');
    }

    /**
     * Get the product segment for the product
     */
    public function product_companies(): HasMany
    {
        return $this->hasMany(ProductCompany::class, 'product_id', 'product_id')->select('company_id');
    }
}
