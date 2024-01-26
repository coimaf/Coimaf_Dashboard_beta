<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
    <div class="container-fluid ">
        <a class="navbar-brand" href="{{route('dash')}}"><img width="150px" src="{{ asset('assets/coimaf_logo.svg') }}" alt="Logo_Coimaf"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="btn bg-primary-cust text-white m-2" aria-current="page" href="{{route('dash')}}">Dashboard</a>
          </li>
          @guest
            <a href="{{route('login')}}"><button class="btn btn-primary">Login</button></a>
          @endguest
          @auth
          
            <form action="{{route('logout')}}" method="POST">
               <button class="btn btn-danger m-2">Logout</button>
                @csrf
            </form>
        
        @endauth
      </div>
    </div>
  </nav>