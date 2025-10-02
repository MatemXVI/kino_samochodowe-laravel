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
    <h1>Edytuj seans</h1>
    <div class ="formularz">
        <form action="{{ route("admin.screenings.update", $screening->id) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="pole_formularza_maly_odstep"></label>Nazwa:<br><input type="checkbox" id="chbx_nazwa" onclick="disable('chbx_nazwa','nazwa')"><input type='text' id="nazwa" name="name" value='{{ $screening->name }}' disabled></label></div>
            <div class="pole_formularza_maly_odstep"></label>Data_seansu:<br><input type="checkbox" id="chbx_data" onclick="disable('chbx_data','data')"><input type='date' id="data" name="date" value='{{ $screening->date }}' disabled></label></div>
            <div class="pole_formularza_maly_odstep"></label>Godzina:<br><input type="checkbox" id="chbx_godzina" onclick="disable('chbx_godzina','godzina')"><input type='time' id="godzina" name="hour" value='{{ $screening->hour }}' disabled></label></div>
            <div class="pole_formularza_maly_odstep"></label>Film:<br><input type="checkbox" id="chbx_film" onclick="disable('chbx_film','film')">
            <select id="film" name="film_id" disabled>
                <option value="{{ $screening->film->id }}">{{ $screening->film->title }} </option>
                @foreach($films as $film)
                    <option value="{{ $film->id }}">{{ $film->title }} </option>
                @endforeach
            </select></label></div>
            <div class="pole_formularza"></label>Miejsce<br><input type="checkbox" id="chbx_miejsce" onclick="disable('chbx_miejsce','miejsce')">
            <select id="miejsce" name="venue_id" disabled>
                <option value="{{ $screening->venue->id }}"> {{ $screening->venue->city }}, ul. {{ $screening->venue->street }}</option>
                @foreach($venues as $venue)
                    <option value="{{ $venue->id }}"> {{ $venue->city }}, ul. {{ $venue->street }}</option>
                @endforeach
            </select></label></div>
            <div class="pole_formularza_maly_odstep"></label><input type="checkbox" id="chbx_cena" onclick="disable('chbx_cena','cena')">Cena biletu: <input type="number" id="cena" name="price" min="4.00" step="0.01" value='{{ $screening->price }}' disabled> zł</label></div>
            <a href="{{ route("admin.screenings.files.load", $screening->id) }}"><b>OBSŁUGA PLIKÓW</b></a><br><br>
            <input type="submit" name="edycja" value="Edytuj" /></div>
            </form>
        </div>
    @if(session('message'))
        <span class="error">{{ session('message') }}</span>
    @endif
    @foreach ($errors->all() as $error)
        <span class="error">{{ $error }}</span>
    @endforeach

@endsection
