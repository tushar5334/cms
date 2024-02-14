<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ColumnFillable;
use Illuminate\Support\Str;

class ProductCompany extends Model
{
    use HasFactory;
    use ColumnFillable;
    protected $table = 'product_companies';
    protected $primaryKey = 'product_company_id';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        ProductCompany::creating(function ($model) {
            $model->product_company_id
                = Str::uuid();
        });
    }

    public static function createManyProductCompanies(array $productCompaniesData = [])
    {
        return ProductCompany::insert($productCompaniesData);
    }
}
