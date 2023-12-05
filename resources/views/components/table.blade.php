<div class="container-fluid main-content">
    <div class="row justify-content-center align-items-center">
        <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 rounded-3 mt-3" style="background-color: rgb(243, 243, 243); height: 80vh;">
            <div class="col-12 rounded-2 mt-3" style="max-height: 77vh; overflow-y: scroll">
                @if(count($rowData) > 0)
                <div class="table-responsive content-main">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr class="text-center align-middle">
                                @foreach ($columnTitles as $title)
                                <th scope="col">{{ $title }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rowData as $employee)
                            <tr class="text-center align-middle">
                                <td class="py-4">{{ $employee->name }} {{ $employee->surname }}</td>
                                <td class="text-uppercase">{{ $employee->fiscal_code }}</td>
                                <td>{{ $employee->role }}</td>
                                <td>
                                    @php
                                    $status = $documentStatuses[$employee->id];
                                    $icon = match($status) {
                                        'red' => '<i class="bi bi-dash-circle-fill text-danger fs-3"></i>',
                                        'yellow' => '<i class="bi bi-exclamation-circle-fill text-warning fs-3"></i>',
                                        default => "<i class='bi bi-check-circle-fill text-success fs-3'></i>",
                                    };
                                    
                                    $expiredDocuments = collect();
                                    $expiringDocuments = collect();
                                    
                                    foreach ($employee->documents as $document) {
                                        $expiryDate = Carbon\Carbon::parse($document->expiry_date);
                                        
                                        if ($expiryDate->isPast()) {
                                            $expiredDocuments->push($document->name);
                                        } elseif ($expiryDate->diffInDays(now()) <= 60) {
                                            $expiringDocuments->push($document->name);
                                        }
                                    }
                                    
                                    $tooltipText = '';
                                    
                                    if ($expiredDocuments->isNotEmpty()) {
                                        $tooltipText .= 'Scaduti: ' . implode(', ', $expiredDocuments->toArray()) . "\n";
                                    }
                                    
                                    if ($expiringDocuments->isNotEmpty()) {
                                        $tooltipText .= 'Stanno per scadere: ' . implode(', ', $expiringDocuments->toArray()) . "\n";
                                    }
                                    @endphp
                                    
                                    <i data-mdb-tooltip-init title="{{ $tooltipText }}" class="{{ $icon }}"></i>
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
                                                        <h5 class="modal-title" id="deleteEmployeeModalLabel{{ $employee->id }}">Conferma eliminazione dipendente</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" id="employeeInfoContainer{{ $employee->id }}">
                                                        Sicuro di voler eliminare {{ $employee->name }} {{ $employee->surname }}? <br>L'azione sarà irreversibile.
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
                        </table>
                    </div>
                    @else
                    <div class="d-flex align-items-center justify-content-center" style="height: 77vh;">
                        <p class="text-center fs-4">Nessun dato disponibile.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>