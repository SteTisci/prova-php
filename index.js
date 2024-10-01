const loginBtn = document.querySelector(".login");
const registerBtn = document.querySelector(".register");
const loginForm = document.querySelector(".login-form");
const registerForm = document.querySelector(".register-form");
const changeLogin = document.querySelector(".change-form-login");
const changeRegister = document.querySelector(".change-form-register");

loginBtn.addEventListener("click", () => {
  registerForm.classList.remove("active");
  changeRegister.classList.remove("active");

  loginForm.classList.add("active");
  changeLogin.classList.add("active");
});

registerBtn.addEventListener("click", () => {
  loginForm.classList.remove("active");
  changeLogin.classList.remove("active");

  registerForm.classList.add("active");
  changeRegister.classList.add("active");
});
