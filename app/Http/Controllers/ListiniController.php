<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListiniController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sortBy', 'Cd_AR');
        $direction = $request->input('direction', 'asc');
        
        $columnTitles = [
            ['text' => 'Codice', 'sortBy' => 'Cd_AR'],
            ['text' => 'Descrizione', 'sortBy' => 'Descrizione'],
            'Modifica'
        ];
        $searchTerm = $request->input('searchListino');
        $routeName = 'dashboard.listini.index';
        
        $query = DB::connection('mssql')->table('AR')->where('Obsoleto', 0);
        
        // Inizializza $listini come una query senza restrizioni
        $listini = $query;
        
        if ($searchTerm) {
            $listini = $query->where(function ($query) use ($searchTerm) {
                $query->where('Cd_AR', 'LIKE', '%'.$searchTerm.'%')
                ->orWhere('Descrizione', 'LIKE', '%'.$searchTerm.'%');
            });
        }
        
        // Applica il filtro di ordinamento e paginazione
        $listini = $listini->select('Cd_AR', 'Descrizione')->orderByRaw("TRIM($sortBy) $direction")->paginate(25);
        
        // Aggiungi i valori dei filtri alla query di paginazione
        $listini->appends(['sortBy' => $sortBy, 'direction' => $direction, 'searchListino' => $searchTerm]);
        
        return view('dashboard.listini.index', compact('columnTitles', 'listini', 'direction', 'sortBy', 'routeName'));
    }
    
    public function show($id)
    {
        $listino = DB::connection('mssql')->selectOne("SELECT * FROM dbo.AR WHERE Cd_AR = ? AND Obsoleto = 0", [$id]);
        
        $listini = $this->getListini($id);
        
        return view('dashboard.listini.show', compact('listino', 'listini'));
    }
    
    private function getListini($id)
    {
        // Dati connessione Database
        $serverName = "192.168.2.22, 1433";
        $connectionOptions = array(
            "database" => "ADB_COIMAF",
            "uid" => "sa",
            "pwd" => "SiStEmA2006!",
            "TrustServerCertificate" => true
        );
        
        // Establishes the connection
        $conn = DB::connection('mssql');
        
        // Array dei codici listino
        $Cd_Listino = [
            'LSA0001', 'LSA0002', 'LSA0003', 'LSA0004', 'LSA0005', '', '', 'LSA0008', 'LSA0009'
        ];
        
        // Array per memorizzare i risultati delle query per ogni listino
        $listini = [];
        
        // Esegui le query per ogni listino
        for ($i = 0; $i < 9; $i++) {
            if ($Cd_Listino[$i] != '') {
                $descrizioneLS = $conn->table('LS')
                ->select('Descrizione')
                ->where('Cd_LS', 'LIKE', $Cd_Listino[$i])
                ->first();
                
                $rigaRevisione = $conn->table('LSRevisione')
                ->select('Id_LSRevisione')
                ->whereNotNull('DataPubblicazione')
                ->where('Cd_LS', 'LIKE', $Cd_Listino[$i])
                ->first();
                
                $risultatiLSArticolo = $conn->table('LSArticolo')
                ->join('LSRevisione', 'LSArticolo.Id_LSRevisione', '=', 'LSRevisione.Id_LSRevisione')
                ->select('Descrizione', 'Cd_AR', 'Prezzo', 'LSArticolo.Sconto as Sconto', 'LSRevisione.Id_LSRevisione')
                ->where('Cd_AR', $id)
                ->whereNotNull('DataPubblicazione')
                ->where('Cd_LS', 'LIKE', $Cd_Listino[$i])
                ->orderBy('DataPubblicazione', 'desc')
                ->first();
                
                // Memorizza i risultati in un array associativo
                $listini[$i] = [
                    'descrizione' => $descrizioneLS ? $descrizioneLS->Descrizione : null,
                    'prezzo' => $risultatiLSArticolo ? $risultatiLSArticolo->Prezzo : null,
                    'sconto' => $risultatiLSArticolo ? $risultatiLSArticolo->Sconto : null,
                    'revisione' => $risultatiLSArticolo ? $risultatiLSArticolo->Descrizione : null,
                    'id_revisione' => $rigaRevisione ? $rigaRevisione->Id_LSRevisione : null
                ];
            }
        }
        
        // Chiudi la connessione al database
        $conn->disconnect();
        
        return $listini;
    }
    
    public function edit($id)
    {
        $listini = $this->getListini($id);
        $listino = DB::connection('mssql')->selectOne("SELECT * FROM dbo.AR WHERE Cd_AR = ? AND Obsoleto = 0", [$id]);
        
        // Passa i dati alla vista
        return view('dashboard.listini.edit', compact('id', 'listino', 'listini'));
    }
    
    
    public function update(Request $request, $id)
    {
        $nuoviPrezzi = $request->input('prezzo');
        $nuoviSconti = $request->input('sconto');
        
        foreach ($nuoviPrezzi as $revisioneId => $nuovoPrezzo) {
            $nuovoSconto = $nuoviSconti[$revisioneId] ?? '';
            if ($nuovoPrezzo === null) {
                $nuovoPrezzo = 0;
            }
            
            $result = DB::connection('mssql')
            ->table('LSArticolo')
            ->join('LSRevisione', 'LSArticolo.Id_LSRevisione', '=', 'LSRevisione.Id_LSRevisione')
            ->where('Cd_AR', $id)
            ->whereNotNull('DataPubblicazione')
            ->where('LSRevisione.Id_LSRevisione', $revisioneId)
            ->get();

            if ($result->isEmpty()) {
                DB::connection('mssql')
                ->table('LSArticolo')
                ->insert([
                    'Id_LSRevisione' => $revisioneId,
                    'Cd_AR' => $id,
                    'Prezzo' => $nuovoPrezzo,
                    'Sconto' => $nuovoSconto
                ]);
            } else {
                DB::connection('mssql')
                ->table('LSArticolo')
                ->where('Cd_AR', $id)
                ->where('Id_LSRevisione', $revisioneId)
                ->update(['Prezzo' => $nuovoPrezzo, 'Sconto' => $nuovoSconto]);
            }
            
        }
        
        return redirect()->route('dashboard.listini.show', $id)->with('success', 'Prezzi e sconti aggiornati con successo.');
    }
    
    
}