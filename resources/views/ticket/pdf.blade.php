<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
        }

        #bilet {
            width: 800px;
            height: 400px;
            margin: 0;
            padding: 0;
            position: relative;
            display: flex;
            background-color: white;
            border: 2px solid #000;
        }

        #left-side {
            width: 120px;
            background-color: #005db4;
            position: relative;
            border-right: 2px dashed #000;
        }

        #logo {
            position: absolute;
            left: -140px;
            top: 180px;
            width: 400px;
            transform: rotate(-90deg);
            color: white;
            font-size: 28px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        #main-content {
            flex: 1;
            padding: 25px;
            position: relative;
            background-color: white;
        }

        #id-biletu {
            text-align: right;
            font-size: 12px;
            color: #666;
            margin-bottom: 30px;
        }

        #screening-information {
            text-align: center;
            margin: 20px 0;
        }

        #screening-information h1 {
            font-size: 26px;
            margin: 0;
            color: #000;
            text-transform: uppercase;
        }

        #rest-information {
            margin: 25px 0;
            line-height: 1.8;
            font-size: 14px;
        }

        #announcement {
            font-style: italic;
            color: #666;
            font-size: 12px;
            margin: 20px 0;
            padding: 15px;
            border: 1px dashed #ccc;
            background-color: #f9f9f9;
            border-radius: 4px;
        }

        #price {
            position: absolute;
            bottom: 25px;
            right: 25px;
            font-size: 22px;
            color: #005db4;
        }

        #right-side {
            width: 220px;
            position: relative;
            border-left: 2px dashed #000;
            background-color: #f9f9f9;
        }

        #top-right-side {
            height: 180px;
            width: 100%;
            background-color: #ac0303;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #top-right-side img {
            width: 90%;
            height: auto;
            object-fit: contain;
        }

        .qr-code {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
        }

        .qr-code img {
            width: 160px;
            height: 160px;
            background-color: white;
            padding: 10px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        b {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div id="bilet">
        <div id="left-side">
            <div id="logo">
                <b>KINO SAMOCHODOWE</b>
            </div>
        </div>

        <div id="main-content">
            <div id="id-biletu">
                Numer biletu: #{{ $ticket->id }}<br>
                Wygenerowano: {{ $ticket->created_at }}
            </div>

            <div id="screening-information">
                <h1>{{ $ticket->screening->name }}</h1>
            </div>

            <div id="rest-information">
                Data seansu:
                <b>{{ $ticket->screening->date." ".$ticket->screening->hour }}</b><br>
                Numer miejsca parkingowego: <b>{{ $ticket->parking_spot_number }}</b><br>
                Miejsce: <b>{{ $ticket->screening->venue->city }} ul.{{ $ticket->screening->venue->street }}</b>
            </div>

            <div id="announcement">
                Częstotliwość stacji radiowej zostanie udostępniona przed seansem.<br>
                W razie problemów technicznych proszę wezwać pomoc!
            </div>

            <div id="price">
                Cena: <b>{{ $ticket->screening->price }} zł</b>
            </div>
        </div>

        <div id="right-side">
            <div id="top-right-side">
                <img src="{{ public_path('img/ticket/car.png') }}">
            </div>
            <div class="qr-code">
                <img src="{{ $qrcode }}">
            </div>
        </div>
    </div>
</body>
</html>
