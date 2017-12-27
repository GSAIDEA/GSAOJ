<?php
    require_once "include/db_info.php";
    require_once "include/setlang.php";
    require_once "include/include_auth.php";
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

    <?php
    require_once "importcss.php";
    require_once "nav.php";
    ?>
  </head>

  <body class="body-signin">
    <?php
    if (isset($_POST['key'])) {
        $key = $_POST['key'];
        $result = $auth->activate($key);
        if ($result['error']) {
            echo "<script>alert(\"".$result['message']."\")</script>";
        } else {
            echo "<script type='text/javascript'>window.location = './index.php';</script>";
        }
    }
    ?>
      <div class="container">
        <div class="row margin-bottom-50"></div>
        <div class="row margin-bottom-50">
          <form class="form-signin" action="activate.php" method="post" style="max-width: 1000px;">
            <h2 class="margin-bottom-20"><?php echo $MSG_ACTIVATE_PLZ;?></h2>
            <br>
            <label for="inputId" class="sr-only"><?php echo $MSG_KEY?></label>
            <input type="text" name="key" class="form-control" placeholder="<?php echo $MSG_KEY;?>" required autofocus>
            <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $MSG_ACTIVATE_SUBMIT;?></button>
          </form>
        </div>
      </div>
      <hr>
      <div class="container">
        <div class="row margin-bottom-50"></div>
        <form class="form-signin" action="resend.php" method="post" style="max-width: 1500px">
          <h3 class="text-center"><?php echo $MSG_IF_EMAIL_EXPIRED; ?></h3>
          <input type="email" class="form-control" id="email" name="email" placeholder=<?php echo $MSG_FIND_EMAIL;?>>
          <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $MSG_RESEND_EMAIL; ?></button>
        </form>
      </div>
      <div class="row margin-bottom-50"></div>
      <?php require_once "importjs.php";?>
      <?php require_once "footer.php";?>
  </body>

  </html>
