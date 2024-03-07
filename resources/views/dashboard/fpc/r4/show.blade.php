<x-Layouts.layoutDash>
    
    <div class="container-fluid px-4">
        <div class="row justify-content-end">
            <div class="col-3">
                <p class="card-footer fw-semibold mt-3">Creato da: {{$r4->user->name}}  il: {{$r4->created_at->format('d/m/Y')}} 
                    @if($r4->updated_by_id)
                    <br><br>Modificato da: {{$r4->updatedBy->name}} il: {{$r4->updated_at->format('d/m/Y')}}</p>
                    @endif
                    <a href="{{ route('dashboard.r4.edit', compact('r4')) }}" class="btn btn-warning float-end fs-4 mt-3 me-4">Modifica</a>
                </div>
            </div>
            <div class="row mx-3 g-3">
                
                <div class="col-12 col-md-4">
                    <label for="name">Nome</label>
                    <input value="{{$r4->name}}" type="text" name="name" class="form-control" readonly>
                </div>
                
                <div class="col-12 col-md-4">
                    <label for="type">Tipo</label>
                    <input value="{{$r4->typer4->name ?? ''}}" type="text" name="type" class="form-control" readonly>
                </div>
                
                <div class="col-12 col-md-4">
                    <label for="serial_number">Matricola</label>
                    <input value="{{$r4->serial_number}}" type="text" name="serial_number" class="form-control" readonly>
                </div>
                
                <div class="col-12 col-md-4">
                    <label for="assigned_to">Assegnato a</label>
                    <input value="{{$r4->assigned_to}}" type="text" name="assigned_to" class="form-control text-uppercase" readonly>
                </div>
                
                <div class="col-12 col-md-4">
                    <label for="control_frequency">Frequenza Controllo</label>
                    <input value="{{$r4->control_frequency}}" type="text" name="control_frequency" class="form-control text-uppercase" readonly>
                </div>
                
                <div class="col-12 col-md-4">
                    <label for="buy_date">Data Acquisto</label>
                    <input type="date" value="{{$r4->buy_date}}" name="buy_date" class="form-control" readonly>
                </div>
                
                <div class="col-12 col-md-12">
                    <label for="description">Descrizione</label>
                    <textarea name="description" class="form-control w-100" rows="4" style="resize: none;" readonly>{{ $r4->description }}</textarea>
                </div>
                
            </div>

            <div class="bg-white mt-3 border rounded-top-4">
                <h4 class="p-3 fw-semibold">Documenti</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data Esecuzione</th>
                                <th>Data Scadenza</th>
                                <th>Download</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($r4->documents as $document)
                            <tr>
                                <td>{{ $document->name }}</td>
                                <td>{{ $document->date_start ? \Carbon\Carbon::parse($document->date_start)->format('d-m-Y') : '' }}</td>
                                <td>{{ $document->expiry_date ? \Carbon\Carbon::parse($document->expiry_date)->format('d-m-Y') : '' }}</td>
                                <td>
                                    @if($document->file)
                                    <a class="link-underline link-underline-opacity-0 link-dark fw-bold" href="{{ asset("storage/{$document->file}") }}" download="">
                                        <i class="bi bi-download pe-2"></i> Download
                                    </a>
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            
            
        </x-Layouts.layoutDash>
        
        <style>
            .form-control:focus{
                border-color: #dee2e6;
                box-shadow: none;
            }
            
            .form-control{
                cursor: default;
            }
        </style>
        