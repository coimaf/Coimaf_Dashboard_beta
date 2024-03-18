<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{asset('./coimaf_favicon.png')}}" type="image/png">
    @vite(['resources/css/app.css'])
</head>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-2 p-0 m-0">
                @if(auth()->check())
                <x-sidebar :userName="auth()->user()->name" />
                    @endif
                </div>
                <!-- Sidebar Toggle Button -->
                <button class="btn bg-primary-cust d-lg-none side-toggle" id="sidebarToggle">
                    <i class="bi bi-justify text-white fs-4"></i>
                </button>
            <div class="col-12 col-md-10 p-0 m-0">
                <div class="rounded-3 m-2" style="background-color: rgb(243, 243, 243); height: 98vh;">
                    <div class="rounded-2 mt-1 p-1" style="overflow-y: scroll; overflow-x: hidden;">
                        {{ $slot }}
                    </div>
                </div> 
            </div>
                <!-- Main Content -->
            
            
        </div>
    </div>

        @vite(['resources/js/app.js'])
        <script>
            setTimeout(function() {
                window.location.reload(true);
            },  3600000); // Ricarica la pagina ogni ora (3,600,000 millisecondi)
        </script>
        
        <script
        type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"
        ></script>
    </body>
    </html>
    