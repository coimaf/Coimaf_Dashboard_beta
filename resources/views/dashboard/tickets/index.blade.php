<x-Layouts.layoutDash>
    
    <x-allert />
    
    <div class="col-12 col-md-11 d-flex justify-content-end  my-1 w-100">
        <a href="{{route('dashboard.tickets.create')}}"><x-Buttons.buttonBlue type="button" props="NUOVO" /></a>
    </div>
    
    <x-table :columnTitles="$columnTitles" :direction="$direction" :sortBy="$sortBy" :routeName="$routeName" :rowData="$tickets">
        <tr class="ps-4 align-middle">
            <th colspan="{{ count($columnTitles) }}">
                <form class="d-flex" action="{{ route('dashboard.tickets.index') }}" method="GET">
                    <input type="search" class="form-control me-2" placeholder="Cerca" name="ticketsSearch" value="{{ request('query') }}">
                    <x-Buttons.buttonBlue type='submit' props='Cerca' />
                </form>
            </th>
        </tr>
        <tbody>
            @foreach ($tickets as $ticket)
            <tr class="align-middle">
                <td class="ps-4 py-1">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{route('dashboard.tickets.show', compact('ticket'))}}">
                        {{ $ticket->id }}
                    </a>
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{route('dashboard.tickets.show', compact('ticket'))}}">
                        {{ $ticket->title }}
                    </a>
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{route('dashboard.tickets.show', compact('ticket'))}}">
                        {{ rtrim($ticket->descrizione) }}
                    </a>
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{route('dashboard.tickets.show', compact('ticket'))}}">
                        {{ $ticket->zona }}
                    </a>
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{route('dashboard.tickets.show', compact('ticket'))}}">
                        {{ $ticket->status }}
                    </a>
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{route('dashboard.tickets.show', compact('ticket'))}}">
                        {{ $ticket->priority }}
                    </a>
                </td>
                <td class="ps-4">
                    <a href="{{ route('dashboard.tickets.edit', $ticket->id) }}">
                        <i class='bi bi-pencil-square text-warning'></i>
                    </a>                    
                </td>
                </tr>
                @endforeach
            </tbody>
        </x-table>
        <x-pagination :props="$tickets" />
        
    </x-Layouts.layoutDash>
    
