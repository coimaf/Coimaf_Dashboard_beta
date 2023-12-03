<x-Layouts.layoutDash>
    
    @php
        $columnTitles = [];
        $rowData = [];
    @endphp
    
    <x-table
    :columnTitles="$columnTitles"
    :rowData="$rowData"
    />
</x-Layouts.layoutDash>