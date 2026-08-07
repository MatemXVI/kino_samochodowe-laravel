# 🎬 Kino Samochodowe – Laravel

Aplikacja webowa służąca do obsługi kina samochodowego, stworzona w języku **PHP** z wykorzystaniem frameworka **Laravel** oraz relacyjnej bazy danych **MySQL**.

System umożliwia użytkownikom przeglądanie repertuaru, wybór seansów i miejsc parkingowych, zakup biletów oraz zarządzanie swoim kontem. Administratorzy mogą zarządzać filmami, seansami, użytkownikami oraz pozostałymi elementami systemu.

Projekt powstał jako rozwinięcie wcześniejszej aplikacji napisanej w czystym PHP. Następnie został przeprojektowany i przepisany do frameworka Laravel, z wykorzystaniem m.in. modelu MVC, routingu, migracji oraz ORM Eloquent.

Później ten sam system został również zaimplementowany w języku Python z wykorzystaniem frameworka Django, co pozwoliło mi porównać sposób organizacji i tworzenia podobnej aplikacji w różnych technologiach backendowych.

---

# 📸 Zrzuty ekranu

## Strona główna

![Strona główna](screenshots/home.png)

## Repertuar

![Repertuar](screenshots/repertuar.png)

## Informacje o filmie

![Informacje o filmie](screenshots/film.png)

## Wybór miejsca

![Wybór miejsca](screenshots/parking.png)

## Bilet

![Bilet](screenshots/ticket.png)

## Panel administratora

![Panel administratora](screenshots/admin.png)

---

# ✨ Funkcjonalności

- rejestracja użytkowników
- logowanie i uwierzytelnianie
- podział użytkowników według ról
- przeglądanie repertuaru
- wyświetlanie informacji o filmach
- wybór daty i seansu
- wybór miejsca parkingowego
- zakup biletów
- generowanie biletów z kodem QR
- historia zakupionych biletów
- zarządzanie filmami
- zarządzanie seansami
- zarządzanie użytkownikami
- panel administratora
- weryfikacja dostępności miejsc
- obsługa logiki związanej z rezerwacją i sprzedażą biletów

---

# 🛠 Technologie

- PHP
- Laravel
- MySQL
- Eloquent ORM
- Blade
- HTML
- CSS
- JavaScript
- jQuery
- Bootstrap
- Git

---

# 🧩 Architektura aplikacji

Projekt wykorzystuje architekturę **MVC (Model–View–Controller)** charakterystyczną dla frameworka Laravel.

Warstwa modeli odpowiada za reprezentację danych oraz relacji pomiędzy encjami.

Kontrolery obsługują logikę aplikacji, żądania użytkowników oraz komunikację pomiędzy widokami a modelami.

Widoki zostały utworzone z wykorzystaniem silnika szablonów **Blade**.

Do komunikacji z relacyjną bazą danych wykorzystywany jest **Eloquent ORM**.

---

# 🗄 Baza danych

Projekt wykorzystuje relacyjną bazę danych **MySQL**.

Baza została zaprojektowana z wykorzystaniem:

- kluczy głównych
- kluczy obcych
- relacji między tabelami
- ograniczeń integralności danych
- relacji obsługiwanych przez Eloquent ORM

Najważniejsze obszary danych dotyczą:

- użytkowników
- filmów
- repertuaru
- seansów
- miejsc parkingowych
- biletów
- rezerwacji

![Diagram ERD](screenshots/ERD.jpg)

W repozytorium znajdują się również pliki `.sql` umożliwiające odtworzenie bazy danych.

- `database_empty.sql` – struktura bazy z podstawowymi kontami
- `database_demo.sql` – baza zawierająca przykładowe dane demonstracyjne

---

# 🚀 Instalacja

## 1. Klonowanie repozytorium

```bash
git clone https://github.com/MatemXVI/kino_samochodowe-laravel.git
```

## 2. Przejście do katalogu projektu

```bash
cd kino_samochodowe-laravel
```

## 3. Instalacja zależności PHP

```bash
composer install
```

## 4. Przygotowanie konfiguracji środowiska

Skopiuj plik:

```text
.env.example
```

i utwórz na jego podstawie:

```text
.env
```

Następnie wygeneruj klucz aplikacji:

```bash
php artisan key:generate
```

## 5. Przygotowanie bazy danych

Utwórz pustą bazę danych MySQL.

Następnie zaimportuj do niej jeden z dostarczonych plików `.sql`:

- `database_empty.sql` – podstawowa wersja bazy
- `database_demo.sql` – wersja zawierająca dane demonstracyjne

## 6. Konfiguracja połączenia z MySQL

W pliku `.env` uzupełnij dane dostępowe do bazy. Poniższe dane są przykładowe.

```text
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nazwa_bazy
DB_USERNAME=uzytkownik
DB_PASSWORD=haslo
```

Dane dostępowe do lokalnej bazy danych nie są przechowywane w repozytorium.

## 7. Utworzenie dowiązania do plików aplikacji

Jeżeli obrazy i inne pliki znajdują się w katalogu `storage`, wykonaj:

```bash
php artisan storage:link
```

## 8. Uruchomienie aplikacji

```bash
php artisan serve
```

Aplikacja będzie dostępna pod adresem:

```text
http://127.0.0.1:8000
```

---

# 👤 Konto testowe

W demonstracyjnej wersji bazy dostępne jest konto administratora:

**E-mail:** `root@root.com`  
**Hasło:** `root`  
**Rola:** `superadmin`

Możliwe jest również utworzenie własnego konta użytkownika.

---

# 📖 Czego nauczyłem się podczas projektu

Projekt pozwolił mi rozwinąć praktyczne umiejętności w zakresie:

- tworzenia aplikacji backendowych w PHP i Laravel
- organizacji aplikacji zgodnie z architekturą MVC
- projektowania relacyjnych baz danych
- definiowania relacji między encjami
- pracy z Eloquent ORM
- tworzenia routingu
- tworzenia kontrolerów oraz modeli
- pracy z szablonami Blade
- uwierzytelniania i autoryzacji użytkowników
- obsługi różnych ról użytkowników
- tworzenia logiki biznesowej
- walidacji danych
- obsługi formularzy
- generowania kodów QR
- refaktoryzacji istniejącej aplikacji
- przenoszenia rozwiązania z czystego PHP do frameworka

---

# 🔄 Rozwój projektu

Pierwsza wersja systemu została wykonana w czystym PHP.

Następnie aplikacja została przeprojektowana i przeniesiona do Laravel, dzięki czemu mogłem wykorzystać rozwiązania oferowane przez framework, takie jak:

- routing
- MVC
- ORM Eloquent
- migracje
- Blade
- mechanizmy autoryzacji
- walidacja

Kolejnym etapem było stworzenie analogicznej aplikacji w Pythonie z wykorzystaniem Django.

Pozwoliło mi to porównać podejście do:

- modelowania danych
- routingu
- ORM
- organizacji kodu
- obsługi użytkowników
- budowania aplikacji backendowych

w Laravel oraz Django.

---

# 🔮 Możliwe kierunki dalszego rozwoju

- REST API
- testy automatyczne
- Docker
- integracja z rzeczywistym systemem płatności
- wysyłanie biletów e-mailem
- rozbudowany system raportowania
- logowanie zdarzeń i monitoring aplikacji
- dalsza optymalizacja zapytań do bazy danych

---

# 👨‍💻 Autor

**Mateusz Milczarek**

[GitHub – MatemXVI](https://github.com/MatemXVI)
