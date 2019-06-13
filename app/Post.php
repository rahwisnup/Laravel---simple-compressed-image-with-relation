<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title','body', 'photo_id'];

    public function image(){
        return $this->belongsTo('App\Image_uploaded', 'photo_id');
    }
}
