<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\OnlyAdminMiddleware;
use App\Http\Middleware\OnlyGuestMiddleware;
use App\Http\Middleware\OnlyUserMiddle;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Login, Register, Logout
Route::get('/', [HomeController::class,'home'])->name('login')->middleware([OnlyGuestMiddleware::class]);
Route::post('/', [UserController::class,'doLogin'])->name('doLogin')->middleware([OnlyGuestMiddleware::class]);
Route::post('/register', [UserController::class,'doRegister'])->name('doRegister')->middleware([OnlyGuestMiddleware::class]);
Route::any('/logout', [UserController::class,'doLogout'])->name('doLogout')->middleware('auth');
// End of Login, Register, Logout

// Dashboard
Route::get('/dashboard', [DashboardController::class,'dashboard'])->name('dashboard')->middleware('auth');
// End of dashbord

// Event
Route::prefix('event')->middleware('auth')->group(function () {
    Route::controller(EventController::class)->group(function(){
        Route::get('/list','allEvent')->name("listEvent");
        Route::get('/{id}','detailEvent')->name("addEvent")->where('id', '[0-9]+');
        Route::post('/add','addEvent')->name("editEvent");
        Route::post('/edit','editEvent')->name("detailEvent");
        Route::post('/delete','deleteEvent')->name("deleteEvent");
    });

    Route::controller(EventController::class)->middleware([OnlyUserMiddle::class])->group(function(){
        Route::get('/contribute','contributeEvent')->name("contributeEvent");
        Route::get('/my','myEvent')->name("myEvent");
        Route::post('/booking','bookingEvent')->name("bookingEvent");
    });

    Route::get('/booked', [EventController::class,'bookedEvent'])->name("bookedEvent")->middleware([OnlyAdminMiddleware::class]);
});
// End of Event

// Users
Route::get('/users', [UserController::class,'allUsers'])->name('users')->middleware([OnlyAdminMiddleware::class, Authenticate::class]);
// Enf of Users

Route::get('/calendar', [CalendarController::class,'calendar'])->name('calendar')->middleware('auth');
Route::get('/profile', [UserController::class,'profile'])->name('profile')->middleware('auth');
Route::post('/profile', [UserController::class,'updateProfile'])->name('updateProfile')->middleware('auth');