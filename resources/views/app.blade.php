<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>@yield('title')</title>
        <link rel="stylesheet" href={{asset("css/style.css")}}>
        @yield("scripts")
    </head>

    <body>
        <header>
            @if(Auth::check())
                <div id="logged">
                    <ul>
                        @if(Auth::user()->role == "user")
                            <li><a href={{ route('user.dashboard') }} title="Menu">{{ Auth::user()->login }} </a></li>
                            <li><a href={{ route('user.logout') }}>Wyloguj się</a></li>
                        @elseif(Auth::user()->role == "admin" || Auth::user()->role == "superadmin")
                            <li><a href={{ route('admin.index')  }} title="Menu">{{ Auth::user()->login }}</a></li>
                            <li><a href={{ route('admin.logout') }}>Wyloguj się</a></li>
                        @endif
                    </ul>
                </div>
            @else
                <div id="logged">
                    <ul>
                        <li><a href={{ route('login') }}>Zaloguj się</a></li>
                        <li><a href={{ route('register.create') }}>Zarejestruj się</a></li> {{-- nie powinno być przycisków w
                        formularzach oraz w panelu administracyjnym - być może konieczne będzie grupowanie tras? --}}
                    </ul>
                </div>
            @endif
            <h1><a href={{ route('films.index') }}>KINO SAMOCHODOWE</a></h1>
            @if ((Route::is('admin.*')) || (Route::is('administrators.*')))
                <nav class='administrator'>
                    <a href={{ url()->previous() }}>Cofnij</a>
                </nav>
            @else
                <nav>
                    @yield('left-select')
                    <a href="{{ route('films.index') }}">REPERTUAR</a>
                    <a href="{{ route('screenings.index') }}"> SEANSE</a>
                    <a href="{{ route('venues.index') }}" title='Informacje o seansie'>MIEJSCA</a>
                    <a href>O NAS</a>
                    <a href>KONTAKT</a>
                    @yield('right-select')
                </nav>
            @endif
        </header>
        <section>
            @yield('content')
        </section>
        <footer>
            <ul>
                <li><a href>Kino Samochodowe</a></li>
                <li><a href>Newsletter</a></li>
                <li><a href>Kontakt</a></li>
            </ul>
            <ul>
                <li><a href>Regulacje</a></li>
                <li><a href>Polityka prywatności</a></li>
                <li><a href>Polityka cookies</a></li>
            </ul>
            <ul>
                <li><a href>Facebook</a></li>
                <li><a href>Instagram</a></li>
                <li><a href>Twitter</a></li>
            </ul><br>
        </footer>
    </body>
</html>
