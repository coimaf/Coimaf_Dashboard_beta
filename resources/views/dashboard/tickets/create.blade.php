<x-Layouts.layoutDash>
    
    <h6 class="fw-bold p-4 fs-5">Crea un nuovo Ticket</h6>

    <div class='d-flex align-items-center'>
        <p class="px-4 fs-4 fw-bold">Ticket Numero: {{$nextTicketNumber}}</p>
        
        <p id="differenza" class='fw-bold fs-4 d-flex align-items-center gap-2'></p>
    </div>
    
    <form id="form" class="p-4" style="overflow: hidden;" action="{{route('dashboard.tickets.store')}}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <input placeholder="Titolo*" type="text" name="title" class="form-control" required>
            </div>
            
            <div class="col-12 col-md-6">
                <input placeholder="Seleziona un Cliente*" list="customer" class="form-control" id="customerInput" name="selectedCustomer" required>
                <input type="hidden" id="selectedCdCFInput" name="selectedCdCF">
                <input type="hidden" id="selectedCd_CFClasse3Input" name="selectedCd_CFClasse3">
                <datalist id="customer">
                    @foreach ($customers as $customer)
                    <option value="{{ trim($customer->Descrizione) }}" data-cd-cf="{{ $customer->Cd_CF }}" data-Cd_CFClasse3='{{ $customer->Cd_CFClasse3}}'></option>
                    @endforeach
                </datalist>
                <p id="customerMessage" style="color: red; display: none;">Seleziona un cliente valido dalla lista.</p>
            </div>
            
            <div class="col-12 col-md-6">
                
                <select name="priority" class="form-control" required>
                    @foreach(\App\Models\Ticket::getPriorityOptions() as $priorityOption)
                    <option value="{{ $priorityOption }}" @if($priorityOption === 'Normale') selected @endif><span for="">Priorità: </span> {{ $priorityOption }}</option>
                    @endforeach
                </select>
            </div>
            
            
            <div class="col-12">
                <textarea placeholder="Descrizione Problema" type="text" name="description" class="form-control" style="height: 100px; resize: none;"></textarea>
            </div>
            
            <div class="col-12 col-md-6">
                <select name="machine_model_id" class="form-control">
                    <option value="">Modello Macchina</option>
                    @foreach($machines as $machine)
                    <option value="{{ $machine->id }}">{{ $machine->model }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-12 col-md-6">
                <select name="machine_sold_id" class="form-control">
                    <option value="">Seriale Macchina</option>
                    @foreach($machines as $machine)
                    <option value="{{ $machine->id }}">{{ $machine->serial_number }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-12 col-md-6 mb-4">
                <select name="technician_id" class="form-control">
                    <option value="">Seleziona un Tecnico</option>
                    @foreach($technicians as $technician)
                    <option value="{{ $technician->id }}">{{ $technician->name }} {{ $technician->surname }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-12 col-md-6 mb-4" hidden>
                <label class="my-2" for="status">Stato</label>
                <select name="status" class="form-control" required>
                    <option value="Aperto">Aperto</option>
                </select>
            </div>
            
            <div class="col-12 col-md-6 mb-4" hidden>
                <label class="my-2" for="">Data Apertura</label>
                <label class="form-control"> {{  \Carbon\Carbon::now()->format('d-m-Y') }} </label>
            </div>
            
            <div class="col-12 col-md-1">
                <label class="my-2" for="intervention_date">Data intervento</label>
            </div>
            
            <div class="col-12 col-md-3 mb-4">
                <input type="date" name="intervention_date" class="form-control">
            </div>
            
            <div class="col-12">
                <textarea placeholder="Risoluzione Problema" type="text" name="notes" class="form-control" style="height: 100px; resize: none;"></textarea>
            </div>
            <div class="row py-3">
                <x-Buttons.buttonBlue type="submit" props="Aggiungi" />
            </div>
        </div>
    </form>
    
</x-Layouts.layoutDash>

<script>
    document.getElementById('customerInput').addEventListener('input', function() {
        var selectedOption = document.querySelector('#customer option[value="' + this.value + '"]');
        var cdCFInput = document.getElementById('selectedCdCFInput');
        var Cd_CFClasse3Input = document.getElementById('selectedCd_CFClasse3Input');
        var totaleDare = 0;
        var totaleAvere = 0;
        
        if (selectedOption) {
            cdCFInput.value = selectedOption.getAttribute('data-cd-cf');
            
            // Invia una richiesta AJAX per ottenere i risultati in base a cdCF
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/fetch-results?cdCF=' + cdCFInput.value, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var results = JSON.parse(xhr.responseText);
                    // Costruisci il testo dei risultati
                    var resultText = '';
                    results.forEach(function(result) {
                        // Aggiungi i valori Dare e Avere al totale
                        totaleDare += parseFloat(result.ImportoDare);
                        totaleAvere += parseFloat(result.ImportoAvere);
                    });
                    // Calcola la differenza tra Dare e Avere
                    var differenza = totaleAvere - totaleDare;
                    
                    // Costruisci il testo per mostrare la differenza
                    var differenzaText = '<i class="bi bi-circle-fill"></i>  SALDO: ' + differenza.toFixed(2); // Utilizza toFixed per limitare i decimali a due cifre
                    
                    // Aggiorna il paragrafo con la differenza calcolata
                    var differenzaElement = document.getElementById('differenza');
                    differenzaElement.innerHTML = differenzaText;
                    
                    // Aggiungi lo stile CSS in base al valore della differenza
                    if (differenza >= 0) {
                        differenzaElement.style.color = 'green'; // Testo verde per valori positivi, null o 0
                    } else {
                        differenzaElement.style.color = 'red'; // Testo rosso per valori negativi
                    }
                    
                    // Aggiungi il valore di cdCF ai dati del modulo
                    document.getElementById('cdCFInput').value = cdCFInput.value;
                }
            };
            xhr.send();
            
            Cd_CFClasse3Input.value = selectedOption.getAttribute('data-Cd_CFClasse3');
        } else {
            cdCFInput.value = ''; // Se l'utente cancella l'input, azzera il valore di Cd_CF
            Cd_CFClasse3Input.value = '';
        }
        // console.log(cdCFInput.value);
        // console.log(Cd_CFClasse3Input.value );
    });
    
    // Aggiungi un listener per il submit del form
    document.getElementById('form').addEventListener('submit', function(event) {
        console.log('Form submitted'); // Debug
        // Verifica se il valore inserito è presente nella lista dei clienti
        var selectedOption = document.querySelector('#customer option[value="' + document.getElementById('customerInput').value + '"]');
        if (!selectedOption) {
            // Se non è presente, impedisce l'invio del form e mostra un messaggio di errore
            event.preventDefault();
            document.getElementById('customerMessage').style.display = 'block';
        }
    });
</script>
