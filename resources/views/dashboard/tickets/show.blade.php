<x-Layouts.layoutDash>
    <div class="col-lg-12">
        <div class="card mb-1 text-black">
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
</x-Layouts>

