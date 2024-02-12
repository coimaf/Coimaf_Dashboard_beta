<div class="print-preview">
    <x-Layouts.layoutDash>
        
        <div class="row">
            <div class="col-3">
                <p class="card-footer fw-semibold m-4 fs-4 print">Ticket Numero: {{$ticket->id}}</p>
            </div>
            <div class="col-3 print">
                <p class="card-footer fw-semibold m-4 fs-4
                @if($ticket->status === 'Aperto')
                text-success
                @elseif($ticket->status === 'Chiuso')
                text-danger
                @elseif($ticket->status === 'In lavorazione')
                text-warning
                @else
                text-primary
                @endif">
                Stato: {{ $ticket->status }}
            </p>
            
        </div>
        <div class="col-3 no-print">
            <p class="card-footer fw-semibold m-4">Creato da: {{$ticket->user->name}}  il: {{$ticket->created_at->format('d/m/Y')}} 
                @if($ticket->updated_by)
                <br><br>Modificato da: {{$ticket->updatedBy->name}} il: {{$ticket->updated_at->format('d/m/Y')}}</p>
                @endif
            </p>
        </div>
        <div class="col-3 no-print">
            <a href="{{ route('dashboard.tickets.edit', $ticket->id) }}" class="btn btn-warning float-end fs-4 m-4">Modifica</a>
            <a href="#" id="printButton" class="btn btn-success fs-4 float-end m-4">Stampa</a>
        </div>
    </div>
    
    <div class="p-3 row g-3">
        
        <div class="col-12 col-md-4">
            <label class="fs-5 mb-1 fw-semibold">Titolo</label>
            <input value="{{$ticket->title}}" class="form-control form-custom fs-5" readonly>
        </div>
        
        <div class="col-12 col-md-4">
            <label class="fs-5 mb-1 fw-semibold">Cliente</label>
            <input value="{{$ticket->cd_cf}} {{$ticket->descrizione}}" class="form-control form-custom fs-5" readonly>
        </div>
        
        <div class="col-12 col-md-4">
            <label class="fs-5 mb-1 fw-semibold">Priorità</label>
            <input value="{{$ticket->priority}}" class="form-control form-custom fs-5" readonly>
        </div>
        
        <div class="col-12 col-md-6">
            <label class="fs-5 mb-1 fw-semibold">Modello</label>
            <input value="{{$ticket->machinesSold->model ?? ''}}" class="form-control form-custom fs-5" readonly>
        </div>
        
        <div class="col-12 col-md-6">
            <label class="fs-5 mb-1 fw-semibold">Seriale</label>
            <input value="{{$ticket->machinesSold->serial_number ?? ''}}" class="form-control form-custom fs-5" readonly>
        </div>
        
        <div class="col-12">
            <label class="fs-5 mb-1 fw-semibold">Descrizione Problema</label>
            <textarea class="form-control form-custom fs-5" style="height: 100px; resize: none;" readonly>{{$ticket->description}}</textarea>
        </div>
        
        
        <div class="col-12">
            <label class="fs-5 mb-1 fw-semibold">Risoluzione Problema</label>
            <textarea class="form-control form-custom fs-5" style="height: 100px; resize: none;" readonly>{{$ticket->notes}}</textarea>
        </div>
        
        <div class="col-12 col-md-6">
            <label class="fs-5 mb-1 fw-semibold">Tecnico</label>
            <input value="{{$ticket->technician->name}} {{$ticket->technician->surname}}" class="form-control form-custom fs-5" readonly>
        </div>
        
        <div class="col-12 col-md-6">
            <label class="fs-5 mb-1 fw-semibold">Chiusura</label>
            <input value="{{\Carbon\Carbon::parse($ticket->intervention_date)->format('d/m/Y')}}" class="form-control form-custom fs-5" readonly>
        </div>
        
    </div>
    
    

    <section id="formSection" class="bg-white border border-5 m-1 mt-2">
        <div class="col-12">
            <div id="replacementTable">
                <table class="table table-hover table-custom-padding">
                    <thead class="table-dark">
                        <tr>
                            <th>Articolo</th>
                            <th>Descrizione</th>
                            <th>Quantità</th>
                            <th class="text-end">Prezzo</th>
                            <th class="text-center">Sconto</th>
                            <th class="text-end">Totale</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($replacements as $replacement)
                        <tr>
                            <td>{{ $replacement->art }}</td>
                            <td>{{ $replacement->desc }}</td>
                            <td class="text-center quantity" width='10px;'>{{ $replacement->qnt }}</td>
                            <td class="text-end" width='100px;'>{{ number_format($replacement->prz, 3, ',', '.') }}</td>
                            <td class="text-center" width='80px;'>{{ $replacement->sconto }}</td>
                            <td class="text-end total" width='80px;'>{{ number_format($replacement->tot, 3, ',', '.') }}</td>
                            <td class="text-center"></td> <!-- Aggiungo una cella vuota per il completamento della riga -->
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" class="text-end fw-bold">Totale:</td>
                            <td class="text-end fw-bold" id="totalCell"></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</x-Layouts.layoutDash>
</div>


<style>
    .form-custom{
        cursor: default;
    }
    
    .form-custom:hover, .form-custom:focus{
        box-shadow: none;
        border-color: var(--bs-border-color);
    }
    
    @media print {
        .print{
            
        }
        
        .no-print{
            visibility: hidden;
        }
    }
    
</style>

<script>
    // Aggiungi un ascoltatore di eventi al pulsante Stampa
    document.getElementById('printButton').addEventListener('click', function() {
        // Apri l'anteprima di stampa della tua nuova pagina
        var printWindow = window.open('{{ route('dashboard.tickets.print', ['ticket' => $ticket->id]) }}', '_print');
        
        // Esegui l'azione di stampa nell'anteprima di stampa
        printWindow.onload = function() {
            printWindow.print();
            
            // Chiudi la finestra dopo l'azione di stampa
            printWindow.close();
        };
    });

    function updateTotal() {
    var total = 0;
    var prz = document.querySelectorAll('.total');

    prz.forEach(function(element) {
        var value = parseFloat(element.textContent.replace(/\./g, '').replace(',', '.')); // Rimuovi i punti e sostituisci la virgola con un punto
        total += value; // Aggiungi il valore al totale
    });

    var formattedTotal = total.toLocaleString('it-IT', { minimumFractionDigits: 3 }) + ' €'; // Formatta il totale secondo il formato desiderato

    // Aggiorna il contenuto della cella con id "totalCell" con il totale formattato
    document.getElementById('totalCell').textContent = formattedTotal;
}



window.onload = function() {
        updateTotal();
    };
</script>


