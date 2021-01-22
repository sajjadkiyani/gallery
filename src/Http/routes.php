<?php
use Kiyani\Gallery\Http\Controllers\GalleryController ;
Route::group(['prefix' => 'dashboard'] ,function (){
    Route::resource('gallery',GalleryController::class);
});
