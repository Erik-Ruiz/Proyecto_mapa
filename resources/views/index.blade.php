<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
	<!-- CSS -->
	<link rel="stylesheet" href="{!! asset('../resources/css/register.css') !!}">
</head>
<body>
<div class="form-structor">
	<div class="signup">
		<h2 class="form-title" id="signup"><span>or</span>Sign up</h2>
		<div class="form-holder">
		<form method="POST" action="{{route('register')}}">
    		@csrf
			<input type="text" name="username" class="input" placeholder="Usuario">
			<input type="text" name="nombre" class="input" placeholder="Nombre">
			<input type="text" name="apellidos" class="input" placeholder="Apellido">
			
			
			<select class="select_etiquetas" id="grupo" name="grupo">
				@foreach ($grupos as $grupo)
					<option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
				@endforeach
			</select> 
			
			<input type="text" name="correo" class="input" placeholder="Correo">
			<input type="password" name="password" class="input" placeholder="Escribe tu contraseña">
			<input type="password" name="passwordrepetida" class="input" placeholder="Repite la contraseña">
		</div>
		<button class="submit-btn" type="submit" value="Iniciar sesión">Sign up</button>
		</form>
	</div>
	<div class="login slide-up">
		<div class="center">
			<h2 class="form-title" id="login"><span>or</span>Log in</h2>
			<div class="form-holder">
			<form method="POST" action="{{route('login')}}">
   				@csrf
				<input type="text" name="username" class="input" placeholder="Escribe tu usuario">

				<input type="password" name="password" class="input" placeholder="Escribe tu contraseña">

			</div>
			<button class="submit-btn">Log in</button>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="../resources/js/register.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@php
    if(isset($_GET['mensaje'])){
        $mensaje = $_GET['mensaje'];
        if($mensaje=="repenombre"){
           echo "<script>repenombre()</script>";
        }
        if($mensaje=="contranoval"){
           echo "<script>contraseñanoval()</script>";
        }
        if($mensaje=="correoinval"){
           echo "<script>correoinvalido()</script>";
        }
        if($mensaje=="rellenacampos"){
           echo "<script>campovacio()</script>";
        }
		if($mensaje=="usunoexsiste"){
           echo "<script>usunoexsiste()</script>";
        }
    }   
    @endphp
</body>
</html>