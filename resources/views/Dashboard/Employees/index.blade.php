  <x-Layouts.layoutDash>
    
    <div class="container d-flex justify-content-center">
      @if (session('success'))
      <div class="alert alert-success mt-5">
        {{ session('success') }}
      </div>
    @endif
    </div>
    
    <div class="col-12 col-md-11 d-flex justify-content-end mt-5">
      <a href="{{route('dashboard.employees.create')}}"><x-Buttons.buttonBlue type="button" props="NUOVO" /></a>
    </div>
    
    
    <x-table
      :columnTitles="$columnTitles"
      :rowData="$employees"
      :documentStatuses="$documentStatuses"

    />

  </x-Layouts.layoutDash>
  