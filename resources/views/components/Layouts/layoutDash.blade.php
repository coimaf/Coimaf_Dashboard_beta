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
            <!-- Sidebar Toggle Button -->
            <div class="col-12 col-md-2 p-0 m-0">
                <button class="btn bg-primary-cust d-block d-lg-none mt-2 ms-4 mb-3 side-toggle" id="sidebarToggle">
                    <i class="bi bi-justify text-white fs-4"></i>
                </button>
                @if(auth()->check())
                    <x-sidebar :userName="auth()->user()->name" />
                @endif
            </div>
            <!-- Main Content -->
            <div class="col-sm-10 col-12">
                {{ $slot }}
            </div>
        </div>
    </div>
    <script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"
  ></script>
        @vite(['resources/js/app.js'])
    </body>
    </html>
    