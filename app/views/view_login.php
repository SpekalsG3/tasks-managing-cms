<link rel="stylesheet" type="text/css" href="./css/login.css">

<div class="header">
  <a class="header__home" href="./">Home</a>
  <div class="header__login">Login</div>
</div>

<div class="content">
  <div class="form">
    <div class="form__head">
      <div class="form__title">Sign in</div>
    </div>
    <form class="form__inputs" method="POST" action="">
      <input class="form__input" placeholder="Login" type="text" name="login">
      <input class="form__input" placeholder="Password" type="password" name="password">
      <input class="form__submit" value="Sign In" type="submit" name="signin">
    </form>
  </div>
</div>

<script type="text/javascript" src="./js/login.js"></script>
<script type="text/javascript">
  <?php if (isset($error)) { ?>
      document.addEventListener("DOMContentLoaded", function() {
        var errBody = <?php echo json_encode(["title" => $error[0], "msg" => $error[1]]) ?>;
        ShowPopup(errBody["title"], errBody["msg"], true);
      });
  <?php } ?>
</script>