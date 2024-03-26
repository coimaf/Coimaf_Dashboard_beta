<x-Layouts.layoutDash>
    <h6 class="fw-bold px-4 pt-4 fs-5">Modifica Veicolo</h6>
    
    <x-allert />
    
    <form id="form" style="overflow: hidden;" action="{{ route('dashboard.vehicles.edit', compact('vehicle')) }}" method="post" class="p-4" enctype="multipart/form-data">
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
                    <div class="document row align-items-center my-3 mx-0 p-0">
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
                    <div class="maintenance row align-items-center my-3 mx-0 p-0">
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
                            <input class="form-control" type="date" name="maintenance_start_at[]" value="{{ $maintenance->start_at ? \Carbon\Carbon::parse($maintenance->start_at)->format('Y-m-d') : '' }}">
                        </div>
                        <div class="col-12 col-md-2">
                            <label for="">Scadenza</label>
                            <input class="form-control" type="date" name="maintenance_end_at[]" value="{{ $maintenance->end_at ? \Carbon\Carbon::parse($maintenance->end_at)->format('Y-m-d') : '' }}">
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
            
        </div>
        <div class="row fixed-button">
            <x-Buttons.buttonBlue type="submit" props="Salva" />
        </div>
    </form>
    
    
    <style>
        
        .fixed-button {
            margin-top: 100px;
            position: fixed;
            bottom: 0;
            width: 80%;
            z-index: 1000; /* Assicurati che il pulsante sia sopra gli altri elementi */
        }
        
    </style>
    
    <script>
        function scrollToBottom() {
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: 'smooth'
            });
        }
        
        // Funzione per scorrere la pagina fino a un elemento specifico
        function scrollToElement(element) {
            element.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        
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
            // Trova il container delle manutenzioni
            var maintenancesContainer = document.getElementById('maintenances');
            
            // Aggiungi il nuovo documento sopra il container delle manutenzioni
            maintenancesContainer.parentNode.insertBefore(newDocument, maintenancesContainer);
            
            // Scorrere la pagina verso il nuovo documento
            scrollToElement(newDocument);
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
                <input class="form-control" type="date" name="new_maintenance_start_at[]">
            </div>
            <div class="col-12 col-md-2">
                <label for="">Data Scadenza</label>
                <input class="form-control" type="date" name="new_maintenance_end_at[]">
            </div>
            `;
            container.appendChild(newMaintenance);
            scrollToBottom()
        }
    </script>
</x-Layouts.layoutDash>
