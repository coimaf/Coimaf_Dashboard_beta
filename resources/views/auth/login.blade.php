<x-Layouts.layout>
    
    <div class="container container-login">
        <div class="row justify-content-center align-items-center vh-100">
            <div style="background-color:rgb(240, 240, 240) " class="col-md-6 p-5 rounded-5 shadow container-login">
                <div class="col-12 text-center">
                    
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        
                            @foreach ($errors->all() as $error)
                            <p class="text-danger message-error-login">{{$error}}</p>
                            @endforeach
                        
                    </div>
                    @endif
                    
                    <img width="50%" class="mb-5 logo-login" src="{{asset('assets/coimaf_logo.png')}}" alt="Logo Coimaf">
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        @method('post')
                        
                        <div class="mb-3">
                            <label for="username" class="form-label fs-5">Username</label>
                            <input type="text" name="username" value="{{ old('username') }}" id="username" class="form-control" />
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label fs-5">Password</label>
                            <input type="password" name="password" id="password" class="form-control" />
                        </div>
                        
                        <div class="mb-3">
                            <input type="submit" value="Login" class="btn text-white w-100 my-2 py-3" style="background-color: #081B49" />
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</x-Layouts.layout>

<style>
    .container-login{
        padding: 10px 30px 0 30px!important;
    }
    
    @media (max-width: 769px) {
        .message-error-login{
            font-size: 0.6rem;
            margin:auto
        }
    }
</style>