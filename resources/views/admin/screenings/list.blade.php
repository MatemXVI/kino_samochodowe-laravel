@extends('app')

@section('title', "Panel administracyjny")

@section('content')
    <p><b>Seans:</b> {{ $screening->name }} <br><b>Data:</b> {{ $screening->date }}  {{ $screening->hour }} <br><b>Film:</b> {{ $screening->film->title }} <br><b>Miejsce:</b> {{ $screening->venue->city }} , {{ $screening->venue->street }} <br></p>

    <table align="center" class="lista">
        <tr>
            <th>Numer Biletu</th>
            <th>Numer miejsca parkingowego</th>
            <th>Data wygenerowania</th>
            <th>Cena</th>
            <th>Akcja</th>
        </tr>
        @if ($paginator->count() > 0)
            @foreach($paginator as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->parking_spot_number }}</td>
                    <td>{{ $ticket->created_at }}</td>
                    <td>{{ $screening->price }} zł</td>
                    @if($ticket->user_id != NULL)
                        <td><a href={{ route("ticket.show",  $ticket->id) }} title='Nr biletu: {{ $ticket->id }}'><b>ZOBACZ BILET</b></td>
                    @endif
                </tr>
            @endforeach
        @if ($paginator->lastPage() > 1)
                @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                    <span class='paginator'><a href="{{ $paginator->url($i) }}"> <b>{{ $i }}</b></a></span>
                @endfor
        @endif
    @else
        <h2>Brak biletów</h2>
        <a href='dodaj_seans.php'><b>DODAJ SEANS</b></a>
    @endif
    </table>

@endsection
