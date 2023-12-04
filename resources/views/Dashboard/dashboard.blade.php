<x-Layouts.layoutDash>
    
    @php
        $columnTitles = [];
        $rowData = [];
    @endphp
    
    <div class="container mt-5">
        <x-table
        :columnTitles="$columnTitles"
        :rowData="$rowData"
        />
    </div>
</x-Layouts.layoutDash>