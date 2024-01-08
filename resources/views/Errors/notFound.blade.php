<x-Layouts.layout>
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="text-center">
            <img width="150px" src="{{asset('assets/not_found.png')}}" alt="">
            <p class="fs-3"> <span class="text-warning">Opps!</span> Pagina non trovata.</p>
            <p class="lead">
                La pagina che cercavi non esiste
              </p>
            <a href="{{route('home')}}" class="btn btn-primary">Home</a>
        </div>
    </div>
</x-Layouts.layout>