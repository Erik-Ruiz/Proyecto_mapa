console.clear();

const loginBtn = document.getElementById('login');
const signupBtn = document.getElementById('signup');

loginBtn.addEventListener('click', (e) => {
	let parent = e.target.parentNode.parentNode;
	Array.from(e.target.parentNode.parentNode.classList).find((element) => {
		if(element !== "slide-up") {
			parent.classList.add('slide-up')
		}else{
			signupBtn.parentNode.classList.add('slide-up')
			parent.classList.remove('slide-up')
		}
	});
});

signupBtn.addEventListener('click', (e) => {
	let parent = e.target.parentNode;
	Array.from(e.target.parentNode.classList).find((element) => {
		if(element !== "slide-up") {
			parent.classList.add('slide-up')
		}else{
			loginBtn.parentNode.parentNode.classList.add('slide-up')
			parent.classList.remove('slide-up')
		}
	});
});


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

function correoinvalido(){
    Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Utiliza un correo válido!',
  })
}

function contraseñanoval(){
    Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Contraseñas incorrectas!',
  })
}