<x-Layouts.layoutDash>
    <div class="col-12 col-md-11 d-flex justify-content-end my-1 w-100">
        <a href="{{ route('dashboard.deadlines.create') }}"><x-Buttons.buttonBlue type="button" props="NUOVO" /></a>
    </div>
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
    
    
    
    
    <x-table :columnTitles="$columnTitles" :rowData="$deadlines" :direction="$direction" :sortBy="$sortBy" :routeName="$routeName">
        <tr class="text-center align-middle">
            <th colspan="{{ count($columnTitles) }}">
                <form class="d-flex" action="{{ route('dashboard.deadlines.index') }}" method="GET">
                    <input type="search" class="form-control me-2" placeholder="Cerca" name="deadlineSearch" value="{{ request('query') }}">
                    <x-Buttons.buttonBlue type='submit' props='Cerca' />
                </form>
            </th>
        </tr>
        <tbody>
            @foreach ($deadlines as $deadline)
            <tr class="text-center align-middle">
                <td class="py-4"><a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.deadlines.show', compact('deadline')) }}">{{ $deadline->name }}</a></td>
                
                <td class="py-4">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.deadlines.show', compact('deadline')) }}">
                        
                        @php
                        $status = $deadline->getStatus();
                        @endphp
                        
                        @if ($status === 'expired')
                        <i class="bi bi-dash-circle-fill text-danger fs-5 me-3"></i>
                        @elseif ($status === 'expiring_soon')
                        <i class="bi bi-exclamation-circle-fill text-warning fs-5 me-3"></i>
                        @else
                        <i class='bi bi-check-circle-fill text-success fs-5 me-3'></i>
                        @endif
                        
                        {{ Carbon\Carbon::parse($deadline->documentDeadlines->first()->expiry_date)->format('d-m-Y') }}
                        
                    </a>
                </td>
                
                
                <td class="py-4">
                    @foreach ($deadline->tags as $tag)
                    <a class="badge bg-primary link-underline link-underline-opacity-0" href="{{ route('dashboard.deadlines.tag', $tag->name) }}">{{ $tag->name }}</a>
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
