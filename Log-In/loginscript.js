
const container = document.getElementById('container');
const signUpBtn = document.getElementById('signUp');
const signInBtn = document.getElementById('signIn');

const addAnimation = (button) => {
    button.classList.add('button-animated');
    button.addEventListener('animationend', () => {
    button.classList.remove('button-animated');
    }, {once: true});
};

signUpBtn.addEventListener('click', () => {
    container.classList.add('right-panel-active');
    addAnimation(signUpBtn);
});

signInBtn.addEventListener('click', () => {
    container.classList.remove('right-panel-active');
    addAnimation(signInBtn);
});


function showToast(message) {
    const toast = document.getElementById("toast");
    toast.textContent = message;
    toast.classList.add("show");

    setTimeout(() => {
        toast.classList.remove("show");
    }, 3000);
}


document.getElementById("registerForm").addEventListener("submit", function (e) {
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    let errors = [];

    if (name === "") {
        showToast("Ju lutem vendosni emrin!");
    } else if (!/^[a-zA-Z]+$/.test(name)) {
        showToast("Emri duhet te permbaje vetem shkronja!");
    } else if (name.length < 3) {
        showToast("Emri duhet te kete te pakten 3 shkronja!");
    }

    const emailPattern = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
    if (!emailPattern.test(email)) {
        showToast("Ju lutem vendosni nje email te vlefshem!");
    }

    const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    if (!passwordPattern.test(password)) {
        showToast("Fjalekalimi duhet te permbaje te pakten 8 karaktere, nje shkronje te madhe, nje te vogel dhe nje numer!");
    }

    if (errors.length > 0) {
        e.preventDefault(); 
        showToast(errors.join("\n"));
    }
});

document.getElementById("loginForm").addEventListener("submit", function (e) {
    const email = document.getElementById("loginEmail").value.trim();
    const password = document.getElementById("loginPassword").value.trim();
    let errors = [];

    const emailPattern = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
    if (!emailPattern.test(email)) {
        showToast("Ju lutem vendosni nje email te vlefshem!");
    }

    if (password === "") {
        showToast("Ju lutem vendosni fjalekalimin!");
    }

    if (errors.length > 0) {
        e.preventDefault(); 
        showToast(errors.join("\n"));
    }
});
