@extends('app')

@section('title', "Panel administracyjny")

@section('content')
    <h1>Wprowadź film</h1>
    <div class="formularz">
        <form method="post" action="{{ route("admin.films.store") }}" >
            @csrf
            <table align="center">
                <tr>
                    <td><label>Tytuł:*<br><input type="text" name="title" value="{{ old("title") }}"/></label></td>
                    <td><label>Gatunek:<br><input type="text" name="genre" value="{{ old("genre") }}" /></label></td>
                </tr>
                <tr>
                    <td><label>Reżyseria:<br><input type="text" name="director" value="{{ old("director") }}" /></label></td>
                    <td><label>Kraj:<br><input type="text" name="country" value="{{ old("country") }}" /></label></td>
                </tr>
                <tr>
                    <td><label>Obsada:<br><input type="text" name="cast" value="{{ old("cast") }}" /></label></td>
                    <td><label>Czas trwania: <input type="number" id="number" name="duration" value="{{ old("duration") }}" /> min</label></td>
                </tr>
                <tr>
                    <td><label>Scenariusz:<br><input type="text" name="screenplay" value="{{ old("screenplay") }}" /></label></td>
                    <td><label>Rok produkcji: <input type="number" id="number" name="production_year" min="1888" value="{{ old("production_year") }}" /></label></td>
                </tr>
            </table>
                    <div><label>Opis:<br><textarea name="description" cols="1" rows="5" id="opis" title = "Proszę nie dodawać apostrofów, np. It's."></textarea>{{ old("description") }}</label>
                    {{-- <input type="hidden" name="MAX_FILE_SIZE" value="1048576" /></div>
                    <label>Plakat:<br><input type="file" name="plakat" accept="image/jpeg, image/png"></label><br> --}}
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
