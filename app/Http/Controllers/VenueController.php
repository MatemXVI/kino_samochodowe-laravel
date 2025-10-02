<?php

namespace App\Http\Controllers;
use App\Models\Venue;
use App\Models\VenueImage;
use App\Models\Screening;

class VenueController extends Controller
{

    public function index(){
        $venues = Venue::orderBy("city")->get();
        $id = null;
        return view("main.venues.show", compact("id",  "venues"));
    }

    public function show(Venue $venue){
        $id = $venue->id;
        $venues = Venue::whereNot("id", $id)->orderBy("city")->get();
        // $venues = Venue::orderByRaw('(id = ?) DESC, city', [$id])->get();
        $images = VenueImage::where("venue_id", $id)->get();
        $screenings = Screening::with(["film", "venue"])->where("venue_id", $id)->orderBy("date")->get();
        $path = $venue->getPath();
        return view("main.venues.show", compact("id", "venue", "venues", "images", "screenings", "path"));
    }


}
