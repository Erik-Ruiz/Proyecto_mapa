var statusForm = true
var csrf_token = token.content

function changeStatusForm(){
    statusForm = !statusForm;
    if(statusForm){
        if(checkStatusdata()){
            editUser();
            return;
        }
    }
    document.getElementById("usernameForm").disabled = statusForm
    document.getElementById("nameForm").disabled = statusForm
    document.getElementById("surnameForm").disabled = statusForm
    document.getElementById("mailForm").disabled = statusForm
    document.getElementById("gruposForm").disabled = statusForm

}

function editUser(){
    username = document.getElementById("usernameForm").value
    nombre = document.getElementById("nameForm").value
    surname = document.getElementById("surnameForm").value
    email = document.getElementById("mailForm").value
    grupo = document.getElementById("gruposForm").value

    var ajax = new XMLHttpRequest();
    ajax.open('POST', "../editUser");
    var form = new FormData();
    form.append("_token", csrf_token)
    form.append("_method", "PUT")
    form.append("name", nombre)
    form.append("surname", surname)
    form.append("username", username)
    form.append("mail", email)
    form.append("group", grupo)

    ajax.onload = function(){
        if(ajax.responseText == "OK"){
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Usuario modificado correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        }else if(ajax.responseText == "ERROR"){
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Datos incorrectos',
                showConfirmButton: true,
            })
        }else if(ajax.responseText == "REPEUSER"){
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Nombre de usuario repetido',
                showConfirmButton: true,
            })
        }
        else if(ajax.responseText == "REPEMAIL"){
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Correo repetido',
                showConfirmButton: true,
            })
        }
        else{
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Ha ocurrido un error inesperado',
                showConfirmButton: true,
            })
        }
        document.getElementById("usernameForm").disabled = statusForm
        document.getElementById("nameForm").disabled = statusForm
        document.getElementById("surnameForm").disabled = statusForm
        document.getElementById("mailForm").disabled = statusForm
        document.getElementById("gruposForm").disabled = statusForm

    }
    ajax.send(form)
}

function checkStatusdata(){
    username = document.getElementById("usernameForm").value
    nombre = document.getElementById("nameForm").value
    surname = document.getElementById("surnameForm").value
    email = document.getElementById("mailForm").value
    grupo = document.getElementById("gruposForm").value

    if((username == null || username.length == 0 || /^\s+$/.test(username)) || (nombre == null || nombre.length == 0 || /^\s+$/.test(nombre)) || (surname == null || surname.length == 0 || /^\s+$/.test(surname)) || (email == null || email.length == 0 || /^\s+$/.test(email))){
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Datos incorrectos',
            showConfirmButton: true,
        })
        return false
    }
    return true
}