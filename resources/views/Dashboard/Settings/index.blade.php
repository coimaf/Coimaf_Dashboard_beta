<x-Layouts.layoutDash>
    <div class="container my-5">
        <div class="row gutters-sm">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body tab-content">
                        <div class="tab-pane active" id="profile">
                            <h3 class="fw-bold">Impostazioni Dashboard</h3>
                            <hr>
                            <h6 class="fw-bold">Dipendenti</h6>
                            <hr>
                            <table class="table">
                                <thead>
                                    <tr class="text-center">
                                        <th>Ruolo</th>
                                        <th>Tipi di Documento</th>
                                        <th>Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documentTypes as $role => $types)
                                        <tr class="text-center">
                                            <td>{{ $role }}</td>
                                            <td>{{ implode(' - ', $types) }}</td>
                                            <td>
                                                <a href="{{ route('dashboard.settings.create', ['id' => $role]) }}" class="btn btn-success">Aggiungi</a>
                                                <a href="#" class="btn btn-warning">Modifica</a>
                                                <a href="#" class="btn btn-danger">Elimina</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       
        
    </div>
    
</x-Layouts.layoutDash>