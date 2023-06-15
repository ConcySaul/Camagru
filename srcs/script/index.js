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

function changePassword() {
    var pass = document.getElementById('password').value;
    var confirm = document.getElementById('confirm_password').value;

    var url = window.location.pathname;
    parameters = url.split('/');
    var formData = new FormData();
    if (pass == confirm && (pass && confirm)) {
        formData.append("password", pass);
        formData.append("challengeId", parameters[2]);
        fetch("http://localhost:3001/confirmPassword", {
            method: "POST",
            body: formData
        })
        .then(response => {
            if (response.status === 200) {
                window.location.href = 'http://localhost:3001/Index';
              }
        })
        .catch(error => {
            console.log(error);
            return;
        })
    }
    else {
        alert ("passwords are not the same");
    }
}
