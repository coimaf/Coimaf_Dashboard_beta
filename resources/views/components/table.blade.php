<div class="container-fluid main-content">
    <div class="row justify-content-center align-items-center">
        <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 rounded-3 mt-3" style="background-color: rgb(243, 243, 243); height: 80vh;">
            <div class="col-12 rounded-2 mt-3" style="max-height: 77vh; overflow-y: scroll">
                @if(count($rowData) > 0)
                <div class="table-responsive content-main">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr class="text-center align-middle">
                                @foreach ($columnTitles as $column)
                                <th>
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
    </div>
</div>
