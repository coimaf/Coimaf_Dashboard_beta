<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Deadline;
use Illuminate\Http\Request;

class DeadlineController extends Controller
{
    public function index()
    {
        $columnTitles = ["Nome Documento", "Scadenza", "Tag", "Modifica", "Elimina"];
        $deadlines = Deadline::with('documentDeadlines')->get();
        
        return view('dashboard.deadlines.index', [
            'columnTitles' => $columnTitles,
            'deadlines' => $deadlines,
        ]);
    }
}
