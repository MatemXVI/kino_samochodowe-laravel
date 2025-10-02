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
    <h1>Obsługa plików</h1><hr>
    <div class="pliki"> {{-- może zrobić galerię - będzie widać dodane zdjęcie, lecz kwestia układu strony, zdjęcia mogą nie za dobrze wyglądać --}}
        <h3>Załadowane pliki</h3>
        <h4>{{ $venue->city }}, ul.{{ $venue->street }}</h4><hr>
        @if($venueImages->count() >= 1)
            @foreach($venueImages as $i => $venueImage)
            <div>
            <form action={{ route("admin.venues.files.rename", $venueImage->id) }}  method="post" enctype="multipart/form-data" class="inline-form">
                @csrf
                @method("PATCH")
                @if($venueImages->count() > 1)
                    <label><input type="radio" name="image_id" id="radio_nazwa_zdjecia{{ $i }}" onclick="disable_radio(this)" value="{{ $venueImage->id }}"><input type="text" class="nazwa_zdjecia_input" id="nazwa_zdjecia{{ $i }}" name="image_filename" value="{{ $venueImage->image_filename }}" style="width:450px" disabled></label>
                @elseif($venueImages->count() == 1)
                    <label><input type="text" id="nazwa_zdjecia" name="image_filename" value="{{ $venueImage->image_filename }}" style="width:450px"></label>
                @endif
                <button class="przycisk" type="submit" ><b>Zmień nazwę</b></button>
            </form>
            <form action={{ route("admin.venues.files.destroy", $venueImage->id) }} method="post" enctype="multipart/form-data" class="inline-form">
                @csrf
                @method("DELETE")
                <button class="przycisk" type="submit" onclick="return confirm('Czy na pewno chcesz usunąć plik?')"><b>Usuń</b></button><br>
                </form>
            </div>
            @endforeach
        @else
            <h3>Brak plików</h3>
        @endif
        <form action={{ route("admin.venues.files.store", $venue->id) }}  method="post" enctype="multipart/form-data">
            @csrf
            <label><br><input type="file" id="plik" name="image[]" multiple accept="image/jpeg, image/png" ></label><br> <input type="submit" name="dodaj_zdjecie" value="Dodaj" />
        </form><br>
        @if(session('message'))
            <span class="error">{{ session('message') }}</span>
        @endif
        @if(session('success'))
            <span class="success">{{ session('success') }}</span>
        @endif
        @foreach ($errors->image->all() as $error)
            <span class="error">{{ $error }}</span>
        @endforeach
    </div>
@endsection
