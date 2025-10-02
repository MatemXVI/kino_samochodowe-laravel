<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = ['city', 'street', 'place_type', 'parking_spot_count', 'additional_info', 'user_id', 'editor_id'];

    public function getPath(){
        return "img/venues/".$this->id."/";
    }

    public function screenings(){
        return $this->hasMany(Screening::class);
    }
    public function venue_images(){
        return $this->hasMany(VenueImage::class);
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function editor(){
        return $this->belongsTo(User::class, 'editor_id');
    }
}
