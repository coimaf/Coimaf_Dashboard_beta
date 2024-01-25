<x-Layouts.layoutDash>
    
    <h6 class="fw-bold">Crea un nuovo Ticket</h6>
    <p>Ticket Numero: {{$nextTicketNumber}}</p>
    
    <form style="overflow: hidden;" action="{{route('dashboard.tickets.store')}}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <input placeholder="Titolo*" type="text" name="title" class="form-control" required>
            </div>
            
            <div class="col-12 col-md-6">
                <input placeholder="Seleziona un Cliente*" list="customer" class="form-control" id="customerInput" name="selectedCustomer">
                <input type="hidden" id="selectedCdCFInput" name="selectedCdCF">
                <datalist id="customer" required>
                    @foreach ($customers as $customer)
                    <option value="{{ trim($customer->Descrizione) }}" data-cd-cf="{{ $customer->Cd_CF }}"></option>
                    @endforeach
                </datalist>
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
            
            <div class="col-12 col-md-6">
                <textarea placeholder="Risoluzione Problema" type="text" name="notes" class="form-control" style="height: 100px; resize: none;"></textarea>
            </div>
            
            <x-Buttons.buttonBlue type="submit" props="Aggiungi" />
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
</script>
