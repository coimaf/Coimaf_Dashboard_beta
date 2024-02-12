<x-Layouts.layoutDash>
    
    <form class="p-4 container" style="overflow: hidden;" action="{{ route('dashboard.tickets.update', $ticket->id) }}" method="POST" class="my-1">
        @csrf
        @method('PUT')
        <h6 class="fw-bold fs-5">Modifica Ticket</h6>
        <div class="row g-2">
            <div class="col-12 col-md-4">
                <label class="my-2" for="title">Titolo</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $ticket->title) }}" required>
            </div>
            
            <div class="col-12 col-md-4">
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
            
            <div class="col-12 col-md-4">
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
                <label class="pb-3" for="selectedCustomer">Seleziona un Cliente*</label>
                <input type="text" placeholder="Seleziona un Cliente*" list="customer" class="form-control" id="customerInput" name="selectedCustomer" value="{{ $ticket->descrizione }}">
                <input type="hidden" id="selectedCdCFInput" name="selectedCdCF" value="{{ $ticket->cd_cf }}">
                <datalist id="customer" required>
                    @foreach ($customers as $customer)
                    <option value="{{ trim($customer->Descrizione) }}" data-cd-cf="{{ $customer->Cd_CF }}"></option>
                    @endforeach
                </datalist>
            </div>       
            
            <div class="col-12 col-md-6">
                <label class="pb-3" for="description">Descrizione Problema</label>
                <textarea type="text" name="description" class="form-control" style="height: 70px; resize: none;">{{ old('description', $ticket->description) }}</textarea>
            </div>
            
            <div class="col-12 col-md-3">
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
            
            <div class="col-12 col-md-3">
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
            
            <div class="col-12 col-md-3">
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
            
            <div class="col-12 col-md-3">
                <label class="my-2" for="closed">Data Chiusura</label>
                <input type="date" name="closed" class="form-control" value="{{ old('closed', $ticket->closed) }}" >
            </div>
            
            <div class="col-12 col-md-12">
                <label class="pb-3" for="notes">Risoluzione Problema</label>
                <textarea type="text" name="notes" class="form-control" style="height: 100px; resize: none;" >{{ old('notes', $ticket->notes) }}</textarea>
            </div>
            
        </div>
        
        <div class="row m-3 border rounded-4 p-3 bg-white">
            
            <div class="col-12 col-md-2">
                <label class="pb-3" for="art">Seleziona un articolo</label>
                <input type="text" placeholder="Seleziona un Articolo" list="art" class="form-control" id="articleInput" name="art">
                <input type="hidden" id="selectedArtInput" name="selectedArtInput">
                <datalist id="art">
                    @foreach ($articles as $article)
                        <option value="{{ trim($article->Cd_AR) }}" data-desc="{{ $article->Descrizione }}" data-prezzo="{{ $article->Prezzo }}"></option>
                    @endforeach
                </datalist>
            </div>  
            
            <div class="col-12 col-md-3">
                <label class="pb-3" for="desc">Seleziona una Descrizione</label>
                <input type="text" placeholder="Seleziona una descrizione" list="desc" class="form-control" id="descInput" name="desc">
                <input type="hidden" id="selectedDescInput" name="selectedDescInput">
                <datalist id="desc">
                    @foreach ($articles as $article)
                        <option value="{{ trim($article->Descrizione) }}" data-art="{{ $article->Cd_AR }}" data-prezzo="{{ $article->Prezzo }}"></option>
                    @endforeach
                </datalist>
            </div>            
            
            
            
            <div class="col-12 col-md-1">
                <label class="my-2" for="qnt">Quantità</label>
                <input type="number" id="qnt" name="qnt" class="form-control" value="0">
            </div>
            
            <div class="col-12 col-md-2">
                <label class="my-2" for="prz">Prezzo</label>
                <div class="input-group">
                    <input type="text" name="prz" id="prz" class="form-control" value="0.00" step="0.01" readonly>
                    <div class="input-group-append">
                        <span class="input-group-text">€</span>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-1">
                <label class="my-2" for="sconto">Sconto</label>
                <div class="input-group">
                    <input type="text" id="sconto" name="sconto" class="form-control" value="0">
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-2">
                <label class="my-2" for="tot">Totale</label>
                <div class="input-group">
                    <input type="text" id="tot" name="tot" class="form-control" value="0" readonly>
                    <div class="input-group-append">
                        <span class="input-group-text">€</span>
                    </div>
                </div>
            </div>
            
            <div class="col-1 d-flex align-items-center" style="padding-top: 24px;">
                <button type="submit" class="btn"><i class="bi bi-plus-circle-fill fs-4"></i></button>
            </div>
            
        </div>
        
        <div class="row py-3">
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
    
    document.getElementById('articleInput').addEventListener('input', function() {
        var selectedOption = document.querySelector('#art option[value="' + this.value + '"]');
        var descInput = document.getElementById('descInput');
        var priceInput = document.getElementById('prz');
        var quantityInput = document.getElementById('qnt');
        var scontoInput = document.getElementById('sconto');

        if (selectedOption) {
            descInput.value = selectedOption.getAttribute('data-desc');
            var price = parseFloat(selectedOption.getAttribute('data-prezzo')); // Ottieni il prezzo come float
            priceInput.value = formatPrice(price); // Formatta il prezzo
            quantityInput.value = 1;
            updateTotal();
        } else {
            descInput.value = '';
            priceInput.value = '0.000'; // Imposta il prezzo a 0.000 se l'opzione non è selezionata
            quantityInput.value = 0;
            scontoInput.value = 0;
            updateTotal();
        }
    });

    function formatPrice(price) {
        var formattedPrice = price.toFixed(3); // Ottieni il prezzo con tre decimali
        // Aggiungi gli zeri finali se necessario
        var parts = formattedPrice.split('.');
        if (parts.length === 1) {
            formattedPrice += '.000';
        } else if (parts.length === 2 && parts[1].length === 1) {
            formattedPrice += '00';
        } else if (parts.length === 2 && parts[1].length === 2) {
            formattedPrice += '0';
        }
        return formattedPrice;
    }

    document.getElementById('descInput').addEventListener('input', function() {
        var selectedOption = document.querySelector('#desc option[value="' + this.value + '"]');
        var articleInput = document.getElementById('articleInput');
        var priceInput = document.getElementById('prz');
        var quantityInput = document.getElementById('qnt');
        var scontoInput = document.getElementById('sconto');

        if (selectedOption) {
            articleInput.value = selectedOption.getAttribute('data-art');
            var price = parseFloat(selectedOption.getAttribute('data-prezzo')) / 100; // Converti il prezzo da centesimi a euro
            priceInput.value = price; // Visualizza il prezzo con due decimali
            quantityInput.value = 1; // Imposta la quantità a 1
            updateTotal();
        } else {
            articleInput.value = '';
            priceInput.value = '0';
            quantityInput.value = 0; // Imposta la quantità a 0
            scontoInput.value = 0;
            updateTotal();
        }
    });

    document.getElementById('qnt').addEventListener('input', function() {
        updateTotal();
    });

    function updateTotal() {
        var quantity = parseFloat(document.getElementById('qnt').value);
        var price = parseFloat(document.getElementById('prz').value);

        if (isNaN(quantity)) {
            quantity = 0;
        }

        if (isNaN(price)) {
            price = 0;
        }

        var total = quantity * price;
        document.getElementById('tot').value = total.toFixed(3); // Ottieni il totale con tre decimali
    }

    document.getElementById('sconto').addEventListener('input', function() {
        updateTotalWithDiscount();
    });

    function updateTotalWithDiscount() {
        var quantity = parseFloat(document.getElementById('qnt').value);
        var price = parseFloat(document.getElementById('prz').value);
        var discount = parseFloat(document.getElementById('sconto').value);

        if (isNaN(quantity)) {
            quantity = 0;
        }

        if (isNaN(price)) {
            price = 0;
        }

        if (isNaN(discount)) {
            discount = 0;
        }

        var subtotal = quantity * price;
        var discountAmount = (subtotal * discount) / 100;
        var total = subtotal - discountAmount;

        document.getElementById('tot').value = total.toFixed(3); // Ottieni il totale con tre decimali
    }
</script>
