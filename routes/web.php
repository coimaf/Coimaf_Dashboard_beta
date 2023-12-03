<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('welcome');
})->name('home')->middleware('auth');

Route::get('/dipendenti', function () {
    return view('Dashboard.dipendenti');
})->name('dipendenti')->middleware('officina');

Route::get('/dashboard', function () {
    return view('Dashboard.dashboard');
})->name('dash')->middleware('officina');

Route::get('/test', [AuthController::class, 'test'])->name('test');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');