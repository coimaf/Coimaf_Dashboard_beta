<x-Layouts.layoutDash>
    <h6 class="fw-bold px-4 pt-4 fs-5">Modifica Veicolo</h6>
    
    <x-allert />
    
    <form style="overflow: hidden;" action="{{ route('dashboard.vehicles.edit', compact('vehicle')) }}" method="post" class="p-4" enctype="multipart/form-data">
        @csrf
        @method('PUT') 
        
        <div class="row g-3">
            
            <div class="col-12 col-md-4">
                <label class="my-2" for="type_vehicle_id">Tipo</label>
                <select class="form-control" name="type_vehicle_id" id="type_vehicle_id" required>            
                    @foreach ($typeVehicles as $typeVehicle)    
                    <option value="{{$typeVehicle->id}}" {{$vehicle->TypeVehicle->name == $typeVehicle->name ? 'selected' : ''}}>{{$typeVehicle->name}}</option>  
                    @endforeach            
                </select>                
            </div>
            
            <div class="col-12 col-md-4">
                <label class="my-2" for="brand">Marca</label>
                <input type="text" name="brand" class="form-control" value="{{ $vehicle->brand }}" required>
            </div>
            
            <div class="col-12 col-md-4">
                <label class="my-2" for="model">Modello</label>
                <input type="text" name="model" class="form-control" value="{{ $vehicle->model }}" required>
            </div>
            
            <div class="col-12 col-md-4">
                <label class="my-2" for="license_plate">Targa</label>
                <input type="text" name="license_plate" class="form-control text-uppercase" value="{{ $vehicle->license_plate }}" required>
            </div>
            
            <div class="col-12 col-md-4">
                <label class="my-2" for="chassis">Telaio</label>
                <input type="text" name="chassis" class="form-control text-uppercase" value="{{ $vehicle->chassis }}" required>
            </div>
            
            <div class="col-12 col-md-4">
                <label class="my-2" for="registration_year">Anno immatricolazione</label>
                <input type="text" name="registration_year" class="form-control" value="{{ \Carbon\Carbon::parse($vehicle->registration_year)->format('d-m-Y') }}" required>
            </div>
            
            <div class="col-12 bg-white">
                <div id="documents">
                    <h3>Documenti</h3>
                    <!-- Loop attraverso i documenti esistenti per la visualizzazione e modifica -->
                    @foreach ($vehicle->documents as $key => $document)
                    <div class="document row align-items-center my-3">
                        <div class="col-12 col-md-3">
                            <label for="">Nome del documento</label>
                            <input class="form-control" type="text" name="document_name[]" placeholder="Nome del documento" value="{{ $document->name }}">
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="">File del documento</label>
                            <!-- Aggiungi condizione per mostrare il campo solo se il documento ha un file -->
                            @if ($document->file)
                            <input class="form-control" type="file" name="document_file[]">
                            @else
                            <input class="form-control" type="file" name="document_file[]">
                            @endif
                        </div>
                        <div class="col-12 col-md-2">
                            <label for="">Data Esecuzione</label>
                            <input class="form-control" type="date" name="document_date_start[]" value="{{ $document->date_start }}">
                        </div>
                        <div class="col-12 col-md-2">
                            <label for="">Data Scadenza</label>
                            <input class="form-control" type="date" name="document_expiry_date[]" value="{{ $document->expiry_date }}">
                        </div>
                        <!-- Aggiungi un campo nascosto per l'ID del documento -->
                        <input type="hidden" name="document_id[]" value="{{ $document->id }}">
                        @endforeach
                        <div class="col-12 col-md-2">
                            <!-- Aggiungi un pulsante per aggiungere un nuovo documento -->
                            <button type="button" class="btn mt-3" onclick="addDocument()"><i class="bi bi-plus-circle fs-3 text-success"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div id="maintenances">
                    <h3>Manutenzioni</h3>
                    <!-- Loop attraverso le manutenzioni esistenti per la visualizzazione e modifica -->
                    @foreach ($vehicle->maintenances as $key => $maintenance)
                    <div class="maintenance row align-items-center my-3">
                        <div class="col-12 col-md-2">
                            <label for="">Nome</label>
                            <input class="form-control" type="text" name="maintenance_name[]" placeholder="Nome*" required value="{{ $maintenance->name }}">
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="">Descrizione</label>
                            <textarea class="form-control" name="maintenance_description[]" placeholder="Descrizione" style="resize: none;">{{ $maintenance->description }}</textarea>
                        </div>
                        <div class="col-12 col-md-2">
                            <label for="">File</label>
                            <input class="form-control" type="file" name="maintenance_file[]">
                        </div>
                        <div class="col-12 col-md-1">
                            <label for="">Prezzo</label>
                            <input class="form-control" type="number" step=".01" name="maintenance_price[]" value="{{ $maintenance->price }}">
                        </div>
                        <div class="col-12 col-md-2">
                            <label for="">Data Esecuzione</label>
                            <input class="form-control" type="date" name="maintenance_execution_date[]" value="{{ $maintenance->execution_date }}">
                        </div>
                        <!-- Aggiungi un campo nascosto per l'ID -->
                        <input type="hidden" name="maintenance_id[]" value="{{ $maintenance->id }}">
                        @endforeach
                        <div class="col-12 col-md-2">
                            <!-- Aggiungi un pulsante per aggiungere una nuova manutenzione -->
                            <button type="button" class="btn mt-3" onclick="addMaintenance()"><i class="bi bi-plus-circle fs-3 text-success"></i></button>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <div class="row mt-5">
                <x-Buttons.buttonBlue type="submit" props="Modifica" />
            </div>
        </div>
    </form>
    
    <script>
        // Funzione per aggiungere un nuovo campo documento
        function addDocument() {
            var container = document.getElementById('documents');
            var newDocument = document.createElement('div');
            newDocument.classList.add('document', 'row', 'align-items-center', 'my-3');
            newDocument.innerHTML = `
            <div class="col-12 col-md-3">
                <label for="">Nome del documento</label>
                <input class="form-control" type="text" name="new_document_name[]" placeholder="Nome del documento">
            </div>
            <div class="col-12 col-md-3">
                <label for="">File del documento</label>
                <input class="form-control" type="file" name="new_document_file[]">
            </div>
            <div class="col-12 col-md-2">
                <label for="">Data Esecuzione</label>
                <input class="form-control" type="date" name="new_document_date_start[]">
            </div>
            <div class="col-12 col-md-2">
                <label for="">Data Scadenza</label>
                <input class="form-control" type="date" name="new_document_expiry_date[]">
            </div>
            `;
            container.appendChild(newDocument);
        }

        // Funzione per aggiungere un nuovo campo manutenzione
        function addMaintenance() {
            var container = document.getElementById('maintenances');
            var newMaintenance = document.createElement('div');
            newMaintenance.classList.add('maintenance', 'row', 'align-items-center', 'my-3');
            newMaintenance.innerHTML = `
            <div class="col-12 col-md-2">
                <label for="">Nome*</label>
                <input class="form-control" type="text" required name="new_maintenance_name[]" placeholder="Nome">
            </div>
            <div class="col-12 col-md-3">
                <label for="">Descrizione</label>
                <textarea class="form-control" name="new_maintenance_description[]" placeholder="Descrizione"  style="resize: none;"></textarea>
            </div>
            <div class="col-12 col-md-2">
                <label for="">File</label>
                <input class="form-control" type="file" name="new_maintenance_file[]">
            </div>
            <div class="col-12 col-md-1">
                <label for="">Prezzo</label>
                <input class="form-control" step=".01" type="number" name="new_maintenance_price[]">
            </div>
            <div class="col-12 col-md-2">
                <label for="">Data Esecuzione</label>
                <input class="form-control" type="date" name="new_maintenance_execution_date[]">
            </div>
            `;
            container.appendChild(newMaintenance);
        }
    </script>
</x-Layouts.layoutDash>
