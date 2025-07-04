<!DOCTYPE html>
<html lang="es">
<head>
{{-- Bootstrap CSS --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@stack('scripts')

<head>
  <!-- jQuery y Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  @stack('scripts')  <!-- Para cargar los scripts de las secciones hijas -->
</head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Administración')</title>
    
    {{-- CDN FullCalendar --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
    
    {{-- Estilos personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <main class="main-content" style="flex-grow: 1; padding: 20px; background-color: #f4f6f9;">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/es.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')

    
</body>
</html>