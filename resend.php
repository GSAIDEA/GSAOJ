<?php
        require_once("include/db_info.php");
        require_once("include/setlang.php");
        require_once("include/include_auth.php");
?>
<!doctype html>
<html lang="ko">

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
    <?php
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $result = $auth->resendActivation($email);
        if ($result['error']) {
            echo "<script>alert(\"".$result['message']."\")</script>";
        } else {
            echo "<script type='test/javascript'>window.location = \"./index.php\";</script>";
        }
    }
    ?>
  </body>

</html>
