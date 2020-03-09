<!DOCTYPE html>
<html>
<head>
  <title><?php echo $title ?></title>
  <link rel="stylesheet" type="text/css" href="./css/common.css">
  <style type="text/css"><?php include "css/".$content_style; ?></style>
</head>
<body>

  <?php include "app/views/".$content_view; ?>

  <script type="text/javascript" src="./js/common.js"></script>
</body>
</html>