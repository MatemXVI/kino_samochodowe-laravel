Wersja 2.1 aplikacja webowej stworzonej we frameworku Laravel - system do zarządzania kinem samochodowym.  Projekt powstał na bazie wcześniejszej aplikacji w czystym PHP i został przerobiony na framework Laravel, naprawiono w nim kilka błędów.

Funkcjonalności:
- Administrator
  - Zarządzanie filmami, seansami i miejscami seansu.
  - Podgląd i zarządzanie biletami, miejscami parkingowymi i użytkownikami.
  - Główny administrator ma dodatkowo możliwość zarządzania innymi administratorami.
- Użytkownik
  - Przegląd filmów, seansów i miejsc seansu.
  - Wybór miejsca parkingowego i zakup biletu.
  - Rezygnacja z biletu ze zwrotem pieniędzy.
  - Zakup biletów wyłącznie po zalogowaniu.
  - Symulacja płatności elektronicznej (okno płatności, brak realnej integracji).
  - Bilety generowane są z kodem QR zawierającym dane identyfikacyjne użytkownika.
 
Technologie:
- Backend: PHP 8.2.4; Laravel Framework 12.20.0; JavaScript; 
- Frontend: HTML, CSS (prosty układ stron i przyciski)
- Baza danych: MySQL
- Środowisko programistyczne: Visual Studio Code 1.103.2
- Generator kodów QR: PHPQRCode (https://github.com/chillerlan/php-qrcode)

Pierwsza wersja - aplikacja w czystym PHP: https://github.com/MatemXVI/kino_samochodowe

Opis interfejsu graficznego: https://github.com/MatemXVI/kino-samochodowe-laravel/blob/main/Interfejs_graficzny.pdf
W projekcie skupiałem się głównie na backendzie, frontend jest głównie w celu pokazania układu pól, przycisków, zdjęć itd.
Aplikacja będzie dalej rozwijana, planowane jest dodanie możliwości pobrania biletu w PDF i formacie graficznym JPG/PNG. Planowane też jest przerobienie interfejsu graficznego.
