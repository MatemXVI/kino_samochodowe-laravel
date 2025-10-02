@extends('app')

@section('title', $screening->name)

@section('content')

    <div id="content">
        <div id="zdjecie_seansu">
            <img src={{ Storage::url($path.$screening->poster_filename) }} alt={{ $screening->name }} width="400" height="500"><br>
        </div>
        <div id="description_seans">
            <h2 class="tytul">{{ $screening->name }}</h2>
            <div id="informacje">
                <div class="linia"><b>Data:</b> {{ $screening->date }}
                    <hr>
                </div>
                <div class="linia"><b>Godzina:</b> {{ $screening->hour }}
                    <hr>
                </div>
                <div class="linia"><b>Czas trwania:</b> {{ $screening->film->duration }} min
                    <hr>
                </div>
                <div class="linia"><b>Miejscowość:</b> {{ $screening->venue->city }} ul. {{ $screening->venue->street }}
                    <hr>
                </div>
                <div class="linia"><b>Rodzaj miejsca:</b> {{ $screening->venue->place_type }}
                    <hr>
                </div>
                <div class="linia"><b>Ilość miejsc:</b> {{ $screening->venue->parking_spot_count }}
                    <hr>
                </div>
                <div class="linia"><b>Cena biletu:</b> {{ $screening->price }} zł
                    <hr>
                </div>
                <h3>Dźwięk z filmu będzie nadawany na stacji radiowej, której częstotliwość podamy przed seansem. W razie
                    problemów technicznych prosimy wezwać pomoc.</h3>
            </div>
        </div>
        <div style="clear:both"></div>
        <div id="ktory_film">
            <h1>Film</h1>
            <h3><a href={{ route('films.show',  $screening->film_id) }} title="Kliknij aby wyświetlić informacje o filmie">{{ $screening->film->title }}</a></h3>
        </div>
    </div>

@endsection
