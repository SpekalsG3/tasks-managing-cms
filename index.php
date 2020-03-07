<?php
  session_start();
  $admin = false;

  if (isset($_SESSION["admin"])) {
    $admin = true;
  }

  include_once "./php/dbconn.php";

  $stmt = $conn->prepare("SELECT * from tasks");
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $stmt->execute();
  $result = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tasks</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="./css/common.css">
  <link rel="stylesheet" type="text/css" href="./css/index.css">
</head>
<body>
  <div class="header">
    <div class="header__home">Home</div>
    <?php if ($admin) { ?>
      <a class="header__logout" href="./php/auth.php?action=logout">Log Out</a>
    <?php } else { ?>
      <a class="header__login" href="./login.php">Login</a>
    <?php } ?>
  </div>

  <div class="modal">
    <div class="form">
      <div class="form__head">
        <div class="form__title">Add Task</div>
      </div>
      <form class="form__inputs" method="GET" action="./php/edit.php">
        <input class="form__input" placeholder="Author" type="text" name="author">
        <input class="form__input" placeholder="Email" type="text" name="email">
        <textarea class="form__input form__input--textarea" placeholder="Task" name="value"></textarea>
        <select class="form__input" name="status">
          <option value="progress" selected="">In Progress</option>
          <option value="done">Done</option>
        </select>
        <input class="form__submit" value="Save" type="submit" name="signin">
        <input class="form__submit form__submit--half form__submit--second" value="Delete" type="button" name="delete">
      </form>
    </div>
  </div>

  <div class="add">
    <div class="add__wrap">
      <div class="add__title">Add task</div>
      <button class="add__btn">Add</button>
    </div>
  </div>


  <div class="content">
    <div class="tasks">
       <div class="tasks__row tasks__row--header">
          <div class="tasks__cell" data-name="author">Author</div>
          <div class="tasks__cell" data-name="email">Email</div>
          <div class="tasks__cell" data-name="task">Task</div>
          <div class="tasks__cell" data-name="done">Status</div>
          <?php if ($admin) { ?>
            <div class="tasks__edit-column"></div>
          <?php } ?>
          <div class="tasks__tooltip">Order by</div>
       </div>

      <div class="tasks__wrap">
      </div>
    </div>
  </div>

  <div class="pages">
      <div class="pages__btn pages__btn--prev">
        <img class="pages__arrow" src="./img/arrow.svg">
      </div>
      <div class="pages__btn pages__btn--number pages__btn--selected">1</div>
      <div class="pages__btn pages__btn--number">2</div>
      <div class="pages__btn pages__btn--number">3</div>
      <div class="pages__btn pages__btn--next">
        <img class="pages__arrow" src="./img/arrow.svg">
      </div>
  </div>

  <script type="text/javascript" src="./js/common.js"></script>
  <script type="text/javascript">
    var tasks = <?php echo json_encode($result); ?>;
  </script>
  <script type="text/javascript" src="./js/index.js"></script>
  <?php if ($admin) { ?>
    <script type="text/javascript" src="./js/admin.js"></script>
  <?php } ?>
  <script type="text/javascript">
    changePage();
  </script>
</body>
</html>