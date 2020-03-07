<?php
  session_start();

  if (isset($_SESSION["admin"])) {
    header("Location: ./");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="./css/common.css">
  <link rel="stylesheet" type="text/css" href="./css/login.css">
</head>
<body>
  <div class="header">
    <a class="header__home" href="./">Home</a>
    <div class="header__login">Login</div>
  </div>

  <div class="content">
    <div class="form">
      <div class="form__head">
        <div class="form__title">Sign in</div>
      </div>
      <form class="form__inputs" method="POST" action="./php/auth.php?action=login">
        <input class="form__input" placeholder="Login" type="text" name="login">
        <input class="form__input" placeholder="Password" type="password" name="password">
        <input class="form__submit" value="Sign In" type="submit" name="signin">
      </form>
    </div>
  </div>

  <script type="text/javascript" src="./js/common.js"></script>
  <script type="text/javascript" src="./js/login.js"></script>
</body>
</html>