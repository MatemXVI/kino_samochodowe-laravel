@extends('app')

@section('title', "Panel administracyjny")

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

@section('content')
    <h1>Edytuj miejsce seansu</h1>
    <div class ="formularz">
        <form action="{{ route("admin.venues.update", $venue->id) }}" method="post">
            @csrf
            @method('PATCH')
					<div class="pole_formularza_maly_odstep"><label>Miejscowość*:<br><input type="checkbox" id="chbx_miejscowosc" onclick="disable('chbx_miejscowosc','miejscowosc')"><input type="text" id="miejscowosc" name="city" value="{{ $venue->city }}" disabled/></label></div>
					<div class="pole_formularza_maly_odstep"><label>Ulica*:<br><input type="checkbox" id="chbx_ulica" onclick="disable('chbx_ulica','ulica')"><input type="text" id="ulica" name="street" value="{{ $venue->street }}" disabled/></label></div>
					<div class="pole_formularza"><label>Rodzaj miejsca*:<br><input type="checkbox" id="chbx_rodzaj_miejsca" onclick="disable('chbx_rodzaj_miejsca','rodzaj_miejsca')"><input type="text" id="rodzaj_miejsca" name="place_type" value="{{ $venue->place_type }}" disabled/></label></div>
					<div class="pole_formularza_maly_odstep"><label><input type="checkbox" id="chbx_ilosc_miejsc" onclick="disable('chbx_ilosc_miejsc','ilosc_miejsc')">Ilość miejsc parkingowych*: <input type="number" id="ilosc_miejsc" name="parking_spot_count" value="{{ $venue->parking_spot_count }}" min="1" disabled/></label></div>
					<div class="pole_formularza_maly_odstep"><label><input type="checkbox" id="chbx_dodatkowe_informacje" onclick="disable('chbx_dodatkowe_informacje','dodatkowe_informacje')">Opis:<br><textarea name="additional_info" cols="1" rows="4" id="dodatkowe_informacje" disabled>{{ $venue->additional_info }}</textarea></label></div>
					<div><a href="{{ route("admin.venues.files.store", $venue->id) }}"><b>OBSŁUGA PLIKÓW</b></a></div>
					<div class="przycisk_formularz"><input type="submit" name="edycja" value="Edytuj" /></div>
				</form>
        </div>
    @if(session('message'))
        <span class="error">{{ session('message') }}</span>
    @endif
    @foreach ($errors->all() as $error)
        <span class="error">{{ $error }}</span>
    @endforeach

@endsection
