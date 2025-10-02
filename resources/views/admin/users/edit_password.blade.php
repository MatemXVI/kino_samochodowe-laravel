@extends('app')

@section('title', "Panel administracyjny")

@section('scripts')

    <script>
        function disable(checkbox,form){
            if(document.getElementById(checkbox).checked == true){
                document.getElementById(form).disabled = false
            }else{
                document.getElementById(form).disabled = true
            }
        }
    </script>

@section('content')

<h1> Wybierz dane do edycji</h1>
<div class ="formularz">
    <form action='{{ route("admin.users.update_password", $user->id) }}' method='post' >
        @csrf
        @method('PATCH')
        <div class="pole_formularza_maly_odstep"><label>Nowe hasło:<br><input type="password" id="password" name="password" required/></label></div>
        <div class="pole_formularza_maly_odstep"><label>Powtórz hasło:<br><input type="password" id="password_confirmation" name="password_confirmation" required/></label></div>
        <div class="przycisk_formularz"><input type="submit" name="edycja" value="Edytuj" /></div>
    </form>
</div>
    @if(session('message'))
        <span class="error">{{ session('message') }}</span>
    @endif
    @foreach ($errors->all() as $error)
        <span class="error">{{ $error }}</span>
    @endforeach

@endsection
