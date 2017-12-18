<?php
require_once("include/db_info.php");
require_once("include/setlang.php");
require_once("include/include_auth.php");
$sessionuid=$auth->getSessionUID($auth->getSessionHash());
if(!isset($_GET['page'])) {
	$request_page = 0;
}
else {
	$request_page = $_GET['page'];
}
if(!isset($_GET['uid']) && !isset($_GET['pid'])){
	$mode = 0;
	$res = $db_conn->prepare("select count(*) as row_count from submit;");
	$res->execute();
}
else if(!isset($_GET['uid'])){
	$mode = 1;
	$uid = $_GET['uid'];
	$res = $db_conn->prepare("select count(*) as row_count from submit where problem_id = ?;");
	$res->execute(array($pid));
}
else if(!isset($_GET['pid'])){
	$mode = 2;
	$pid = $_GET['pid'];
	$res = $db_conn->prepare("select count(*) as row_count from submit where uid = ?;");
	$res->execute(array($uid));
}
else{
	$mode = 3;
	$pid = $_GET['pid'];
	$uid = $_GET['uid'];
	$res = $db_conn->prepare("select count(*) as row_count from submit where uid = ? and problem_id = ?;");
	$res->execute(array($uid,$pid));
}
$res->setFetchMode(PDO::FETCH_ASSOC);
$row_count = $res->fetch()['row_count'];

if($row_count == 0) $page_count = 0;
else $page_count = floor(($row_count-1)/$PAGE_LINE);
if($page_count < $request_page || $request_page < 0) {
	echo "<script type='text/javascript'>alert('".sprintf($MSG_ERR_NOT_FOUND, "페이지")."'); window.history.back();</script>";
	die();
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
    <!--meta http-equiv="refresh" content="3;url=#"-->
    <?php require("importcss.php");?>

  </head>
  <body>
    <!-- navbar -->
    <?php require("nav.php");?>

    <main role="main">
      <div class="container">
        <div class="row margin-bottom-20"></div>
        <div class="row margin-bottom-20">
          <h3 class="mx-auto"><?php echo $MSG_STATUS;?></h3>
        </div>
        <div class="row margin-bottom-20">
          <nav class="mx-auto">
            <ul class="pagination">
              <li class="page-item"><a class="page-link" href="status.php">&lt;&lt;</a></li>
              <li class="page-item <?php if($request_page == 0) echo "active";?>"><a class="page-link" href="status.php">1</a></li>
              <?php
              for($i=1; $i<=$page_count; $i++) {
                if($i == $request_page) $temp_active = " active";
                else $temp_active = "";?>
              <li class='page-item<?php echo $temp_active; ?>'><a class='page-link' href='status.php?page=<?php echo $i;?>'><?php echo $i+1;?></a></li>
              <?php
              }
            ?>
              <li class='page-item'><a class='page-link' href='status.php?page=<?php echo $page_count;?>'>&gt;&gt;</a></li>
            </ul>
          </nav>
        </div>

        <div class="row">
          <table class='table table-sm'>
            <thead>
              <tr>
                <th><?php echo $MSG_STATUS_SUBMITID; ?></th>
                <th><?php echo $MSG_STATUS_USER; ?></th>
                <th><?php echo $MSG_STATUS_PROBLEMID; ?></th>
                <th><?php echo $MSG_STATUS_RESULT; ?></th>
                <th><?php echo $MSG_STATUS_TIME_USAGE; ?></th>
                <th><?php echo $MSG_STATUS_MEMORY_USAGE; ?></th>
                <th><?php echo $MSG_STATUS_CODE_LENGTH; ?></th>
                <th><?php echo $MSG_STATUS_LANGUAGE; ?></th>
                <th><?php echo $MSG_STATUS_SUBMIT_DATE; ?></th>
              </tr>
            </thead>
            <tbody>
<?php
	if($mode == 0){
		$res = $db_conn->prepare("select submit_id, uid, problem_id, state, time_usage, memory_usage, language, code_length, submit_date from submit order by submit_id desc limit ".($request_page*$PAGE_LINE).",".$PAGE_LINE.";");
		$res->execute();
	}
	else if($mode == 1){
		$res = $db_conn->prepare("select submit_id, uid, problem_id, state, time_usage, memory_usage, language, code_length, submit_date from submit where problem_id=? order by submit_id desc limit ".($request_page*$PAGE_LINE).",".$PAGE_LINE.";");
		$res->execute(array($pid));
	}
	else if($mode == 2){
		$res = $db_conn->prepare("select submit_id, uid, problem_id, state, time_usage, memory_usage, language, code_length, submit_date from submit where uid=? order by submit_id desc limit ".($request_page*$PAGE_LINE).",".$PAGE_LINE.";");
		$res->execute(array($uid));
	}
	else{
		$res = $db_conn->prepare("select submit_id, uid, problem_id, state, time_usage, memory_usage, language, code_length, submit_date from submit where uid=? and problem_id=? order by submit_id desc limit ".($request_page*$PAGE_LINE).",".$PAGE_LINE.";");
		$res->execute(array($uid, $pid));
	}
	$res->setFetchMode(PDO::FETCH_ASSOC);
	while($line = $res->fetch()) {
		$user=$auth->getUser($line['uid']);
?>
              <tr>
                <th><?php echo $line['submit_id']; ?></th>
                <th><a href='./userinfo.php?uid=<?php echo $line['uid']; ?>'><?php echo $user['userid']; ?></a></th>
                <th><a href='./problem.php?id=<?php echo $line['problem_id']?>'><?php echo $line['problem_id']; ?></a></th>
<?php
switch($line['state']) {
	case "pending":
		$badge_type = "secondary";
		$text_color = "#868e96";
		break;
	case "compile error": case "runtime error": case "expression error":
		$badge_type = "warning";
		$text_color = "#ffc107";
		break;
	case "time limit exceeded":
		$badge_type = "dark";
		$text_color = "#343a40";
		break;
	case "wrong":
		$badge_type = "danger";
		$text_color = "#dc3545";
		break;
	case "correct":
		$badge_type = "success";
		$text_color = "#28a745";
		break;
}
if($line['uid'] == $auth->getSessionUID($auth->getSessionHash())) {?>
                <th><a href="./result.php?submitid=<?php echo $line['submit_id'];?>" class="badge badge-<?php echo $badge_type;?>" style="font-size: 1rem"><?php echo $line['state']; ?></a></th>
<?php } else {?>
		<th><p style="color: <?php echo $text_color;?>; margin-bottom: 0; padding-bottom: 0;"><?php echo $line['state'];?></p></th>
<?php }?>
                <th><?php echo $line['time_usage']; ?>MS</th>
                <th><?php echo $line['memory_usage'] ?>KB</th>
                <th><?php echo $line['code_length'] ?>B</th>
<?php if($line['uid']==$auth->getSessionUID($auth->getSessionHash())){?>
		<th><a href='./editor.php?id=<?php echo $line['problem_id'];?>&submitid=<?php echo $line['submit_id'];?>'><?php echo $line['language'] ?></a></th>
<?php }
else {?>
		<th><?php echo $line['language'] ?></th>
<?php }?>
                <th><?php echo $line['submit_date'] ?></th>
              </tr>
<?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
    <?php require("importjs.php");?>
    <?php require("footer.php");?>
  </body>
</html>
