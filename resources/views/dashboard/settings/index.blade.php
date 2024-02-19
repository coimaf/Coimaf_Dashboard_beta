<x-Layouts.layoutDash>
    <x-allert />
    <div class="container-fluid">
        <div class="row gutters-sm">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body tab-content">
                        <div class="tab-pane active" id="profile">
                            <h3 class="fw-bold">Impostazioni Dashboard</h3>
                            <hr>
                            <table class="table">
                                <thead>
                                    <tr class="">
                                        <th>Dipendenti</th>
                                        <th>Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <p class="mb-0">Documenti e Ruoli</p>
                                            <label class="text-muted">Gestisci l'associazione tra ruoli e documenti.</label>
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.settings.employees.create') }}"><i class="bi bi-pencil-square text-warning fs-5 mx-2"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                                
                                <thead>
                                    <tr class="">
                                        <th>Scadenzario</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <p class="mb-0">Tags</p>
                                            <label class="text-muted">Crea o rimuovi i Tags per lo scadenzario.</label>
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.settings.deadlines.create') }}"><i class="bi bi-pencil-square text-warning fs-5 mx-2"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                                
                                <thead>
                                    <tr class="">
                                        <th>Macchine Vendute</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <p class="mb-0">Garanzia</p>
                                            <label class="text-muted">Crea o rimuovi i vari tipi di Garanzia per le macchine vendute.</label>
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.settings.machinesSold.create') }}"><i class="bi bi-pencil-square text-warning fs-5 mx-2"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr class="">
                                        <th>Tickets</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <p class="mb-0">Tecnici</p>
                                            <label class="text-muted">Crea o rimuovi i Tecnici per poterli assegnare ai Tickets.</label>
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.settings.tecnicians.create') }}"><i class="bi bi-pencil-square text-warning fs-5 mx-2"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr class="">
                                        <th>Flotta</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <p class="mb-0">Tipo Veicolo</p>
                                            <label class="text-muted">Aggiungi o rimuovi i tipi di veicolo da aggiungere alla Flotta.</label>
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.settings.vehicle.create') }}"><i class="bi bi-pencil-square text-warning fs-5 mx-2"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr class="">
                                        <th>FPC</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <p class="mb-0">R4</p>
                                            <label class="text-muted">Aggiungi o rimuovi i tipi da aggiungere a FPC R4.</label>
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.settings.r4.create') }}"><i class="bi bi-pencil-square text-warning fs-5 mx-2"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-Layouts.layoutDash>