<x-Layouts.layoutDash>

    <x-allert />
    
    <div class="col-12 col-md-11 d-flex justify-content-end my-1 w-100">
        <a href="{{ route('dashboard.vehicles.create') }}"><x-Buttons.buttonBlue type="button" props="NUOVO" /></a>
    </div>
    
    <x-table :columnTitles="$columnTitles" :rowData="$vehicles">
        <tr class="ps-3 align-middle">
            <th colspan="{{ count($columnTitles) }}">
                <form class="d-flex" action="{{ route('dashboard.vehicles.index') }}" method="GET">
                    <input type="search" class="form-control me-2" placeholder="Cerca" name="vehicleSearch" value="{{ request('query') }}">
                    <x-Buttons.buttonBlue type='submit' props='Cerca' />
                </form>
            </th>
        </tr>
        <tbody>
            @foreach ($vehicles as $vehicle)
            <tr class="align-middle">

                <td class="ps-3">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.vehicles.show', compact('vehicle')) }}">{{ $vehicle->typeVehicle->name ?? ' ' }}</a>
                </td>

                <td class="ps-3">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.vehicles.show', compact('vehicle')) }}">{{ $vehicle->brand }}</a>
                </td>

                <td class="ps-3">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.vehicles.show', compact('vehicle')) }}">{{ $vehicle->model }}</a>
                </td>
                
                <td class="ps-2">
                    <a class="link-underline link-underline-opacity-0 link-dark text-uppercase" href="{{ route('dashboard.vehicles.show', compact('vehicle')) }}">{{ $vehicle->license_plate }}</a>
                </td>

                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark text-uppercase" href="{{ route('dashboard.vehicles.show', compact('vehicle')) }}">{{ $vehicle->chassis }}</a>
                </td>

                <td class="ps-5">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.vehicles.show', compact('vehicle')) }}">{{ \Carbon\Carbon::parse($vehicle->registration_year)->format('d-m-Y') }}</a>
                </td>
                
            <td class="ps-5">
                <a href='{{ route('dashboard.vehicles.edit', compact('vehicle')) }}'>
                    <i class='bi bi-pencil-square text-warning'></i>
                </a>
            </td>
            
            <td class="ps-4">
                <button type="button" class="btn bi bi-trash3-fill text-danger" data-bs-toggle="modal" data-bs-target="#deletevehicleModal{{ $vehicle->id }}"></button>
                
                <form action='{{ route('dashboard.vehicles.destroy', compact('vehicle')) }}' method="post">
                    @csrf
                    @method('delete')
                    <!-- Modal -->
                    <div class="modal fade" id="deletevehicleModal{{ $vehicle->id }}" tabindex="-1" aria-labelledby="deletevehicleModalLabel{{ $vehicle->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-black" id="deletevehicleModalLabel{{ $vehicle->id }}">Conferma eliminazione dipendente</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-black" id="vehicleInfoContainer{{ $vehicle->id }}">
                                    Sicuro di voler eliminare <b>{{ $vehicle->brand }} {{ $vehicle->model }}</b> con targa <b>{{ strtoupper($vehicle->license_plate) }}</b> ? <br>L'azione sarà irreversibile.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                    <form action='{{ route('dashboard.vehicles.destroy', compact('vehicle')) }}' method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Elimina</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</x-table>
{{-- <x-pagination :props="$vehicles" /> --}}

</x-Layouts.layoutDash>