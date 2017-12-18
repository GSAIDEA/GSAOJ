<?php
require_once("../include/db_info.php");
require_once("../include/setlang.php");
require_once("../include/include_auth.php");
$uid = $auth->getSessionUID($auth->getSessionHash());
?>
<!doctype html>
<html lang="en">
  <head>

    <title><?php echo $OJ_NAME;?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <?php
    if(!$auth->islogged()){
            echo "<script>windows.location = \"../\"</script>";
	    die();
    }
    $privilege_stmt = $db_conn->prepare("select type from privilege where id=".$uid);
    $privilege_stmt->execute();
    $privilege = $privilege_stmt->fetch();
    if(strcmp($privilege['type'], "admin") != 0){
            echo "<script>windows.location = \"../\"</script>";
	    die();
    }?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php require("importcss.php");?>

  </head>
  <body>
    <?php require("nav-admin.php");?>
    <div class="row">

      <main role="main" class="col-md-9 pt-3">
        <h1 class="text-center">Hello World</h1>
      </main>
    </div>
    <?php require("importjs.php");?>
  </body>
</html>
