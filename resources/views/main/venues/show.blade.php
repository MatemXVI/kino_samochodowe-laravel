@extends('app')

@section('title', 'Miejsce seansu')

@section('content')
    <div class="z_miejscami">
        <div id="wybor_miejsca">
            <form method="get">
                <select class="select_index" name="id_miejsca" onchange="window.location.href = '/venues/' + this.value">
                    @if($id)
                        <option value="{{ $venue->id }}"> {{ $venue->city }}, ul.{{ $venue->street }} </option>
                        @foreach($venues as $venue)
                            <option value="{{ $venue->id }}"> {{ $venue->city }}, ul.{{ $venue->street }} </option>
                        @endforeach
                    @else
                        <option value=''>Wybierz miejsce seansu</option>
                        @foreach($venues as $venue)
                            <option value="{{ $venue->id }}"> {{ $venue->city }}, ul.{{ $venue->street }} </option>
                        @endforeach
                    @endif
                </select>
            </form>
        </div>
        @if($id)
        <div id="informacje_miejsce">
            <div class="linia"><b>Miejscowość:</b> {{ $venue->city }} ul. {{ $venue->street }} <hr></div>
            <div class="linia"><b>Rodzaj miejsca:</b> {{ $venue->place_type }}<hr></div>
            <div class="linia"><b>Ilość miejsc:</b> {{ $venue->parking_spot_count }}<hr></div>
            @if( $venue->additional_info != NULL)
                <div class="linia">{{ $venue->additional_info }} <hr></div>
            @endif
        </div>
        @if($images->isNotEmpty())
            <h3>Zdjęcia miejsca:</h3>
            <div id="zdjecia">
                @foreach($images as $image)
                    <div class="zdjecie"><img src = {{ Storage::url($path.$image->image_filename) }} width="500px" height="250px"></div>
                @endforeach
            </div>
        <div style="clear:both"></div>
        @endif
        <div>
            <h3>Najbliższe seanse:</h3>
            @foreach($screenings as $screening)
                <a href={{ route('screenings.show',  $screening->id)}} title="Informacje o seansie">{{ $screening->name }}
                <a href={{ route('tickets.parking', ['screening_id' => $screening->id]) }} > <b>{{ $screening->hour }}</b></a>
                <div class='krotki_opis'>
                    {{ $screening->date }} | {{ $screening->name }} <hr>
                </div>
            @endforeach
        @endif
    </div>

@endsection
