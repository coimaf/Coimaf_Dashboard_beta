<x-Layouts.layoutDash>
    <div class="container px-4">
        <div class="row justify-content-end">
            <div class="col-3">
                <a href="{{ route('dashboard.vehicles.edit', compact('vehicle')) }}" class="btn btn-warning float-end fs-4 m-4">Modifica</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4 text-black">
                    <div class="card-body text-center">
                        <div class="d-flex justify-content-center">
                            <i class="bi bi-car-front-fill pe-2 fs-1"></i>
                        </div>
                        <h5 class="my-3 fs-3 fw-bold text-alt">{{$vehicle->typeVehicle->name}} {{$vehicle->brand}} {{$vehicle->model}}</h5>
                        <p class="card-footer fw-semibold mt-3">Creato da: {{$vehicle->user->name}}  il: {{$vehicle->created_at->format('d/m/Y')}} 
                            @if($vehicle->updated_by_id)
                            <br><br>Modificato da: {{$vehicle->updatedBy->name}} il: {{$vehicle->updated_at->format('d/m/Y')}}</p>
                            @endif
                        </div>
                    </div>

                    <div class="card mb-4 mb-lg-0 text-black">
                        <div class="card-body p-0 text-black">
                            <ul class="list-group list-group-flush rounded-3 text-black">
                                @foreach($vehicle->documents as $document)
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3 text-black">
                                    <label class="w-25">{{ $document->name }}</label>
                                    <div class="d-flex flex-column align-items-end">
                                        @if($document->date_start)
                                        <span>Data Esecuzione: {{ \Carbon\Carbon::parse($document->date_start)->format('d-m-Y') }}</span>
                                        @endif
                                        @if($document->expiry_date)
                                        <span>Data Scadenza: {{ \Carbon\Carbon::parse($document->expiry_date)->format('d-m-Y') }}</span>
                                        @endif
                                    </div>
                                    @if($document->file)
                                    <a class="link-underline link-underline-opacity-0 link-dark fw-bold" href="{{ asset("storage/{$document->file}") }}" download="{{ $document->name }}" >
                                        <p class="mb-0"><i class="bi bi-download pe-2"></i> Download</p>
                                    </a>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4 text-black">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="fw-bold fs-5">Targa</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="mb-0 fs-5 text-uppercase">{{$vehicle->license_plate}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="fw-bold fs-5">Telaio</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="mb-0 fs-5 text-uppercase">{{$vehicle->chassis}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="fw-bold fs-5">Anno immatricolazione</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="mb-0 fs-5 text-uppercase">{{ \Carbon\Carbon::parse($vehicle->registration_year)->format('d-m-Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($vehicle->maintenances)
                    <!-- Visualizzazione delle manutenzioni esistenti -->
                    @foreach ($vehicle->maintenances as $item)
                    
                    <div class="row g-3 my-3 bg-white border border-1 m-2 rounded-2 align-items-center">
                        <div class="col-12 col-md-2">
                            <p class="fw-bold fs-5">{{$item->name}}</p>
                        </div>

                        <div class="col-12 col-md-2">
                            <p>{{$item->description}}</p>
                         </div>
                         @if( $item->price )
                            <div class="col-12 col-md-2">
                                <p>{{ $item->price . " €"}}</p>
                            </div>
                            @else
                            <div class="col-12 col-md-2">
                                <p> </p>
                            </div>
                        @endif
                        @if( $item->start_at )
                        <div class="col-12 col-md-2">
                           <p>{{\Carbon\Carbon::parse($item->start_at)->format('d-m-Y')}}</p>
                        </div>
                        @else
                        <div class="col-12 col-md-2">
                            <p> </p>
                         </div>
                         @endif

                         @if($item->file)
                         <div class="col-12 col-md-2">
                             <a class="link-underline link-underline-opacity-0 link-dark fw-bold" href="{{ asset("storage/{$item->file}") }}" download="{{ $item->name }}" >
                                 <p class="mb-0"><i class="bi bi-download pe-2"></i> Download</p>
                             </a>
                         </div>
     
                         @endif

                    </div>
                    
                    @endforeach
                    @endif

                </div>
            </div>
        </div>
    </x-Layouts>
    