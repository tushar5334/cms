<?php

namespace App\Models\Admin;

use App\Services\ImageService;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use App\Libraries\General;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Admin extends Authenticatable
{
    protected $guard = 'admin';
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Get the user's profile picture.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function displayPicture(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => (new ImageService())->getFileUrl('user_images', $attributes['profile_picture'], 'public'),
        );

        /*  return new Attribute(
            get: fn ($value, $attributes) => General::getPublicFileUrl('user_images', $attributes['profile_picture'], 'public'),
        ); */
    }
}
