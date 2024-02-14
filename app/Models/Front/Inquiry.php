<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ColumnFillable;
use Database\Factories\InquiryFactory;
use Illuminate\Support\Str;

class Inquiry extends Model
{
    use HasFactory;
    use SoftDeletes;
    use ColumnFillable;
    protected $table = 'inquiries';
    protected $primaryKey = 'inquiry_id';
    public $incrementing = false;

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return new InquiryFactory();
    }

    protected static function boot()
    {
        parent::boot();
        Inquiry::creating(function ($model) {
            $model->inquiry_id
                = Str::uuid();
        });
    }
}
