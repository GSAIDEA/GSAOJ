<?php
	require_once("include/db_info.php");
	require_once("include/setlang.php");

	if(!isset($_GET['uid'])) {
		$err_user_id = true;
	}
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

    <?php if($err_user_id) echo "    <meta http-equiv='refresh' content='3; url=./problemset.php'>";?>

    <?php require("importcss.php");?>

  </head>
  <body>
    <!-- navbar -->
    <?php require("nav.php");?>
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <table class="table table-sm">
            <tr>
              <th><?php echo $MSG_RANKING_SOLVED;?></th>
              <td> </td>
            </tr>
            <tr>
              <th><?php echo $MSG_RANKING_SUBMIT;?> </th>
              <td> </td>
            </tr>
            <tr>
              <th><?php echo $MSG_INFO_CORRECT;?></th>
              <td> </td>
            </tr>
            <tr>
              <th><?php echo $MSG_INFO_EXPRESSION_ERROR;?></th>
              <td> </td>
            </tr>
            <tr>
              <th><?php echo $MSG_INFO_WRONG;?></th>
              <td> </td>
            </tr>
            <tr>
              <th><?php echo $MSG_INFO_TIME_EXCEED;?></th>
              <td> </td>
            </tr>
            <tr>
              <th><?php echo $MSG_INFO_RUNTIME_ERROR;?></th>
              <td> </td>
            </tr>
            <tr>
              <th><?php echo $MSG_INFO_COMPILE_ERROR;?></th>
              <td> </td>
            </tr>
          </table>
        </div>
        <div class="col-md-8">
      
        </div>

      </div>
    </div>

    <?php require("importjs.php");?>
    <?php require("footer.php");?>

  </body>
</html>
