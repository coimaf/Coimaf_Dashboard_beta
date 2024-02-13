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
                            <img src="{{asset('assets/PDF_file_icon.svg.png')}}" alt="PDF_icon"
                            class="img-fluid" style="width: 50px;">
                        </div>
                        <h5 class="my-3 fs-3 fw-bold text-alt">{{$vehicle->typeVehicle->name}} {{$vehicle->brand}} {{$vehicle->model}}</h5>
                        <p class="card-footer fw-semibold mt-3">Creato da: {{$vehicle->user->name}}  il: {{$vehicle->created_at->format('d/m/Y')}} 
                            @if($vehicle->updated_by)
                            <br><br>Modificato da: {{$vehicle->updatedBy->name}} il: {{$vehicle->updated_at->format('d/m/Y')}}</p>
                            @endif
                    </div>
                </div>
                <div class="card mb-4 mb-lg-0 text-black">
                    <div class="card-body p-0 text-black">
                        <ul class="list-group list-group-flush rounded-3 text-black">
                            {{-- <li class="list-group-item d-flex justify-content-between align-items-center p-3 text-black">
                                @foreach ($deadline->documentDeadlines as $document)
                                    <label for="">{{$document->name}}</label>
                                    <label> {{ Carbon\Carbon::parse($document->expiry_date)->format('d-m-Y') }}</label>
                                    @endforeach
                                    <a class="link-underline link-underline-opacity-0 link-dark fw-bold" href="{{ asset("storage/{$document->pdf_path}") }}" download="{{ $document->name }} {{ $deadline->name }}">
                                        <p class="mb-0"><i class="bi bi-download pe-2"></i> Download</p>
                                    </a>
                                </li> --}}
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
            </div>
        </div>
    </div>
</x-Layouts>
