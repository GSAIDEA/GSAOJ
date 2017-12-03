<?php
require_once("include/db_info.php");
require_once("include/setlang.php");

if(!isset($_GET['page'])) {
	$request_page = 0;
}
else {
	$request_page = $_GET['page'];
}
$res = $db_conn->prepare("select count(*) as row_count from userdata;");
$res->execute();
$row_count = $res->fetch(PDO::FETCH_ASSOC)['row_count'];
if($row_count == 0) $page_count = 0;
else $page_count = floor(($row_count-1)/$PAGE_LINE);
if($page_count < $request_page || $request_page < 0) {
	echo "<script type='text/javascript'>alert(); window.history.back();</script>";
	die();
}
$res = $db_conn->prepare("select userid, sangme, submit, solved_once from userdata left join users on userdata.uid = users.id order by solved_once desc, submit asc limit ".($request_page*$PAGE_LINE).", ".$PAGE_LINE.";");
$res->execute();
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
    <!-- navbar -->
    <?php require("nav.php");?>

    <main role="main">
      <div class="container">
        <div class="row margin-bottom-20"></div>

        <div class="row margin-bottom-20">
          <h3 class="mx-auto"><?php echo $MSG_RANKING;?></h3>
        </div>
        <div class="row margin-bottom-20">
          <nav class="mx-auto">
            <ul class="pagination">
              <li class="page-item"><a class="page-link" href="rank.php">&lt;&lt;</a></li>
              <li class="page-item <?php if($request_page == 0) echo "active";?>"><a class="page-link" href="rank.php">1</a></li>
<?php
for($i=1; $i<=$page_count; $i++) {
	if($i == $request_page) $temp_active = " active";
	else $temp_active = "";
?>
              <li class="page-item<?php echo $temp_active;?>"><a class="page-link" href="rank.php?page=<?php echo $i;?>"><?php echo $i+1;?></a></li>
<?php }?>
              <li class="page-item"><a class="page-link" href="rank.php?page=<?php echo $page_count;?>">&gt;&gt;</a></li>
            </ul>
          </nav>
        </div>

        <div class="row">
          <table class='table table-sm'>
            <thead>
              <tr>
		<th><?php echo $MSG_RANKING_RANK;?></th>
                <th><?php echo $MSG_RANKING_ID;?></th>
                <th><?php echo $MSG_RANKING_SUBMIT;?></th>
                <th><?php echo $MSG_RANKING_SOLVED;?></th>
                <th><?php echo $MSG_RANKING_SANGME;?></th>
                <th><?php echo $MSG_RANKING_SUCCESS_RATE;?></th>
              </tr>
            </thead>
            <tbody>
<?php
$res = $db_conn->prepare("select userid, sangme, submit, solved, solved_once, isactive from userdata left join users on userdata.uid = users.id order by solved_once desc, submit asc limit ".($request_page*$PAGE_LINE).", ".$PAGE_LINE.";");
$res->execute();
$i = 0;
while($line = $res->fetch(PDO::FETCH_ASSOC)) {
	$i++;
	if($line['isactive'] == 0) continue;
	if($line['submit'] == 0) $temp_success_rate = 0;
	else $temp_success_rate = round(floatval($line['solved'])/floatval($line['submit'])*100, 3)
?>
              <tr>
                <th><?php echo $i;?></th>
<?php $getuid=$db_conn->prepare("select id from users where userid = ?");
$getuid->execute(array($line['userid']));
$uid=$getuid->fetch(PDO::FETCH_ASSOC);
?>
                <th><a href='./userinfo.php?uid=<?php echo $uid['id'];?>'><?php echo $line['userid'];?></a></th>
                <th><?php echo $line['submit'];?></th>
                <th><?php echo $line['solved_once'];?></th>
                <th><?php echo htmlentities($line['sangme']);?></th>
                <th><?php echo sprintf("%.2f", $temp_success_rate);?>%</th>
              </tr>
<?php }?>
            </tbody>
          </table>
        </div>
      </div>
    </main>

    <?php require("importjs.php");?>
    <?php require("footer.php");?>

  </body>
</html>
