<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clients', [ClientController::class, 'index'])->name('clients');
Route::get('/clients/create', [ClientController::class, 'create']);
Route::get('/clients/{client}', [ClientController::class, 'show']);
Route::get('/clients/{client}/edit', [ClientController::class, 'edit']);
Route::post('/clients', [ClientController::class, 'store']);
Route::put('/clients/{client}', [ClientController::class, 'update']);
Route::post('/clients/calendar', [ClientController::class, 'addCalendar']);

Route::get('/calendars/{id}', [CalendarController::class, 'edit']);
Route::get('/calendars/{season}', [ClientController::class, 'calendarListBySeason']);
