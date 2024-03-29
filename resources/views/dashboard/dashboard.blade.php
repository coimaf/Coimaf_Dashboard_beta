<x-Layouts.layoutDash>
  <div class="container-fluid p-5">
    <div class="row justify-content-start mx-auto align-items-center">
      @if(Str::contains(auth()->user()->groups, 'GESTIONALE-Ticket'))
      <div class="col-md-3 my-2">
        <div class="container-filter-home card text-black" style="width: 100%;">
          <h4 class="card-title text-center py-3 text-uppercase fw-bold" style="color: #ffffff; background-color: #081B49;">Tickets</h4>
          <div class="container">
            <div class="row flex-column justify-content-center align-items-center">
              <div class="col-md-4 w-100 d-flex align-items-center">
                <a href="{{ route('dashboard.tickets.index', ['status' => 'Aperto']) }}" class="text-decoration-none text-dark">
                  <div class="card-custom card m-2 text-success fw-bold">
                    <div class="card-body"> 
                      <p class="card-text"><i class="bi pe-3 bi-envelope-open fs-4 fs-md-1"></i> Aperti: {{ $openTicketsCount }}</p>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-md-4 w-100 d-flex align-items-center">
                <a href="{{ route('dashboard.tickets.index', ['status' => 'In attesa di un ricambio']) }}" class="text-decoration-none text-dark">
                  <div class="card-custom card m-2 text-warning fw-bold">
                    <div class="card-body text-center">
                      <p class="card-text"><i class="bi pe-2 bi-arrow-clockwise fs-4 fs-md-1"></i> In attesa di Ricambio: {{ $waitingForSparePartsCount }}</p>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-md-4 w-100 d-flex align-items-center">
                <a href="{{ route('dashboard.tickets.index', ['urgent' => true]) }}" class="text-decoration-none text-dark">
                  <div class="card-custom card m-2 text-danger fw-bold">
                    <div class="card-body text-center">
                      <p class="card-text"><i class="bi pe-3 bi-exclamation-octagon-fill fs-4 fs-md-1"></i> Urgenti: {{ $urgentTicketsCount }}</p>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif
      @if(Str::contains(auth()->user()->groups, 'GESTIONALE-Scadenzario'))
      <div class="col-md-3 my-2">
        <div class="card container-filter-home text-black" style="width: 100%;">
            <h4 class="card-title text-center py-3 text-uppercase fw-bold" style="color: #ffffff; background-color: #081B49;">Scadenze</h4>
            <div class="container p-3">
                <div class="row flex-column">
                    <div class="col-md-6 w-100 d-flex align-items-center">
                        <a href="{{ route('dashboard.deadlines.index', ['inscadenza' => true]) }}" class="text-decoration-none text-dark">
                            <div class="card-custom card text-warning fw-bold">
                                <div class="card-body">
                                    <p class="card-text"><i class="bi pe-3 bi-exclamation-triangle-fill fs-4 fs-md-1"></i> In scadenza: {{ $expiringDeadlinesCount }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 w-100 d-flex align-items-center">
                        <a href="{{ route('dashboard.deadlines.index', ['scadute' => true]) }}" class="text-decoration-none text-dark">
                            <div class="card-custom card text-danger fw-bold">
                                <div class="card-body">
                                    <p class="card-text"><i class="bi pe-3 bi-x-circle-fill fs-4 fs-md-1"></i> Scaduti: {{ $expiredDeadlinesCount }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(Str::contains(auth()->user()->groups, 'GESTIONALE-Sottoscorta'))
    <div class="col-md-3 my-2">
      <div class="card container-filter-home text-black" style="width: 100%;">
          <h4 class="card-title text-center py-3 text-uppercase fw-bold" style="color: #ffffff; background-color: #081B49;">Articoli sottoscorta</h4>
          <div class="container p-3">
              <div class="row flex-column">
                  <div class="col-md-6 w-100 d-flex align-items-center">
                      <a href="{{ route('items_under_stock')}}" class="text-decoration-none text-dark">
                          <div class="card-custom card text-warning fw-bold">
                              <div class="card-body">
                                  <p class="card-text"><i class="bi pe-3 bi-exclamation-triangle-fill fs-4 fs-md-1"></i> Sottoscorta: {{count($itemsUnderstock)}}</p>
                              </div>
                          </div>
                      </a>
                  </div>
              </div>
          </div>
      </div>
  </div>
  @endif
  @if(Str::contains(auth()->user()->groups, 'GESTIONALE-Flotta'))
      <div class="col-md-3 my-2">
        <div class="card container-filter-home text-black" style="width: 100%;">
            <h4 class="card-title text-center py-3 text-uppercase fw-bold" style="color: #ffffff; background-color: #081B49;">Flotta</h4>
            <div class="container p-3">
                <div class="row flex-column">
                    <div class="col-md-6 w-100 d-flex align-items-center">
                        <a href="{{ route('dashboard.vehicles.index', ['inscadenza' => true]) }}" class="text-decoration-none text-dark">
                            <div class="card-custom card text-warning fw-bold">
                                <div class="card-body">
                                    <p class="card-text"><i class="bi pe-3 bi-exclamation-triangle-fill fs-4 fs-md-1"></i> In scadenza: {{ $expiringVehiclesCount }} </p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 w-100 d-flex align-items-center">
                        <a href="{{ route('dashboard.vehicles.index', ['scaduti' => true]) }}" class="text-decoration-none text-dark">
                            <div class="card-custom card text-danger fw-bold">
                                <div class="card-body">
                                    <p class="card-text"><i class="bi pe-3 bi-x-circle-fill fs-4 fs-md-1"></i> Scaduti: {{ $expiredVehiclesCount }} </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    </div>
  </div>
</x-Layouts.layoutDash>

<style>
.card-custom {
  box-shadow: none;
}

.container-filter-home{
  min-height: 300px;
}
</style>
