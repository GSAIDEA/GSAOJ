<?php
require_once("include/db_info.php");
require_once("include/setlang.php");
function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                       	$sortable_array[$k] = $v2;
               	    }
       	        }
            } else {
               	$sortable_array[$k] = $v;
       	    }
        }
       	switch ($order) {
            case SORT_ASC:
		asort($sortable_array);
		break;
            case SORT_DESC:
               	arsort($sortable_array);
		break;
	}

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
       	}
    }

    return $new_array;
}

$res = $db_conn->query("select uid, submit, solved_once, sangme from userdata order by solved desc, submit asc;");
$result = $res->fetchAll(PDO::FETCH_ASSOC);
array_sort($result, 'solved', SORT_DESC);
$row_count = count($result);
$page_count = floor(($row_count-1)/50);
if($page_count < 0){
	$page_count = 0;
}
$page = isset($_GET['page']) ? $_GET['page'] : 0;
$err_index_out_of_range = $page_count < $page || $page < 0;
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

    <?php if($err_index_out_of_range) {?>
    <meta http-equiv='refresh' content='3; url=./rank.php'>
    <?php } require("importcss.php");?>

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
<?php
for($i=0; $i<=$page_count; $i++) {
	if($i == $page) $temp_active = " active";
	else $temp_active = ""; ?>
              <li class='page-item<?php echo $temp_active;?>'><a class='page-link' href="rank.php?page=<?php echo $i;?>"><?php echo ($i+1);?></a></li>
<?php }?>

              <li class='page-item'><a class='page-link' href='rank.php?page=<?php echo $page_count;?>'>&gt;&gt;</a></li>
            </ul>
          </nav>
        </div>

        <div class="row">
<?php
if($err_index_out_of_range) { ?>
          <h3 class='text-center'>".$MSG_ERR_PROBLEMSET_PAGE."</h3>
<?php }else{?>

          <table class='table table-striped table-sm'>
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
for($i=0+50*$page; $i<50+50*$page; $i++) {
    if($i>=count($result))break;
    $success_rate = $result[$i]['submit']==0 ? 0 : $result[$i]['solved']/$result[$i]['submit'] * 100;
?>
              <tr>
		<th><?php echo $i+1;?></th>
		<th><?php
			$getuserid = $db_conn->prepare("select userid from users where id=:id");
			$getuserid->execute([":id"=> $result[$i]['uid']]);
			$userid = $getuserid->fetch(PDO::FETCH_ASSOC);
			echo "<a href=\"./userinfo.php?id=".$result[$i]['uid']."\">".$userid['userid']."</a>";
		    ?></th>
<?php
    foreach($result[$i] as $key=>$val){
	if($key != 'uid'){
?>
                <th><?php echo $val; ?></th>
<?php }}?>
                <th><?php echo sprintf("%.2f", $success_rate);?>%</th>
              </tr>
<?php }?>
            </tbody>
          </table>
<?php }?>
        </div>
      </div>
    </main>

    <?php require("importjs.php");?>
    <?php require("footer.php");?>

  </body>
</html>
