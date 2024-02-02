<x-Layouts.layoutDash>
        <div class="container px-4">
            <div class="row justify-content-end">
                <div class="col-3">
                    <a href="{{ route('dashboard.deadlines.edit', $deadline->id) }}" class="btn btn-warning float-end fs-4 m-4">Modifica</a>
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
                            <h5 class="my-3 fs-3 fw-bold text-alt">{{$deadline->name}}</h5>
                            <p class="card-footer fw-semibold mt-3">Creato da: {{$deadline->user->name}}  il: {{$deadline->created_at->format('d/m/Y')}} 
                                @if($deadline->updated_by)
                                <br><br>Modificato da: {{$deadline->updatedBy->name}} il: {{$deadline->updated_at->format('d/m/Y')}}</p>
                                @endif
                        </div>
                    </div>
                    <div class="card mb-4 mb-lg-0 text-black">
                        <div class="card-body p-0 text-black">
                            <ul class="list-group list-group-flush rounded-3 text-black">
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3 text-black">
                                    @foreach ($deadline->documentDeadlines as $document)
                                        <label for="">{{$document->name}}</label>
                                        <label> {{ Carbon\Carbon::parse($document->expiry_date)->format('d-m-Y') }}</label>
                                        @endforeach
                                        <a class="link-underline link-underline-opacity-0 link-dark fw-bold" href="{{ asset("storage/{$document->pdf_path}") }}" download="{{ $document->name }} {{ $deadline->name }}">
                                            <p class="mb-0"><i class="bi bi-download pe-2"></i> Download</p>
                                        </a>
                                    </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4 text-black">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="fw-bold fs-5">Scadenza</p>
                                </div>
                                <div class="col-sm-9">
                                    @foreach ($deadline->documentDeadlines as $document)
                                    <label class="fs-4"> {{ Carbon\Carbon::parse($document->expiry_date)->format('d-m-Y') }}</label>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="fw-bold fs-5">Tag</p>
                                </div>
                                <div class="col-sm-9">
                                    @foreach ($deadline->tags as $tag)
                                    <span class="badge bg-primary fs-6">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="fw-bold fs-5">Descrizione</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="mb-0 fs-5">{{$deadline->description}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-Layouts>
