<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    // public function index() {
    //     return view('test');
    // }

    // public function print(Ticket $ticket) {
    //     $ticketCdCf = $ticket->cd_cf;
        
    //     $indirizziStampati = [];
    //     $indirizziFiltrati = [];
        
    //     $customers = DB::connection('mssql')
    //     ->table('cfcontatto')
    //     ->where('cd_cf', $ticketCdCf)
    //     ->get();  
    //     $infoCustomers = DB::connection('mssql')
    //     ->table('cf4mm')
    //     ->where('cd_cf', $ticketCdCf)
    //     ->get();
        
    //     foreach ($infoCustomers as $info) {
    //         if (!in_array($info->Indirizzo, $indirizziStampati)) {
    //             $indirizziFiltrati[] = $info->Indirizzo;
    //             $indirizziStampati[] = $info->Indirizzo;
    //         }
    //     }
    //     $indirizziFiltrati = array_unique($indirizziFiltrati);
        
    //     return view('test', compact('ticket', 'customers', 'infoCustomers', 'indirizziFiltrati'));
    // }
}
