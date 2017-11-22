<?php
	require_once("include/db_info.php");
	require_once("include/setlang.php");
	require_once("include/include_auth.php");
	if(isset($_GET['uid'])){
		$uid=$_GET['uid'];
	}
	if(isset($_GET['pid'])){
		$pid=$_GET['pid'];
	}
	$sessionuid=$auth->getSessionUID($auth->getSessionHash());
	if(!isset($_GET['page'])) {
		$request_page = 0;
	}
	else {
		$request_page = $_GET['page'];
	}
	if(!isset($uid)&&!isset($pid)){
		$res = $db_conn->prepare("select count(*) as row_count from submit;");
		$res->execute();
	}
	else if(!isset($uid)){
		$res = $db_conn->prepare("select count(*) as row_count from submit where problem_id = ?;");
		$res->execute(array($pid));
	}
	else if(!isset($pid)){
		$res = $db_conn->prepare("select count(*) as row_count from submit where uid = ?;");
		$res->execute(array($uid));
	}
	else{
		$res = $db_conn->prepare("select count(*) as row_count from submit where uid = ? and problem_id = ?;");
		$res->execute(array($uid,$pid));
	}
	$res->setFetchMode(PDO::FETCH_ASSOC);
	$row_count = $res->fetch()['row_count'];

	if($row_count == 0) $page_count = 0;
	else $page_count = floor(($row_count-1)/$PAGE_LINE);

	$err_status_page = $page_count < $request_page || $request_page < 0;
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
    <meta http-equiv="refresh" content="3;url=#">
    <?php if($err_status_page) { ?>
        <meta http-equiv='refresh' content='3; url=./status.php'>
    <?php
    }
    require("importcss.php");
    ?>

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
<?php
if($err_status_page){
?>
          <div class='col-md-12'>
            <h4 class='text-center'><?php echo $MSG_ERR_PROBLEMSET_PAGE; ?></h4>
          </div>
<?php } 
else {
?>
          <table class='table table-sm'>
            <thead>
              <tr>
                <th><?php echo $MSG_STATUS_NUM; ?></th>
                <th><?php echo $MSG_STATUS_USER; ?></th>
                <th><?php echo $MSG_STATUS_PROBLEM_NUM; ?></th>
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
	if(!isset($uid)&&!isset($pid)){
		$res = $db_conn->prepare("select submit_id, uid, problem_id, state, time_usage, memory_usage, language, code_length, submit_date from submit order by submit_id desc limit ".($request_page*$PAGE_LINE).",".$PAGE_LINE.";");
		$res->execute();
	}
	else if(!isset($uid)){
		$res = $db_conn->prepare("select submit_id, uid, problem_id, state, time_usage, memory_usage, language, code_length, submit_date from submit where problem_id=? order by submit_id desc limit ".($request_page*$PAGE_LINE).",".$PAGE_LINE.";");
		$res->execute(array($pid));
	}
	else if(!isset($pid)){
		$res = $db_conn->prepare("select submit_id, uid, problem_id, state, time_usage, memory_usage, language, code_length, submit_date from submit where uid=? order by submit_id desc limit ".($request_page*$PAGE_LINE).",".$PAGE_LINE.";");
		$res->execute(array($uid));
	}
	else{
		$res = $db_conn->prepare("select submit_id, uid, problem_id, state, time_usage, memory_usage, language, code_length, submit_date from submit where uid=? and problem_id=? order by submit_id desc limit ".($request_page*$PAGE_LINE).",".$PAGE_LINE.";");
		$res->execute(array($uid,$pid));
	}
	$res->setFetchMode(PDO::FETCH_ASSOC);
	while($line = $res->fetch()) {
		$user=$auth->getUser($line['uid']);

?>
              <tr>
                <th><?php echo $line['submit_id']; ?></th>
                <th><a href='./userinfo.php?id=<?php echo $line['uid']; ?>'><?php echo $user['userid']; ?></a></th>
                <th><a href='./problem.php?id=<?php echo $line['problem_id']?>'><?php echo $line['problem_id']; ?></th>
                <th><?php echo $line['state']; ?></th>
                <th><?php echo $line['time_usage']; ?>MS</th>
                <th><?php echo $line['memory_usage'] ?>KB</th>
                <th><?php echo $line['code_length'] ?>B</th>
<?php if($line['uid']==$auth->getSessionUID($auth->getSessionHash())){?>
		<th><a href='./editor.php?id=<?php echo $line['problem_id'];?>&submitid=<?php echo $line['submit_id'];?>'><?php echo $line['language'] ?></th>
<?php }
else {?>
		<th><?php echo $line['language'] ?></th>
<?php }?>
                <th><?php echo $line['submit_date'] ?></th>
              </tr>
<?php } ?>
            </tbody>
          </table>
<?php } ?>
        </div>
      </div>
    </main>

    <?php require("importjs.php");?>
    <?php require("footer.php");?>

  </body>
</html>
