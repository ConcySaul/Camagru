var sticker1Path;
var sticker2Path;
var sticker3Path;
var flag = 1;
var dataURL;
var image_type;

document.addEventListener("DOMContentLoaded", function() {
    const video = document.getElementById('videoElement');
    navigator.mediaDevices.getUserMedia({ video: true }).then(stream => {
        video.srcObject = stream;
    })
    .catch(error => {
         console.log(error);
    });
});

document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("input[type=file]").addEventListener('change', (event) => {
        flag = 0;
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
        dataURL = preview.src;
        image_type = event.target.files[0].type;
        button.removeAttribute("hidden");
    });
});


function postPicture() {
    var draggable1 = document.getElementById('sticker1');
    var draggable2 = document.getElementById('sticker2');
    var draggable3 = document.getElementById('sticker3');

    var formData = new FormData();

    const stickerData = {
        top: draggable1.style.top,
		left: draggable1.style.left,
		height: draggable1.style.height,
		src: sticker1Path
	};

    const stickerData2 = {
        top: draggable2.style.top,
		left: draggable2.style.left,
		height: draggable2.style.height,
		src: sticker2Path
	};

    const stickerData3 = {
        top: draggable3.style.top,
		left: draggable3.style.left,
		height: draggable3.style.height,
		src: sticker3Path
	};

    formData.append("imageData", dataURL);
    formData.append('imageType', image_type);
    formData.append("stickerData", JSON.stringify(stickerData));
    formData.append("stickerData2", JSON.stringify(stickerData2));
    formData.append("stickerData3", JSON.stringify(stickerData3));

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

function useCamera() {
    const video = document.getElementById('videoElement');
    const preview = document.getElementById("preview");
    var button = document.getElementById("addButton");

    if (!flag) {
        flag = 1;
        preview.src = "";
    }
    else {
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        dataURL = canvas.toDataURL('image/png');
        preview.src = dataURL;
        image_type = 'image/png';
    }
    button.removeAttribute("hidden");
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
    const scaleInput = document.getElementById("sticker1");
    scaleInput.addEventListener('input', () => {
        document.getElementById('sticker1').style.height = (scaleInput.value / 100) + "%";
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const scaleInput = document.getElementById("sticker2");
    scaleInput.addEventListener('input', () => {
        document.getElementById('sticker2').style.height = (scaleInput.value / 100) + "%";
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const scaleInput = document.getElementById("sticker3");
    scaleInput.addEventListener('input', () => {
        document.getElementById('sticker3').style.height = (scaleInput.value / 100) + "%";
    });
});

function addSticker(path) {
    var draggable1 = document.getElementById('sticker1');
    var draggable2 = document.getElementById('sticker2');
    var draggable3 = document.getElementById('sticker3');

    if (!draggable1.src) {
        draggable1.style.height = "15%";
        draggable1.style.position = "absolute";
        draggable1.style.top = "50%";
        draggable1.style.left = "50%";
        draggable1.src = path;
        sticker1Path = path;

        const resize = document.querySelector(".resize_1");
        resize.value = 1500;
    }
    else if (draggable1.src && !draggable2.src) {
        draggable2.style.height = "15%";
        draggable2.style.position = "absolute";
        draggable2.style.top = "50%";
        draggable2.style.left = "50%";
        draggable2.src = path;
        sticker2Path = path;

        const resize = document.querySelector(".resize_2");
        resize.value = 1500;
    }
    else if (draggable2.src && !draggable3.src) {
        draggable3.style.height = "15%";
        draggable3.style.position = "absolute";
        draggable3.style.top = "50%";
        draggable3.style.left = "50%";
        draggable3.src = path;
        sticker3Path = path;

        const resize = document.querySelector(".resize_3");
        resize.value = 1500;
    }
}
