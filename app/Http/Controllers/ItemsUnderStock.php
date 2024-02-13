<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemsUnderStock extends Controller
{
    public function index(Request $request)
    {
        $columnTitles = [
            ' ',
            'COD.',
            ['text' => 'DESCRIZIONE', 'sortBy' => 'Descrizione'],
            ['text' => 'MARCA', 'sortBy' => 'Cd_ARMarca'],
            'UM',
            ['text' => 'IN MAGAZZINO', 'sortBy' => 'Quantita'],
            'IMPEGNATA',
            'IN ORDINE',
            'DISPONIBILE',
            'SCORTA MINIMA',
            'SOTTOSCORTA'
        ];
        
        $searchTerm = $request->input('itemsUnderstockSearch');
        $sortBy = $request->input('sortBy');
        $direction = $request->input('direction', 'asc');
        $routeName = 'items_under_stock';
        $id = 1;
        $today = date("Y");

        // Imposta $sortBy al valore predefinito se non è specificato nella richiesta
        if (!$sortBy) {
            $sortBy = 'AR.Cd_AR, MGGiacDisp.Cd_MG';
        }
        
        $results = DB::connection('mssql')
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
                    MGGiacDisp.QuantitaDisp < AR.ScortaMinima 
                    AND (AR.Descrizione LIKE '%$searchTerm%' OR AR.Cd_ARMarca LIKE '%$searchTerm%' OR ARARMisura.Cd_ARMisura LIKE '%$searchTerm%')
                ORDER BY 
                $sortBy $direction
            ");
        
        return view( 'dashboard.items_understock.index', compact('results', 'columnTitles', 'id', 'sortBy', 'routeName', 'direction'));
    }
}
