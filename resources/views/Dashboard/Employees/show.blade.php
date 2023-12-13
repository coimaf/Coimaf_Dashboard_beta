<x-Layouts.layoutDash>
    <section class="m-5" style="background-color: rgb(243, 243, 243); height: 86vh; overflow:auto">
        <div class="container p-5">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4 text-black">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-center">
                                <img src="{{asset('assets/default-profile.webp')}}" alt="avatar"
                                     class="rounded-circle img-fluid" style="width: 200px;">
                            </div>
                            <h5 class="my-3 fs-3 fw-bold text-alt">{{$employee->name}} {{$employee->surname}}</h5>
                            <p class=" mb-1 text-capitalize">{{$employee->role->name}}</p>
                            <p class=" mb-4 text-uppercase">{{$employee->fiscal_code}}</p>
                            <p class="card-footer fw-semibold">Creato da: {{$employee->user->name}} <br> il: {{$employee->created_at->format('d/m/Y')}}</p>
                        </div>
                    </div>
                    <div class="card mb-4 mb-lg-0 text-black">
                        <div class="card-body p-0 text-black">
                            <ul class="list-group list-group-flush rounded-3 text-black">
                                @foreach ($employee->documents as $document)
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3 text-black">                                        
                                        <i class="bi bi-circle-fill {{ getStatusIconClass($document->expiry_date) }}"></i>
                                        <a class="link-underline link-underline-opacity-0 link-dark fw-semibold" href="{{ asset('storage/' . $document->pdf_path) }}" download="{{ $document->name }} {{ $employee->name }} {{$employee->surname}}">
                                            <p class="mb-0"><i class="bi bi-download pe-2"></i> {{$document->name}}</p>
                                        </a>
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
                                    <p class="mb-0">Nome</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{$employee->name}} {{$employee->surname}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Data di nascita</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{ \Carbon\Carbon::parse($employee->birthday)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{$employee->email}}</p>
                                </div>
                            </div>
                            <hr>
                            @if($employee->email_work)
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Email Lavoro</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class=" mb-0">{{$employee->email_work}}</p>
                                    </div>
                                </div>
                                <hr>
                            @endif
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Telefono</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{$employee->phone}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Indirizzo</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class=" mb-0">{{$employee->address}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-Layouts>

@php
function getStatusIconClass($expiryDate)
{
    $expiryDate = Carbon\Carbon::parse($expiryDate);

    if ($expiryDate->isPast()) {
        return 'text-danger';
    } elseif ($expiryDate->diffInDays(now()) <= 60) {
        return 'text-warning';
    }

    return 'text-success';
}
@endphp
