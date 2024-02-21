<x-Layouts.layoutDash>
    
    <h6 class="fw-bold p-4 fs-5">Crea un nuovo Ticket</h6>
    <p class="px-4">Ticket Numero: {{$nextTicketNumber}}</p>
    
    <form id="form" class="p-4" style="overflow: hidden;" action="{{route('dashboard.tickets.store')}}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <input placeholder="Titolo*" type="text" name="title" class="form-control" required>
            </div>
            
            <div class="col-12 col-md-6">
                <input placeholder="Seleziona un Cliente*" list="customer" class="form-control" id="customerInput" name="selectedCustomer" required>
                <input type="hidden" id="selectedCdCFInput" name="selectedCdCF">
                <datalist id="customer">
                    @foreach ($customers as $customer)
                    <option value="{{ trim($customer->Descrizione) }}" data-cd-cf="{{ $customer->Cd_CF }}"></option>
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
                <select name="technician_id" class="form-control" required>
                    <option value="">Seleziona un Tecnico*</option>
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
        
        if (selectedOption) {
            cdCFInput.value = selectedOption.getAttribute('data-cd-cf');
        } else {
            cdCFInput.value = ''; // Se l'utente cancella l'input, azzera il valore di Cd_CF
        }
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
