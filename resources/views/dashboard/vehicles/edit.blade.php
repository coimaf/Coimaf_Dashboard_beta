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

            <div>
                <div id="documents">
                    @foreach ($vehicle->documents as $key => $document)
                        <div class="document row align-items-center">
                            <div class="col-12 col-md-3">
                                <input class="form-control" type="text" name="document_name[]" placeholder="Nome del documento" value="{{ $document->name }}">
                            </div>
                            <div class="col-12 col-md-3">
                                @if ($document->file)
                                    <input class="form-control" type="file" name="document_file[]">
                                @else
                                    <input class="form-control" type="file" name="document_file[]">
                                @endif
                            </div>
                            <div class="col-12 col-md-3">
                                <input class="form-control" type="date" name="document_date_start[]" value="{{ $document->date_start }}">
                            </div>
                            <div class="col-12 col-md-3">
                                <input class="form-control" type="date" name="document_expiry_date[]" value="{{ $document->expiry_date }}">
                            </div>
                            <!-- Aggiungi un campo nascosto per l'ID del documento -->
                            <input type="hidden" name="document_id[]" value="{{ $document->id }}">
                        </div>
                    @endforeach
                </div>
            </div>
            
            
            
            <div class="row mt-5">
                <x-Buttons.buttonBlue type="submit" props="Aggiorna" />
            </div>
        </div>
    
</x-Layouts.layoutDash>