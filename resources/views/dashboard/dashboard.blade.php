<x-Layouts.layoutDash>
  <div class="container-fluid p-5">
    <div class="row justify-content-center align-items-center">
      <div class="col-md-4 my-2">
        <div class="container-filter-home card text-black">
          <h4 class="card-title text-center py-3 text-uppercase fw-bold" style="color: #ffffff; background-color: #081B49;">Tickets</h4>
          <div class="container p-3">
            <div class="row flex-column justify-content-center align-items-center">
              <div class="col-md-4 d-flex align-items-center justify-content-center">
                <a href="{{ route('dashboard.tickets.index', ['status' => 'Aperto']) }}" class="text-decoration-none text-dark">
                  <div class="card-custom card m-2 text-success fw-bold">
                    <div class="card-body text-center">
                      <i class="bi bi-envelope-open fs-1"></i> 
                      <p class="card-text">Aperti: {{ $openTicketsCount }}</p>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-md-4 w-100 d-flex align-items-center justify-content-center">
                <a href="{{ route('dashboard.tickets.index', ['status' => 'In attesa di un ricambio']) }}" class="text-decoration-none text-dark">
                  <div class="card-custom card m-2 text-warning fw-bold">
                    <div class="card-body text-center">
                      <i class="bi bi-arrow-clockwise fs-1"></i>
                      <p class="card-text">In attesa di Ricambio: {{ $waitingForSparePartsCount }}</p>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-md-4 d-flex align-items-center justify-content-center">
                <a href="{{ route('dashboard.tickets.index', ['urgent' => true]) }}" class="text-decoration-none text-dark">
                  <div class="card-custom card m-2 text-danger fw-bold">
                    <div class="card-body text-center">
                      <i class="bi bi-exclamation-octagon-fill fs-1"></i>
                      <p class="card-text">Urgenti: {{ $urgentTicketsCount }}</p>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-4 my-2">
        <div class="card container-filter-home text-black">
            <h4 class="card-title text-center py-3 text-uppercase fw-bold" style="color: #ffffff; background-color: #081B49;">Scadenze</h4>
            <div class="container p-3">
                <div class="row flex-column align-items-center justify-content-center" style="margin: 15%;">
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <a href="{{ route('dashboard.deadlines.index', ['inscadenza' => true]) }}" class="text-decoration-none text-dark">
                            <div class="card-custom card m-2 text-warning fw-bold">
                                <div class="card-body text-center">
                                  <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                                    <p class="card-text">In scadenza: {{ $expiringDeadlinesCount }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <a href="{{ route('dashboard.deadlines.index', ['scadute' => true]) }}" class="text-decoration-none text-dark">
                            <div class="card-custom card m-2 text-danger fw-bold">
                                <div class="card-body text-center">
                                  <i class="bi bi-x-circle-fill fs-1"></i>
                                    <p class="card-text">Scaduti: {{ $expiredDeadlinesCount }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
      <div class="col-md-4 my-2">
        <div class="card container-filter-home text-black">
          <h4 class="card-title text-center py-3 text-uppercase fw-bold" style="color: #ffffff; background-color: #081B49;"> ............. </h4>
          <div class="container p-3">
            <div class="row flex-column align-items-center justify-content-center" style="margin: 15%;">
              <div class="col-md-6 d-flex align-items-center justify-content-center">
                <a href="#" class="text-decoration-none text-dark">
                  <div class="card-custom card m-2 text-black fw-bold">
                    <div class="card-body text-center">
                      <p class="card-text fs-1"> ... </p>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-md-6 d-flex align-items-center justify-content-center">
                <a href="#" class="text-decoration-none text-dark">
                  <div class="card-custom card m-2 text-black fw-bold">
                    <div class="card-body text-center">
                      <p class="card-text fs-1"> ... </p>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-Layouts.layoutDash>

<style>
.card-custom {
  box-shadow: none;
}

.container-filter-home{
  min-height: 400px;
}
</style>
