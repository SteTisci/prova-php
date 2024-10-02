const loginBtn = document.querySelector(".login");
const registerBtn = document.querySelector(".register");
const loginForm = document.querySelector(".login-form");
const registerForm = document.querySelector(".register-form");
const changeLogin = document.querySelector(".change-form-login");
const changeRegister = document.querySelector(".change-form-register");

/* 
  This script manages the form currenty active, check which form was active before reloading the page and show it,
  for example if the login form is currently active and the user insert a wrong input,
  when the submit button is clicked the page will show the login form instead of the default register form with the error messages corresponding to the wrong inputs. 
*/

document.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => {
    registerForm.classList.add("active");
    changeLogin.classList.add("active");

    if (loginForm.classList.contains("active")) {
      registerForm.classList.remove("active");
      changeLogin.classList.remove("active");
    }
  }, 100);
});

loginBtn.addEventListener("click", () => {
  registerForm.classList.remove("active");
  changeLogin.classList.remove("active");

  loginForm.classList.add("active");
  changeRegister.classList.add("active");
});

registerBtn.addEventListener("click", () => {
  loginForm.classList.remove("active");
  changeRegister.classList.remove("active");

  registerForm.classList.add("active");
  changeLogin.classList.add("active");
});
