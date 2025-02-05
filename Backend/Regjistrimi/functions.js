function validate_name(name){
    let element = document.getElementById("name");
    let elementError = document.getElementById("nameerror");

    let regName = /^[a-zA-Z]+$/;

    if(name === '' || name == null){
        element.style.borderColor = "red";
        elementError.innerHTML = "Ju lutem vendosni emrin!";
    }else if(! regName.test(name)){
        element.style.borderColor = "red";
        elementError.innerHTML = "Emri duhet te permbaje vetem shkronja!";
    }else if(name.length < 3){
        element.style.borderColor = "red";
        elementError.innerHTML = "Emri duhet te permbaje te pakten 3 shkronja!";
    }else{
        element.style.borderColor = "green";
        elementError.innerHTML = "";
    }
}


function validate_email(email){
    let element = document.getElementById("email");
    let elementError = document.getElementById("emailerror");

    let regEmail = /^[A-Za-z0-9+_.-]+@(.+)+\.com$/;

    if(email === '' || email == null){
        element.style.borderColor = "red";
        elementError.innerHTML = "Ju lutem vendosni emailin!";
    }else if(!regEmail.test(email)){
        element.style.borderColor = "red";
        elementError.innerHTML = "Emaili qe ju vendoset nuk eshte ne formatin e duhur! Formati i kerkuar: username@domainname.com";
    }else{
        elementError.innerHTML = "";
        element.style.borderColor = "green";
    }
}

function validate_password(password){
    let element = document.getElementById("password");
    let elementError = document.getElementById("passworderror");

    let regPass = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;

    if(password === '' || password == null){
        element.style.borderColor = "red";
        elementError.innerHTML = "Ju lutem vendosni fjalekalimin!";
    }else if(!regPass.test(password)){
        element.style.borderColor = "red";
        elementError.innerHTML = "Fjalekalimi duhet te permbaje nje shkronje te madhe, nje shkronje te vogel, nje numer dhe te pakten 8 karaktere!";
    }else{
        elementError.innerHTML = "";
        element.style.borderColor = "green";
    };
}

function appendValidationError(elementId,message){
    $(`#${elementId}error`).text(message);
}

function showToast(message, type = "success") {
    const toast = document.getElementById("toast");
    toast.textContent = message;

    if (type === "error") {
        toast.classList.add("error");
    } else {
        toast.classList.add("success");
    }

    toast.classList.add("show");

    setTimeout(() => {
        toast.classList.remove("show", "error", "success");
    }, 3000);
}



