<?php
require_once("../include/db_info.php");
require_once("../include/setlang.php");
require_once("../include/include_auth.php");
require_once("checkprivilege.php");
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

    <?php require("importcss.php");?>

  </head>
  <body>
    <?php require("nav-admin-top.php");?>
    <div class="container-fluid">
      <div class="row">
        <?php require("nav-admin.php");?>
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
          <div class="row">
            <div class="col-md-12">
              <h1 class="text-center">Hello World</h1>
            </div>
          </div>
        </main>
      </div>
    </div>
    <?php require("importjs.php");?>
  </body>
</html>
