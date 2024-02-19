<x-Layouts.layoutDash>
    
    <x-allert />
    
    <div class="col-12 col-md-11 d-flex justify-content-end my-1 w-100">
        <a href="{{ route('dashboard.fpc.r4.create') }}"><x-Buttons.buttonBlue type="button" props="NUOVO" /></a>
    </div>
    
    <x-table :columnTitles="$columnTitles" :rowData="$r4s" :direction="$direction" :sortBy="$sortBy" :routeName="$routeName">
        <tr class="ps-3 align-middle">
            <th colspan="{{ count($columnTitles) }}">
                <form class="d-flex" action="{{ route('dashboard.fpc.r4.index') }}" method="GET">
                    <input type="search" class="form-control me-2" placeholder="Cerca" name="r4Search" value="{{ request('query') }}">
                    <x-Buttons.buttonBlue type='submit' props='Cerca' />
                </form>
            </th>
        </tr>
        <tbody>
            @foreach ($r4s as $r4)
            <tr class="align-middle">
                
                <td class="ps-3">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.r4.show', compact('r4')) }}">{{ $r4->name }}</a>
                </td>
                
                <td class="ps-3">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.r4.show', compact('r4')) }}">{{ $r4->typer4->name ?? ' ' }}</a>
                </td>
                
                <td class="ps-3">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.r4.show', compact('r4')) }}">{{ $r4->serial_number }}</a>
                </td>
                
                <td class="ps-2">
                    <a class="link-underline link-underline-opacity-0 link-dark text-uppercase" href="{{ route('dashboard.r4.show', compact('r4')) }}">{{ $r4->assigned_to }}</a>
                </td>
                
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark text-uppercase" href="{{ route('dashboard.r4.show', compact('r4')) }}">{{ $r4->control_frequency }}</a>
                </td>
                
                <td class="ps-4">
                    @if ($r4->buy_date)
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.r4.show', compact('r4')) }}">{{ \Carbon\Carbon::parse($r4->buy_date)->format('d-m-Y') }}</a>
                    @endif
                </td>
                
                <td class="ps-3">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.r4.show', compact('r4')) }}"> 
                        <i data-mdb-tooltip-init title="{{ $r4->getDocumentStatuses()['tooltipText'] }}" class="{{ $r4->getDocumentStatuses()['icon'] }}"></i>
                    </a>
                </td>
                
                <td class="ps-5">
                    <a href='{{ route('dashboard.r4.edit', compact('r4')) }}'>
                        <i class='bi bi-pencil-square text-warning'></i>
                    </a>
                </td>
                
                <td class="ps-4">
                    <button type="button" class="btn bi bi-trash3-fill text-danger" data-bs-toggle="modal" data-bs-target="#deleter4Modal{{ $r4->id }}"></button>
                    
                    <form action='{{ route('dashboard.r4.destroy', compact('r4')) }}' method="post">
                        @csrf
                        @method('delete')
                        <!-- Modal -->
                        <div class="modal fade" id="deleter4Modal{{ $r4->id }}" tabindex="-1" aria-labelledby="deleter4ModalLabel{{ $r4->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-black" id="deleter4ModalLabel{{ $r4->id }}">Conferma eliminazione dipendente</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-black" id="r4InfoContainer{{ $r4->id }}">
                                        Sicuro di voler eliminare <b>{{ $r4->name }}</b>? <br>L'azione sarà irreversibile.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                        <form action='{{ route('dashboard.r4.destroy', compact('r4')) }}' method="post">
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
    <x-pagination :props="$r4s" />
    
</x-Layouts.layoutDash>