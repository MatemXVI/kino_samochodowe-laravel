<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\FilmImage;
use App\Models\Screening;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;

Carbon::setLocale('pl');

class FilmController extends Controller
{
    public function show(Film $film)
    {
        $screenings = Screening::with(['film', 'venue'])->where('film_id', $film->id)->orderBy('date')->get();
        $images = FilmImage::where('film_id', $film->id)->get();
        $path_poster = $film->getPathPoster();
        $path_images = $film->getPathImages();

        return view('main.films.show', compact('film', 'screenings', 'images', 'path_images', 'path_poster'));
    }

    public function index(Request $request)
    {
        $venueId = $request->query('venue');
        $date = $request->query('date');
        $queryFilms = Film::select('films.*')->distinct()->join('screenings', 'screenings.film_id', '=', 'films.id');

        // pasek select z miejscami
        if ($venueId) {
            $venues = Venue::whereNot('id', $venueId)->orderBy('city')->get();
            $selectedVenue = Venue::findOrFail($venueId);
        } else {
            $venues = Venue::orderBy('city')->get();
            $selectedVenue = null;
        }
        // wszystkie miejsca(nie wybrano miejsca seansu)
        if (!$venueId || $selectedVenue === null) {
            if ($date) {
                $films = $queryFilms->where('date', $date)->orderBy('date')->get();
                foreach ($films as $film) {
                    $hours = Screening::where('film_id', $film->id)->where('date', $date)->orderBy('hour')->get();
                    $film->hours = $hours;
                    $film->path = $film->getPathPoster();
                }

            } else {
                $films = $queryFilms->get();
                foreach ($films as $film) {
                    $hours = Screening::where('film_id', $film->id)->orderBy('hour')->get();
                    $film->hours = $hours;
                    $film->path = $film->getPathPoster();
                }

            }
        } else { // wybrane miejsce seansu
            if ($date) {
                $films = $queryFilms->where([['date', $date], ['venue_id', $venueId]])->orderBy('date')->get();
                foreach ($films as $film) {
                    $hours = Screening::where('film_id', $film->id)->where([['date', $date], ['venue_id', $venueId]])->orderBy('hour')->get();
                    $film->hours = $hours;
                    $film->path = $film->getPathPoster();
                }

            } else {
                $films = $queryFilms->where('venue_id', $venueId)->get();
                foreach ($films as $film) {
                    $hours = Screening::where('film_id', $film->id)->where('venue_id', $venueId)->orderBy('hour')->get();
                    $film->hours = $hours;
                    $film->path = $film->getPathPoster();
                }
            }
        }

        return view('main.films.index', compact('venues', 'selectedVenue', 'venueId', 'films'));
    }
}
