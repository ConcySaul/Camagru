<!DOCTYPE html>
<html>
  <head>
    <title>Login Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/index.css">
    <script type="text/javascript" src="script/index.js"></script>
  </head>
  <body>
    <div id="login-container">
        <form id="signupForm" action="signUp" method="post">
            <!-- SIGNUP FORM -->
            <?php
              if (isset($_SESSION['msg'])) {
                echo "<h3>".($_SESSION['msg'])."</h3>";
                unset($_SESSION['msg']);
              }
            ?>
            <input type="text" class="input" placeholder="username" id="username" name="username" required>
            <br>
            <input type="email" class="input" placeholder="email" class="email" id="email" name="email" required>
            <br  id="email_br">
            <input type="password" class="input" placeholder="password" id="password" name="password" required>
            <br>
            <input id="submit" class="input" type="submit" value="SignUp">
            <input id="switch" class="input" type="button" value="Or Login" onClick="switchLogin()">
          </form>
          <!-- LOGIN FORM -->
          <?php
              if (isset($_SESSION['msg'])) {
                echo "<h3>".($_SESSION['msg'])."</h3>";
                unset($_SESSION['msg']);
              }
            ?>
          <form id="loginForm" action="login" method="post" hidden>
            <input type="text" class="input" placeholder="username" id="username" name="username" required>
            <br>
            <input type="password" class="input" placeholder="password" id="password" name="password" required>
            <br>
            <input id="submit" class="input" type="submit" value="Login">
            <input id="switch" class="input" type="button" value="Or Signup" onClick="switchSignUp()">
          </form>
      </div>
  </body>
</html>