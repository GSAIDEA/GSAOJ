<?php
require_once("include/db_info.php");
require_once("include/setlang.php");

if(!isset($_GET['page'])) {
	$request_page = 0;
}
else {
	$request_page = $_GET['page'];
}
if(isset($_GET['search'])){
	$search_query = $_GET['search'];
	$res=$db_conn->prepare("select count(*) as row_count from problem where title like :search;");
	$res->execute(array(":search"=>"%".$search_query."%"));
}
else{
	$res = $db_conn->prepare("select count(*) as row_count from problem;");
	$res->execute();
}
$row_count = $res->fetch(PDO::FETCH_ASSOC)['row_count'];
if($row_count == 0) $page_count = 0;
else $page_count = floor(($row_count-1)/$PAGE_LINE);
if($page_count < $request_page || $request_page < 0) {
	echo "<script type='text/javascript'>alert('".sprintf($MSG_ERR_NOT_FOUND, "페이지")."'); window.history.back()</script>";
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

    <?php require("importcss.php");?>

  </head>
  <body>
    <!-- navbar -->
    <?php require("nav.php");?>

    <main role="main">
      <div class="container">
        <div class="row margin-bottom-20"></div>

        <div class="row margin-bottom-20">
          <h3 class="mx-auto"><?php echo $MSG_PROBLEMSET;?></h3>
        </div>

        <div class="row margin-bottom-20">
          <nav class="mx-auto">
            <ul class="pagination">
              <li class="page-item"><a class="page-link" href="problemset.php">&lt;&lt;</a></li>
              <li class="page-item <?php if($request_page == 0) echo "active";?>"><a class="page-link" href="problemset.php">1</a></li>
<?php
for($i=1; $i<=$page_count; $i++) {
	if($i == $request_page) $temp_active = " active";
	else $temp_active = "";
?>
              <li class="page-item<?php echo $temp_active;?>"><a class="page-link" href="problemset.php?page=<?php echo $i;?>"><?php echo $i+1;?></a></li>
<?php }?>
              <li class="page-item"><a class="page-link" href="problemset.php?page=<?php echo $page_count;?>">&gt;&gt;</a></li>
            </ul>
          </nav>
        </div>

	<div class="row margin-bottom-20">
	  <div class="col-md-6">
            <form class="form-inline my-2 my-lg-0" sytle="float:left;" action="problem.php">
              <input class="form-control" name="id" type="text" placeholder = <?php echo $MSG_PROBLEM_ID;?> aria-label="Search">
              <button class="btn btn-primary" type="submit">Search</button>
            </form>
	  </div>
	  <div class="col-md-6">
            <form class="form-inline my-2 my-lg-0" style="float: right;" action="problemset.php">
              <input class="form-control" name="search" type="text" placeholder = <?php echo $MSG_PROBLEM_TITLE;?> aria-label="Search">
              <button class="btn btn-primary" type="submit">Search</button>
            </form>
	  </div>
	</div>

        <div class="row">
          <table class='table table-sm'>
            <thead>
              <tr>
                <th><?php echo $MSG_PROBLEM_ID; ?></th>
                <th><?php echo $MSG_PROBLEM_TITLE; ?></th>
                <th><?php echo $MSG_PROBLEM_SOURCE; ?></th>
                <th><?php echo $MSG_PROBLEM_SOLVED; ?></th>
                <th><?php echo $MSG_PROBLEM_SUBMIT; ?></th>
                <th><?php echo $MSG_PROBLEM_SUCCESS_RATE; ?></th>
              </tr>
            </thead>
            <tbody>
<?php 
if(isset($_GET['search'])){
	$search_query = $_GET['search'];
	$res=$db_conn->prepare("select problem_id, title, source, solved, submit from problem where title like :search order by problem_id asc limit ".($request_page*$PAGE_LINE).",".$PAGE_LINE.";");
	$res->execute(array(":search"=>"%".$search_query."%"));
}
else {
	$res = $db_conn->prepare("select problem_id, title, source, solved, submit, defunct from problem order by problem_id asc limit ".($request_page*$PAGE_LINE).",".$PAGE_LINE.";");
	$res->execute();
}
while($line = $res->fetch(PDO::FETCH_ASSOC)) {
	if($line['defunct'] != 0) continue;
	if($line['submit'] == 0) $temp_success_rate = 0;
	else $temp_success_rate = round(floatval($line['solved'])/floatval($line['submit'])*100, 3);
?>
              <tr>
                <th><?php echo $line['problem_id']; ?></th>
                <th><a href='./problem.php?id=<?php echo $line['problem_id']; ?>'><?php echo $line['title']; ?></a></th>
                <th><?php echo $line['source']; ?></th>
                <th><?php echo $line['solved']; ?></th>
                <th><?php echo $line['submit']; ?></th>
                <th><?php echo sprintf("%.2f", $temp_success_rate); ?>%</th>
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
