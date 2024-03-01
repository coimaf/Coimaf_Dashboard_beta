<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\R4Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ItemsUnderStock;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TypeR4Controller;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DeadlineController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\AuthCustomAuthController;

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
// Route::get('/test', [TestController::class, 'index'])->name('test');

//? Non esiste home
// Route::get('/', function () {
//     return view('dashboard.dashboard');
// })->name('home')->middleware('auth');
Route::get('/', [HomeController::class, 'indexHome'])->name('home')->middleware('auth');

// Dashboard
// Route::get('/dashboard', function () {
//     return view('dashboard.dashboard');
// })->name('dash')->middleware('auth');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dash')->middleware('auth');

// Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::get('/login/root', function () {
    return view('auth.loginRoot');
})->name('loginRoot')->middleware('guest');
Route::post('custom-login', [AuthCustomAuthController::class, 'login'])->name('custom.login');

// Profile
Route::get('/profile', [ProfileController::class, 'profile'])->name('dashboard.profile')->middleware('auth');

// Dipendenti
Route::get('/dipendenti', [EmployeeController::class, 'index'])->name('dashboard.employees.index')->middleware('auth', 'dipendenti');
Route::get('/dipendente/nuovo', [EmployeeController::class, 'create'])->name('dashboard.employees.create')->middleware('auth', 'dipendenti');
Route::post('/dipendente', [EmployeeController::class, 'store'])->name('dashboard.employees.store')->middleware('auth', 'dipendenti');
Route::get('/dipendente/{employee}', [EmployeeController::class, 'show'])->name('dashboard.employees.show')->middleware('auth', 'dipendenti');
Route::get('/dipendente/{employee}/modifica', [EmployeeController::class, 'edit'])->name('dashboard.employees.edit')->middleware('auth', 'dipendenti');
Route::put('/dipendente/{employee}', [EmployeeController::class, 'update'])->name('dashboard.employees.update')->middleware('auth', 'dipendenti');
Route::delete('/dipendente/{employee}/elimina', [EmployeeController::class, 'destroy'])->name('dashboard.employees.destroy')->middleware('auth', 'dipendenti');

// Scadenzario
Route::get('/scadenzario', [DeadlineController::class, 'index'])->name('dashboard.deadlines.index')->middleware('auth', 'scadenzario');
Route::get('/scadenzario/tag/{tag}', [DeadlineController::class, 'showByTag'])->name('dashboard.deadlines.tag')->middleware('auth', 'scadenzario');
Route::get('/scadenzario/nuovo', [DeadlineController::class, 'create'])->name('dashboard.deadlines.create')->middleware('auth', 'scadenzario');
Route::post('/scadenzario', [DeadlineController::class, 'store'])->name('dashboard.deadlines.store')->middleware('auth', 'scadenzario');
Route::get('/scadenzario/{deadline}', [DeadlineController::class, 'show'])->name('dashboard.deadlines.show')->middleware('auth', 'scadenzario');
Route::get('/scadenzario/{deadline}/modifica', [DeadlineController::class, 'edit'])->name('dashboard.deadlines.edit')->middleware('auth', 'scadenzario');
Route::put('/scadenzario/{deadline}', [DeadlineController::class, 'update'])->name('dashboard.deadlines.update')->middleware('auth', 'scadenzario');
Route::delete('/scadenzario/{deadline}/elimina', [DeadlineController::class, 'destroy'])->name('dashboard.deadlines.destroy')->middleware('auth', 'scadenzario');

// Impostazioni
Route::get('/impostazioni', [SettingController::class, 'index'])->name('dashboard.settings.index')->middleware('auth', 'impostazioni');
Route::get('/dashboard/impostazioni/dipendenti/crea', [SettingController::class, 'employeesCreate'])->name('dashboard.settings.employees.create')->middleware('auth', 'impostazioni');
Route::post('/dashboard/impostazioni/dipendenti/manage', [SettingController::class, 'employeesManageDocument'])->name('dashboard.settings.employees.manageDocument')->middleware('auth', 'impostazioni');
Route::post('/dashboard/impostazioni/dipendenti/addRole', [SettingController::class, 'employeesAddRole'])->name('dashboard.settings.employees.addRole')->middleware('auth', 'impostazioni');
Route::delete('/dashboard/impostazioni/dipendenti/removeRole/{roleId}', [SettingController::class, 'employeesRemoveRole'])->name('dashboard.settings.employees.removeRole')->middleware('auth', 'impostazioni');
Route::post('/dashboard/impostazioni/dipendenti/addDocument', [SettingController::class, 'employeesAddDocument'])->name('dashboard.settings.employees.addDocument')->middleware('auth', 'impostazioni');
Route::delete('/dashboard/impostazioni/dipendenti/removeDocument/{documentId}', [SettingController::class, 'employeesRemoveDocument'])->name('dashboard.settings.employees.removeDocument')->middleware('auth', 'impostazioni');

Route::get('/dashboard/impostazioni/scadenzario/crea', [SettingController::class, 'deadlinesCreate'])->name('dashboard.settings.deadlines.create')->middleware('auth', 'impostazioni');
Route::post('/dashboard/impostazioni/scadenzario/aggiungi-tag', [SettingController::class, 'deadlinesAddTag'])->name('dashboard.settings.deadlines.tagAdd')->middleware('auth', 'impostazioni');
Route::delete('/dashboard/impostazioni/scadenzario/rimuovi-tag/{tagId}', [SettingController::class, 'deadlinesRemoveTag'])->name('dashboard.settings.deadlines.tagRemove')->middleware('auth', 'impostazioni');

Route::get('/dashboard/impostazioni/macchine-vendute/crea', [SettingController::class, 'machinesSoldsCreate'])->name('dashboard.settings.machinesSold.create')->middleware('auth', 'impostazioni');
Route::post('/dashboard/impostazioni/macchine-vendute/aggiungi', [SettingController::class, 'machinesSoldsStore'])->name('dashboard.settings.machinesSold.store')->middleware('auth', 'impostazioni');
Route::delete('/dashboard/impostazioni/macchine-vendute/rimuovi//{warrantyId}', [SettingController::class, 'machinesSoldsDelete'])->name('dashboard.settings.machinesSold.delete')->middleware('auth', 'impostazioni');

Route::get('/dashboard/impostazioni/tecnici/crea', [TechnicianController::class, 'create'])->name('dashboard.settings.tecnicians.create')->middleware('auth', 'impostazioni');
Route::post('/dashboard/impostazioni/tecnici/aggiungi', [TechnicianController::class, 'store'])->name('dashboard.settings.tecnicians.store')->middleware('auth', 'impostazioni');
Route::delete('/dashboard/settings/technicians/{technician}', [TechnicianController::class, 'destroy'])->name('dashboard.settings.tecnicians.delete')->middleware('auth', 'impostazioni');

Route::get('/dashboard/impostazioni/flotta/crea', [SettingController::class, 'vehiclesCreate'])->name('dashboard.settings.vehicle.create')->middleware('auth', 'impostazioni');
Route::post('/dashboard/impostazioni/flotta/aggiungi', [SettingController::class, 'vehiclesStore'])->name('dashboard.settings.vehicle.store')->middleware('auth', 'impostazioni');
Route::delete('/dashboard/impostazioni/flotta/rimuovi/{vehicleType}', [SettingController::class, 'vehiclesDelete'])->name('dashboard.settings.vehicle.delete')->middleware('auth', 'impostazioni');

Route::get('/dashboard/impostazioni/flotta/documenti/crea', [SettingController::class, 'documentVehiclesCreate'])->name('dashboard.settings.documentVehiclesCreate.create')->middleware('auth', 'impostazioni');
Route::post('/dashboard/impostazioni/flotta/documenti/aggiungi', [SettingController::class, 'documentVehiclesStore'])->name('dashboard.settings.documentVehiclesCreate.store')->middleware('auth', 'impostazioni');
Route::delete('/dashboard/impostazioni/flotta/documenti/elimina/{documentVehicle}', [SettingController::class, 'documentVehiclesDelete'])->name('dashboard.settings.documentVehiclesCreate.delete')->middleware('auth', 'impostazioni');

Route::get('/dashboard/impostazioni/r4/tipo/crea', [TypeR4Controller::class, 'create'])->name('dashboard.settings.r4.create')->middleware('auth', 'impostazioni');
Route::post('/dashboard/impostazioni/r4/tipo/aggiungi', [TypeR4Controller::class, 'store'])->name('dashboard.settings.r4.store')->middleware('auth', 'impostazioni');
Route::delete('/dashboard/impostazioni/r4/tipo/elimina/{typeR4Id}', [TypeR4Controller::class, 'destroy'])->name('dashboard.settings.r4.delete')->middleware('auth', 'impostazioni');

// Macchine Vendute
Route::get('/macchine-vendute', [MachineController::class, 'index'])->name('dashboard.machinesSolds.index')->middleware('auth', 'DbMacchine');
Route::get('/dashboard/macchine-vendute/crea', [MachineController::class, 'create'])->name('dashboard.machinesSolds.create')->middleware('auth', 'DbMacchine');
Route::post('/dashboard/macchine-vendute/store', [MachineController::class, 'store'])->name('dashboard.machinesSolds.store')->middleware('auth', 'DbMacchine');
Route::get('/dashboard/macchine/{machine}', [MachineController::class, 'show'])->name('dashboard.machinesSolds.show')->middleware('auth', 'DbMacchine');
Route::get('/dashboard/macchine/modifica/{machine}', [MachineController::class, 'edit'])->name('dashboard.machinesSolds.edit')->middleware('auth', 'DbMacchine');
Route::put('/dashboard/macchine/modifica/{machine}', [MachineController::class, 'update'])->name('dashboard.machinesSolds.update')->middleware('auth', 'DbMacchine');
Route::delete('/dashboard/macchine/elimina/{machine}', [MachineController::class, 'destroy'])->name('dashboard.machinesSolds.destroy')->middleware('auth', 'DbMacchine');

// Tickets
Route::get('/tickets', [TicketController::class, 'index'])->name('dashboard.tickets.index')->middleware('auth', 'ticket');
Route::get('/dashboard/tickets/crea', [TicketController::class, 'create'])->name('dashboard.tickets.create')->middleware('auth', 'ticket');
Route::post('/dashboard/tickets/store', [TicketController::class, 'store'])->name('dashboard.tickets.store')->middleware('auth', 'ticket');
Route::get('/dashboard/tickets/dettaglio/{ticket}', [TicketController::class, 'show'])->name('dashboard.tickets.show')->middleware('auth', 'ticket');
Route::get('/dashboard/tickets/{ticket}/modifica', [TicketController::class, 'edit'])->name('dashboard.tickets.edit')->middleware('auth', 'ticket');
Route::put('/dashboard/tickets/update/{ticket}', [TicketController::class, 'update'])->name('dashboard.tickets.update')->middleware('auth', 'ticket');
Route::delete('/dashboard/tickets/elimina/{ticket}', [TicketController::class, 'destroy'])->name('dashboard.tickets.delete')->middleware('auth', 'ticket');
Route::get('/dashboard/tickets/stampa/{ticket}', [TicketController::class, 'print'])->name('dashboard.tickets.print')->middleware('auth', 'ticket');
Route::delete('/dashboard/replacements/{id}', [TicketController::class, 'destroyReplacement'])->name('dashboard.replacements.destroy')->middleware('auth', 'ticket');
Route::get('/fetch-results', [TicketController::class, 'fetchResults'])->name('fetch.results');


// Articoli Sotto Scorta
Route::get('/articoli-sotto-scorta', [ItemsUnderStock::class, 'index'])->name('items_under_stock')->middleware('auth', 'sottoscorta');

// Flotta
Route::get('/flotta', [VehicleController::class, 'index'])->name('dashboard.vehicles.index')->middleware('auth', 'flotta');
Route::get('/flotta/crea', [VehicleController::class, 'create'])->name('dashboard.vehicles.create')->middleware('auth', 'flotta');
Route::post('/flotta/store', [VehicleController::class, 'store'])->name('dashboard.vehicles.store')->middleware('auth', 'flotta');
Route::get('/flotta/dettaglio/{vehicle}', [VehicleController::class, 'show'])->name('dashboard.vehicles.show')->middleware('auth', 'flotta');
Route::get('/flotta/modifica/{vehicle}', [VehicleController::class, 'edit'])->name('dashboard.vehicles.edit')->middleware('auth', 'flotta');
Route::put('/flotta/modifica/{vehicle}', [VehicleController::class, 'update'])->name('dashboard.vehicles.update')->middleware('auth', 'flotta');
Route::delete('/flotta/elimina/{vehicle}', [VehicleController::class, 'destroy'])->name('dashboard.vehicles.destroy')->middleware('auth', 'flotta');
Route::delete('/flotta/{vehicle}/maintenances/{maintenance}', [VehicleController::class, 'destroyMaintenance'])->name('maintenance.destroy')->middleware('auth', 'flotta');

// FPC
Route::get('fpc', function()  { return view('dashboard.fpc.index'); })->name('dashboard.fpc.index')->middleware('auth', 'fpc');
    // r4
    Route::get( '/fpc/r4/index', [R4Controller::class, 'index'])->name('dashboard.fpc.r4.index')->middleware('auth', 'fpc');
    Route::get( '/fpc/r4/crea', [R4Controller::class, 'create'])->name('dashboard.fpc.r4.create')->middleware('auth', 'fpc');
    Route::post('/fpc/r4/store', [R4Controller::class, 'store'])->name('dashboard.fpc.store')->middleware('auth', 'fpc');
    Route::get('/fpc/dettaglio/{r4}', [R4Controller::class, 'show'])->name('dashboard.r4.show')->middleware('auth', 'fpc');
    Route::get('/fpc/modifica/{r4}', [R4Controller::class, 'edit'])->name('dashboard.r4.edit')->middleware('auth', 'fpc');
    Route::put('/fpc/update/{r4}', [R4Controller::class, 'update'])->name('dashboard.r4.update')->middleware('auth', 'fpc');
    Route::delete('/fpc/elimina/{r4}', [R4Controller::class, 'destroy'])->name('dashboard.r4.destroy')->middleware('auth', 'fpc');



// Searchable
// Route::get('/dashboard/search', [SearchController::class, 'search'])->name('dashboard.search')->middleware('auth', 'officina');
