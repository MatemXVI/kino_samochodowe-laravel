<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenueImage extends Model
{
    protected $fillable = ['venue_id', 'image_filename'];

    public function venue(){
        return $this->belongsTo(Venue::class);
    }
}
