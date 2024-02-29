<div class="sidebar">
    <main class="d-flex vh-100">
        <div class="d-flex flex-column p-3 text-bg-light " >
            <a class="py-3 text-center" href="{{ route('dash') }}"><img width="60%" src="{{ asset('assets/coimaf_logo.png') }}" alt="Logo_Coimaf"></a>
            {{-- <form class="d-flex" action="{{ route('dashboard.search') }}" method="GET">
                <input class="form-control me-2" type="search" placeholder="Cerca" aria-label="Search" name="searched">
                <x-Buttons.buttonBlue type='submit' props='Cerca' />
            </form> --}}
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('dash') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page">
                        <i class="bi bi-house-fill pe-2"></i>
                        Home
                    </a>
                </li>
                @if(Str::contains(auth()->user()->groups, 'GESTIONALE-Ticket'))
                <li class="nav-item">
                    <a href="{{ route('dashboard.tickets.index') }}" class="nav-link pb-0 {{ Request::is('tickets') ? 'active pb-2' : '' }}" aria-current="page">
                        <i class="bi bi-ticket-detailed pe-2"></i>
                        Tickets
                    </a>
                    <ul class="nav flex-column">
                        <li class="nav-item ps-4">
                            <a href="{{ route('dashboard.tickets.create') }}" class="nav-link pt-0 {{ Request::is('dashboard/tickets/crea') ? 'active pt-2' : '' }}" aria-current="page">
                                <i class="bi bi-plus-circle fs-6 pe-2"></i>
                                Nuovo Ticket
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(Str::contains(auth()->user()->groups, 'GESTIONALE-DbMacchine'))
                <li class="nav-item">
                    <a href="{{ route('dashboard.machinesSolds.index') }}" class="nav-link {{ Request::is('macchine-vendute') ? 'active' : '' }}" aria-current="page">
                        <i class="bi bi-grid-1x2 pe-2"></i>
                        Macchine installate
                    </a>                                        
                </li>
                @endif
                @if(Str::contains(auth()->user()->groups, 'GESTIONALE-Dipendenti'))
                <li class="nav-item">
                    <a href="{{ route('dashboard.employees.index') }}" class="nav-link {{ Request::is('dipendenti') ? 'active' : '' }}" aria-current="page">
                        <i class="bi bi-people-fill pe-2"></i>
                        Dipendenti
                    </a>
                </li>
                @endif
                @if(Str::contains(auth()->user()->groups, 'GESTIONALE-Scadenzario'))
                <li class="nav-item">
                    <a href="{{ route('dashboard.deadlines.index') }}" class="nav-link {{ Request::is('scadenzario') ? 'active' : '' }}" aria-current="page">
                        <i class="bi bi-file-earmark-medical-fill pe-2"></i>
                        Scadenzario
                    </a>
                </li>
                @endif
                @if(Str::contains(auth()->user()->groups, 'GESTIONALE-Sottoscorta'))
                <li class="nav-item">
                    <a href="{{ route('items_under_stock') }}" class="nav-link {{ Request::is('articoli-sotto-scorta') ? 'active' : '' }}" aria-current="page">
                        <i class="bi bi-box-seam pe-2"></i>
                        Articoli Sottoscorta
                    </a>
                </li>
                @endif
                @if(Str::contains(auth()->user()->groups, 'GESTIONALE-Flotta'))
                <li class="nav-item">
                    <a href="{{ route('dashboard.vehicles.index') }}" class="nav-link {{ Request::is('flotta') ? 'active' : '' }}" aria-current="page">
                        <i class="bi bi-car-front-fill pe-2"></i>
                        Flotta
                    </a>
                </li>
                @endif
                @if(Str::contains(auth()->user()->groups, 'GESTIONALE-FPC'))
                <li class="nav-item">
                    <a href="{{ route('dashboard.fpc.index') }}" class="nav-link {{ Request::is('fpc') ? 'active' : '' }}" aria-current="page">
                        <i class="bi bi-journal-richtext pe-2"></i>
                        FPC
                    </a>
                </li>
                @endif
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-black text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('assets/default-profile.webp') }}" alt="profile_photo" width="32" height="32" class="rounded-circle me-2">
                    <strong>{{ $userName }}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    @if(Str::contains(auth()->user()->groups, 'GESTIONALE-Impostazioni'))
                    <li><a class="dropdown-item" href="{{route('dashboard.settings.index')}}">Impostazioni</a></li>
                    @endif
                    <li><a class="dropdown-item" href="{{route('dashboard.profile')}}">Profilo</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            <button class="dropdown-item">Logout</button>
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.querySelector('.sidebar');
        const contentMain = document.querySelector('.content-main');
        const mainContent = document.querySelector('.main-content');
        
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            sidebar.classList.toggle('active');
            contentMain.classList.toggle('sidebar-active');
            
            // Aggiunta la logica per nascondere o mostrare il contenuto principale
            if (sidebar.classList.contains('active')) {
                mainContent.style.display = 'none';
            } else {
                mainContent.style.display = 'block';
            }
        });
        
        document.addEventListener('click', function (event) {
            if (!event.target.closest('.sidebar') && !event.target.closest('#sidebarToggle')) {
                sidebar.classList.remove('active');
                contentMain.classList.remove('sidebar-active');
                mainContent.style.display = 'block'; // Mostra il contenuto principale al di fuori della sidebar
            }
        });
        
        window.addEventListener('resize', function () {
            if (window.innerWidth > 991.98) {
                sidebar.classList.remove('active');
                contentMain.classList.remove('sidebar-active');
                mainContent.style.display = 'block'; // Mostra il contenuto principale quando la finestra è sufficientemente larga
            }
        });
    });
    
</script>


<style>
    @media print{
        
    .side-toggle{
        visibility: hidden;
    }
    }
</style>