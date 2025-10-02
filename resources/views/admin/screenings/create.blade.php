@extends('app')

@section('title', "Panel administracyjny")

@section('content')
    <h1>Wprowadź seans</h1>
    <div class="formularz">
        <form method="post" action="{{ route("admin.screenings.store") }}" >
            @csrf
            <div class="pole_formularza_maly_odstep"><label>Nazwa:<br><input type="text" name="name"  value="{{ old("name") }}" required></label></div>
            <div class="pole_formularza_maly_odstep"><label>Data_seansu:<br><input type="date" name="date" value="{{ old("date") }}" required></label></div>
            <div class="pole_formularza_maly_odstep"><label>Godzina:<br><input type="time" name="hour"  value="{{ old("hour") }}" required></label></div>
            <div class="pole_formularza_maly_odstep"><label>Film:<br>
            <select name="film_id" required>
                @foreach($films as $film)
                <option value="{{ $film->id }}"> {{ $film->title }}</option>
                @endforeach
            </select></label></div>
            <div class="pole_formularza"><label>Miejsce:<br>
            <select name="venue_id" required>
                @foreach($venues as $venue)
                <option value="{{ $venue->id }}"> {{ $venue->city }}, ul. {{ $venue->street }}</option>
                @endforeach
            </select></label></div>
            <div class="pole_formularza_maly_odstep"><label>Cena biletu: <input type="number" name="price" step="0.01" value="{{ old("price") }}" required> zł</label></div>
            {{-- <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
            <div class="pole_formularza_maly_odstep"><label>Plakat:<br><input type="file" name="plakat" accept="image/jpeg, image/png" enctype="multipart/form-data"></label></div> --}}
            <div class="przycisk_formularz"><input type="submit" name="dodawanie" value="Dodaj" /></div>
        </form>
    </div>
    @if(session('message'))
        <span class="error">{{ session('message') }}</span>
    @endif
    @foreach ($errors->all() as $error)
        <span class="error">{{ $error }}</span>
    @endforeach

@endsection
