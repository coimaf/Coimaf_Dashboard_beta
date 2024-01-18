<x-Layouts.layoutDash>
    <div class="container-fluid main-content">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 rounded-3 mt-5" style="background-color: rgb(243, 243, 243); height: 90vh;">
                <div class="col-12 rounded-2 mt-3 p-5 container-create" style="max-height: 80vh; overflow-y: scroll">
                    <h2 class="">Aggiungi una nuova Macchina</h2>
                    
                    <form action="{{route('dashboard.machinesSolds.store')}}" method="POST" class="my-5" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="my-2" for="model">Modello</label>
                                <input type="text" name="model" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="my-2" for="brandInput">Marca</label>
                                <input list="brandList" class="form-control" id="brandInput" name="brand">
                                <datalist id="brandList">
                                    <option value="">Seleziona una Marca</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->Descrizione }}" data-cd-ar-marca="{{ $brand->Cd_ARMarca }}"></option>
                                    @endforeach
                                </datalist>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="my-2" for="serial_number">Numero di Serie</label>
                                <input type="text" name="serial_number" class="form-control" required>
                            </div>
                            
                            <div class="col-12 col-md-6 mb-4">
                                <label class="my-2" for="sale_date">Data di vendita</label>
                                <input type="date" name="sale_date" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="my-2" for="old_buyer_input">Vecchio Proprietario</label>
                                <input list="old_buyer" class="form-control" id="old_buyer_input" name="old_buyer">
                                <datalist id="old_buyer">
                                    @foreach ($customers as $customer)
                                        <option value="{{ trim($customer->Descrizione) }}" data-cd-cf="{{ $customer->Cd_CF }}"></option>
                                    @endforeach
                                </datalist>
                            </div> 
                            
                            <div class="col-12 col-md-6">
                                <label class="my-2" for="buyer_input">Proprietario Attuale</label>
                                <input list="buyer" class="form-control" id="buyer_input" name="buyer">
                                <datalist id="buyer" required>
                                    @foreach ($customers as $customer)
                                        <option value="{{ trim($customer->Descrizione) }}" data-cd-cf="{{ $customer->Cd_CF }}"></option>
                                    @endforeach
                                </datalist>
                            </div>
                            
                            <div class="col-12 col-md-6 mb-4">
                                <label class="my-2" for="warranty_expiration_date">Data di scadenza garanzia</label>
                                <input type="date" name="warranty_expiration_date" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="my-2" for="warranty_type_id">Tipo Garanzia</label>
                                <select name="warranty_type_id" class="form-control" required>
                                    <option value="">Seleziona una garanzia</option>
                                    @foreach($warranty_type as $warranty)
                                        <option value="{{ $warranty->id }}">{{ $warranty->name }}</option>
                                    @endforeach
                                </select>
                            </div>                            
                                                        
                            <div class="col-12 col-md-6 mb-4">
                                <label class="my-2" for="registration_date">Data di registrazione</label>
                                <input type="date" name="registration_date" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-6 mb-4">
                                <label class="my-2" for="delivery_ddt">Consegna DDT</label>
                                <input type="text" name="delivery_ddt" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-12">
                                <label class="pb-3" for="notes">Note</label>
                                <textarea type="text" name="notes" class="form-control" style="height: 100px; resize: none;" required></textarea>
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
