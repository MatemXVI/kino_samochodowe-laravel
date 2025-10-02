<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use App\Models\VenueImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VenuesController extends Controller
{

    public function index(){
        $limit = 5;
        $paginator = Venue::with(['user', 'editor'])->paginate($limit);
        return view("admin.venues.index", compact("paginator"));
    }

    public function create(){
        return view("admin.venues.create");
    }

    public function store(Request $request){

       $data = $request->validate(
        ['city' => ['required', 'string'],
                'street' => ['required', 'string'],
                'place_type' => ['required', 'string'],
                'parking_spot_count' => ['required', 'integer', 'min:0'],
                'additional info' => ['nullable', 'string']],
               [
                "required" => "Podaj miejscowość, ulicę oraz ilość miejsc parkingowych!",
                "parking_spot_count.*" => "Wartość musi być liczbą!"
               ]
        );

        $data['user_id'] = Auth::user()->id;
        Venue::create($data);


        return redirect(route("admin.venues.index"))->with('message', "Miejsce zostało dodane do bazy.");
    }

    public function edit(Venue $venue){
        return view("admin.venues.edit", compact("venue"));
    }

    public function update(Request $request, Venue $venue){
       $data = $request->validate(
        ['city' => ['sometimes', 'required', 'string'],
                'street' => ['sometimes', 'required', 'string'],
                'place_type' => ['sometimes', 'string'],
                'parking_spot_count' => ['sometimes', 'required', 'integer'],
                'additional_info' => ['nullable', 'string']],
            [
                "required" => "Podaj miejscowość, ulicę oraz ilość miejsc parkingowych!",
                "parking_spot_count.*" => "Wartość musi być liczbą!"
               ]
        );
        if (!$request->hasAny(['city','street','place_type','parking_spot_count','additional_info'])) {
            return back()->with('message', 'Nie wybrano żadnych pól do edycji.');
        }
        $venue->fill($data);
        $venue->editor_id = Auth::user()->id;
        if (!$venue->isDirty()){
            return back()->with('message', 'Nie wprowadzono żadnych zmian.');
        }
        $venue->save();
        return redirect()->route('admin.venues.index')->with('message', 'Miejsce seansu zostało zmienione');

    }

    public function destroy(Venue $venue){
        Storage::deleteDirectory($venue->getPath());
        $venue->delete();
        return redirect()->route("admin.venues.index")->with('message', ("Miejsce zostało usunięte z bazy."));
    }

    public function loadFiles(Venue $venue){
        $venueImages = $venue->venue_images;
        foreach($venueImages as $venueImage){
            $fileName = $venueImage->image_filename;
            $venueId = $venueImage->venue_id;
            $path = $venue->getPath().$fileName;
            if (!Storage::disk('public')->exists($path)) {
                $venueImage->delete();
            }
        }
        return view("admin.venues.files", compact("venueImages", "venue"));
    }

    public function storeFiles(Venue $venue, Request $request){
        $path = $venue->getPath();
        $request->validateWithBag("image", [
                                "image"   => "required|array",
                                "image.*" => "file|max:8192|mimes:jpeg,png",
                                ]);
        foreach($request->file("image") as $file){
            $filename = $file->getClientOriginalName();
            $isFileDB = $venue->venue_images->where('image_filename', $filename)->where("venue_id", $venue->id)->first();
            $isFileStorage = Storage::exists($path.$filename);
            if($isFileStorage && $isFileDB){
                return back()->with("message", "Plik ".$filename." już istnieje — nic nie zostało dodane.");
            }
        }
        DB::transaction(function () use($request, $path, $venue) {
            foreach($request->file("image") as $file){
                $filename = $file->getClientOriginalName();
                $file->storeAs( $path, $filename);
                $venueImage = new VenueImage;
                $venueImage->image_filename = $filename;
                $venueImage->venue_id = $venue->id;
                $venueImage->save();
            }
        });
        return back()->with("success", "Wszystkie pliki zostały pomyślnie dodane.");
    }

    public function renameFiles(VenueImage $venueImage, Request $request){
        $path = $venueImage->venue->getPath();
        $request->validate(["image_filename" => "required"],["image_filename" => "Nie wybrano pliku!"]);
        $formFilename = $request->input("image_filename");
        $venueImage = $venueImage->find($venueImage->id);
        $currentFilename = $venueImage->image_filename;
        if($currentFilename == $formFilename){
            return back()->with("message", "Plik nosi taką samą nazwę!");
        }
        if (Storage::disk('public')->exists($path.$formFilename)) {
            return back()->with('message', 'Plik o tej nazwie już istnieje!');
        }
        Storage::disk("public")->move($path.$currentFilename, $path.$formFilename);
        $venueImage->image_filename = $formFilename;
        $venueImage->save();
        return back()->with("success", "Nazwa pliku została pomyślnie zmieniona.");
    }

    public function destroyFiles(VenueImage $venueImage){
        $path = $venueImage->venue->getPath();
        $filename = $venueImage->image_filename;
        Storage::disk("public")->delete($path.$filename);
        $venueImage->delete();
        return back()->with("success", "Plik został pomyślnie usunięty.");
    }
}
