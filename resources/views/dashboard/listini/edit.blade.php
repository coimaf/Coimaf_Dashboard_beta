<x-Layouts.layoutDash>
    {{-- @dd($listini) --}}
    <x-allert />

    <div class="container bg-white border border-2 rounded-3">
        <div class="row">
            <div class="col-2">
                <img class="border border-2 m-2 ms-0" width="100%" src="{{asset('assets\placeholder.png')}}" alt="img_product" />
            </div>
            <div class="col-10 my-auto">
                <p class="fs-4"><span class="fw-bold fs-4">Codice Articolo:</span> {{ $listino->Cd_AR }}</p>
                <p class="fs-4"><span class="fw-bold fs-4">Descrizione:</span> {{ $listino->Descrizione }}</p>
                <p class="fs-4"><span class="fw-bold fs-4">Marca:</span> {{$listino->Cd_ARMarca}}</p>
                <p class="fs-4"><span class="fw-bold fs-4">Unita' di misura:</span> {{$listino->Cd_ARMisura}}</p>
            </div>
        </div>
    </div>
    
    <form action="{{ route('dashboard.listini.update', $id) }}" method="POST" class="p-4" style="overflow: hidden;">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>Listino</th>
                        <th>Prezzo</th>
                        <th>Sconto</th>
                        <th>Revisione</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listini as $item)
                    <tr>
                        <td>{{ $item['descrizione'] }}</td>
                        <td>
                            <input class="form-control" type="text" name="prezzo[{{ $item['id_revisione'] }}]" value="{{ $item['prezzo'] ? number_format($item['prezzo'], 3) : null}}">
                        </td>
                        <td>
                            <input class="form-control" type="text" name="sconto[{{ $item['id_revisione'] }}]" value="{{ str_replace(',', '.', $item['sconto']) }}">
                        </td>
                        <td>{{ $item['revisione'] ?? 'Articolo non presente in revisione.' }}</td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            
            <div class="row py-3">
                <x-Buttons.buttonBlue type="submit" props="Salva" />
            </div>
        </div>
    </form>
    
    
</x-Layouts.layoutDash>