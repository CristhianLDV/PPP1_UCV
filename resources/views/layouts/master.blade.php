<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

        <title>@yield('title', 'Panel de Control')</title>

        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        @include('layouts.head')


        <!-- FullCalendar CSS -->
        {{-- <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css" rel="stylesheet" /> --}}
        
                <!-- Estilos personalizados -->
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@vite(['resources/js/app.js'])




    </head>
<body>
    <div id="wrapper">
         @include('layouts.header')
         @include('layouts.sidebar')
         <div class="content-page">  
            <div class="content">
                <div class="container-fluid">
                   @include('layouts.settings')
                   @yield('content')
                </div> 
            </div> 
        </div> 
        @include('layouts.footer')  
        @include('layouts.footer-script')  
    </div> 
    @include('includes.flash')

    <!-- FullCalendar JS -->
{{-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.js"></script> --}}

    </body>
</html>