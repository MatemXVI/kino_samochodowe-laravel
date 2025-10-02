<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];

    protected $fillable = ["price", "parking_spot_number", "screening_id"];

    public function dataQR(): string
    {
        return implode(' ', [
            $this->id,
            $this->screening_id,
            $this->parking_spot_number,
            $this->user_id
        ]);
    }


    public function screening(){
        return $this->belongsTo(Screening::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
