<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-9 mt-3 p-0">
                <img width="240px;" src="{{ asset('assets/coimaf_logo.png') }}" alt="">
                <p style="color: #06205C; font-size: 11px; padding-top:10px;" class="fw-semibold">ARREDAMENTI REFRIGERAZIONE AERAULICA</p>
            </div>
            <div class="col-3 m-0 p-0 text-end">
                <p class="m-0 p-0" style="font-size: 8px;">COIMAF SRL</p>
                <p class="m-0 p-0" style="font-size: 8px;">VIA DEL LAVORO</p>
                <p class="m-0 p-0" style="font-size: 8px;">88060 SAN SOSTENE (CZ)</p>
                <p class="m-0 p-0" style="font-size: 8px;">Tel. 0967.522303</p>
                <p class="m-0 p-0" style="font-size: 8px;">info@coimaf.com</p>
                <p class="m-0 p-0" style="font-size: 8px;">www.coimaf.com</p>
            </div>
            <div class="col-12 ms-2 mt-1" style="font-size: 11px;">
                Ticket Numero {{$ticket->id}} del {{$ticket->created_at->format('d/m/Y')}}
            </div>
            <div class="col-12 m-0 p-0 mt-3">
                <p style="font-size: 11px; margin:2px;" class="fw-bold">{{$ticket->descrizione}}</p>
                @foreach ($customers as $customer)
                @php $numbers = ''; @endphp
                
                @if(isset($customer->Telefono) && $customer->Telefono !== null)
                @php $numbers .= preg_replace('/[^0-9]/', '', $customer->Telefono) . ' - '; @endphp
                @endif
                
                @if(isset($customer->Telefono2) && $customer->Telefono2 !== null)
                @php $numbers .= preg_replace('/[^0-9]/', '', $customer->Telefono2) . ' - '; @endphp
                @endif
                
                @if(isset($customer->Cellulare) && $customer->Cellulare !== null)
                @php $numbers .= preg_replace('/[^0-9]/', '', $customer->Cellulare) . ' - '; @endphp
                @endif
                
                @if(isset($customer->Cellulare2) && $customer->Cellulare2 !== null)
                @php $numbers .= preg_replace('/[^0-9]/', '', $customer->Cellulare2) . ' - '; @endphp
                @endif
                
                @if(!empty($numbers))
                <p style="font-size: 11px; margin:2px;">{!! rtrim($numbers, ' - ') !!}</p>
                @endif
                @endforeach
                
                
                @foreach ($indirizziFiltrati as $indirizzo)
                <p style="font-size: 11px; margin:2px;">{{ $indirizzo }}<br></p>
                @endforeach
                @foreach ($infoCustomers as $info)
                <p style="font-size: 11px; margin:2px;">{{$info->Città}}</p>
                @endforeach
            </div>
            <div class="col-9 m-0 p-0">
                <p style="font-size: 11px;" class="fw-bold mt-3">PROBLEMA: {{$ticket->title}} 
                    @isset($ticket->machinesSold->model)
                    - {{$ticket->machinesSold->model}}
                    @endisset
                    @isset($ticket->machinesSold->serial_number)
                    - {{$ticket->machinesSold->serial_number}}
                    @endisset
                </p>
            </div>
            <div class="col-3 m-0 p-0">
                <p style="text-align:end; font-size: 11px;" class="mt-3 fw-bold">Priorità {{$ticket->priority}}</p>
            </div>
            
            <hr class="hr-print">

            <p style="font-size: 11px;">{{$ticket->description}}</p>
            
            <div class="col-6 p-0" style="margin-top: 150px;">
                <p class="fw-bold" style="font-size: 11px;">SOLUZIONE</p>
            </div>
            
            <hr class="hr-print" style="margin-bottom: 130px;">
            
            <div class="col-6 p-0" style="margin-top: 65px;">
                <p class="m-0 p-0" style="font-size: 11px;">Data intervento __________________</p>
            </div>
            <div class="col-6 p-0 text-end" style="margin-top: 65px;">
                <p class="m-0 p-0" style="font-size: 11px;">Firma __________________</p>
            </div>
            
        </div>
    </div>
    
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<style>
    body{
        font-family: 'Lato', sans-serif;
    }
    
    .hr-print {
        border: 1px solid #000;
        margin-top: 2px;
    }
</style>