<?php

use App\Http\Controllers\EventAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Simple API to get list and detail Event
Route::controller(EventAPIController::class)->group(function(){
    Route::get('/events','allEvent')->name("listEventAPI");
    Route::get('/event/{id}','detailEvent')->name("detailEventAPI")->where('id', '[0-9]+');
});
