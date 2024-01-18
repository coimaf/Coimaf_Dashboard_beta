<x-Layouts.layoutDash>
    <h6 class="fw-bold">Modifica Macchina</h6>
    
    <form action="{{ route('dashboard.machinesSolds.update', $machine->id) }}" method="POST" class="my-1" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-12">
                <label class="my-2" for="model">Modello</label>
                <input type="text" name="model" class="form-control" value="{{ old('model', $machine->model) }}" required>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="my-2" for="brandInput">Marca</label>
                <input list="brandList" class="form-control" id="brandInput" name="brand" value="{{ old('brand', $machine->brand) }}">
                <datalist id="brandList">
                    <option value="">Seleziona una Marca</option>
                    @foreach($brands as $brand)
                    <option value="{{ $brand->Descrizione }}" data-cd-ar-marca="{{ $brand->Cd_ARMarca }}"></option>
                    @endforeach
                </datalist>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="my-2" for="serial_number">Numero di Serie</label>
                <input type="text" name="serial_number" class="form-control" value="{{ old('serial_number', $machine->serial_number) }}" required>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="my-2" for="old_buyer_input">Vecchio Proprietario</label>
                <input list="old_buyer" class="form-control" id="old_buyer_input" name="old_buyer" value="{{ old('old_buyer', $machine->old_buyer) }}">
                <datalist id="old_buyer" required>
                    @foreach ($customers as $customer)
                    <option value="{{ trim($customer->Descrizione) }}" data-cd-cf="{{ $customer->Cd_CF }}"></option>
                    @endforeach
                </datalist>
            </div> 
            
            <div class="col-12 col-md-6">
                <label class="my-2" for="buyer_input">Proprietario Attuale</label>
                <input list="buyer" class="form-control" id="buyer_input" name="buyer" value="{{ old('buyer', $machine->buyer) }}">
                <datalist id="buyer" required>
                    @foreach ($customers as $customer)
                    <option value="{{ trim($customer->Descrizione) }}" data-cd-cf="{{ $customer->Cd_CF }}"></option>
                    @endforeach
                </datalist>
            </div>                            
            
            <div class="col-12 col-md-6">
                <label class="my-2" for="warranty_type_id">Tipo Garanzia</label>
                <select name="warranty_type_id" class="form-control" required>
                    <option value="">Seleziona una garanzia</option>
                    @foreach($warranty_type as $warranty)
                    <option value="{{ $warranty->id }}" {{ old('warranty_type_id', $machine->warranty_type_id) == $warranty->id ? 'selected' : '' }}>{{ $warranty->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-6">
                <label class="my-2" for="sale_date">Data di vendita</label>
                <input type="date" name="sale_date" class="form-control" value="{{ old('sale_date', $machine->sale_date) }}" required>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="my-2" for="delivery_ddt">Consegna DDT</label>
                <input type="text" name="delivery_ddt" class="form-control" value="{{ old('delivery_ddt', $machine->delivery_ddt) }}" required>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="pb-3" for="notes">Note</label>
                <textarea type="text" name="notes" class="form-control" style="height: 100px; resize: none;" required>{{ old('notes', $machine->notes) }}</textarea>
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
