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
                                <td>{{ $employee->fiscal_code }}</td>
                                <td>{{ $employee->role }}</td>
                                <td>
                                    @php
                                        $status = $documentStatuses[$employee->id];
                                        $icon = match($status) {
                                            'red' => '<i class="bi bi-dash-circle-fill text-danger fs-3"></i>', // Aggiungi la classe CSS per l'icona rossa
                                            'yellow' => '<i class="bi bi-exclamation-circle-fill text-warning fs-3"></i>', // Aggiungi la classe CSS per l'icona gialla
                                            default => "<i class='bi bi-check-circle-fill text-success fs-3'></i>", // Aggiungi la classe CSS per l'icona verde
                                        };
                                    @endphp
                        
                                    <i class="{{ $icon }}"></i>
                                </td>
                                <td><a href='#'><i class='bi bi-pencil-square text-warning'></i></a></td>
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

