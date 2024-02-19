<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Vehicle;
use App\Models\Deadline;
use Illuminate\Http\Request;
use App\Models\DocumentVehicles;
use Illuminate\Support\Facades\DB;

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

        // $today = date("Y");
        // $itemsUnderstock = DB::connection('mssql')
        // ->select("
        //     SELECT 
        //         MGGiacDisp.Cd_AR, 
        //         AR.Descrizione, 
        //         AR.Cd_ARMarca, 
        //         ARARMisura.Cd_ARMisura, 
        //         MGGiacDisp.Quantita, 
        //         MGGiacDisp.ImpQ, 
        //         MGGiacDisp.OrdQ, 
        //         MGGiacDisp.QuantitaDisp, 
        //         AR.ScortaMinima, 
        //         AR.ScortaMinima - MGGiacDisp.QuantitaDisp AS SottoScortaQ, 
        //         AR.Obsoleto 
        //     FROM 
        //         MGDisp('{$today}') AS MGGiacDisp 
        //     INNER JOIN 
        //         AR ON MGGiacDisp.Cd_AR = AR.Cd_AR 
        //     INNER JOIN 
        //         ARARMisura ON AR.Cd_AR = ARARMisura.Cd_AR AND ARARMisura.DefaultMisura = 1 
        //     WHERE 
        //         MGGiacDisp.QuantitaDisp < AR.ScortaMinima");
        
        return view('dashboard.dashboard',  compact('openTicketsCount', 'waitingForSparePartsCount', 'urgentTicketsCount', 'expiringDeadlinesCount', 'expiredDeadlinesCount'));
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

        $today = date("Y");
        $itemsUnderstock = DB::connection('mssql')
        ->select("
            SELECT 
                MGGiacDisp.Cd_AR, 
                AR.Descrizione, 
                AR.Cd_ARMarca, 
                ARARMisura.Cd_ARMisura, 
                MGGiacDisp.Quantita, 
                MGGiacDisp.ImpQ, 
                MGGiacDisp.OrdQ, 
                MGGiacDisp.QuantitaDisp, 
                AR.ScortaMinima, 
                AR.ScortaMinima - MGGiacDisp.QuantitaDisp AS SottoScortaQ, 
                AR.Obsoleto 
            FROM 
                MGDisp('{$today}') AS MGGiacDisp 
            INNER JOIN 
                AR ON MGGiacDisp.Cd_AR = AR.Cd_AR 
            INNER JOIN 
                ARARMisura ON AR.Cd_AR = ARARMisura.Cd_AR AND ARARMisura.DefaultMisura = 1 
            WHERE 
                MGGiacDisp.QuantitaDisp < AR.ScortaMinima");
        
        return view('dashboard.dashboard',  compact('openTicketsCount', 'waitingForSparePartsCount', 'urgentTicketsCount', 'expiringDeadlinesCount', 'expiredDeadlinesCount', 'itemsUnderstock'));
    }
}
