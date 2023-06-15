var stickerPath;

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
    var draggable = document.getElementById('sticker');
    var formData = new FormData();
    const stickerData = {
        top: draggable.style.top,
		left: draggable.style.left,
		height: draggable.style.height,
		src: stickerPath
	};

    formData.append("image", file[0]);
    formData.append("stickerData", JSON.stringify(stickerData));
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

function changePassword() {

    fetch("http://localhost:3001/changePassword", {
        method: "POST",
    })
    .then(response => {
        console.log(response);
    })
    .catch(error => {
        console.log(error);
        return;
    })
}


document.addEventListener("DOMContentLoaded", function() {
    const scaleInput = document.querySelector(".resize-range");
    scaleInput.addEventListener('input', () => {
        document.getElementById('sticker').style.height = (scaleInput.value / 100) + "%";
    });
});

function addSticker(path) {
    var draggable = document.getElementById('sticker');
    draggable.style.height = "15%";
    draggable.style.position = "absolute";
    draggable.style.top = "40%";
    draggable.style.left = "40%";
    draggable.src = path;
    stickerPath = path;

    // if (video.srcObject || document.getElementById("photo").src !== window.location.href)
    //     document.getElementById("takepic-btn").style.display = "flex";
    const resize = document.querySelector(".resize-range")
    resize.value = 1500;
}
