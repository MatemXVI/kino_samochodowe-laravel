@extends('app')

@section('title', "Panel administracyjny")

@section('content')
    <h1>Wprowadź miejsce seansu</h1>
    <div class="formularz">
        <form method="post" action="{{ route("admin.venues.store") }}" >
            @csrf
            <table align="center">
                    <div class="pole_formularza_maly_odstep"><label>Miejscowość*:<br><input type="text" name="city" value="{{ old("city") }}" required></label></div>
					<div class="pole_formularza_maly_odstep"><label>Ulica*:<br><input type="text" name="street" value="{{ old("street") }}" required></label></div>
					<div class="pole_formularza"><label>Rodzaj miejsca*:<br><input type="text" name="place_type" value="{{ old("place_type") }}" /></label></div>
					<div class="pole_formularza_maly_odstep"><label>Ilość miejsc parkingowych*: <input type="number" name="parking_spot_count" min="0" value="{{ old("parking_spot_count") }}" required></label></div>
					<div class="pole_formularza_maly_odstep"><label>Opis:<br><textarea name="additional_info" cols="1" rows="4" id="dodatkowe_informacje" {{ old("additional_info") }}></textarea></label></div>
					<div>Zdjęcia można dodawać przy edycji!</div>
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
