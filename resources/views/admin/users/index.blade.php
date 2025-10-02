@extends('app')

@section('title', "Panel administracyjny")

@section('content')

    @if ($paginator->count() > 0)
        <table align="center" class="lista">
            <tr><th>ID Użytkownika</th><th>Login</th><th>Imię i nazwisko</th><th>Telefon</th>@if(Auth::user()->role == "superadmin")<th>Uprawnienia</th>@endif<th colspan="3">Akcja</th></tr>
            @foreach($paginator as $user)
            {{-- @if(Auth::user()->role != "superadmin" && ($user->role == "admin" || $user->role == "superadmin" )) @continue @endif --}}
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->login }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->phone_number }}</td>
                 @if(Auth::user()->role == "superadmin")
                    <td>{{ $user->role }}
                @endif
                @if(Auth::user()->role == "superadmin" && ($user->role == 'admin' || $user->role == 'superadmin'))
                    <td><a href="{{ route("admin.users.edit", $user->id)  }}"><b>EDYTUJ</b></a></td>
                    <td><a href="{{ route("admin.users.edit_password", $user->id)  }}"><b>ZMIEŃ HASŁO</b></a></td>
                    <td><form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="przycisk" onclick="return confirm('Czy na pewno chcesz usunąć użytkownika?')"><b>USUŃ</b></button><br>
                    </form></td>
                @endif
                </tr>
            @endforeach
            </table><p>
            @if ($paginator->lastPage() > 1)
                    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                        <span class='paginator'><a href="{{ $paginator->url($i) }}"> <b>{{ $i }}</b></a></span>
                    @endfor
            @endif
            </p>
        @if(Auth::user()->role == "superadmin")
            <p class="dodaj"><a href={{ route('admin.administrators.create') }}><b>ZAREJESTRUJ ADMINISTRATORA </b></a></p>
        @endif
        @else
            <h2>Brak użytkowników</h2> {{--  sprawdzić czy jest reakcja na brak użytkowników w bazie --}}
            @if(Auth::user()->role == "superadmin")
                <a href={{ route('admin.administrators.create') }}><b>ZAREJESTRUJ ADMINISTRATORA </b></a>
            @endif
        @endif
        @if(session('message'))
            <span class="information">{{ session('message') }}</span>
        @endif

@endsection
