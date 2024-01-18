<x-Layouts.layoutDash>
    <div class="container-fluid main-content">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 rounded-3 mt-5" style="background-color: rgb(243, 243, 243); height: 90vh;">
                <div class="col-12 rounded-2 mt-3 p-5 container-create" style="max-height: 80vh; overflow-y: scroll">
                    
                    <h2 class="">Crea un nuovo Ticket</h2>
                    <p class="fw-bold">Ticket Numero: {{$nextTicketNumber}}</p>
                    
                    <form action="{{route('dashboard.tickets.store')}}" method="POST" class="my-5">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="my-2" for="title">Titolo</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="my-2" for="machine_model_id">Cliente</label>
                                <input list="customer" class="form-control" id="customerInput" name="selectedCustomer">
                                <input type="hidden" id="selectedCdCFInput" name="selectedCdCF">
                                <datalist id="customer" required>
                                    <option value="">Seleziona un Cliente</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ trim($customer->Descrizione) }}" data-cd-cf="{{ $customer->Cd_CF }}"></option>
                                    @endforeach
                                </datalist>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <label class="pb-3" for="description">Descrizione Problema</label>
                                <textarea type="text" name="description" class="form-control" style="height: 100px; resize: none;"></textarea>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="my-2" for="machine_model_id">Modello Macchina</label>
                                <select name="machine_model_id" class="form-control" required>
                                    <option value="">Seleziona un Modello</option>
                                    @foreach($machines as $machine)
                                    <option value="{{ $machine->id }}">{{ $machine->model }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="my-2" for="machine_sold_id">Seriale Macchina</label>
                                <select name="machine_sold_id" class="form-control" required>
                                    <option value="">Seleziona un Seriale</option>
                                    @foreach($machines as $machine)
                                    <option value="{{ $machine->id }}">{{ $machine->serial_number }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6 mb-4">
                                <label class="my-2" for="technician_id">Tecnico</label>
                                <select name="technician_id" class="form-control" required>
                                    <option value="">Seleziona un Tecnico</option>
                                    @foreach($technicians as $technician)
                                        <option value="{{ $technician->id }}">{{ $technician->name }} {{ $technician->surname }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6 mb-4">
                                <label class="my-2" for="status">Stato</label>
                                <select name="status" class="form-control" required>
                                    <option value="">Seleziona uno stato</option>
                                    @foreach(\App\Models\Ticket::getStatusOptions() as $statusOption)
                                        <option value="{{ $statusOption }}">{{ $statusOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-12 col-md-6 mb-4">
                                <label class="my-2" for="priority">Priorità</label>
                                <select name="priority" class="form-control" required>
                                    <option value="">Seleziona una priorità</option>
                                    @foreach(\App\Models\Ticket::getPriorityOptions() as $priorityOption)
                                        <option value="{{ $priorityOption }}">{{ $priorityOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                                                        
                            <div class="col-12 col-md-6 mb-4">
                                <label class="my-2" for="">Data Apertura</label>
                                <label class="form-control"> {{  \Carbon\Carbon::now()->format('d-m-Y') }} </label>
                            </div>
                            
                            <div class="col-12 col-md-6 mb-4">
                                <label class="my-2" for="closed">Data Chiusura</label>
                                <input type="date" name="closed" class="form-control">
                            </div>

                            <div class="col-12 col-md-12">
                                <label class="pb-3" for="notes">Risoluzione Problema</label>
                                <textarea type="text" name="notes" class="form-control" style="height: 100px; resize: none;"></textarea>
                            </div>

                            <x-Buttons.buttonBlue type="submit" props="Aggiungi" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    
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
