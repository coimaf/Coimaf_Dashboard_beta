<x-Layouts.layoutDash>
    <input type="hidden" id="screenWidth" name="screenWidth" value="">
    <x-allert />
    
    <div class="col-12 col-md-11 d-flex justify-content-end my-1 w-100">
        <a href="{{route('dashboard.employees.create')}}"><x-Buttons.buttonBlue type="button" props="NUOVO" /></a>
    </div>
    
    
    <x-table :columnTitles="$columnTitles" :rowData="$employees" :direction="$direction" :sortBy="$sortBy" :routeName="$routeName">
        <tr class="align-middle">
            <th colspan="{{ count($columnTitles) }}">
                <form class="d-flex" action="{{ route('dashboard.employees.index') }}" method="GET">
                    <input type="search" class="form-control me-2" placeholder="Cerca" name="employeeSearch" value="{{ request('query') }}">
                    <x-Buttons.buttonBlue type='submit' props='Cerca' />
                </form>
            </th>
        </tr>
        <tbody>
            @foreach ($employees as $employee)
            <tr class="align-middle">
                <td class="ps-3">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.employees.show', compact('employee')) }}">
                        {{ $employee->name }} {{ $employee->surname }}
                    </a>
                </td>
                
                <td class="text-uppercase">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.employees.show', compact('employee')) }}">
                        {{ $employee->fiscal_code }}
                    </a>
                </td>
                
                <td class="ps-2">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.employees.show', compact('employee')) }}">
                        {{ $employee->roles->pluck('name')->implode(', ') }}
                    </a>
                </td>
                
                <td class="ps-5">
                    <i data-mdb-tooltip-init title="{{ $employee->getDocumentStatuses()['tooltipText'] }}" class="{{ $employee->getDocumentStatuses()['icon'] }}"></i>
                </td>
                
                
                <td class="ps-5">
                    <a href='{{route('dashboard.employees.edit', compact('employee'))}}'>
                        <i class='bi bi-pencil-square text-warning'></i>
                    </a>
                </td>
                <td class="ps-5">
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
        <x-pagination :props="$employees" />
    </x-Layouts.layoutDash>