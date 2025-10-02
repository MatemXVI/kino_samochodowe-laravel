<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScreeningImage extends Model
{
    public $timestamps = false;
    protected $fillable = ['screening_id', 'image_filename'];
    public function screening(){
        return $this->belongsTo(Screening::class);
    }
}
