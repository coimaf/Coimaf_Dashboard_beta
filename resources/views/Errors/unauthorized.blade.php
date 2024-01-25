<x-Layouts.layout>
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="text-center">
            <img class="mb-4" width="150px" src="{{asset('assets/denied_access.png')}}" alt="">
            <p class="fs-3"> <span class="text-danger">Opps!</span> Non sei autorizzato.</p>
            <p class="lead">
                Non hai i permessi necessari per accedere a questa pagina.<br>
                Contatta l'amministratore dell'azienda per richiedere i permessi.
              </p>
            <a href="{{route('dash')}}" class="btn btn-primary">Home</a>
        </div>
    </div>
</x-Layouts.layout>