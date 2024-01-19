@if ($employees->count() > 0)
@include('dashboard.employees.index', ['columnTitles' => $columnTitlesEmployees, 'rowData' => $employees, 'direction' => null, 'sortBy' => null, 'routeName' => null])

@elseif ($deadlines->count() > 0)
@include('dashboard.deadlines.index', ['columnTitles' => $columnTitlesDeadlines, 'rowData' => $deadlines, 'direction' => null, 'sortBy' => null, 'routeName' => null])

@elseif ($machines->count() > 0)
@include('dashboard.machines.index', ['columnTitles' => $columnTitlesMachines, 'rowData' => $machines, 'direction' => null, 'sortBy' => null, 'routeName' => null])

@elseif($tickets->count() > 0)
@include('dashboard.tickets.index', ['columnTitles' => $columnTitlesTickets, 'rowData' => $tickets, 'direction' => null, 'sortBy' => null, 'routeName' => null])

@else

<x-Layouts.layoutDash>
    <div class="d-flex align-items-center justify-content-center" style="height: 77vh;">
        <p class="text-center fs-4">Nessun dato disponibile per la ricerca.</p>
    </div>
</x-Layouts.layoutDash>

@endif
