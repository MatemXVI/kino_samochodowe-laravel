<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Ticket;
use App\Models\Venue;
use App\Models\Screening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ScreeningsController extends Controller
{

    public function index(){
        $limit = 5;
        $paginator = Screening::with(['user', 'editor'])->paginate($limit);
        return view("admin.screenings.index", compact("paginator"));
    }

    public function create(){
        $films = Film::all();
        $venues = Venue::all();
        return view("admin.screenings.create", compact("films", "venues"));
    }

    public function store(Request $request){
        $data = $request->validate(
            ['name' => ['required', 'string'],
                    'date' => ['required', 'date'],
                    'hour' => ['required', 'date_format:H:i'],
                    'film_id' => ['required', 'exists:films,id'],
                    'venue_id' => ['required', 'exists:venues,id'],
                    'price'   => ['required', 'numeric', 'min:0']
        ],
        [
                "required" => "Podaj wszystkie dane",
                "price" => "Wartość musi być liczbą!"
                ]
        );

        $data['user_id'] = Auth::user()->id;
        $screening = Screening::create($data);
        $id = $screening->id;
        $screening = Screening::with(['venue'])->where("id", $id)->first();
        $parking_spot_count = $screening->venue->parking_spot_count;
        for($i=1; $i<=$parking_spot_count; $i++){
            Ticket::create(['parking_spot_number' => $i,
                                       'screening_id' => $screening->id
                                       ]);
        }

        return redirect(route("admin.screenings.index"))->with('message', "Seans został dodany do bazy.");
    }

    public function edit(Screening $screening){
        $screening->load(['venue', 'film']);
        $ticket = Ticket::where("screening_id", $screening->id)->first();
        $films = Film::all();
        $venues = Venue::all();
        return view("admin.screenings.edit", compact("screening", "films", "venues", "ticket"));
    }

    public function update(Request $request, Screening $screening){
        $data = $request->validate(
            ['name' => ['sometimes', 'required', 'string'],
                    'date' => ['sometimes', 'required', 'date'],
                    'hour' => ['sometimes', 'required'],
                    'film_id' => ['sometimes', 'required', 'exists:films,id'],
                    'venue_id' => ['sometimes', 'required', 'exists:venues,id'],
                    'price'   => ['sometimes', 'required', 'numeric', 'min:0']
            ]
        );


        if (!$request->hasAny(['name','date','hour','film_id','venue_id','price'])) {
            return back()->with('message', 'Nie wybrano żadnych pól do edycji.');
        }


        $screening->fill($data);
        $screening->editor_id = Auth::user()->id;

        if (!$screening->isDirty()){
            return redirect()->back()->with('message', 'Nie wprowadzono żadnych zmian.');
        }
        $screening->save();
        return redirect()->route('admin.screenings.index')->with('message', 'Seans został zmieniony');

    }

    public function destroy(Screening $screening){
        $name = $screening->name;
        Storage::deleteDirectory($screening->getPath());
        $screening->delete();
        return redirect()->route("admin.screenings.index")->with('message', ("Seans ". $name  ." został usunięty z bazy.")); //usuwane są również bilety należące do danego seansu
    }


//bilety
    public function tickets(Screening $screening){
        $limit = 30;
        $screening->load(['venue', 'film']);
        $paginator = Ticket::with(["screening.venue", "screening.film"])->where("screening_id", $screening->id)->paginate($limit);
        return view("admin.screenings.list", compact("screening","paginator"));
    }

//miejsca parkingowe
    public function parkings(Screening $screening){
        $screening->load(['venue', 'film']);
        $ilosc_miejsc_wolnych = Ticket::whereNull("user_id")->where("screening_id", $screening->id)->count("*");
        $ilosc_miejsc = Ticket::where("screening_id", $screening->id)->count("*");
        $tickets = Ticket::where("screening_id", $screening->id)->get();
        return view("admin.screenings.parking", compact("screening", "ilosc_miejsc_wolnych", "tickets", "ilosc_miejsc"));
    }


    public function loadFiles(Screening $screening){
        $path = $screening->getPath();
        $posterFilename = $path.$screening->poster_filename;
        $screeningImages = $screening->screening_images;
            if (!Storage::disk('public')->exists($posterFilename)) {
                $screening->poster_filename = NULL;
                $screening->save();
            }
        return view("admin.screenings.files", compact("posterFilename", "screeningImages", "screening"));
    }

     public function storePoster(Screening $screening, Request $request){
        $path = $screening->getPath();
        $request->validate( ["poster" => "required|file|max:8192|mimes:jpeg,png"]);
        $filename = $request->file("poster")->getClientOriginalName();
        $isFileDB = $screening->where('poster_filename', $filename)->first();
        $isFileStorage = Storage::exists($path.$filename);
        if($isFileStorage && $isFileDB){
            return back()->with("poster_message", "Plik już istnieje");
        }
        $request->file("poster")->storeAs( $path, $filename);
        $screening->poster_filename = $filename;
        $screening->save();
        return back()->with("poster_message", "Plakat został pomyślnie dodany");
    }

    public function renamePoster(Screening $screening, Request $request){
        $path = $screening->getPath();
        $request->validate(["poster_filename" => "required"]);
        $formFilename = $request->input("poster_filename");
        $currentFilename = $screening->poster_filename;
        if($currentFilename == $formFilename){
            return back()->with("poster_message", "Plik nosi taką samą nazwę!");
        }
        if (Storage::disk('public')->exists($path.$formFilename)) {
            return back()->with('message', 'Plik o tej nazwie już istnieje!');
        }
        Storage::disk("public")->move($path.$currentFilename, $path.$formFilename);
        $screening->poster_filename = $formFilename;
        $screening->save();
        return back()->with("poster_message", "Nazwa pliku została pomyślnie zmieniona.");
    }

    public function destroyPoster(Screening $screening){
        $path = $screening->getPath();
        $filename = $screening->poster_filename;
        Storage::disk("public")->delete($path.$filename);
        $screening->poster_filename = NULL;
        $screening->save();
        return back()->with("poster_message", "Plik został pomyślnie usunięty.");
    }
}
