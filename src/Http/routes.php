<?php
use Kiyani\Gallery\Http\Controllers\GalleryController ;
use Kiyani\Gallery\Http\Controllers\ImagesGalleryController;
Route::group(['prefix' => 'dashboard' ,'middleware' => ['web']] ,function (){
    Route::resource('gallery',GalleryController::class);
    Route::resource('image-gallery',ImagesGalleryController::class);
    Route::post('image-gallery', [ImagesGalleryController::class ,'upload'])->name('image.gallery.upload');
    Route::delete('image-gallery/{id}', [ImagesGalleryController::class ,'destroy'])->name('image.gallery.delete');
});
