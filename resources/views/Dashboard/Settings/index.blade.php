<x-Layouts.layoutDash>
    <div class="container-fluid main-content mt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 rounded-3 mt-3" style="background-color: rgb(243, 243, 243); height: 80vh;">
                <div class="col-12 rounded-2 mt-3" style="max-height: 77vh; overflow-y: scroll">
                    <div class="container d-flex justify-content-center">
                        @if (session('success'))
                        <div class="alert alert-success mt-5">
                            {{ session('success') }}
                        </div>
                        @endif
                        @if (session('error'))
                        <div class="alert alert-danger mt-5">
                            {{ session('error') }}
                        </div>
                        @endif
                    </div>
                    <div class="container my-5">
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
                                                            <a href="{{ route('dashboard.settings.create') }}"><i class="bi bi-pencil-square text-warning fs-5 mx-2"></i></a>
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
                </div>
            </div>
        </div>
    </div>
    
</x-Layouts.layoutDash>