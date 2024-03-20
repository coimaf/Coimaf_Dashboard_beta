<x-Layouts.layoutDash>
    
    <x-table :columnTitles="$columnTitles" :rowData="$results" :sortBy="$sortBy" :routeName="$routeName" :direction="$direction">
        <tr class="align-middle">
            <th colspan="{{ count($columnTitles) }}">
                <form class="d-flex" action="{{ route('items_under_stock') }}" method="GET">
                    <input type="search" class="form-control me-2" placeholder="Cerca" name="itemsUnderstockSearch" value="{{ request('query') }}">
                    <x-Buttons.buttonBlue type='submit' props='Cerca' />
                </form>
            </th>
        </tr>
        <tbody>
            @foreach ($results as $result)
            <tr class="align-middle">
                <td class="ps-3">
                    <p class="link-underline link-underline-opacity-0 link-dark">
                        {{ $id++ }}
                    </p>
                </td>
                <td class="ps-3">
                    <p class="link-underline link-underline-opacity-0 link-dark">
                        {{ $result->Cd_AR }}
                    </p>
                </td>
                <td class="ps-3">
                    <p class="link-underline link-underline-opacity-0 link-dark">
                        {{ $result->Descrizione }}
                    </p>
                </td>
                <td class="ps-3">
                    <p class="link-underline link-underline-opacity-0 link-dark">
                        {{ $result->Cd_ARMarca }}
                    </p>
                </td>
                <td class="ps-3">
                    <p class="link-underline link-underline-opacity-0 link-dark">
                        {{ $result->Cd_ARMisura }}
                    </p>
                </td>
                <td class="text-end  {{ $result->Quantita < 0 ? 'text-danger' : '' }}">
                    <p>
                        {{ str_replace('.', ',', number_format($result->Quantita, 2)) }}
                    </p>
                </td>
                <td class="text-end  {{ $result->ImpQ < 0 ? 'text-danger' : '' }}">
                    <p>
                        {{ str_replace('.', ',', number_format($result->ImpQ, 2)) }}
                    </p>
                </td>
                <td class="text-end  {{ $result->OrdQ < 0 ? 'text-danger' : '' }}">
                    <p>
                        {{ str_replace('.', ',', number_format($result->OrdQ, 2)) }}
                    </p>
                </td>
                <td class="text-end  {{ $result->QuantitaDisp < 0 ? 'text-danger' : '' }}">
                    <p>
                        {{ str_replace('.', ',', number_format($result->QuantitaDisp, 2)) }}
                    </p>
                </td>
                <td class="text-end  {{ $result->ScortaMinima < 0 ? 'text-danger' : '' }}">
                    <p>
                        {{ str_replace('.', ',', number_format($result->ScortaMinima, 2)) }}
                    </p>
                </td>
                <td class="text-end pe-3  {{ $result->SottoScortaQ < 0 ? 'text-danger' : '' }}">
                    <p class="link-underline link-underline-opacity-0 link-dark text-danger">
                        {{ str_replace('.', ',', number_format($result->SottoScortaQ, 2)) }}
                    </p>
                </td>
            </tr>
            @endforeach
        </tbody>
    </x-table>
    
    
</x-Layouts.layoutDash>