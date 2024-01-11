<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DeadlineController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TechnicianController;

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
// Route::get('/test', [TestController::class, 'test'])->name('test');

//? Non sappiamo se servirà
Route::get('/', function () {
    return view('welcome');
})->name('home')->middleware('auth');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->name('dash')->middleware('auth');

// Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Profile
Route::get('/profile', [ProfileController::class, 'profile'])->name('dashboard.profile')->middleware('auth');

// Dipendenti
Route::get('/dipendenti', [EmployeeController::class, 'index'])->name('dashboard.employees.index')->middleware('auth', 'officina');
Route::get('/dipendente/nuovo', [EmployeeController::class, 'create'])->name('dashboard.employees.create')->middleware('auth', 'officina');
Route::post('/dipendente', [EmployeeController::class, 'store'])->name('dashboard.employees.store')->middleware('auth', 'officina');
Route::get('/dipendente/{employee}', [EmployeeController::class, 'show'])->name('dashboard.employees.show')->middleware('auth', 'officina');
Route::get('/dipendente/{employee}/modifica', [EmployeeController::class, 'edit'])->name('dashboard.employees.edit')->middleware('auth', 'officina');
Route::put('/dipendente/{employee}', [EmployeeController::class, 'update'])->name('dashboard.employees.update')->middleware('auth', 'officina');
Route::delete('/dipendente/{employee}/elimina', [EmployeeController::class, 'destroy'])->name('dashboard.employees.destroy')->middleware('auth', 'officina');

// Scadenzario
Route::get('/scadenzario', [DeadlineController::class, 'index'])->name('dashboard.deadlines.index')->middleware('auth', 'officina');
Route::get('/scadenzario/tag/{tag}', [DeadlineController::class, 'showByTag'])->name('dashboard.deadlines.tag')->middleware('auth', 'officina');
Route::get('/scadenzario/nuovo', [DeadlineController::class, 'create'])->name('dashboard.deadlines.create')->middleware('auth', 'officina');
Route::post('/scadenzario', [DeadlineController::class, 'store'])->name('dashboard.deadlines.store')->middleware('auth', 'officina');
Route::get('/scadenzario/{deadline}', [DeadlineController::class, 'show'])->name('dashboard.deadlines.show')->middleware('auth', 'officina');
Route::get('/scadenzario/{deadline}/modifica', [DeadlineController::class, 'edit'])->name('dashboard.deadlines.edit')->middleware('auth', 'officina');
Route::put('/scadenzario/{deadline}', [DeadlineController::class, 'update'])->name('dashboard.deadlines.update')->middleware('auth', 'officina');
Route::delete('/scadenzario/{deadline}/elimina', [DeadlineController::class, 'destroy'])->name('dashboard.deadlines.destroy')->middleware('auth', 'officina');

// Impostazioni
Route::get('/impostazioni', [SettingController::class, 'index'])->name('dashboard.settings.index')->middleware('auth', 'officina');
Route::get('/dashboard/impostazioni/dipendenti/crea', [SettingController::class, 'employeesCreate'])->name('dashboard.settings.employees.create')->middleware('auth', 'officina');
Route::post('/dashboard/impostazioni/dipendenti/manage', [SettingController::class, 'employeesManageDocument'])->name('dashboard.settings.employees.manageDocument')->middleware('auth', 'officina');
Route::post('/dashboard/impostazioni/dipendenti/addRole', [SettingController::class, 'employeesAddRole'])->name('dashboard.settings.employees.addRole')->middleware('auth', 'officina');
Route::delete('/dashboard/impostazioni/dipendenti/removeRole/{roleId}', [SettingController::class, 'employeesRemoveRole'])->name('dashboard.settings.employees.removeRole')->middleware('auth', 'officina');
Route::post('/dashboard/impostazioni/dipendenti/addDocument', [SettingController::class, 'employeesAddDocument'])->name('dashboard.settings.employees.addDocument')->middleware('auth', 'officina');
Route::delete('/dashboard/impostazioni/dipendenti/removeDocument/{documentId}', [SettingController::class, 'employeesRemoveDocument'])->name('dashboard.settings.employees.removeDocument')->middleware('auth', 'officina');

Route::get('/dashboard/impostazioni/scadenzario/crea', [SettingController::class, 'deadlinesCreate'])->name('dashboard.settings.deadlines.create')->middleware('auth', 'officina');
Route::post('/dashboard/impostazioni/scadenzario/aggiungi-tag', [SettingController::class, 'deadlinesAddTag'])->name('dashboard.settings.deadlines.tagAdd')->middleware('auth', 'officina');
Route::delete('/dashboard/impostazioni/scadenzario/rimuovi-tag/{tagId}', [SettingController::class, 'deadlinesRemoveTag'])->name('dashboard.settings.deadlines.tagRemove')->middleware('auth', 'officina');

Route::get('/dashboard/impostazioni/macchine-vendute/crea', [SettingController::class, 'machinesSoldsCreate'])->name('dashboard.settings.machinesSold.create')->middleware('auth', 'officina');
Route::post('/dashboard/impostazioni/macchine-vendute/aggiungi', [SettingController::class, 'machinesSoldsStore'])->name('dashboard.settings.machinesSold.store')->middleware('auth', 'officina');
Route::delete('/dashboard/impostazioni/macchine-vendute/rimuovi//{warrantyId}', [SettingController::class, 'machinesSoldsDelete'])->name('dashboard.settings.machinesSold.delete')->middleware('auth', 'officina');

Route::get('/dashboard/impostazioni/tecnici/crea', [TechnicianController::class, 'create'])->name('dashboard.settings.tecnicians.create')->middleware('auth', 'officina');
Route::post('/dashboard/impostazioni/tecnici/aggiungi', [TechnicianController::class, 'store'])->name('dashboard.settings.tecnicians.store')->middleware('auth', 'officina');
Route::delete('/dashboard/settings/technicians/{technician}', [TechnicianController::class, 'destroy'])->name('dashboard.settings.tecnicians.delete')->middleware('auth', 'officina');

// Macchine Vendute
Route::get('/macchine-vendute', [MachineController::class, 'index'])->name('dashboard.machinesSolds.index')->middleware('auth', 'officina');
Route::get('/dashboard/macchine-vendute/crea', [MachineController::class, 'create'])->name('dashboard.machinesSolds.create')->middleware('auth', 'officina');
Route::post('/dashboard/macchine-vendute/store', [MachineController::class, 'store'])->name('dashboard.machinesSolds.store')->middleware('auth', 'officina');
Route::get('/dashboard/macchine/{machine}', [MachineController::class, 'show'])->name('dashboard.machinesSolds.show')->middleware('auth', 'officina');
Route::get('/dashboard/macchine/modifica/{machine}', [MachineController::class, 'edit'])->name('dashboard.machinesSolds.edit')->middleware('auth', 'officina');
Route::put('/dashboard/macchine/modifica/{machine}', [MachineController::class, 'update'])->name('dashboard.machinesSolds.update')->middleware('auth', 'officina');
Route::delete('/dashboard/macchine/elimina/{machine}', [MachineController::class, 'destroy'])->name('dashboard.machinesSolds.destroy')->middleware('auth', 'officina');

// Tickets
Route::get('/tickets', [TicketController::class, 'index'])->name('dashboard.tickets.index')->middleware('auth', 'officina');
Route::get('/dashboard/tickets/crea', [TicketController::class, 'create'])->name('dashboard.tickets.create')->middleware('auth', 'officina');
Route::post('/dashboard/tickets/store', [TicketController::class, 'store'])->name('dashboard.tickets.store')->middleware('auth', 'officina');
Route::get('/dashboard/tickets/dettaglio/{ticket}', [TicketController::class, 'show'])->name('dashboard.tickets.show')->middleware('auth', 'officina');
Route::get('/dashboard/tickets/{ticket}/modifica', [TicketController::class, 'edit'])->name('dashboard.tickets.edit')->middleware('auth', 'officina');
Route::put('/dashboard/tickets/update/{ticket}', [TicketController::class, 'update'])->name('dashboard.tickets.update')->middleware('auth', 'officina');
Route::delete('/dashboard/tickets/elimina/{ticket}', [TicketController::class, 'destroy'])->name('dashboard.tickets.delete')->middleware('auth', 'officina');

// Searchable
Route::get('/dashboard/search', [SearchController::class, 'search'])->name('dashboard.search')->middleware('auth', 'officina');
