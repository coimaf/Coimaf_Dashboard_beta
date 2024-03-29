<x-Layouts.layoutDash>
    <section class="m-5" style="background-color: rgb(243, 243, 243); height: 86vh; overflow:auto">
        <div class="container p-5">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="card mb-4 text-black">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-center">
                                <img src="{{asset('assets/default-profile.webp')}}" alt="avatar"
                                class="rounded-circle img-fluid" style="width: 50px;">
                            </div>
                            <h5 class="my-3 fs-3 fw-bold text-alt">{{$user->name}}</h5>
                            <label class="fw-bold">Email: </label>
                            <p class="m-2 rounded-5 p-2 border border-1 border-dark" style="background-color: rgb(232, 232, 232);">{{ substr($user->email, 0, -3) . 'com' }}</p>
                            <label class="fw-bold">Gruppi: </label>
                            {{-- Mostra i gruppi utente --}}
                            @php
                                $stringa = $user->groups;

                                // Divide la stringa in un array utilizzando il trattino come delimitatore
                                $arrayDiStringhe = explode(" - ", $stringa);

                                // Unisce l'array in una nuova stringa con il carattere di nuova riga come delimitatore
                                $nuovaStringa = implode('<br>', $arrayDiStringhe);

                                // Stampa la nuova stringa
                            @endphp

                            <p class="m-2 rounded-5 p-2 border border-1 border-dark text-start d-flex justify-content-center" style="background-color: rgb(232, 232, 232);">{!! $nuovaStringa !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-Layouts.layoutDash>