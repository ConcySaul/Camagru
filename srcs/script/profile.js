document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("input[type=file]").addEventListener('change', (event) => {
        var button = document.getElementById("addButton");
        const fileReader = new FileReader();
        const allowedTypes = ['image/jpeg', 'image/png'];

        if (!allowedTypes.includes(event.target.files[0].type)) {
            event.target.value = "";
            alert("File not valid");
            return ;
        }

        fileReader.onload = function () {
            let preview = document.getElementById("preview");
            preview.src = fileReader.result;
        }
        fileReader.readAsDataURL(event.target.files[0]);
        button.removeAttribute("hidden");
    });
});


function postPicture() {
    var file = document.getElementById("file").files;
    var formData = new FormData();

    formData.append("image", file[0]);
    fetch("http://localhost:3001/postPicture", {
        method: "POST",
        body: formData
    })
    .then(response => {
        console.log(response);
    })
    .catch(error => {
        console.log(error);
        return;
    })
}

function modifyUser() {

    let body = {
        username: document.getElementById("username").value,
        email: document.getElementById("email").value
    }

    let post = JSON.stringify(body);
    const url = "http://localhost:3001/modifyUser"
    let xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');
    xhr.send(post);
    xhr.onload = function () {
        if(xhr.status == 201) {
            let username = document.getElementById("username");
            let email = document.getElementById("email");
            if (username.value) {
                username.setAttribute("placeholder", username.value);
            }
            if (email.value) {
                email.setAttribute("placeholder", email.value);
            }

        }
    }
}
