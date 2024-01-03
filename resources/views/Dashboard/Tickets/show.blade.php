<x-Layouts.layoutDash>
    <section class="m-5" style="background-color: rgb(243, 243, 243); height: 86vh; overflow:auto">
        <div class="container p-5">
            <div class="row text-center justify-content-center">
                <div class="col-lg-4">
                    <div class="card mb-4 text-black">
                        <div class="card-body text-center">
                            <h5 class="my-3 fs-3 fw-bold text-alt">{{$ticket->model}}</h5>
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
</x-Layouts>
