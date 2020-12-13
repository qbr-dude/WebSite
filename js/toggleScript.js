let loginDivState = false;
let registrationState = false;

let loginDiv = document.getElementById('login-div');
let loginRef = document.getElementById('login-ref');
let loginForm = document.getElementById('login-form');
let registrationForm = document.getElementById('registration-form');

function toggleLoginForm() {
    if(loginDivState) {
        loginDiv.classList.toggle('profile-form-inactive');
        loginRef.classList.toggle('profile-form-active-ref');
        loginForm.classList.remove('profile-form-inactive');
        registrationForm.classList.add('profile-form-inactive');
        registrationState = false;
        loginDivState = false;
    } 
    else {
        loginRef.classList.toggle('profile-form-active-ref');
        loginDiv.classList.toggle('profile-form-inactive');
        loginDivState = true;
    }
}

function toggleRegistration() {
    if(registrationState) {
        loginForm.classList.toggle('profile-form-inactive');
        registrationForm.classList.toggle('profile-form-inactive');
        registrationState = false;
    }
    else {
        loginForm.classList.toggle('profile-form-inactive');
        registrationForm.classList.toggle('profile-form-inactive');
        registrationState = true;
    }
}