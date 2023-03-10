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
    <br><br>
    {{-- Formulario Registrar --}}
    <form method="POST" action="{{route('register')}}">
    @csrf
    <h2>Registrarse</h2>
    <label for="">Usuario</label>
    <input type="text" name="username" placeholder="Escribe tu usuario">
    <br>
    <label for="">Nombre</label>
    <input type="text" name="nombre" placeholder="Escribe tu nombre">
    <br>
    <label for="">Apellidos</label>
    <input type="text" name="apellidos" placeholder="Escribe tu apellido">
    <br>
    <label for="">Correo</label>
    <input type="text" name="correo" placeholder="Escribe tu correo">
    <br>
    <label for="">Grupo</label>
    <select name="grupo">
        <option value="1">1</option>
    </select>
    <br>
    <label for="">Contraseña</label>
    <input type="password" name="password" placeholder="Escribe tu contraseña">
    <br>
    <label for="">Repita la contraseña</label> 
    <input type="password" name="passwordrepetida" placeholder="Repite la contraseña">
    <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>