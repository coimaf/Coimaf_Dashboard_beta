<x-Layouts.layoutDash>
    <section class="m-5" style="background-color: rgb(243, 243, 243); height: 86vh; overflow:auto">
        <div class="container p-5">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4 text-black">
                        <div class="card-body text-center">
                            <h5 class="my-3 fs-3 fw-bold text-alt">Ticket Numero: {{$ticket->id}}</h5>
                            <p class="card-footer fw-semibold mt-3">Creato da: {{$ticket->user->name}}  il: {{$ticket->created_at->format('d/m/Y')}} 
                            @if($ticket->updated_by)
                            <br><br>Modificato da: {{$ticket->updated_by}} il: {{$ticket->updated_at->format('d/m/Y')}}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-1 text-black">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Titolo: </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{ $ticket->title }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">ID Cliente: </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{ $ticket->cd_cf }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Cliente: </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{ $ticket->descrizione }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Stato: </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{$ticket->status}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Priorità: </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{ $ticket->priority }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Creato il: </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{\Carbon\Carbon::parse($ticket->created_at)->format('d-m-Y')}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Seriale Macchina: </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{$ticket->machinesSold->serial_number ?? ''}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Modello Macchina: </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{$ticket->machinesSold->model ?? ''}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Tecnico: </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{$ticket->technician->name}} {{$ticket->technician->surname}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Descrizione Problema: </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{$ticket->description}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Risoluzione Problema: </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{$ticket->notes}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-Layouts>

