<?php

namespace App\Providers;

use App\Models\Front\Page;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $title = "V K Enterprise";
            $meta_title = "V K Enterprise";
            $meta_keywords = "V K Enterprise";
            $meta_description = "V K Enterprise";
            $description = "V K Enterprise";
            $name = "V K Enterprise";
            $display_header_image = "";

            $page_slug = (Request::path() == '/') ? "" : Request::path();
            $pageDetail = Page::where('page_slug', $page_slug)->first();
            if ($pageDetail) {
                $title = $pageDetail->title;
                $meta_title = $pageDetail->meta_title;
                $meta_keywords = $pageDetail->meta_keywords;
                $meta_description = $pageDetail->meta_description;
                $description = $pageDetail->description;
                $name = $pageDetail->name;
                $display_header_image = $pageDetail->display_header_image;
            }
            $view->with(compact('title', 'meta_title', 'meta_keywords', 'description', 'meta_description', 'name', 'display_header_image'));
        });
    }
}
