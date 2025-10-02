@extends('app')

@section('title', "Kup bilet")

@section('content')

		<h2>Podsumowanie</h2>
		<div id="podsumowanie">
			<div class="pods">
				<div><h4>Film: </h4></div>
				<div>Tytuł filmu: <b>{{ $ticket->screening->film->title }}</b></div>
				<div><b>{{ $ticket->screening->date }} godz. {{ $ticket->screening->hour }}</b></div>
				<div>Seans: <b>{{ $ticket->screening->name }}</b></div>
				<div>Miejsce: <b>{{ $ticket->screening->venue->city }}, ul. {{ $ticket->screening->venue->street }}, {{ $ticket->screening->venue->place_type }}</b></div>
				<div>Numer miejsca: <b>{{ $ticket->parking_spot_number }}</b></div>
				<div>Koszt biletu: <b>{{ $ticket->screening->price }} zł</b></div>
				<div><b>+ 1.5 zł opłaty internetowej za zakup</b></div>
			</div>
			<div class="pods">
				<div><h4>Użytkownik: </h4></div>
				<div>Imię i nazwisko: <b>{{ $user->name }}</b></div>
				<div>Wiek: <b>{{ $user->age }}</b></div>
				<div>E-mail: <b>{{ $user->email }}</b></div>
				<div>Telefon: <b>{{ $user->phone_number }}</b></div>
				<div></div>
				<div>Metoda płatności: <b>{{ $payment }}</b></div>
			</div>
		</div><br>
		<form action={{ route("ticket.generate") }} method="post">
            @csrf
            @method("PATCH")
            <input type="hidden" name="screening_id" value={{ $screeningId }}>
            <input type="hidden" name="parking_spot_number" value= {{ $parkingSpotNumber }} >
            <input type="hidden" name="price" value={{ $ticket->screening->price }} >
            <input type="submit" value="Zakup bilet">
		</form>

@endsection
