@extends('app')

@section('title', "Panel administracyjny")

@section('content')

    <h2>Filmy:</h2>
    @if ($paginator->count() > 0)
        <table align="center" class="lista">
            <tr><th>ID Filmu</th><th>Tytuł</th><th>Reżyseria</th><th>Gatunek</th><th>Czas trwania</th><th>Rok produkcji</th><th colspan="2">Akcja</th></tr>
            @foreach($paginator as $film)
                <tr title="Dodał: {{ $film->user->login }} o {{ $film->created_at }} @if($film->editor); Ostatnia edycja : {{ $film->editor->login}} o {{ $film->updated_at }} @endif ">
                    <td>{{ $film->id }}</td>
                    <td style="min-width:375px">{{ $film->title }}</td>
                    <td>{{ $film->director }}</td>
                    <td style="max-width:200px">{{ $film->genre }}</td>
                    <td>{{ $film->duration }} min</td>
                    <td>{{ $film->production_year }}</td>
                    <td><a href="{{ route("admin.films.edit", $film->id)  }}"><b>EDYTUJ</b></a></td>
                    <td><form action="{{ route('admin.films.destroy', $film->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="przycisk" onclick="return confirm('Czy na pewno chcesz usunąć film')"><b>USUŃ</b></button><br>
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
            <p class="dodaj"><a href={{ route('admin.films.create') }}><b>DODAJ FILM </b></a></p>
        @else
            <h2>Brak filmów</h2>
            <p class="dodaj"><a href={{ route('admin.films.create') }}><b>DODAJ FILM </b></a></p>
        @endif
        @if(session('message'))
            <span class="information">{{ session('message') }}</span>
        @endif

@endsection
