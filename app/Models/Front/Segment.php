<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ColumnFillable;
use Database\Factories\SegmentFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function products(): BelongsToMany
    {
        //return $this->belongsToMany(Tv_show_tags_master_model::class, 'tbl_tv_show_tags', 'ts_master_id', 'ts_tag_master_id');
        return $this->belongsToMany(Product::class, 'product_segments', 'segment_id', 'product_id')
            /* ->select([
            'tbl_tv_show_tags_master.tag'
            ]) */;
    }
}
