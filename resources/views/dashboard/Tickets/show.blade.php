{{-- <x-Layouts.layoutDash>
    <section class="m-5" style="background-color: rgb(243, 243, 243); height: 86vh; overflow:auto">
        <div class="container p-5">
            <div class="row text-center justify-content-center">
                <div class="col-lg-4">
                    <div class="card mb-4 text-black">
                        <div class="card-body text-center">
                            <p class="fw-bold">Ticket Numero: {{$ticket->id}}</p>
                            <p class="fw-bold">Titolo: {{$ticket->title}}</p>
                            <p class="fw-bold">Descrizione Problema: {{$ticket->description}}</p>
                            <p class="fw-bold">Risoluzione Problema: {{$ticket->notes}}</p>
                            <p class="fw-bold">Seriale Macchina: {{$ticket->machinesSold->serial_number}}</p>
                            <p class="fw-bold">Modello Macchina: {{$ticket->machinesSold->model}}</p>
                            <p class="fw-bold">Stato: {{$ticket->status}}</p>
                            <p class="fw-bold">Priorità: {{$ticket->priority}}</p>
                            <p class="fw-bold">Tecnico: {{$ticket->technician->name}} {{$ticket->technician->surname}}</p>
                            <p class="fw-bold">Creato il: {{\Carbon\Carbon::parse($ticket->created_at)->format('d-m-Y')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-Layouts> --}}


<x-Layouts.layoutDash>
    <section class="m-5" style="background-color: rgb(243, 243, 243); height: 86vh; overflow:auto">
        <div class="container p-5">
            <div class="row">
                
                <div class="col-lg-12">
                    <div class="card mb-4 text-black">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Ticket Numero: </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{$ticket->id}}</p>
                                </div>
                            </div>
                            <hr>
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
                                    <p class=" mb-0">{{$ticket->machinesSold->serial_number}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-semibold">Modello Macchina: </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{$ticket->machinesSold->model}}</p>
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

