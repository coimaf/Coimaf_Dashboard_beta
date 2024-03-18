<x-Layouts.layoutDash>

    <x-allert />
    
    <div class="col-12 col-md-11 d-flex justify-content-end w-100">
        <a href="{{route('dashboard.machinesSolds.create')}}"><x-Buttons.buttonBlue type="button" props="NUOVO" /></a>
    </div>

      <x-table :columnTitles="$columnTitles" :rowData="$machines" :direction="$direction" :sortBy="$sortBy" :routeName="$routeName">
        <tr class="align-middle">
            <th colspan="{{ count($columnTitles) }}">
                <form class="d-flex" action="{{ route('dashboard.machinesSolds.index') }}" method="GET">
                    <input type="search" class="form-control me-2" placeholder="Cerca" name="machinesSearch" value="{{ request('query') }}">
                    <x-Buttons.buttonBlue type='submit' props='Cerca' />
                </form>
            </th>
        </tr>
        <tbody>
            @foreach ($machines as $machine)
            <tr class="align-middle">
                <td class="ps-3 py-2">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{route('dashboard.machinesSolds.show', compact('machine'))}}">
                        {{ $machine->codeArticle }}
                    </a>
                </td>
                <td class="ps-3 py-2">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{route('dashboard.machinesSolds.show', compact('machine'))}}">
                        {{ substr($machine->model, 0, 30) . '...'  }}
                    </a>
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{route('dashboard.machinesSolds.show', compact('machine'))}}">
                        {{ $machine->brand }}
                    </a>
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{route('dashboard.machinesSolds.show', compact('machine'))}}">
                        {{ $machine->serial_number }}
                    </a>
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{route('dashboard.machinesSolds.show', compact('machine'))}}">
                        {{ $machine->buyer }}
                    </a>
                </td>
                <td class="ps-3">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{route('dashboard.machinesSolds.show', compact('machine'))}}">
                        {{ $machine->warrantyType->name }}
                    </a>
                </td>
                <td class="ps-3">
                    @if($machine->sale_date)
                        <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.machinesSolds.show', compact('machine')) }}">
                            {{ \Carbon\Carbon::parse($machine->sale_date)->format('d-m-Y') }}
                        </a>
                    @endif
                </td>
                
                <td class="ps-4">
                    <a href="{{ route('dashboard.machinesSolds.edit', $machine->id) }}">
                        <i class='bi bi-pencil-square text-warning'></i>
                    </a>                    
                </td>
            </tr>
            @endforeach
        </tbody>
        </x-table>

        <x-pagination :props="$machines" />

</x-Layouts.layoutDash>
    