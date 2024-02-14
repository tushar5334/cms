<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ColumnFillable;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use ColumnFillable;
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    public $incrementing = false;
    protected $hidden = ['pivot'];
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
}
