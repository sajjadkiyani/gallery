<?php
namespace Kiyani\Gallery;

use Illuminate\Support\Facades\Facade;

class GalleryFacade extends Facade
{
    protected static function getFacadeAccessor(){
        return 'gallery';
    }
}
