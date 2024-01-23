<div class="sidebar">
    <main class="d-flex w-100">
        <div class="d-flex flex-column p-3 text-bg-light w-100" >
            <a class="py-5" href="{{ route('home') }}"><img width="100%" src="{{ asset('assets/coimaf_logo.png') }}" alt="Logo_Coimaf"></a>
            <form class="d-flex" action="{{ route('dashboard.search') }}" method="GET">
                <input class="form-control me-2" type="search" placeholder="Cerca" aria-label="Search" name="searched">
                <x-Buttons.buttonBlue type='submit' props='Cerca' />
            </form>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('dash') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page">
                        <i class="bi bi-house-fill pe-2"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.employees.index') }}" class="nav-link {{ Request::is('dipendenti') ? 'active' : '' }}" aria-current="page">
                        <i class="bi bi-people-fill pe-2"></i>
                        Dipendenti
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.deadlines.index') }}" class="nav-link {{ Request::is('scadenzario') ? 'active' : '' }}" aria-current="page">
                        <i class="bi bi-file-earmark-medical-fill pe-2"></i>
                        Scadenzario
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.machinesSolds.index') }}" class="nav-link {{ Request::is('macchine-vendute') ? 'active' : '' }}" aria-current="page">
                        <i class="bi bi-grid-1x2 pe-2"></i>
                        Macchine Installate
                    </a>                                        
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.tickets.index') }}" class="nav-link {{ Request::is('tickets') ? 'active' : '' }}" aria-current="page">
                        <i class="bi bi-ticket-detailed pe-2"></i>
                        Tickets
                    </a>                                        
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-black text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('assets/default-profile.webp') }}" alt="profile_photo" width="32" height="32" class="rounded-circle me-2">
                    <strong>{{ $userName }}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="{{route('dashboard.settings.index')}}">Impostazioni</a></li>
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