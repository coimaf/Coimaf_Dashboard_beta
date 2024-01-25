<div class="container-fluid p-0">
   
            <div class="col-12 rounded-2 table-custom-padding">
                @if(count($rowData) > 0)
                <div class="table-responsive table-custom-padding">
                    <table class="table table-hover table-custom-padding">
                        <thead class="table-dark"> 
                            <tr class="text-center align-middle table-custom-padding">
                                @foreach ($columnTitles as $column)
                                <th class="table-custom-padding">
                                    @if (is_array($column) && array_key_exists('sortBy', $column) && array_key_exists('text', $column))
                                    <a class="link-light link-offset-2 link-underline link-underline-opacity-0" href="{{ route("$routeName", ['sortBy' => $column['sortBy'], 'direction' => ($direction == 'asc' && $sortBy == $column['sortBy']) ? 'desc' : 'asc']) }}">
                                            {{ $column['text'] }}
                                            @if ($sortBy == $column['sortBy'])
                                                <i class="bi bi-sort-{{ $direction == 'asc' ? 'up' : 'down' }}-alt"></i>
                                            @else
                                            <i class="bi bi-sort-down-alt"></i>
                                            @endif
                                        </a>
                                    @else
                                        {{ $column }}
                                    @endif
                                </th>
                            @endforeach
                            
                            </tr>
                        </thead>
                        {{ $slot }}
                    </table>
                </div>
                @else
                <div class="d-flex align-items-center justify-content-center" style="height: 77vh;">
                    <p class="text-center fs-4">Nessun dato disponibile.</p>
                </div>
                @endif
            </div>
        </div>


        <style>
            .table-custom-padding {
              padding: 3px!important;
              margin: 0!important; /* Adjust the padding value as needed */
              font-size: 12px;
              border-bottom-width: 0px;
              padding-top: 0px;
              padding-bottom: 0px;
              padding-right: 0px;
              padding-left: 0px;
            }
            .table > :not(caption) > * > *{
                padding: 0;
                margin: 0;
            }
          </style>