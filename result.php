<?php
require "./include/db_info.php";
require "./include/include_auth.php";
require "./include/setlang.php";
?>
  <!DOCTYPE html>
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

  <body>
    <!-- navbar -->
    <?php require("nav.php");
if (!$auth->isLogged()) {
    echo "<script type='text/javascript'>alert('".$MSG_ERR_NOT_LOGGEDIN."'); window.history.back()</script>";
    die();
}
if (!isset($_GET['submitid'])) {
    echo "<script type='text/javascript'>alert('".sprintf($MSG_ERR_NOT_FOUND, $MSG_STATUS_SUBMITID)."'); window.history.back();</script>";
    die();
}
try {
    $stmt = $db_conn->prepare("select uid, problem_id, submit_id, state from submit where submit_id=:sub");
    $stmt->execute([":sub"=>(int)$_GET['submitid']]);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($res) == 0) {
        echo "<script type='text/javascript'>alert('".sprintf($MSG_ERR_NOT_FOUND, $MSG_STATUS_SUBMITID)."'); window.history.back();</script>";
        die();
    }
    $row = $res[0];
    if ($row['uid'] != $auth->getSessionUID($auth->getSessionHash())) {
        echo "<script type='text/javascript'>alert('".$MSG_ERR_WRONG_APPROACH."'); window.history.back();</script>";
        die();
    }
} catch (PDOException $e) {
    echo "<script type='text/javascript'>alert('".$MSG_ERR_PDOEXCEPTION."'); window.history.back();</script>";
}
?>
    <main role="main">
      <div class="container">
        <div class="row margin-bottom-20"></div>

        <div class="row">
          <div class="col-md-12">
            <h4><?php echo $MSG_STATUS_RESULT.": ".$row['state'];?></h4>
          </div>
        </div>
        <hr>
        <div class="row">
          <?php switch ($row['state']) {
case "pending": ?>
          <div class="col-md-12">
            <div class="alert alert-secondary">
              <?php echo $MSG_RESULT_PENDING;?>
            </div>
          </div>
          <?php break; case "compile error": ?>
          <div class="col-md-12">
            <div class="alert alert-warning">
              <?php
$cperrpath = "/home/judge/problem/".$row['problem_id']."/submit/".$row['submit_id']."/compile_error.txt";
$cperrfile = fopen($cperrpath, "r");
$cperrcontent = fread($cperrfile, filesize($cperrpath));
fclose($cperrfile);
echo str_replace("\n", "<br>", $cperrcontent);
?></div>
          </div>
          <?php break; case "runtime error": ?>
          <div class="col-md-12">
            <div class="alert alert-warning">
              <?php
$rterrpath = "/home/judge/problem/".$row['problem_id']."/submit/".$row['submit_id']."/";
$i = 1;
while (is_file($rterrpath.$i.".error.out")) {
    $i++;
}
$rterrpath = $rterrpath.($i-1).".error.out";
$rterrfile = fopen($rterrpath, "r");
$rterrcontent = fread($rterrfile, filesize($rterrpath));
fclose($rterrfile);
echo str_replace("\n", "<br>", $rterrcontent);
?></div>
          </div>
          <?php break; case "expression error": ?>
          <div class="col-md-12">
            <div class="alert alert-warning">
              <?php echo $MSG_RESULT_EXPRERR;?>
            </div>
          </div>
          <?php break; case "correct": ?>
          <div class="col-md-12">
            <div class="alert alert-success">
              <?php
$correctpath = "/home/judge/problem/".$row['problem_id']."/submit/".$row['submit_id']."/";
$i = 1;
while (is_file($correctpath.$i.".error.out")) {
    $temppath = $correctpath.$i.".error.out";
    $tempfile = fopen($temppath, "r");
    $tempcontent = fread($tempfile, filesize($temppath));
    fclose($tempfile);
    echo $i.": ".$tempcontent."<br>";
    $i++;
}
?>
            </div>
          </div>
          <?php break; case "wrong": ?>
          <div class="col-md-12">
            <div class="alert alert-danger">
              <?php echo $MSG_RESULT_WRONG;?>
            </div>
          </div>
          <?php break; case "time limit exceeded": ?>
          <div class="col-md-12">
            <div class="alert alert-secondary">
              <?php
$correctpath = "/home/judge/problem/".$row['problem_id']."/submit/".$row['submit_id']."/";
$i = 1;
while (is_file($correctpath.$i.".error.out")) {
    $temppath = $correctpath.$i.".error.out";
    $tempfile = fopen($temppath, "r");
    $tempcontent = fread($tempfile, filesize($temppath));
    fclose($tempfile);
    echo $i.": ".$tempcontent."<br>";
    $i++;
}
?>
            </div>
          </div>
          <?php break;} ?>
        </div>
      </div>
    </main>
  </body>

  </html>
