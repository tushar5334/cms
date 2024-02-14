<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ColumnFillable;
use Illuminate\Support\Str;
use App\Services\ImageService;
use Database\Factories\SliderImageFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;


class SliderImage extends Model
{
    use HasFactory;
    use SoftDeletes;
    use ColumnFillable;
    protected $table = 'slider_images';
    protected $primaryKey = 'slider_id';
    public $incrementing = false;

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return new SliderImageFactory();
    }

    protected static function boot()
    {
        parent::boot();
        SliderImage::creating(function ($model) {
            $model->slider_id
                = Str::uuid();
        });
    }

    public static function createOrUpdateSliderImage(array $request, string $slider_id): object
    {
        $slider_image = SliderImage::updateOrCreate(
            ['slider_id' => $slider_id],
            $request
        );
        return $slider_image;
    }

    /**
     * Get the user's profile picture.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function displaySliderImage(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => (new ImageService())->getFileUrl('slider_images', $attributes['slider_image'], 'public'),
        );
    }
}
