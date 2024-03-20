<x-Layouts.layoutDash>
    <h6 class="fw-bold p-4 fs-5">Aggiungi Veicolo</h6>
    
    <form id="form" class="px-4 py-3" style="overflow: hidden;" action="{{ route('dashboard.vehicles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            
            <div class="col-12 col-md-4">
                <select class="form-control" name="type_vehicle_id" id="type_vehicle_id" required>
                    <option value="" selected disabled>Seleziona il tipo di veicolo*</option>
                    @foreach ($typeVehicles as $typeVehicle)                  
                    <option value="{{$typeVehicle->id}}">{{$typeVehicle->name}}</option>  
                    @endforeach            
                </select>
            </div>
            
            <div class="col-12 col-md-4">
                <input placeholder="Marca*" type="text" name="brand" class="form-control" required>
            </div>
            
            <div class="col-12 col-md-4">
                <input placeholder="Modello*" type="text" name="model" class="form-control" required>
            </div>
            
            <div class="col-12 col-md-4">
                <input placeholder="Targa*" type="text" name="license_plate" class="form-control  mt-4 text-uppercase" required>
            </div>
            
            <div class="col-12 col-md-4">
                <input placeholder="Telaio*" type="text" name="chassis" class="form-control mt-4 text-uppercase" required>
            </div>
            
            <div class="col-12 col-md-4">
                <label for="registration_year">Anno immatricolazione*</label>
                <input type="date" name="registration_year" class="form-control" required>
            </div>
            
            <div>
                <h3 class="my-4">Aggiungi Documenti</h3>
                <div id="documents">
                    <div class="document row align-items-center">
                        <div class="col-12 col-md-3">
                            <label for=""> </label>
                            <input class="form-control" type="text" name="document_name[]" placeholder="Nome del documento">
                        </div>
                        <div class="col-12 col-md-3">
                            <label for=""> </label>
                            <input class="form-control" type="file" name="document_file[]">
                        </div>
                        <div class="col-12 col-md-2">
                            <label for="">Data Esecuzione</label>
                            <input class="form-control" type="date" name="document_date_start[]">
                        </div>
                        <div class="col-12 col-md-2">
                            <label for="">Data Scadenza</label>
                            <input class="form-control" type="date" name="document_expiry_date[]">
                        </div>
                        <div class="col-12 col-md-2 p-0 mt-3">
                            <button class="btn" type="button" onclick="addDocument()"><i class="bi bi-plus-circle fs-3 text-success"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row py-3">
                <x-Buttons.buttonBlue type="submit" props="Aggiungi" />
            </div>
            
        </div>
    </form>
    
</x-Layouts.layoutDash>


<script>
    function addDocument() {
        var container = document.getElementById('documents');
        var newDocument = document.createElement('div');
        newDocument.classList.add('document');
        newDocument.innerHTML = `
        <div class="document row align-items-center my-4">
            <div class="col-12 col-md-3">
                <input class="form-control" type="text" name="document_name[]" placeholder="Nome del documento">
            </div>
            <div class="col-12 col-md-3">
                <input class="form-control" type="file" name="document_file[]">
            </div>
            <div class="col-12 col-md-2">
                <input class="form-control" type="date" name="document_date_start[]">
            </div>
            <div class="col-12 col-md-2">
                <input class="form-control" type="date" name="document_expiry_date[]">
            </div>
        </div>
        `;
        container.appendChild(newDocument);
    }
</script>
