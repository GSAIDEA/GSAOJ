<?php
    require_once("include/db_info.php");
    require_once("include/setlang.php");
?>
  <!doctype html>
  <html lang="en">

  <head>

    <title>
      <?php echo $OJ_NAME;?>
    </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php require("importcss.php");?>
  </head>

  <body class="body-signin">
    <?php require("nav.php");?>
    <?php
    require_once("include/include_auth.php");
    if ($auth->islogged()) {
        echo "<script>history.back();</script>";
        die();
    }
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $uid = $auth->getUID($email);
        $user = $auth->getUser($uid);

        $result =$auth->requestReset($email);
        if (!result['error']) {
            echo "<script>alert(\"".$result['message']."\")</script>";
        } else {
            echo "<script>alert(\"".sprintf($MSG_ID_ALERT, $user['userid'])."\");</script>";
            echo "<script>location.href = \" ./reset.php\";</script>";
        }
    }
    ?>

      <div class="container">
        <form class="form-signin" action="findacc.php" method="post">
          <h3 class="margin-bottom-20"><?php echo $MSG_FIND_ACCOUNT;?></h3>
          <label for="inputEmail" class="sr-only"><?php echo $MSG_FIND_EMAIL;?></label>
          <input type="email" name="email" class="form-control" placeholder="<?php echo $MSG_FIND_EMAIL;?>" required autofocus>
          <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $MSG_SUBMIT;?></button>
        </form>
      </div>

      <?php require("importjs.php");?>
      <?php require("footer.php");?>

  </body>

  </html>
