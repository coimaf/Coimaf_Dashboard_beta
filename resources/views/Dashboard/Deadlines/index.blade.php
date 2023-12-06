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
      <a href=""><x-Buttons.buttonBlue type="button" props="NUOVO" /></a>
    </div>
    
    
    <x-table :columnTitles="$columnTitles" :rowData="$deadlines">
        <tbody>
            @foreach ($deadlines as $deadline)
            
            <tr class="text-center align-middle">
                <td class="py-4">{{ $deadline->name }}</td>
                @foreach ($deadline->documentDeadlines as $document)    
                <td class="py-4">{{ Carbon\Carbon::parse($deadline->expiry_date)->format('d/m/Y') }}</td>
                @endforeach
                <td class="py-4">{{ $deadline->tag }}</td>
                {{-- <td class="py-4"><a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.deadlines.show', compact('deadline')) }}">{{ $deadline->name }} {{ $deadline->surname }}</a></td>
                
                <td class="text-uppercase"><a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.deadlines.show', compact('deadline')) }}">{{ $deadline->fiscal_code }}</a></td>
                
                <td><a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.deadlines.show', compact('deadline')) }}">{{ $deadline->role }}</a></td>
                --}}
                                                  
                
                {{-- <td>
                    <a href='{{route('dashboard.deadlines.edit', compact('employee'))}}'>
                        <i class='bi bi-pencil-square text-warning'></i>
                    </a>
                </td> --}}

                {{-- <td>
                    <button type="button" class="btn bi bi-trash3-fill text-danger" data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal{{ $employee->id }}"></button>
                    
                    <form action="{{route('dashboard.deadlines.destroy', compact('employee'))}}" method="post">
                        @csrf
                        @method('delete')
                        <!-- Modal -->
                        <div class="modal fade" id="deleteEmployeeModal{{ $employee->id }}" tabindex="-1" aria-labelledby="deleteEmployeeModalLabel{{ $employee->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-black" id="deleteEmployeeModalLabel{{ $employee->id }}">Conferma eliminazione dipendente</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-black" id="employeeInfoContainer{{ $employee->id }}">
                                        Sicuro di voler eliminare <b>{{ $employee->name }} {{ $employee->surname }}</b>? <br>L'azione sarà irreversibile.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                        <form action="{{ route('dashboard.deadlines.destroy', compact('employee')) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">Elimina</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </td> --}}
            </tr>
            @endforeach
        </tbody>
    </x-table>
    
  </x-Layouts.layoutDash>
  