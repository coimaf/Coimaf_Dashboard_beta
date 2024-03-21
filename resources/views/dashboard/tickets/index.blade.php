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
            <tr class="align-middle" style="--bs-table-bg: {{ $ticket->status === 'Chiuso' ? 'rgb(208, 208, 208)' : 'white' }}">
                <td class="ps-4 py-1">
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{route('dashboard.tickets.show', compact('ticket'))}}">
                        {{ $ticket->id }}
                    </a>
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{route('dashboard.tickets.show', compact('ticket'))}}">
                        {{ rtrim($ticket->descrizione) }}
                    </a>
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{route('dashboard.tickets.show', compact('ticket'))}}">
                        {{ $ticket->title }}
                    </a>
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{ route('dashboard.tickets.show', compact('ticket')) }}">
                        {{ $ticket->status }}
                    </a>                    
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 {{ $ticket->priority !== 'Urgente' ? 'link-dark' : '' }}" href="{{route('dashboard.tickets.show', compact('ticket'))}}" style="color: {{ $ticket->priority === 'Urgente' ? 'red' : 'inherit' }}; font-weight: {{ $ticket->priority === 'Urgente' ? 'bold' : 'inherit' }}">
                        {{ $ticket->priority }}
                    </a>
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{route('dashboard.tickets.show', compact('ticket'))}}">
                        {{ \Carbon\Carbon::parse($ticket->created_at)->format('d-m-Y') }}
                    </a>
                </td>
                <td>
                    <a class="link-underline link-underline-opacity-0 link-dark" href="{{route('dashboard.tickets.show', compact('ticket'))}}">
                        {{ $ticket->zona }}
                    </a>
                </td>
                <td>
                    @php
                    $currentYear = date('Y');
                    $saldo = DB::connection('mssql')
                    ->select('
                    SELECT
                    S.Cd_CF,
                    C.Descrizione AS CF_Descrizione,
                    T.DtReg,
                    S.ImportoDare,
                    S.ImportoAvere,
                    T.Descrizione AS CGMovT_Descrizione,
                    CASE
                    WHEN R.Id_CGMovR IS NULL THEN ?
                    ELSE U.Descrizione
                    END AS CGCausale_Descrizione,
                    T.NumRif,
                    D.NumFattura AS Sc_NumFattura,
                    D.DataFattura AS Sc_DataFattura,
                    D.DataScadenza AS Sc_DataScadenza
                    FROM (
                    SELECT
                    NULL AS Id_CGMovR,
                    CGMovR.Cd_CF AS Cd_CF,
                    SUM(CGMovR.ImportoE * SegnoDare) AS ImportoDare,
                    SUM(CGMovR.ImportoE * SegnoAvere) AS ImportoAvere,
                    1 AS IncludiInSaldo
                    FROM
                    CGMovT
                    INNER JOIN
                    CGMovR ON CGMovT.Id_CGMovT = CGMovR.Id_CGMovT
                    WHERE
                    1 = 0 /* non serve saldo precedente */
                    AND CGMovT.DtSaldo BETWEEN ? AND ?
                    AND CGMovR.Cd_CF IS NOT NULL
                    AND CGMovR.Cd_CF IN (
                    SELECT
                    Cd_CF
                    FROM
                    CF
                    WHERE
                    CGMovR.Cd_CF = ?
                    )
                    GROUP BY
                    CGMovR.Cd_CF
                    
                    UNION ALL
                    
                    SELECT
                    CGMovR.Id_CGMovR AS Id_CGMovR,
                    CGMovR.Cd_CF AS Cd_CF,
                    CGMovR.ImportoE * SegnoDare AS ImportoDare,
                    CGMovR.ImportoE * SegnoAvere AS ImportoAvere,
                    CASE
                    WHEN CGMovT.DtSaldo BETWEEN ? AND ? THEN 1
                    ELSE 0
                    END AS IncludiInSaldo
                    FROM
                    CGMovT
                    INNER JOIN
                    CGMovR ON CGMovT.Id_CGMovT = CGMovR.Id_CGMovT
                    WHERE
                    CGMovR.Cd_CF IS NOT NULL
                    AND CGMovT.DtReg BETWEEN ? AND ?
                    AND CGMovR.Cd_CF IN (
                    SELECT
                    Cd_CF
                    FROM
                    CF
                    WHERE
                    CGMovR.Cd_CF = ?
                    )
                    
                    UNION ALL
                    
                    SELECT
                    CGMovR.Id_CGMovR AS Id_CGMovR,
                    CGMovR.Cd_CF AS Cd_CF,
                    CGMovR.ImportoE * SegnoDare AS ImportoDare,
                    CGMovR.ImportoE * SegnoAvere AS ImportoAvere,
                    1 AS IncludiInSaldo
                    FROM
                    CGMovT
                    INNER JOIN
                    CGMovR ON CGMovT.Id_CGMovT = CGMovR.Id_CGMovT
                    WHERE
                    CGMovR.Cd_CF IS NOT NULL
                    AND CGMovT.DtSaldo BETWEEN ? AND ?
                    AND CGMovT.DtReg > ?
                    AND CGMovT.TipoCausale IN (?, ?)
                    AND CGMovR.Cd_CF IN (
                    SELECT
                    Cd_CF
                    FROM
                    CF
                    WHERE
                    CGMovR.Cd_CF = ?
                    )
                    ) AS S
                    LEFT JOIN CGMovR AS R ON S.Id_CGMovR = R.Id_CGMovR
                    LEFT JOIN CGMovT AS T ON R.Id_CGMovT = T.Id_CGMovT
                    LEFT JOIN CF AS C ON S.Cd_CF = C.Cd_CF
                    LEFT JOIN CGCausale AS U ON T.Cd_CGCausale = U.Cd_CGCausale
                    LEFT JOIN SC AS D ON R.Id_Sc = D.Id_Sc
                    ORDER BY
                    S.Cd_CF,
                    T.DtReg
                    ', ['Saldo Precedente', $currentYear . '-01-01', $currentYear . '-12-31', $ticket->cd_cf, $currentYear . '-01-01', $currentYear . '-12-31', $currentYear . '-01-01', $currentYear . '-12-31', $ticket->cd_cf, $currentYear . '-01-01', $currentYear . '-12-31', $currentYear . '-12-31', '9', 'F', $ticket->cd_cf]);
                    
                    $totaleDare = 0;
                    $totaleAvere = 0;

                    // Itera attraverso gli elementi dell'array di risultati
                    foreach ($saldo as $s) {
                        // Somma i valori Dare e Avere al totale
                        $totaleDare += floatval($s->ImportoDare);
                        $totaleAvere += floatval($s->ImportoAvere);
                    }

                    // Calcola la differenza tra Avere e Dare
                    $differenza = $totaleDare - $totaleAvere;

                    $colore = $differenza < 0 ? 'red' : 'green';
                    @endphp
                    <a class="link-underline link-underline-opacity-0 " href="{{route('dashboard.tickets.show', compact('ticket'))}}" style="color: {{ $colore }}">
                        
                        {{ number_format($differenza, 2) }}
                        
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

<style>
    .bg-close{
        background-color: rgb(208, 208, 208);
    }
</style>