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
        <a href="{{ route('dashboard.deadlines.create') }}"><x-Buttons.buttonBlue type="button" props="NUOVO" /></a>
    </div>
    
    
    <x-table :columnTitles="$columnTitles" :rowData="$deadlines">
        <tbody>
            @foreach ($deadlines as $deadline)
            <tr class="text-center align-middle">
                <td class="py-4"><a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.deadlines.show', compact('deadline')) }}">{{ $deadline->name }}</a></td>
                
                <td class="py-4">
                    @foreach ($deadline->documentDeadlines as $document)
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.deadlines.show', compact('deadline')) }}">{{  Carbon\Carbon::parse($document->expiry_date)->format('d-m-Y') }}</a>
                    @endforeach
                </td>
                
                <td class="py-4">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.deadlines.show', compact('deadline')) }}">
                        @foreach ($deadline->tags as $tag)
                        <span class="badge bg-primary">{{ $tag->name }}</span>
                        @endforeach
                        
                    </a>
                </td>
                
                <td>
                    <a href='{{route('dashboard.deadlines.edit', compact('deadline'))}}'>
                        <i class='bi bi-pencil-square text-warning'></i>
                    </a>
                </td>
                
                <td>
                    <button type="button" class="btn bi bi-trash3-fill text-danger" data-bs-toggle="modal" data-bs-target="#deleteDeadlineModal{{ $deadline->id }}"></button>
                    
                    <form action="{{route('dashboard.deadlines.destroy', compact('deadline'))}}" method="post">
                        @csrf
                        @method('delete')
                        <!-- Modal -->
                        <div class="modal fade" id="deleteDeadlineModal{{ $deadline->id }}" tabindex="-1" aria-labelledby="deleteDeadlineModalLabel{{ $deadline->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-black" id="deleteDeadlineModalLabel{{ $deadline->id }}">Conferma eliminazione dipendente</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-black" id="DeadlineInfoContainer{{ $deadline->id }}">
                                        Sicuro di voler eliminare <b>{{ $deadline->name }}</b>? <br>L'azione sarà irreversibile.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                        <form action="{{ route('dashboard.deadlines.destroy', compact('deadline')) }}" method="post">
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
    
</x-Layouts.layoutDash>
