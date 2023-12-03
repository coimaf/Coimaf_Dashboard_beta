  @php
  $columnTitles = ["Nome", "Codice Fiscale", "Ruolo", "Documenti", "azione"];
  $rowData = ["Mario Rossi", "MRCRSS87P12ER342S", "Ufficio", "<i class='bi bi-check text-success fs-3'></i>", "<a href='#'><i class='bi bi-pencil-square text-warning'></i></a>"];
  @endphp


<x-Layouts.layoutDash>

  <div class="col-12 col-md-11 d-flex justify-content-end mt-5">
    <x-Buttons.buttonBlue props="NUOVO" />
  </div>

  <x-table
  :columnTitles="$columnTitles"
  :rowData="$rowData"
  />
</x-Layouts.layoutDash>
