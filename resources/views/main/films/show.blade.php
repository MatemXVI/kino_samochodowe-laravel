@extends('app')

@section('title', $film->title)

@section('content')

    <div id = "content">
        <div id="plakat">
            <img src = {{ Storage::url($path_poster.$film->poster_filename) }} alt={{ $film->title }} width="261" height="377">
        </div> <!-- brak obrazka niech nie przesuwa tekstu na lewo - utrzyma go na środku !-->
        <div id="description">
            <h2 class="tytul">{{ $film->title }}</h2>
            <div id="informacje">
                <div class="linia"><b>Czas trwania:</b> {{ $film->duration }} min<hr></div>
                <div class="linia"><b>Gatunek:</b> {{ $film->genre }}<hr></div>
                <div class="linia"><b>Kraj:</b> {{ $film->country }}<hr></div>
                <div class="linia"><b>Rok produkcji:</b> {{ $film->production_year }}<hr></div>
                <div class="linia"><b>Reżyseria:</b> {{ $film->director }}<hr></div>
                <div class="linia"><b>Scenariusz:</b> {{ $film->screenplay }}<hr></div>
                <div class="linia"><b>Obsada:</b> {{ $film->cast }}<hr></div>
            </div>
            <div id="opis">
                <b>Opis</b>:<br>
                {{ $film->description }}
            <hr></div>
            <div>
            <h3>Najbliższe seanse:</h3>
                @foreach($screenings as $screening)
                    <a href={{ route('screenings.show', $screening->id) }} title='Informacje o seansie'>{{ $screening->name }}</a>
                    <a href="{{ route('tickets.parking', ['screening_id' => $screening->id]) }}"><b>{{ $screening->hour }}</b></a>
                    <div class='krotki_opis'>
                        {{ $screening->date }} | {{ $screening->venue->city }} | {{ $screening->venue->street }}<hr>
                    </div>
                @endforeach
            </div>
        </div>
        <div style="clear:both"></div>
        @if($images->isNotEmpty())
        <h3>Zdjęcia filmu:</h3>
        <div id="zdjecia">
                @foreach($images as $image)
                    <div class="zdjecie">
                        <img src = {{ Storage::url($path_images.$image->image_filename) }} width="500px" height="250px"></div>
                @endforeach
        </div>
        @endif
        <div style="clear:both"></div>
    </div>
@endsection
