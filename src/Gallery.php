<?php
namespace Kiyani\Gallery ;
use Kiyani\Gallery\Models\Gallery as galleries;
class Gallery
{
    public function all()
    {
            return galleries::all();
    }

    public function published()
    {
        return galleries::where('published_at' , '!=' , null)->get();
    }
}
