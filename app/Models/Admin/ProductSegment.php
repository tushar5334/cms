<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ColumnFillable;
use Illuminate\Support\Str;

class ProductSegment extends Model
{
    use HasFactory;
    use ColumnFillable;
    protected $table = 'product_segments';
    protected $primaryKey = 'product_segment_id';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        ProductSegment::creating(function ($model) {
            $model->product_segment_id
                = Str::uuid();
        });
    }

    public static function createManyProductSegments(array $productSegmentData = [])
    {
        return ProductSegment::insert($productSegmentData);
    }
}
