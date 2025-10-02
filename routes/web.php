<?php

use App\Http\Controllers\Admin\FilmsController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\ScreeningsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\VenuesController;
use App\Http\Controllers\BuyTicketController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Route;

// -- PANEL UŻYTKOWNIKA --- //

//main
Route::get('/', [FilmController::class, 'index'])->name('films.index');
Route::get('films/{film}', [FilmController::class, 'show'])->name('films.show');
Route::get('screenings', [ScreeningController::class, 'index'])->name('screenings.index');
Route::get('screenings/{screening}', [ScreeningController::class, 'show'])->name('screenings.show');
Route::get('venues', [VenueController::class, 'index'])->name('venues.index');
Route::get('venues/{venue}', [VenueController::class, 'show'])->name('venues.show');

//wybór miejsc parkingowych
Route::get('tickets/parking', [BuyTicketController::class, 'parking'])->name('tickets.parking');

//wylogowanie
Route::get('logout', [UserController::class, 'logout'])->name('user.logout')->middleware("auth");

//logowanie,rejestracja
Route::middleware('guest')->group(function () {
    Route::get('login', [UserController::class, 'showLoginForm'])->name('login');
    Route::post('login', [UserController::class, 'login'])->name('login');

    Route::get('register', [UserController::class, 'create'])->name('register.create');
    Route::post('register', [UserController::class, 'store'])->name('register.store');

});

Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('ticket.show');

//zakup biletu, panel użytkownika
Route::middleware(['role:user'])->group(function () {
    //kup bilet
    Route::get('ticket/selected', [BuyTicketController::class, 'selected'])->name('ticket.selected');
    Route::post('ticket/payment', [BuyTicketController::class, 'payment'])->name('ticket.payment');
    Route::post('ticket/summary', [BuyTicketController::class, 'summary'])->name('ticket.summary');
    Route::patch('ticket/generate', [BuyTicketController::class, 'generate'])->name('ticket.generate');

    //podgląd biletów
    Route::get('user/tickets', [TicketController::class, 'index'])->name('user.tickets.index');
    Route::delete('user/tickets/{ticket}', [TicketController::class, 'destroy'])->name('user.tickets.destroy');

    //user
    Route::get('user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('user/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::patch('user/profile', [UserController::class, 'update'])->name('user.update');
    Route::patch('user/password', [UserController::class, 'updatePassword'])->name('user.password');
});



//--- PANEL ADMINISTRATORA
Route::prefix('admin')->name('admin.')->group(function () {
//logowanie/wylogowanie
    Route::get('login', [IndexController::class, 'showLoginForm'])->name('login');
    Route::post('login', [IndexController::class, 'login'])->name('login');
    Route::get('logout', [IndexController::class, 'logout'])->name('logout')->middleware("auth");

    Route::middleware(['role:admin,superadmin'])->group(function(){

    //MENU
    Route::get('/', [IndexController::class, 'index'])->name('index');

    //UŻYTKOWNICY
    Route::get('users', [UsersController::class, 'index'])->name('users.index');
    Route::get('users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::patch('users/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::get('users/{user}/password/edit', [UsersController::class, 'edit_password'])->name('users.edit_password');
    Route::patch('users/{user}/password', [UsersController::class, 'update_password'])->name('users.update_password');
    Route::delete('users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');


    Route::resource('films', FilmsController::class)->except('show');
    Route::resource('screenings', ScreeningsController::class)->except('show');
    Route::resource('venues', VenuesController::class)->except('show');
    Route::get('screenings/{screening}/tickets', [ScreeningsController::class, 'tickets'])->name('screenings.tickets');
    Route::get('screenings/{screening}/parkings', [ScreeningsController::class, 'parkings'])->name('screenings.parkings');

    //PLIKI

    //miejsca seansu
    Route::get('venues/{venue}/files', [VenuesController::class, 'loadFiles'])->name('venues.files.load');
    Route::post('venues/{venue}/files', [VenuesController::class, 'storeFiles'])->name('venues.files.store');
    Route::patch('venues/files/{venueImage}', [VenuesController::class, 'renameFiles'])->name('venues.files.rename');
    Route::delete('venues/files/{venueImage}', [VenuesController::class, 'destroyFiles'])->name('venues.files.destroy');

    //filmy
    Route::get('films/{film}/files', [FilmsController::class, 'loadFiles'])->name('films.files.load');
    //zdjęcia
    Route::post('films/{film}/files', [FilmsController::class, 'storeFiles'])->name('films.files.store');
    Route::patch('films/files/{filmImage}', [FilmsController::class, 'renameFiles'])->name('films.files.rename');
    Route::delete('films/files/{filmImage}', [FilmsController::class, 'destroyFiles'])->name('films.files.destroy');
    //plakat
    Route::post('films/poster/{film}/files', [FilmsController::class, 'storePoster'])->name('films.files.storePoster');
    Route::patch('films/files/poster/{film}', [FilmsController::class, 'renamePoster'])->name('films.files.renamePoster');
    Route::delete('films/files/poster/{film}', [FilmsController::class, 'destroyPoster'])->name('films.files.destroyPoster');

    //seanse
    Route::get('screenings/{screening}/files', [ScreeningsController::class, 'loadFiles'])->name('screenings.files.load');
    Route::post('screenings/poster/{screening}/files', [ScreeningsController::class, 'storePoster'])->name('screenings.files.storePoster');
    Route::patch('screenings/files/poster/{screening}', [ScreeningsController::class, 'renamePoster'])->name('screenings.files.renamePoster');
    Route::delete('screenings/files/poster/{screening}', [ScreeningsController::class, 'destroyPoster'])->name('screenings.files.destroyPoster');

    });

 // ADMINISTRATORZY (tylko superadmin może tworzyć tylko administratorów)
    Route::middleware(['role:superadmin'])->group(function(){
        Route::get('administrators/create', [UsersController::class, 'create'])->name('administrators.create');
        Route::post('administrators', [UsersController::class, 'store'])->name('administrators.store');
  });

});
