<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{

    protected $fillable = ["name", "date", "hour", "price", "screening_id", "film_id", "venue_id", "user_id", "editor_id"];
    public function getHourAttribute($value)
    {
    return \Carbon\Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function getPath(){
        return "img/screenings/".$this->id."/";
    }
    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
    public function screening_images(){
        return $this->hasMany(ScreeningImage::class);
    }
    public function film(){
        return $this->belongsTo(Film::class);
    }
    public function venue(){
        return $this->belongsTo(Venue::class);
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function editor(){
        return $this->belongsTo(User::class, 'editor_id');
    }
}
