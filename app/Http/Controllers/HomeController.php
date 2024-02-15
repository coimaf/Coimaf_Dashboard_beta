<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Vehicle;
use App\Models\Deadline;
use Illuminate\Http\Request;
use App\Models\DocumentVehicles;

class HomeController extends Controller
{
    public function index()
    {
        $openTicketsCount = Ticket::where('status', 'Aperto')->count();
        $waitingForSparePartsCount = Ticket::where('status', 'In attesa di un ricambio')->count();
        $urgentTicketsCount = Ticket::where('priority', 'Urgente')->count();
        
        // Calcolo del numero di scadenze in scadenza (entro 7 giorni dalla data odierna)
        $expiringDeadlinesCount = Deadline::whereHas('documentDeadlines', function ($query) {
            $query->where('expiry_date', '>', now())
            ->where('expiry_date', '<=', now()->addDays(60));
        })
        ->count();
        
        // Calcolo del numero di scadenze scadute (data di scadenza antecedente alla data odierna)
        $expiredDeadlinesCount = Deadline::whereHas('documentDeadlines', function ($query) {
            $query->where('expiry_date', '<', now());
        })
        ->count();


        $expiredVehiclesCount = Vehicle::whereHas('documents', function ($query) {
            $query->where('expiry_date', '<', now());
        })->count();

        $expiringVehiclesCount = Vehicle::whereHas('documents', function ($query) {
            $query->where('expiry_date', '>', now())
            ->where('expiry_date', '<=', now()->addDays(60));
        })
        ->count();
        
        return view('dashboard.dashboard',  compact('openTicketsCount', 'waitingForSparePartsCount', 'urgentTicketsCount', 'expiringDeadlinesCount', 'expiredDeadlinesCount', 'expiredVehiclesCount', 'expiringVehiclesCount'));
    }

    public function indexHome()
    {
        $openTicketsCount = Ticket::where('status', 'Aperto')->count();
        $waitingForSparePartsCount = Ticket::where('status', 'In attesa di un ricambio')->count();
        $urgentTicketsCount = Ticket::where('priority', 'Urgente')->count();
        
        // Calcolo del numero di scadenze in scadenza (entro 7 giorni dalla data odierna)
        $expiringDeadlinesCount = Deadline::whereHas('documentDeadlines', function ($query) {
            $query->where('expiry_date', '>', now())
            ->where('expiry_date', '<=', now()->addDays(60));
        })
        ->count();
        
        // Calcolo del numero di scadenze scadute (data di scadenza antecedente alla data odierna)
        $expiredDeadlinesCount = Deadline::whereHas('documentDeadlines', function ($query) {
            $query->where('expiry_date', '<', now());
        })
        ->count();
        
        return view('dashboard.dashboard',  compact('openTicketsCount', 'waitingForSparePartsCount', 'urgentTicketsCount', 'expiringDeadlinesCount', 'expiredDeadlinesCount'));
    }
}
