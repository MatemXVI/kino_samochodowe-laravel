<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilmImage extends Model
{
    protected $fillable = ['film_id', 'image_filename'];

    public function getPathImages(){
        return "img/films/".$this->film_id."/images/";
    }
    public function film(){
        return $this->belongsTo(Film::class);
    }
}
