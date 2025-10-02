@extends('app')

@section('title', "Panel administracyjny")

@section('content')

    <h2>Miejsca seansu:</h2>
    @if ($paginator->count() > 0)
        <table align="center" class="lista">
            <tr><th>ID Miejsca</th><th>Miejscowość</th><th>Ulica</th><th>Rodzaj miejsca</th><th>Ilość miejsc parkingowych</th><th colspan="2">Akcja</th></tr>
            @foreach($paginator as $venue)
                <tr title="Dodał: {{ $venue->user->login }} o {{ $venue->created_at }} @if($venue->editor); Ostatnia edycja : {{ $venue->editor->login}} o {{ $venue->updated_at }} @endif ">
                    <td>{{ $venue->id }}</td>
                    <td>{{ $venue->city }}</td>
                    <td>{{ $venue->street }}</td>
                    <td>{{ $venue->place_type }}</td>
                    <td>{{ $venue->parking_spot_count }}</td>
                    <td><a href="{{ route("admin.venues.edit", $venue->id)  }}"><b>EDYTUJ</b></a></td>
                    <td><form action="{{ route('admin.venues.destroy', $venue->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="przycisk" onclick="return confirm('Czy na pewno chcesz usunąć film?')"><b>USUŃ</b></button><br>
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
            <p class="dodaj"><a href={{ route('admin.venues.create') }}><b>DODAJ NOWE MIEJSCE </b></a></p>
        @else
            <h2>Brak miejsc</h2>
                <p class="dodaj"><a href={{ route('admin.venues.create') }}><b>DODAJ NOWE MIEJSCE </b></a></p>
        @endif
        @if(session('message'))
            <span class="information">{{ session('message') }}</span>
        @endif

@endsection
