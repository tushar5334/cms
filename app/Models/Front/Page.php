<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Page extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'pages';
    protected $primaryKey = 'page_id';
    public $incrementing = false;
    //protected $appends = ['display_page_header_image'];
    /**
     * Get the user's profile picture.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function displayHeaderImage(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => (new ImageService())->getFileUrl('page_images', $attributes['page_header_image'], 'public'),
        );
    }
}
