<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\FilmImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FilmsController extends Controller
{

    public function index(){
        $limit = 5;
        $paginator = Film::with(['user', 'editor'])->paginate($limit);
        return view("admin.films.index", compact("paginator"));
    }

    public function create(){
        return view("admin.films.create");
    }

    public function store(Request $request){

        $film = $request->validate([
                'title' => ['required', 'string'],
                'genre' => ['nullable', 'string'],
                'director' => ['nullable', 'string'],
                'country' => ['nullable', 'string'],
                'cast' => ['nullable', 'string'],
                'duration' => ['nullable', 'integer'],
                'screenplay' => ['nullable', 'string'],
                'production_year' => ['nullable', 'integer', 'min:1888'],
                'description' => ['nullable', 'string'],
            ],
            ["title.required" => "Podaj tytuł filmu!"]
                    // ,["duration.required" => "Podaj czas trwania!"]
        );

        $film['user_id'] = Auth::user()->id;
        Film::create($film);
        return redirect(route("admin.films.index"))->with('message', "Film został dodany do bazy.");
    }

    public function edit(Film $film){
        return view("admin.films.edit", compact("film"));
    }

    public function update(Request $request, Film $film){
        $data = $request->validate([
                'title' => ['sometimes','required', 'string'],
                'genre' => ['nullable', 'string'],
                'director' => ['nullable', 'string'],
                'country' => ['nullable', 'string'],
                'cast' => ['nullable', 'string'],
                'duration' => ['nullable', 'integer'],
                'screenplay' => ['nullable', 'string'],
                'production_year' => ['nullable', 'integer', 'min:1888'],
                'description' => ['nullable', 'string']
            ],
            ["title.required" => "Podaj tytuł filmu!"]
        );


        if (!$request->hasAny(['title','genre','director','country','cast','duration','screenplay','production_year','description'])) {
            return back()->with('message', 'Nie wybrano żadnych pól do edycji.');
        }

        $film->fill($data);
        $film->editor_id = Auth::user()->id;

        if (!$film->isDirty()){
            return redirect()->back()->with('message', 'Nie wprowadzono żadnych zmian.');
        }

        $film->save();
        return redirect()->route('admin.films.index')->with('message', 'Film został zmieniony');

    }

    public function destroy(Film $film){
        $title = $film->title;
        Storage::deleteDirectory($film->getPathForCatalog());
        $film->delete();
        return redirect()->route("admin.films.index")->with('message', ("Film ". $title  ." został usunięty z bazy."));
    }

    public function loadFiles(Film $film){
        $path = $film->getPathImages();
        $filmImages = $film->film_images;
        foreach($filmImages as $filmImage){
            $fileName = $filmImage->image_filename;
            $filmId = $filmImage->film_id;
            if (!Storage::disk('public')->exists($path.$fileName)) {
                $filmImage->delete();
            }
        }
            $posterFilename = $film->getPathPoster().$film->poster_filename;
            if (!Storage::disk('public')->exists($posterFilename)) {
                $film->poster_filename = NULL;
                $film->save();
            }

        return view("admin.films.files", compact("posterFilename", "filmImages", "film"));
    }

     public function storePoster(Film $film, Request $request){
        $path = $film->getPathPoster();
        $request->validateWithBag("poster", ["poster" => "required|file|max:8192|mimes:jpeg,png"]);
        $filename = $request->file("poster")->getClientOriginalName();
        $isFileDB = $film->where('poster_filename', $filename)->first();
        $isFileStorage = Storage::exists($path.$filename);
        if($isFileStorage && $isFileDB){
            return back()->with("poster_message", "Plik już istnieje");
        }
        $request->file("poster")->storeAs( $path, $filename);
        $film->poster_filename = $filename;
        $film->editor_id = Auth::user()->id;
        $film->save();
        return back()->with("poster_success", "Plakat został pomyślnie dodany");
    }

    public function renamePoster(Film $film, Request $request){
        $path = $film->getPathPoster();
        $request->validateWithBag("poster",["poster_filename" => "required"]);
        $formFilename = $request->input("poster_filename");
        $currentFilename = $film->poster_filename;
        if($currentFilename == $formFilename){
            return back()->with("poster_message", "Plik nosi taką samą nazwę!");
        }
        if (Storage::disk('public')->exists($path.$formFilename)) {
            return back()->with('message', 'Plik o tej nazwie już istnieje!');
        }
        Storage::disk("public")->move($path.$currentFilename, $path.$formFilename);
        $film->poster_filename = $formFilename;
        $film->editor_id = Auth::user()->id;
        $film->save();
        return back()->with("poster_success", "Nazwa pliku została pomyślnie zmieniona."); //może zrobić galerię - będzie widać dodane zdjęcie, lecz kwestia układu strony, zdjęcia mogą nie za dobrze wyglądać
    }

    public function destroyPoster(Film $film){
        $path = $film->getPathPoster();
        $filename = $film->poster_filename;
        Storage::disk("public")->delete($path.$filename);
        $film->poster_filename = NULL;
        $film->editor_id = Auth::user()->id;
        $film->save();
        return back()->with("poster_success", "Plik został pomyślnie usunięty.");
    }

    public function storeFiles(Film $film, Request $request){
        $path = $film->getPathImages();
        $request->validateWithBag("image", [
                                "image"   => "required|array",
                                "image.*" => "file|max:8192|mimes:jpeg,png",
                                ]);
        foreach($request->file("image") as $file){
            $filename = $file->getClientOriginalName();
            $isFileDB = $film->film_images->where('image_filename', $filename)->where("film_id", $film->id)->first();
            $isFileStorage = Storage::exists($path.$filename);
            if($isFileStorage && $isFileDB){
                return back()->with("message", "Plik ".$filename." już istnieje — nic nie zostało dodane.");
            }
        }
        DB::transaction(function () use($request, $path, $film) {
            foreach($request->file("image") as $file){
                $filename = $file->getClientOriginalName();
                $file->storeAs( $path, $filename);
                $filmImage = new FilmImage;
                $filmImage->image_filename = $filename;
                $filmImage->film_id = $film->id;
                $filmImage->save();
            }
        });
        return back()->with("success", "Wszystkie pliki zostały pomyślnie dodane.");
    }

    public function renameFiles(FilmImage $filmImage, Request $request){
        $path = $filmImage->film->getPathImages();
        $formFilename = $request->input("image_filename");
        $filmImage = $filmImage->find($filmImage->id);
        $currentFilename = $filmImage->image_filename;
        if($currentFilename == $formFilename){
            return back()->with("message", "Plik nosi taką samą nazwę!");
        }
        if (Storage::disk('public')->exists($path.$formFilename)) {
            return back()->with('message', 'Plik o tej nazwie już istnieje!');
        }
        Storage::disk("public")->move($path.$currentFilename, $path.$formFilename);
        $filmImage->image_filename = $formFilename;
        $filmImage->save();
        return back()->with("success", "Nazwa pliku została pomyślnie zmieniona.");
    }

    public function destroyFiles(FilmImage $filmImage){
        $path = $filmImage->film->getPathImages();
        $filename = $filmImage->image_filename;
        Storage::disk("public")->delete($path.$filename);
        $filmImage->delete();
        return back()->with("success", "Plik został pomyślnie usunięty.");
    }

}
