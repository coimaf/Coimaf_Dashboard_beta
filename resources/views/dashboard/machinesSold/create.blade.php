<x-Layouts.layoutDash>
    <h6 class="fw-bold p-4 fs-5">Aggiungi una nuova Macchina</h6>
    
    <form id="form" class="p-4" style="overflow: hidden;" action="{{route('dashboard.machinesSolds.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            
            <div class="col-12 col-md-6">
                <input type="text" placeholder="Modello*" list="artCodeList" class="form-control" id="artCodeInput" name="artCode">
                <datalist id="artCodeList">
                    @foreach ($codeArticles as $codeArticle)
                        <option value="{{ trim($codeArticle->Cd_AR) }}" data-description="{{ $codeArticle->Descrizione }}" data-brand="{{ $codeArticle->Cd_ARMarca }}"></option>
                    @endforeach
                </datalist>
            </div>

            <div class="col-12 col-md-6">
                <input placeholder="Seleziona Marca*" list="brandList" class="form-control" id="brandInput" name="brand" readonly>
                <datalist id="brandList">
                    @foreach ($codeArticles as $codeArticle)
                        <option value="{{ $codeArticle->Cd_ARMarca }}" data-description="{{ $codeArticle->Descrizione }}" data-code="{{ trim($codeArticle->Cd_AR) }}"></option>
                    @endforeach
                </datalist>
            </div> 
            
            <div class="col-12 col-md-6">
                <input type="text" placeholder="Descrizione*" list="artDescList" class="form-control" id="artDescInput" name="model">
                <datalist id="artDescList">
                    @foreach ($codeArticles as $codeArticle)
                        <option value="{{ $codeArticle->Descrizione }}" data-code="{{ trim($codeArticle->Cd_AR) }}" data-brand="{{ $codeArticle->Cd_ARMarca }}"></option>
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
                
                <label class="my-2" for="img">Immagine</label>
                <input type="file" name="img" class="form-control">
                @error('img')
                    <div class="alert alert-danger my-2">{{ $message }}</div>
                @enderror
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
    document.addEventListener("DOMContentLoaded", function () {
        var artCodeInput = document.getElementById("artCodeInput");
        var artDescInput = document.getElementById("artDescInput");
        var brandInput = document.getElementById("brandInput");
        
        artCodeInput.addEventListener("input", function () {
            var selectedCode = this.value.trim();
            var dataList = document.getElementById("artCodeList");
            var options = dataList.querySelectorAll("option");
            for (var i = 0; i < options.length; i++) {
                if (options[i].value.trim() === selectedCode) {
                    artDescInput.value = options[i].getAttribute("data-description");
                    brandInput.value = options[i].getAttribute("data-brand");
                    break;
                }
            }
            // Se il campo codice articolo è vuoto, cancella i valori degli altri due campi
            if (selectedCode === "") {
                artDescInput.value = "";
                brandInput.value = "";
            }
        });

        artDescInput.addEventListener("input", function () {
            var selectedDesc = this.value.trim();
            var dataList = document.getElementById("artDescList");
            var options = dataList.querySelectorAll("option");
            for (var i = 0; i < options.length; i++) {
                if (options[i].value.trim() === selectedDesc) {
                    artCodeInput.value = options[i].getAttribute("data-code");
                    brandInput.value = options[i].getAttribute("data-brand");
                    break;
                }
            }
            // Se il campo descrizione è vuoto, cancella i valori degli altri due campi
            if (selectedDesc === "") {
                artCodeInput.value = "";
                brandInput.value = "";
            }
        });
        
        brandInput.addEventListener("input", function () {
            var selectedBrand = this.value.trim();
            var dataList = document.getElementById("brandList");
            var options = dataList.querySelectorAll("option");
            for (var i = 0; i < options.length; i++) {
                if (options[i].value.trim() === selectedBrand) {
                    artCodeInput.value = options[i].getAttribute("data-code");
                    artDescInput.value = options[i].getAttribute("data-description");
                    break;
                }
            }
            // Se il campo marca è vuoto, cancella i valori degli altri due campi
            if (selectedBrand === "") {
                artCodeInput.value = "";
                artDescInput.value = "";
            }
        });
    });
</script>
