@extends('app')

@section('title', "Panel administracyjny")

@section('content')
	<h2>Seanse:</h2>
    @if ($paginator->count() > 0)
    <table align="center" class="lista">
        <tr><th>ID Seansu</th><th>Nazwa</th><th>Data</th><th>Godzina</th><th>Cena biletu</th><th colspan="4">Akcja</th></tr>
            @foreach($paginator as $screening)
                <tr title="Dodał: {{ $screening->user->login }} o {{ $screening->created_at }} @if($screening->editor)  Ostatnia edycja : {{ $screening->editor->login}} o {{ $screening->updated_at }} @endif ">
                    <td>{{ $screening->id }}</td>
                    <td>{{ $screening->name }}</td>
                    <td>{{ $screening->date }}</td>
                    <td>{{ $screening->hour }}</td>
                    <td>{{ $screening->price }} zł</td>
                    <td><a href={{ route("admin.screenings.tickets", $screening->id)  }}><b>BILETY</b></a></td>
                    <td><a href={{ route("admin.screenings.parkings", $screening->id)  }}><b>MIEJSCA PARKINGOWE</b></a></td>
                    <td><a href={{ route("admin.screenings.edit",$screening->id)  }}><b>EDYTUJ</b></a></td>
                    <td><form action="{{ route('admin.screenings.destroy', $screening->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="przycisk" onclick="return confirm('Czy na pewno chcesz usunąć seans?')"><b>USUŃ</b></button><br>
                    </form></td>
                </tr>
            @endforeach
        </table><p>

        @if ($paginator->lastPage() > 1)
                @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                    <span class='paginator'><a href="{{ $paginator->url($i) }}"> <b>{{ $i }}</b></a></span>
                @endfor
        @endif
        </p>
        <p class="dodaj"><a href={{ route('admin.screenings.create') }}><b>DODAJ SEANS </b></a></p>
    @else
        <h2>Brak seansów</h2>
        <p class="dodaj"><a href={{ route('admin.screenings.create') }}><b>DODAJ SEANS</b></a></p>
    @endif
    @if(session('message'))
        <span class="information">{{ session('message') }}</b></span>
    @endif
@endsection
