var statusForm = true

function changeStatusForm(){
    statusForm = !statusForm;
    document.getElementById("usernameForm").disabled = statusForm
    document.getElementById("nameForm").disabled = statusForm
    document.getElementById("surnameForm").disabled = statusForm
    document.getElementById("mailForm").disabled = statusForm
}