<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DeadlineController;
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

// Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Profile
Route::get('/profile', [ProfileController::class, 'profile'])->name('dashboard.profile')->middleware('auth');

// Dipendenti
Route::get('/dipendenti', [EmployeeController::class, 'index'])->name('dashboard.employees.index')->middleware('officina');
Route::get('/dipendente/nuovo', [EmployeeController::class, 'create'])->name('dashboard.employees.create')->middleware('officina');
Route::post('/dipendente', [EmployeeController::class, 'store'])->name('dashboard.employees.store')->middleware('officina');
Route::get('/dipendente/{employee}', [EmployeeController::class, 'show'])->name('dashboard.employees.show')->middleware('officina');
Route::get('/dipendente/{employee}/modifica', [EmployeeController::class, 'edit'])->name('dashboard.employees.edit')->middleware('officina');
Route::put('/dipendente/{employee}', [EmployeeController::class, 'update'])->name('dashboard.employees.update')->middleware('officina');
Route::delete('/dipendente/{employee}/elimina', [EmployeeController::class, 'destroy'])->name('dashboard.employees.destroy')->middleware('officina');

// Scadenzario
Route::get('/scadenzario', [DeadlineController::class, 'index'])->name('dashboard.deadlines.index')->middleware('officina');
Route::get('/scadenzario/tag/{tag}', [DeadlineController::class, 'showByTag'])->name('dashboard.deadlines.tag')->middleware('officina');
Route::get('/scadenzario/nuovo', [DeadlineController::class, 'create'])->name('dashboard.deadlines.create')->middleware('officina');
Route::post('/scadenzario', [DeadlineController::class, 'store'])->name('dashboard.deadlines.store')->middleware('officina');
Route::get('/scadenzario/{deadline}', [DeadlineController::class, 'show'])->name('dashboard.deadlines.show')->middleware('officina');
Route::get('/scadenzario/{deadline}/modifica', [DeadlineController::class, 'edit'])->name('dashboard.deadlines.edit')->middleware('officina');
Route::put('/scadenzario/{deadline}', [DeadlineController::class, 'update'])->name('dashboard.deadlines.update')->middleware('officina');
Route::delete('/scadenzario/{deadline}/elimina', [DeadlineController::class, 'destroy'])->name('dashboard.deadlines.destroy')->middleware('officina');

// Impostazioni
Route::get('/impostazioni', [SettingController::class, 'index'])->name('dashboard.settings.index')->middleware('officina');
Route::get('/dashboard/impostazioni/dipendenti/crea', [SettingController::class, 'employeesCreate'])->name('dashboard.settings.employees.create')->middleware('officina');
Route::post('/dashboard/impostazioni/dipendenti/manage', [SettingController::class, 'employeesManageDocument'])->name('dashboard.settings.employees.manageDocument')->middleware('officina');
Route::post('/dashboard/impostazioni/dipendenti/addRole', [SettingController::class, 'employeesAddRole'])->name('dashboard.settings.employees.addRole')->middleware('officina');
Route::delete('/dashboard/impostazioni/dipendenti/removeRole/{roleId}', [SettingController::class, 'employeesRemoveRole'])->name('dashboard.settings.employees.removeRole')->middleware('officina');
Route::post('/dashboard/impostazioni/dipendenti/addDocument', [SettingController::class, 'employeesAddDocument'])->name('dashboard.settings.employees.addDocument')->middleware('officina');
Route::delete('/dashboard/impostazioni/dipendenti/removeDocument/{documentId}', [SettingController::class, 'employeesRemoveDocument'])->name('dashboard.settings.employees.removeDocument')->middleware('officina');

Route::get('/dashboard/impostazioni/scadenzario/crea', [SettingController::class, 'deadlinesCreate'])->name('dashboard.settings.deadlines.create')->middleware('officina');
Route::post('/dashboard/impostazioni/scadenzario/aggiungi-tag', [SettingController::class, 'deadlinesAddTag'])->name('dashboard.settings.deadlines.tagAdd')->middleware('officina');
Route::delete('/dashboard/impostazioni/scadenzario/rimuovi-tag/{tagId}', [SettingController::class, 'deadlinesRemoveTag'])->name('dashboard.settings.deadlines.tagRemove')->middleware('officina');

Route::get('/dashboard/impostazioni/macchine-vendute/crea', [SettingController::class, 'machinesSoldsCreate'])->name('dashboard.settings.machinesSold.create')->middleware('officina');
Route::post('/dashboard/impostazioni/macchine-vendute/aggiungi', [SettingController::class, 'machinesSoldsStore'])->name('dashboard.settings.machinesSold.store')->middleware('officina');
Route::delete('/dashboard/impostazioni/macchine-vendute/rimuovi//{warrantyId}', [SettingController::class, 'machinesSoldsDelete'])->name('dashboard.settings.machinesSold.delete')->middleware('officina');

// Macchine Vendute
Route::get('/macchine-vendute', [MachineController::class, 'index'])->name('dashboard.machinesSolds.index')->middleware('officina');
Route::get('/macchine-vendute/crea', [MachineController::class, 'create'])->name('dashboard.machinesSolds.create')->middleware('officina');
Route::post('/macchine-vendute/store', [MachineController::class, 'store'])->name('dashboard.machinesSolds.store')->middleware('officina');
Route::get('/macchine/{machine}', [MachineController::class, 'show'])->name('dashboard.machinesSolds.show')->middleware('officina');
Route::get('/macchine/modifica/{machine}', [MachineController::class, 'edit'])->name('dashboard.machinesSolds.edit')->middleware('officina');
Route::put('/macchine/modifica/{machine}', [MachineController::class, 'update'])->name('dashboard.machinesSolds.update')->middleware('officina');
Route::delete('/macchine/elimina/{machine}', [MachineController::class, 'destroy'])->name('dashboard.machinesSolds.destroy')->middleware('officina');

// Searchable
Route::get('/dashboard/search', [SearchController::class, 'search'])->name('dashboard.search')->middleware('officina');
