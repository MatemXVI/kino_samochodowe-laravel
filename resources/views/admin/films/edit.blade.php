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

    <h1>Edytuj film</h1>
    <div class ="formularz">
        <form action="{{ route("admin.films.update", $film->id) }}" method="post">
            @csrf
            @method('PATCH')
            <table align="center">
                <tr>
                    <td><label>Tytuł:<br><input type="checkbox" id="chbx_tytul" onclick="disable('chbx_tytul','tytul')"><input type="text" id="tytul" name="title" value="{{ $film->title }}" disabled></label></td>
                    <td><label>Gatunek:<br><input type="checkbox" id="chbx_gatunek" onclick="disable('chbx_gatunek','gatunek')"><input type="text" id="gatunek" name="genre" value="{{ $film->genre }}" disabled></label></td>
                </tr>
                <tr>
                    <td><label>Reżyseria:<br><input type="checkbox" id="chbx_rezyseria" onclick="disable('chbx_rezyseria','rezyseria')"><input type="text" id="rezyseria" name="director" value="{{ $film->director }}" disabled></label></td>
                    <td><label>Kraj:<br><input type="checkbox" id="chbx_kraj" onclick="disable('chbx_kraj','kraj')"><input type="text" id="kraj" name="country" value="{{ $film->country }}" disabled></label></td>

                </tr>
                <tr>
                    <td><label>Obsada:<br><input type="checkbox" id="chbx_obsada" onclick="disable('chbx_obsada','obsada')"><input type="text" id="obsada" name="cast" value="{{ $film->cast }}" disabled ></label></td>
                    <td><label><input type="checkbox" id="chbx_czas" onclick="disable('chbx_czas','czas')">Czas trwania: <input type="number" id="czas" name="duration" value="{{ $film->duration }}" disabled> min</label></td>
                </tr>
                <tr>
                    <td><label>Scenariusz:<br><input type="checkbox" id="chbx_scenariusz" onclick="disable('chbx_scenariusz','scenariusz')"><input type="text" id="scenariusz" name="screenplay" value="{{ $film->screenplay }}" disabled ></label></td>
                    <td><label><input type="checkbox" id="chbx_rok" onclick="disable('chbx_rok','rok')">Rok produkcji: <input type="number" id="rok" name="production_year" min="1888" value="{{ $film->production_year }}" disabled></label></td>
                </tr>
            </table>
                    <label><input type="checkbox" id="chbx_opis" onclick="disable('chbx_opis','opis')">Opis:<br><textarea id="opis" name="description" cols="1" rows="5" disabled>{{ $film->description }}</textarea></label><br>
                    <a href="{{ route("admin.films.files.load", $film->id) }}"><b>OBSŁUGA PLIKÓW</b></a><br><br>
                    <input type="submit" name="edycja" value="Edytuj" />

            </form>
        </div>
    @if(session('message'))
        <span class="error">{{ session('message') }}</span>
    @endif
    @foreach ($errors->all() as $error)
        <span class="error">{{ $error }}</span>
    @endforeach

@endsection
