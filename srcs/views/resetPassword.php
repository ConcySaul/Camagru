<!DOCTYPE html>
<html>
  <head>
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/resetPassword.css">
    <script type="text/javascript" src="/script/index.js"></script>
  </head>
  <body>
    <div id="reset-container">
        <form  action="modifyPassword" method="post">
            <?php
              if (isset($_SESSION['msg'])) {
                echo "<h3>".($_SESSION['msg'])."</h3>";
                unset($_SESSION['msg']);
              }
            ?>
            <input type="password" class="input" placeholder="new password" id="password" name="password" required>
            <br>
            <input type="password" class="input" placeholder="confirm new password" id="confirm_password" name="confirm_password" required>
            <br>
            <input id="submit" class="input" type="button" value="change password" onclick="changePassword()">
          </form>
      </div>
  </body>
</html>
