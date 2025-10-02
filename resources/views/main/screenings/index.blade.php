@extends('app')

@section('title', 'Seanse')

@section('scripts')
    <script>
        function disable(checkbox,form){
            if(document.getElementById(checkbox).checked == true){
                document.getElementById(form).disabled = false
            }else{
                document.getElementById(form).disabled = true
            }
        }
    </script>
@endsection

@section('left-select')
    <div class="pasek_z_menu">
        <div class ="wybor1">
            <form method="get" id="repertuar">
                <select class="select_index" name="film" onchange="this.form.submit()">
                    @if($filmId)
                        <option value={{ $selectedFilm->id }} > {{ $selectedFilm->title }} </option>
                        @foreach($films as $film)
                            <option value={{ $film->id }} > {{ $film->title }} </option>
                        @endforeach
                        <option value=''>Wszystkie filmy</option>
                    @else
                        <option value=''>Wybierz film</option>
                        @foreach($films as $film)
                            <option value={{ $film->id }} > {{ $film->title }} </option>
                        @endforeach
                    @endif
                </select>
        </div>
    <div class = "menu">

@endsection

@section('right-select')
    </div>
    <div class ="wybor">
            <select class="select_index" name="venue" onchange="this.form.submit()">
            @if($venueId)
                <option value="{{ $selectedVenue->id }}"> {{ $selectedVenue->city }}, ul.{{ $selectedVenue->street }} </option>
                @foreach($venues as $venue)
                    <option value="{{ $venue->id }}"> {{ $venue->city }}, ul.{{ $venue->street }} </option>
                @endforeach
                <option value=''>Wszystkie miejsca</option>
            @else
                <option value=''>Wybierz miejsce seansu</option>
                @foreach($venues as $venue)
                    <option value="{{ $venue->id }}"> {{ $venue->city }}, ul.{{ $venue->street }} </option>
                @endforeach
            @endif
            </select>
        </div>
    <div style="clear:both"></div>
</div>

@endsection

@section('content')
    <div class="tydzien">
        <div class="dni">
            <ul>
                @for ($i = 0; $i < 7; $i++)
                <?php $day = \Carbon\Carbon::today()->addDays($i); ?>
                <li class="dzien">
                    <button type="submit" class="przycisk" name="date" value="{{ $day->format('Y-m-d') }}">
                        <div>{{ mb_convert_case($day->translatedFormat('D'), MB_CASE_TITLE, 'UTF-8') }}</div>
                        <div>{{ $day->format('d.m') }}</div>
                    </button>
                </li>
                @endfor
            </ul>
        </div>
        <div class="data_pasek">Wybierz inną datę: <label><input type="checkbox" id="chbx_data" onclick="disable('chbx_data','data')"><input type="date" id="data" name='date' title="Wybierz datę" onchange="this.form.submit()" disabled></label></div>
        <div class="all">
            <button type='submit' class='przycisk' name="wszystko"><b>Pokaż seanse na tydzień</b></button>
        </div>
    </form>
@if($screenings->isNotEmpty())
        @if($selectedVenue)
            <h3>Seanse w: {{ $selectedVenue->city }}, ul.{{ $selectedVenue->street }} </h3>
        @endif
    </div>
    <div class="movies">
    @foreach($screenings as $screening)
            @if($loop->first)
                <div class = "linia_repertuaru">
            @endif
		<div class="repertuar">
            <div><img src={{ Storage::url($screening->path.$screening->poster_filename) }} alt='' width='261' height='377'></div>
            <a href="{{ route('screenings.show', $screening->id) }}" title='Informacje o seansie'>{{ $screening->name }}</a>
            <a href="{{ route('tickets.parking', ['screening_id' => $screening->id]) }}" > <b>{{ $screening->hour }}</b></a>
                <div class='krotki_opis'>
                    {{ $screening->date }} | {{ $screening->name }} | {{ $screening->venue->city }} | {{ $screening->venue->street }}
                </div>
        </div>
        @if($loop->iteration % 3 == 0 || $loop->last)
            </div><div style='clear:both'></div><hr>
        @endif
    @endforeach
    </div>
    @else
    <h2>Brak seansów!</h2>
    @endif

@endsection
