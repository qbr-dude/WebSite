let loginDivState = false;
let registrationState = false;
let basketDivState = false;

let addEditDivState = false;
let editFormState = false;
let addFormState = true;

let loginDiv = document.getElementById('login-div');
let loginRef = document.getElementById('login-ref');
let loginForm = document.getElementById('login-form');
let registrationForm = document.getElementById('registration-form');
let basketDiv = document.getElementById('basket-div');
let basketRef = document.getElementById('basket-ref');

let addEditlayout = document.getElementById('add-edit');
let editForm = document.getElementById('edit-form');
let addForm = document.getElementById('add-form');

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

function toggleBasket() {
    if(basketDivState) {
        basketDiv.classList.toggle('profile-form-inactive');
        basketRef.classList.toggle('basket-form-active-ref');
        basketDivState = false;
    }
    else {
        basketDiv.classList.toggle('profile-form-inactive');
        basketRef.classList.toggle('basket-form-active-ref');
        basketDivState = true;
    }
}

function callEditForm() {
    
}

document.addEventListener('click', function(event) {
    if (!loginRef.contains(event.target) && !loginDiv.contains(event.target)) {
        loginDiv.classList.add('profile-form-inactive');
        loginRef.classList.remove('profile-form-active-ref');
    }
    if (!basketRef.contains(event.target) && !basketDiv.contains(event.target)) {
        basketDiv.classList.add('profile-form-inactive');
        basketRef.classList.remove('basket-form-active-ref');
    }
}, true);