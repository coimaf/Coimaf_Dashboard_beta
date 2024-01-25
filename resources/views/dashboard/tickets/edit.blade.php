<x-Layouts.layoutDash>
    <h6 class="fw-bold">Modifica Ticket</h6>
    
    <form action="{{ route('dashboard.tickets.update', $ticket->id) }}" method="POST" class="my-1">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-12">
                <label class="my-2" for="title">Titolo</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $ticket->title) }}" required>
            </div>
            
            <div class="col-12">
                <label class="my-2" for="customerInput">Cliente</label>
                <input list="customer" class="form-control" id="customerInput" name="selectedCustomer" value="{{ old('selectedCustomer', $ticket->customer->Descrizione ?? '') }}">
                <input type="hidden" id="selectedCdCFInput" name="selectedCdCF">
                <datalist id="customer" required>
                    @foreach ($customers as $customer)
                    <option value="{{ trim($customer->Descrizione) }}" data-cd-cf="{{ $customer->Cd_CF }}"></option>
                    @endforeach
                </datalist>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="my-2" for="priority">Priorità</label>
                <select name="priority" class="form-control" required>
                    <option value="">Seleziona una priorità</option>
                    @foreach(\App\Models\Ticket::getPriorityOptions() as $priorityOption)
                    <option value="{{ $priorityOption }}" {{ old('priority', $ticket->priority) == $priorityOption ? 'selected' : '' }}>
                        {{ $priorityOption }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="my-2" for="status">Stato</label>
                <select name="status" class="form-control" required>
                    <option value="">Seleziona uno stato</option>
                    @foreach(\App\Models\Ticket::getStatusOptions() as $statusOption)
                    <option value="{{ $statusOption }}" {{ old('status', $ticket->status) == $statusOption ? 'selected' : '' }}>
                        {{ $statusOption }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-6">
                <label for="selectedCustomer">Seleziona un Cliente*</label>
                <input type="text" placeholder="Seleziona un Cliente*" list="customer" class="form-control" id="customerInput" name="selectedCustomer" value="{{ $ticket->descrizione }}">
                <input type="hidden" id="selectedCdCFInput" name="selectedCdCF" value="{{ $ticket->cd_cf }}">
                <datalist id="customer" required>
                    @foreach ($customers as $customer)
                    <option value="{{ trim($customer->Descrizione) }}" data-cd-cf="{{ $customer->Cd_CF }}"></option>
                    @endforeach
                </datalist>
            </div>       

            <div class="col-12">
                <label class="pb-3" for="description">Descrizione Problema</label>
                <textarea type="text" name="description" class="form-control" style="height: 100px; resize: none;">{{ old('description', $ticket->description) }}</textarea>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="my-2" for="machine_model_id">Modello Macchina</label>
                <select name="machine_model_id" class="form-control">
                    <option value="">Seleziona un Modello</option>
                    @foreach($machines as $machine)
                    <option value="{{ $machine->id }}" {{ old('machine_model_id', $ticket->machine_model_id) == $machine->id ? 'selected' : '' }}>
                        {{ $machine->model }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="my-2" for="machine_sold_id">Seriale Macchina</label>
                <select name="machine_sold_id" class="form-control">
                    <option value="">Seleziona un Seriale</option>
                    @foreach($machines as $machine)
                    <option value="{{ $machine->id }}" {{ old('machine_sold_id', $ticket->machine_sold_id) == $machine->id ? 'selected' : '' }}>
                        {{ $machine->serial_number }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="my-2" for="technician_id">Tecnico</label>
                <select name="technician_id" class="form-control" required>
                    <option value="">Seleziona un Tecnico</option>
                    @foreach($technicians as $technician)
                    <option value="{{ $technician->id }}" {{ old('technician_id', $ticket->technician_id) == $technician->id ? 'selected' : '' }}>
                        {{ $technician->name }} {{ $technician->surname }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-6">
                <label class="my-2" for="closed">Data Chiusura</label>
                <input type="date" name="closed" class="form-control" value="{{ old('closed', $ticket->closed) }}" >
            </div>
            
            <div class="col-12 col-md-12">
                <label class="pb-3" for="notes">Risoluzione Problema</label>
                <textarea type="text" name="notes" class="form-control" style="height: 100px; resize: none;" >{{ old('notes', $ticket->notes) }}</textarea>
            </div>
            
            <x-Buttons.buttonBlue type="submit" props="Aggiorna" />
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