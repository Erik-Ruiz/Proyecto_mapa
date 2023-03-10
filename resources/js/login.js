//Errores (llevan a la pagina de login)
function repenombre(){
    Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Ese usuario ya exsiste!',
  })
}

function campovacio(){
    Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Rellena todo los campos!',
  })
}

function repenombre(){
    Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Utiliza un correo válido!',
  })
}

function repenombre(){
    Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Contraseñas incorrectas!',
  })
}

//Usuario introducido

function repenombre(){
    Swal.fire({
        icon: 'success',
        title: 'Usuario registrado y logueado!',
        showConfirmButton: false,
        timer: 1500
      })
}