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
    <link rel="stylesheet" type="text/css" href="/style/home.css">
    <link rel="stylesheet" type="text/css" href="/style/header.css">
    <link rel="stylesheet" type="text/css" href="/style/utils.css">
    <script type="text/javascript" src="script/home.js"></script>
  </head>
  <body>
        <?php
          returnHeader();
        ?>
        <div id="main-container" class="neon-border">
        <div class="pagination">
          <a href="/Home">&laquo;</a>
          <a href="#"><?php echo $url[1] ?></a>
          <a href="#">&raquo;</a>
      </div>
            <?php
              $pic->printPictures();
            ?>
        </div>
  </body>
</html>
