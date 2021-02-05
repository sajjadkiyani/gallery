<?php
namespace Kiyani\Gallery\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class Gallery extends Model
{
    protected $fillable = [
      'title' ,
      'description' ,
      'title_image' ,
      'is_private' ,
      'published_at' ,
    ];
    public function images()
    {
        return $this->hasMany(ImagesGallery::class)->orderBy('created_at','desc');
    }

    public function image()
    {
        return $this->images()->whereId($this->id)->first();
    }
    public function is_private()
    {
        return $this->is_private ? Lang::get('private') : Lang::get('public');
    }

    public function status()
    {
        return $this->status ? Lang::get('published') : Lang::get('not published') ;
    }
}
