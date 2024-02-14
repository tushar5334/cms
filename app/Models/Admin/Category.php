<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ColumnFillable;
use App\Services\ImageService;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use ColumnFillable;
    protected $table = 'categories';
    protected $primaryKey = 'category_id';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return new CategoryFactory();
    }

    /**
     * Get the user's profile picture.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function displayCategoryImage(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => (new ImageService())->getFileUrl('category_images', $attributes['category_image'], 'public'),
        );
    }
}
