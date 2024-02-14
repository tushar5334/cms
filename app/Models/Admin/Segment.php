<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ColumnFillable;
use Database\Factories\SegmentFactory;
use Illuminate\Support\Str;

class Segment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use ColumnFillable;
    protected $table = 'segments';
    protected $primaryKey = 'segment_id';
    public $incrementing = false;

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return new SegmentFactory();
    }

    protected static function boot()
    {
        parent::boot();
        Segment::creating(function ($model) {
            $model->segment_id
                = Str::uuid();
        });
    }
}
