<?php
namespace Kiyani\Gallery;

use Illuminate\Support\ServiceProvider;

class GalleryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('gallery' ,function (){
            return new Gallery();
        });
    }

    public function boot()
    {
        require_once __DIR__.'/Http/routes.php' ;
//        $this->mergeConfigFrom(__DIR__.'Config/app.php' , 'gallery');
        $this->loadViewsFrom(__DIR__.'/Views' , 'gallery');
        $this->mergeConfigFrom(__DIR__.'/Config/app.php' ,'gallery');
        $this->loadMigrationsFrom(__DIR__.'/Migrations');
        $this->publishes([
            __DIR__.'/Migrations' => database_path('/migrations') ,
            __DIR__.'/Views' => resource_path('/views')
        ]);
        $this->publishes([
            __DIR__.'/Public' => public_path('/'),
        ], 'public');
        $this->publishes([
            __DIR__.'/Config/app.php' => config_path('gallery.php')
        ], 'config');
    }
}
