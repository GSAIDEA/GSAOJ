<?php
require_once("../include/db_info.php");
require_once("../include/setlang.php");
require("checkprivilege.php");
?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $OJ_NAME;?></title>

    <?php require("importcss.php");?>
  </head>

  <body>
    <?php require("nav-admin-top.php");?>
    <div class="container-fluid">
      <div class="row">
        <?php require("nav-admin.php");?>
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
          <h1>Dashboard</h1>
        </main>
      </div>
    </div>

    <?php require("../importjs.php");?>
  </body>

</html>
