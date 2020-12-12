let loginFormState = false;
let loginForm = document.getElementById('login-form');
let loginRef = document.getElementById('login-ref');

function toggleLoginForm() {
    if(loginForm) {
        loginForm.classList.toggle('profile-form-inactive');
        loginRef.classList.toggle('profile-form-active-ref');
        loginFormState = false;
    } 
    else {
        loginRef.classList.toggle('profile-form-active-ref');
        loginForm.classList.toggle('profile-form-inactive');
        loginFormState = true;
    }
}