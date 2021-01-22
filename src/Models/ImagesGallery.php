<?php

namespace Kiyani\Gallery\Models;

use Illuminate\Database\Eloquent\Model;

class ImagesGallery extends Model
{
    protected $table = 'images_gallery';
    protected $fillable = [
        'title',
        'url',
        'gallery_id' ,
        'updated_at' ,
        'created_at' ,
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
