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
            
            @foreach($documents as $document)
            <div class="col-12 col-md-6">
                <div class="form-control">
                    <label class="my-3" for="path_{{ $document->id }}">{{ $document->name }}</label>
                    <input type="file" class="form-control" id="path_{{ $document->id }}" name="documents[{{ $document->id }}][]">
                    
                    <label class="my-3" for="expiry_date_{{ $document->id }}">Data di Scadenza per {{ $document->name }}</label>
                    <input type="date" class="form-control" id="expiry_date_{{ $document->id }}" name="expiry_dates[{{ $document->id }}]"
                    value="{{ $documentsDate->firstWhere('document_id', $document->id)->expiry_date ?? '' }}">
                </div>
            </div>
            @endforeach
            
            <!-- Form per l'aggiunta di una nuova manutenzione -->
            <div class="row g-3 my-3">
                <div class="col-12">
                    <h6 class="fw-bold pt-4 fs-5">Aggiungi Manutenzione</h6>
                </div>
                
                <div class="col-12 col-md-4">
                    <label class="my-2" for="name">Nome Manutenzione</label>
                    <input type="text" name="name" class="form-control">
                </div>
                
                <div class="col-12 col-md-4">
                    <label class="my-2" for="start_at">Data Inizio Manutenzione</label>
                    <input type="date" name="start_at" class="form-control">
                </div>
                
                <div class="col-12 col-md-4">
                    <label class="my-2" for="expiry_date">Data Scadenza Manutenzione</label>
                    <input type="date" name="expiry_date" class="form-control">
                </div>
            </div>
        </form>
            
            @if($maintenance->isNotEmpty())
            <!-- Visualizzazione delle manutenzioni esistenti -->
            @foreach ($maintenance as $item)
            
            <div class="row g-3 my-3 bg-white border border-1 m-2 rounded-2 align-items-center">
                <div class="col-12 col-md-3">
                    <p>{{$item->name}}</p>
                </div>
                
                <div class="col-12 col-md-3">
                   <p>{{$item->start_at}}</p>
                </div>
                
                <div class="col-12 col-md-3">
                    <p> {{$item->expiry_date}}</p>
                </div>

                <div class="col-12 col-md-3 m-0">
                    <form action="{{ route('maintenance.destroy', ['vehicle' => $vehicle, 'maintenance' => $item]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger">Elimina</button>
                    </form>
                </div>
            </div>
            
            @endforeach
            @endif
            
            
            
            <div class="row mt-5">
                <x-Buttons.buttonBlue type="submit" props="Aggiorna" />
            </div>
        </div>
    
</x-Layouts.layoutDash>