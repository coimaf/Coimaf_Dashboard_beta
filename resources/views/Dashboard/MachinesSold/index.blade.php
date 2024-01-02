<x-Layouts.layoutDash>
    
    <div class="container d-flex justify-content-center">
        @if (session('success'))
        <div class="alert alert-success mt-5">
            {{ session('success') }}
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    
    <div class="col-12 col-md-11 d-flex justify-content-end mt-5">
        <a href="{{route('dashboard.machinesSolds.create')}}"><x-Buttons.buttonBlue type="button" props="NUOVO" /></a>
    </div>

      <x-table :columnTitles="$columnTitles" :rowData="$machines">
        <tbody>
            @foreach ($machines as $machine)
            <tr class="text-center align-middle">
                <td class="py-4">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="#">
                        {{ $machine->model }}
                    </a>
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="#">
                        {{ $machine->brand }}
                    </a>
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="#">
                        {{ $machine->current_owner }}
                    </a>
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="#">
                        {{ $machine->warrantyType->name }}
                    </a>
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="#">
                        {{ \Carbon\Carbon::parse($machine->warranty_expiration_date)->format('d-m-Y') }}
                    </a>
                </td>
                <td>
                    <a href='#'>
                        <i class='bi bi-pencil-square text-warning'></i>
                    </a>
                </td>
                <td>
                    <button type="button" class="btn bi bi-trash3-fill text-danger" data-bs-toggle="modal" data-bs-target="#deleteMachineModal{{ $machine->id }}"></button>
                    
                    <form action="#" method="post">
                        @csrf
                        @method('delete')
                        <!-- Modal -->
                        <div class="modal fade" id="deleteMachineModal{{ $machine->id }}" tabindex="-1" aria-labelledby="deleteMachineModalLabel{{ $machine->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-black" id="deleteMachineModalLabel{{ $machine->id }}">Conferma eliminazione dipendente</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-black" id="machineInfoContainer{{ $machine->id }}">
                                        Sicuro di voler eliminare <b>{{ $machine->model }} {{ $machine->brand }}</b>? <br>L'azione sarà irreversibile.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                        <form action="#" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">Elimina</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
            </tr>
            @endforeach
        </tbody>
        </x-table>


</x-Layouts.layoutDash>