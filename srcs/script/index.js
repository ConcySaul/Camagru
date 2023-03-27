function switchSignUp() {
    var submit = document.getElementById("submit");
    var signUpForm = document.getElementById("signupForm");
    var loginForm = document.getElementById("loginForm");
    var switchButton = document.getElementById("switch");

    signUpForm.removeAttribute('hidden', false);
    loginForm .setAttribute('hidden', true);

    submit.value = "Signup";

    switchButton.value = "or Login";
    switchButton.setAttribute("onclick", "switchLogin()")
}

function switchLogin() {
    var submit = document.getElementById("submit");
    var signUpForm = document.getElementById("signupForm");
    var loginForm = document.getElementById("loginForm");
    var switchButton = document.getElementById("switch");

    signUpForm.setAttribute('hidden', true);
    loginForm .removeAttribute('hidden', false);

    submit.value = "Login";

    switchButton.value = "or Sign Up";
    switchButton.setAttribute("onclick", "switchSignUp()")
}