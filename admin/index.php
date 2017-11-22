<?php
	require_once("../../include/db_info.php");
	require_once("../../include/setlang.php");
?>
<!doctype html>
<html lang="en">
  <head>

    <title><?php echo $OJ_NAME;?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php require("./importcss.php");?>

  </head>
  <body>
    <div class="row">
      <?php require("./nav-admin.php");?>

      <main role="main" class="col-md-9 pt-3">
        <h1 class="text-center">Hello World</h1>
      </main>
    </div>
    <?php require("./importjs.php");?>
  </body>
</html>
