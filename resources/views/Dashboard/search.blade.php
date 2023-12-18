<x-Layouts.layoutDash>
    @if ($employees->count() > 0 || $deadlines->count() > 0)
    <div class="mt-5" />
    @if ($employees->count() > 0)
    <x-table :columnTitles="$columnTitlesEmployees" :rowData="$employees">
        <tbody>
            @foreach ($employees as $employee)
            <tr class="text-center align-middle">
                <td class="py-4">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.employees.show', compact('employee')) }}">
                        {{ $employee->name }} {{ $employee->surname }}
                    </a>
                </td>
                
                <td class="text-uppercase">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.employees.show', compact('employee')) }}">
                        {{ $employee->fiscal_code }}
                    </a>
                </td>
                
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.employees.show', compact('employee')) }}">
                        {{ $employee->roles->pluck('name')->implode(', ') }}
                    </a>
                </td>
                
                <td>
                    <i data-mdb-tooltip-init title="{{ $employee->getDocumentStatuses()['tooltipText'] }}" class="{{ $employee->getDocumentStatuses()['icon'] }}"></i>
                </td>
                
                
                <td>
                    <a href='{{route('dashboard.employees.edit', compact('employee'))}}'>
                        <i class='bi bi-pencil-square text-warning'></i>
                    </a>
                </td>
                <td>
                    <button type="button" class="btn bi bi-trash3-fill text-danger" data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal{{ $employee->id }}"></button>
                    
                    <form action="{{route('dashboard.employees.destroy', compact('employee'))}}" method="post">
                        @csrf
                        @method('delete')
                        <!-- Modal -->
                        <div class="modal fade" id="deleteEmployeeModal{{ $employee->id }}" tabindex="-1" aria-labelledby="deleteEmployeeModalLabel{{ $employee->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-black" id="deleteEmployeeModalLabel{{ $employee->id }}">Conferma eliminazione dipendente</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-black" id="employeeInfoContainer{{ $employee->id }}">
                                        Sicuro di voler eliminare <b>{{ $employee->name }} {{ $employee->surname }}</b>? <br>L'azione sarà irreversibile.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                        <form action="{{ route('dashboard.employees.destroy', compact('employee')) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">Elimina</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
    </x-table>
    @endif

    @if ($deadlines->count() > 0)
    <x-table :columnTitles="$columnTitlesDeadlines" :rowData="$deadlines">
        <tbody>
            @foreach ($deadlines as $deadline)
            <tr class="text-center align-middle">
                <td class="py-4"><a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.deadlines.show', compact('deadline')) }}">{{ $deadline->name }}</a></td>
                
                <td class="py-4">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.deadlines.show', compact('deadline')) }}">
                
                        @php
                            $status = $deadline->getStatus();
                        @endphp
                
                        @if ($status === 'expired')
                            <i class="bi bi-dash-circle-fill text-danger fs-5 me-3"></i>
                        @elseif ($status === 'expiring_soon')
                            <i class="bi bi-exclamation-circle-fill text-warning fs-5 me-3"></i>
                        @else
                            <i class='bi bi-check-circle-fill text-success fs-5 me-3'></i>
                        @endif
                
                        {{ Carbon\Carbon::parse($deadline->documentDeadlines->first()->expiry_date)->format('d-m-Y') }}
                
                    </a>
                </td>
                
                
                <td class="py-4">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.deadlines.show', compact('deadline')) }}">
                        @foreach ($deadline->tags as $tag)
                        <span class="badge bg-primary">{{ $tag->name }}</span>
                        @endforeach
                        
                    </a>
                </td>
                
                <td>
                    <a href='{{route('dashboard.deadlines.edit', compact('deadline'))}}'>
                        <i class='bi bi-pencil-square text-warning'></i>
                    </a>
                </td>
                
                <td>
                    <button type="button" class="btn bi bi-trash3-fill text-danger" data-bs-toggle="modal" data-bs-target="#deleteDeadlineModal{{ $deadline->id }}"></button>
                    
                    <form action="{{route('dashboard.deadlines.destroy', compact('deadline'))}}" method="post">
                        @csrf
                        @method('delete')
                        <!-- Modal -->
                        <div class="modal fade" id="deleteDeadlineModal{{ $deadline->id }}" tabindex="-1" aria-labelledby="deleteDeadlineModalLabel{{ $deadline->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-black" id="deleteDeadlineModalLabel{{ $deadline->id }}">Conferma eliminazione dipendente</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-black" id="DeadlineInfoContainer{{ $deadline->id }}">
                                        Sicuro di voler eliminare <b>{{ $deadline->name }}</b>? <br>L'azione sarà irreversibile.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                        <form action="{{ route('dashboard.deadlines.destroy', compact('deadline')) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">Elimina</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </x-table>
    @endif
    @else

    <div class="d-flex align-items-center justify-content-center" style="height: 77vh;">
        <p class="text-center fs-4">Nessun dato disponibile per la ricerca.</p>
    </div>

    @endif
</x-Layouts.layoutDash>
