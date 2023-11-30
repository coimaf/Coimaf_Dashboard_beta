<x-Layouts.layout>

    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-6">
                <div class="col-12">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <p class="text-danger mt-2 ms-4">{{$error}}</p>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        @method('post')

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" value="{{ old('username') }}" id="username" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <input type="submit" value="Login" class="btn btn-primary" />
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</x-Layouts.layout>
