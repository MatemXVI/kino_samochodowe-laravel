@extends('app')

@section('title', "Panel administracyjny")

@section('scripts')
    <script>
        function disable_chbx(checkbox,form){
            if(document.getElementById(checkbox).checked == true){
                document.getElementById(form).disabled = false
            }else{
                document.getElementById(form).disabled = true
            }
        }
        function disable_radio(radio) {
            for (const element of document.getElementsByClassName("nazwa_zdjecia_input")) element.disabled = true;
            radio.closest("label").querySelector("input[type=text]").disabled = false;
        }
		</script>
@section('content')
    <h1>Obsługa plików</h1>
    <h4>{{ $screening->name }}</h4><hr>
    <div class="pliki">
        <h3>Dodaj plakat</h3>
            @if($screening->poster_filename !== NULL)
                <div class="poster">
                    <img src="{{ Storage::url('img/screenings/'.$screening->id.'/'.$screening->poster_filename) }}" width="336" height="500">
                </div>
                <form action={{ route("admin.screenings.files.renamePoster", $screening->id) }} method="post" enctype="multipart/form-data">
                @csrf
                @method("PATCH")
                    <div class = "plik_formularz">
                    <label><input type="text" id="nazwa_plakatu"  name="poster_filename" value={{ $screening->poster_filename }} style="width:450px"></label>
                    <button class="przycisk" type="submit" name="zmien_nazwe_plakatu"><b>Zmień nazwę</b></button>
                </form>
                <form action={{ route("admin.screenings.files.destroyPoster", $screening->id) }} method="post" enctype="multipart/form-data" class="inline-form">
                @csrf
                @method("DELETE")
                    <button class="przycisk" type="submit" onclick="return confirm('Czy na pewno chcesz usunąć plik?')"><b>Usuń</b></button><br>
                </form>
            </div>
            @else
                <h3>Brak pliku!</h3>
            @endif
            <form action={{ route("admin.screenings.files.storePoster", $screening->id) }}  method="post" enctype="multipart/form-data">
                @csrf
            @if($screening->poster_filename !== NULL)
                <div><input type="file" id="plik" name="poster" accept="image/jpeg, image/png"></label></div> <div><input type="submit" name="dodaj_plakat" value="Dodaj" onclick="return confirm('Czy chcesz dodać plakat? Plakat który jest obecnie zostanie usunięty.')" /></div>
            @else
                <div><input type="file" id="plik" name="poster" accept="image/jpeg, image/png"></label></div> <div><input type="submit" name="dodaj_plakat" value="Dodaj" /></div>
            @endif
            </form><br> {{--  może pozwolić na dodawanie kilku plakatów, a w razie czego administrator będzie mógł sobie je zmieniać w systemie --}}
        @if(session('message'))
            <span class="error">{{ session('message') }}</span>
        @endif
        @if(session('success'))
            <span class="success">{{ session('success') }}</span>
        @endif
        @foreach ($errors->all() as $error)
            <span class="error">{{ $error }}</span>
        @endforeach
    </div>

@endsection
