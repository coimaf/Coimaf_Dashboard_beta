<x-Layouts.layoutDash>
    <section class="m-5" style="background-color: rgb(243, 243, 243); height: 86vh; overflow:auto">
        <div class="container p-5">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4 text-black">
                        <div class="card-body text-center">
                            <h5 class="my-3 fs-3 fw-bold text-alt">{{$machine->model}} {{$machine->brand}}</h5>
                            <p class="mb-3 text-capitalize lead">{{$machine->serial_number}}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-8">
                    <div class="card mb-4 text-black">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Venduto il</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{ \Carbon\Carbon::parse($machine->sale_date)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Primo Proprietario</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{ $machine->first_buyer }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Proprietario Attuale</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{$machine->current_owner}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Scadenza Garanzia</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{ \Carbon\Carbon::parse($machine->warranty_expiration_date)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Tipo Garanzia</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{ $machine->warrantyType->name }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Registrata il</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{ \Carbon\Carbon::parse($machine->registration_date)->format('d-m-Y' )}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Spedizione DTT</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{ $machine->delivery_ddt }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Note</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{ $machine->notes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-Layouts>
