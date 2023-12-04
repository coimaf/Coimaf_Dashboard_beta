<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\EmployeeController;

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

//! Solo per Test
Route::get('/test', [TestController::class, 'test'])->name('test');

//? Non sappiamo se servirà
Route::get('/', function () {
    return view('welcome');
})->name('home')->middleware('auth');

// Dashboard
Route::get('/dashboard', function () {
    return view('Dashboard.dashboard');
})->name('dash')->middleware('officina');

// Dipendenti
Route::get('/dipendenti', [EmployeeController::class, 'index'])->name('dashboard.employees.index')->middleware('officina');
Route::get('/dipendenti/nuovo', [EmployeeController::class, 'create'])->name('dashboard.employees.create')->middleware('officina');
Route::post('/dipendenti', [EmployeeController::class, 'store'])->name('dashboard.employees.store')->middleware('officina');
Route::get('/dipendenti/{dipendente}', [EmployeeController::class, 'show'])->name('dashboard.employees.show')->middleware('officina');
Route::get('/dipendenti/{dipendente}/modifica', [EmployeeController::class, 'edit'])->name('dashboard.employees.edit')->middleware('officina');
Route::put('/dipendenti/{dipendente}', [EmployeeController::class, 'update'])->name('dashboard.employees.update')->middleware('officina');
Route::delete('/dipendenti/{dipendente}', [EmployeeController::class, 'destroy'])->name('dashboard.employees.destroy')->middleware('officina');

// Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');