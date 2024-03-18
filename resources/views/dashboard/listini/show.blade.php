<x-Layouts.layoutDash>
    {{-- @dd($listino) --}}

    <x-allert />

    <div class="container my-5">
        <div class="row justify-content-around">
            <div class="col-4">
                <img class="border border-3 m-2" width="100%" src="{{asset('assets\placeholder.png')}}" alt="img_product" />
            </div>
            <div class="col-6 bg-white border border-2 rounded p-3">
                <p class="fs-4"><span class="fw-bold fs-4">Codice Articolo:</span> {{ $listino->Cd_AR }}</p>
                <p class="fs-4"><span class="fw-bold fs-4">Descrizione:</span> {{ $listino->Descrizione }}</p>
                <p class="fs-4"><span class="fw-bold fs-4">Marca:</span> {{$listino->Cd_ARMarca}}</p>
                <p class="fs-4"><span class="fw-bold fs-4">Unita' di misura:</span> {{$listino->Cd_ARMisura}}</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Listino</th>
                            <th class="text-end">Prezzo</th>
                            <th class="text-center">Sconto</th>
                            <th>Revisione</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listini as $item)
                        <tr>
                            <td>{{ $item['descrizione'] }}</td>
                            <td class="text-end">{{ $item['prezzo'] ? number_format($item['prezzo'], 2, ',', '') : '' }}</td>
                            <td class="text-center">{{ number_format($item['sconto'], 2, ',', '') ?? '' }}</td>
                            <td>{{ $item['revisione'] ?? 'Articolo non presente in revisione.' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <a href="{{route('dashboard.listini.edit', ['id' => $listino->Cd_AR])}}">
                    <button type="button" class="btn bg-primary-cust text-white btn-cust w-100 fs-4 mt-5">Modifica Prezzi</button>
                </a>
            </div>
        </div>
    </div>
</x-Layouts.layoutDash>