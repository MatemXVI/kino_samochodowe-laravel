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
    <h4>{{ $film->title }}</h4><hr>
    <div class="pliki">
        <h3>Dodaj plakat</h3>
            @if($film->poster_filename !== NULL)
                <div class="poster">
                    <img src="{{ Storage::url($posterFilename) }}" width="336" height="500">
                </div>
                <form action={{ route("admin.films.files.renamePoster", $film->id) }} method="post" enctype="multipart/form-data">
                @csrf
                @method("PATCH")
                    <div class = "plik_formularz">
                    <label><input type="text" id="nazwa_plakatu"  name="poster_filename" value={{ $film->poster_filename }} style="width:450px"></label>
                    <button class="przycisk" type="submit" name="zmien_nazwe_plakatu"><b>Zmień nazwę</b></button>
                </form>
                <form action={{ route("admin.films.files.destroyPoster", $film->id) }} method="post" enctype="multipart/form-data" class="inline-form">
                @csrf
                @method("DELETE")
                    <button class="przycisk" type="submit" onclick="return confirm('Czy na pewno chcesz usunąć plik?')"><b>Usuń</b></button><br>
                </form>
            </div>
            @else
                <h3>Brak pliku!</h3>
            @endif
            <form action={{ route("admin.films.files.storePoster", $film->id) }}  method="post" enctype="multipart/form-data">
                @csrf
                @if($film->poster_filename !== NULL)
                <div><input type="file" id="plik" name="poster" accept="image/jpeg, image/png"></label></div> <div><input type="submit" name="dodaj_plakat" value="Dodaj" onclick="return confirm('Czy chcesz dodać plakat? Plakat który jest obecnie zostanie usunięty.')" /></div>
            @else
                <div><input type="file" id="plik" name="poster" accept="image/jpeg, image/png"></label></div> <div><input type="submit" name="dodaj_plakat" value="Dodaj" /></div>
            @endif
            </form><br>
        @if(session('poster_message'))
            <span class="error">{{ session('poster_message') }}</span>
        @endif
        @if(session('poster_success'))
            <span class="success">{{ session('poster_success') }}</span>
        @endif
        @foreach ($errors->poster->all() as $error)
            <span class="error">{{ $error }}</span>
        @endforeach
    </div>
    <div class="pliki"> {{-- może zrobić galerię - będzie widać dodane zdjęcie, lecz kwestia układu strony, zdjęcia mogą nie za dobrze wyglądać --}}
        <h3>Załadowane pliki</h3>
        @if($filmImages->count() >= 1)
            @foreach($filmImages as $i => $filmImage)
            <div>
                <form action={{ route("admin.films.files.rename", $filmImage->id) }}  method="post" enctype="multipart/form-data" class="inline-form">
                    @csrf
                    @method("PATCH")
                    @if($filmImages->count() > 1)
                        <label><input type="radio" name="image_id" id="radio_nazwa_zdjecia{{ $i }}" onclick="disable_radio(this)" value="{{ $filmImage->id }}"><input type="text" class="nazwa_zdjecia_input" id="nazwa_zdjecia{{ $i }}" name="image_filename" value="{{ $filmImage->image_filename }}" style="width:450px" disabled></label>
                    @elseif($filmImages->count() == 1)
                        <label><input type="checkbox" id="chbx_nazwa_zdjecia" name="image_id" value="{{ $filmImage->id }}" onclick="disable_chbx('chbx_nazwa_zdjecia', 'nazwa_zdjecia')"><input type="text" id="nazwa_zdjecia" name="image_filename" value="{{ $filmImage->image_filename }}" style="width:450px" disabled></label>
                    @endif
                    <button class="przycisk" type="submit" ><b>Zmień nazwę</b></button>
                </form>
                <form action={{ route("admin.films.files.destroy", $filmImage->id) }} method="post" enctype="multipart/form-data" class="inline-form">
                    @csrf
                    @method("DELETE")
                    <button class="przycisk" type="submit" onclick="return confirm('Czy na pewno chcesz usunąć plik?')"><b>Usuń</b></button><br>
                    </form>
            </div>
            @endforeach<br>
        @else
            <h3>Brak plików</h3>
        @endif
        <form action={{ route("admin.films.files.store", $film->id) }}  method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" id="plik" name="image[]" multiple accept="image/jpeg, image/png"></label><br> <input type="submit" name="dodaj_zdjecie" value="Dodaj" />
        </form><br>
        @if(session('message'))
            <span class="error">{{ session('message') }}</span>
        @endif
        @if(session('success'))
            <span class="success"><b>{{ session('success') }}</span>
        @endif
        @foreach ($errors->image->all() as $error)
            <span class="error">{{ $error }}</b></span>
        @endforeach
    </div>

@endsection
