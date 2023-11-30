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
        
        <x-navbar />

        {{ $slot }}


        @vite(['resources/js/app.js'])
    </body>
</html>
