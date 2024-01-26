<x-Layouts.layoutDash>
    <h6 class="fw-bold p-4 fs-5">Aggiungi una nuova Macchina</h6>
    
    <form class="p-4" style="overflow: hidden;" action="{{route('dashboard.machinesSolds.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <input placeholder="Modello*" type="text" name="model" class="form-control" required>
            </div>
            
            <div class="col-12 col-md-6">
                <input placeholder="Seleziona Marca*" list="brandList" class="form-control" id="brandInput" name="brand" required>
                <datalist id="brandList">
                    <option value="">Seleziona una Marca</option>
                    @foreach($brands as $brand)
                    <option value="{{ $brand->Descrizione }}" data-cd-ar-marca="{{ $brand->Cd_ARMarca }}"></option>
                    @endforeach
                </datalist>
            </div>
            
            <div class="col-12 col-md-6">
                <input placeholder="Numero di Serie*" type="text" name="serial_number" class="form-control" required>
            </div>
            
            <div class="col-12 col-md-6">
                <input placeholder="Vecchio Proprietario" list="old_buyer" class="form-control" id="old_buyer_input" name="old_buyer">
                <datalist id="old_buyer">
                    @foreach ($customers as $customer)
                    <option value="{{ trim($customer->Descrizione) }}" data-cd-cf="{{ $customer->Cd_CF }}"></option>
                    @endforeach
                </datalist>
            </div> 
            
            <div class="col-12 col-md-6">
                <input placeholder="Proprietario Attuale" list="buyer" class="form-control" id="buyer_input" name="buyer">
                <datalist id="buyer">
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
                    <option value="{{ $warranty->id }}" @if($warranty->name === 'Standard') selected @endif>{{ $warranty->name }}</option>
                    @endforeach
                </select>
            </div>                            

            <div class="col-12 col-md-6 mb-4">
                <label class="my-2" for="sale_date">Data installazione</label>
                <input type="date" name="sale_date" class="form-control">
            </div>
            
            
            <div class="col-12 col-md-6 mb-4">
                <label class="my-2" for="delivery_ddt">Documento di trasporto</label>
                <input type="text" name="delivery_ddt" class="form-control">
            </div>
            
            <div class="col-12 col-md-6">
                <label class="pb-3" for="notes">Note</label>
                <textarea type="text" name="notes" class="form-control" style="height: 100px; resize: none;"></textarea>
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
</script>
