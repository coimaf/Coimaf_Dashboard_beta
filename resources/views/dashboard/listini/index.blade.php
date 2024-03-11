<x-Layouts.layoutDash>
    
    <x-table :columnTitles="$columnTitles" :rowData='$listini' :direction="$direction" :sortBy="$sortBy" :routeName="$routeName">
        <tr class="align-middle">
            <th colspan="{{ count($columnTitles) }}">
                <form class="d-flex" action="{{ route('dashboard.listini.index') }}" method="GET">
                    <input type="search" class="form-control me-2" placeholder="Cerca" name="searchListino" value="{{ request('query') }}">
                    <x-Buttons.buttonBlue type='submit' props='Cerca' />
                </form>
            </th>
        </tr>
        <tbody>
{{-- 
            @dd($listini) --}}
            @foreach ($listini as $listino)
            <tr class="align-middle">
                <td class="py-1">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.listini.show', ['id' => $listino->Cd_AR]) }}">
                        {{ $listino->Cd_AR }}
                    </a>
                </td>
                <td class="">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.listini.show', ['id' => $listino->Cd_AR]) }}">
                        {{ $listino->Descrizione }}
                    </a>
                </td>
                <td class="ps-4">
                    <a href="{{route('dashboard.listini.edit', ['id' => $listino->Cd_AR])}}">
                        <i class='bi bi-pencil-square text-warning'></i>
                    </a>                    
                </td>
            </tr>
            @endforeach
        </tbody>
        </x-table>
        
        <x-pagination :props="$listini" />

</x-Layouts.layoutDash>