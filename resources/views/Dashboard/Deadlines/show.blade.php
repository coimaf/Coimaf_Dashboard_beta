<x-Layouts.layoutDash>
    <section class="m-5" style="background-color: rgb(243, 243, 243); height: 86vh; overflow:auto">
        <div class="container p-5">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4 text-black">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-center">
                                <img src="{{asset('assets/PDF_file_icon.svg.png')}}" alt="PDF_icon"
                                class="img-fluid" style="width: 50px;">
                            </div>
                            <h5 class="my-3 fs-3 fw-bold text-alt">{{$deadline->name}}</h5>
                            @foreach ($deadline->documentDeadlines as $document)
                            <p class="mb-3 text-capitalize lead">{{ Carbon\Carbon::parse($document->expiry_date)->format('d-m-Y') }}</p>
                            @endforeach
                            @foreach ($deadline->tags as $tag)
                            <span class="badge bg-primary">{{ $tag->name }}</span>
                            @endforeach
                            <p class="card-footer fw-semibold mt-3">Creato da: {{$deadline->user->name}} <br> il: {{$deadline->created_at->format('d/m/Y')}}</p>
                        </div>
                    </div>
                    <div class="card mb-4 mb-lg-0 text-black">
                        <div class="card-body p-0 text-black">
                            <ul class="list-group list-group-flush rounded-3 text-black">
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3 text-black">                                        
                                    <a class="link-underline link-underline-opacity-0 link-dark fw-semibold" href="{{ asset('storage/' . $document->pdf_path) }}" download="{{ $document->name }} {{ $deadline->name }}">
                                        <p class="mb-0"><i class="bi bi-download pe-2"></i>Download</p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4 text-black">
                        <div class="card-body d-flex align-items-center justify-content-center" style="min-height: 40vh;">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p class=" mb-0 text-center">{{$deadline->description}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-Layouts>
