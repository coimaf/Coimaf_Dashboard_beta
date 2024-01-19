<div class="container-fluid main-content p-0">
   
            <div class="col-12 rounded-2" style="overflow-y: scroll">
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
                        <tr class="text-center align-middle">
                            <th colspan="{{ count($columnTitles) }}">
                                <form class="d-flex" action="{{ route('dashboard.employees.index') }}" method="GET">
                                    <input type="search" class="form-control me-2" placeholder="Cerca" name="modelSearch" value="{{ request('query') }}">
                                    <x-Buttons.buttonBlue type='submit' props='Cerca' />
                                </form>
                            </th>
                        </tr>
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