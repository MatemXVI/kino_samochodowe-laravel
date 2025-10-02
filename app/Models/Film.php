<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = ['title', 'director', 'cast', 'screenplay', 'genre', 'duration', 'country', 'production_year', 'description', 'user_id', 'editor_id'];

    public function getPath(){
        return "img/films/".$this->id;
    }
    public function getPathPoster(){
        return "img/films/".$this->id."/poster/";
    }

    public function getPathImages(){
        return "img/films/".$this->id."/images/";
    }

    public function screenings(){
        return $this->hasMany(Screening::class);
    }

    public function film_images(){
        return $this->hasMany(FilmImage::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function editor(){
        return $this->belongsTo(User::class, 'editor_id');
    }
}
