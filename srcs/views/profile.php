<?php
    require_once ("header.php");
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Camagru</title>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="height=device-height, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/style/profile.css">
    <link rel="stylesheet" type="text/css" href="/style/header.css">
    <link rel="stylesheet" type="text/css" href="/style/utils.css">
    <script src="/script/profile.js"></script>
  </head>
  <body>
        <?php
            returnHeader();
        ?>
        <div id="main-container" class="neon-border">
            <div id="profilePicture" class="neon-div-border">
            </div>
            <div id="form-div" class="neon-div-border">
                <form action="">
                    <input class="input neon-div-border" type="text" name="username" id="username"
                        <?php
                            echo('placeholder="'.$_SESSION['username'].'"'); 
                        ?>
                    >
                    <input class="input neon-div-border" type="email" name="email" id="email"
                        <?php
                            echo('placeholder="'.$_SESSION['email'].'"'); 
                        ?>
                    >
                    <input class="input neon-div-border" type="button" value="Save" onClick="modifyUser()">
                </form>
            </div>
            <div class="neon-div-border" id="picture-div">
                <div class="image-container">
                    <img src="" width="600" height="400" id="preview">
                </div>
                <div class="input-container">
                    <input type="range" id="yRange" min="0" max="400">
                    <input type="range" id="xRange" min="0" max="600">
                </div>
                <!-- <video id="video" width="640" height="480" autoplay></video> -->
            </div>
            
			<div class="sticker-slide" id="sticker_slide">
                <?php $picture->printStickers() ?>
			</div>

            <input type="button" value="Add" id="addButton" hidden="true" onClick="postPicture()">
            <input type="file" name="file" id="file" class="inputfile" />
            <br>
            <label id="file-label" class="neon-div-border" for="file">Choose a file...</label>
            <br>
            <label id="switchLabel" class="neon-div-border" onClick="useCamera()">or use Camera</label>
        </div>
  </body>
</html>
