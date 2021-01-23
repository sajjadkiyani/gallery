<?php
use Kiyani\Gallery\Http\Controllers\GalleryController ;
Route::group(['prefix' => 'dashboard' ,'middleware' => ['web']] ,function (){
    Route::resource('gallery',GalleryController::class);
});
