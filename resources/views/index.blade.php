<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    {{-- Formulario login --}}
    <form method="POST" action="{{route('login')}}">
    @csrf
    <h2>Login</h2>
    <label for="">Usuario</label>
    <input type="text" name="username" placeholder="Escribe tu usuario">
    <label for="">Contraseña</label>
    <input type="password" name="password" placeholder="Escribe tu contraseña">
    <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>