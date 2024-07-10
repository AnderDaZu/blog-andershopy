<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    {{-- @livewireStyles --}}
</head>
<body>
    
    <h1 class="text-xl uppercase text-center font-semibold">Correo de prueba</h1>

    <p>Nombre: <span>{{ $data['name'] }}</span></p>

    <p>Email: <span>{{ $data['email'] }}</span></p>

    <p>Mensaje: <span>{{ $data['message'] }}</span></p>

</body>
</html>