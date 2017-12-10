<?php
	require_once("include/db_info.php");
	require_once("include/setlang.php");
	require_once("include/include_auth.php");
	$err_user_id=false;
	if(!isset($_GET['uid'])) {
		$err_user_id = true;
	}
	else{
		$uid=$_GET['uid'];
		$res = $db_conn->prepare("select * from userdata where uid = ?;");
		$res->execute(array($uid));
		$res->setFetchMode(PDO::FETCH_ASSOC);
		$line = $res->fetch();
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

    <?php if($err_user_id) echo "    <meta http-equiv='refresh' content='3; url=./index.php'>";?>
    <?php require("importcss.php");?>

  </head>
  <body>
    <!-- navbar -->
    <?php require("nav.php");?>
    <div class="container">
      <div class="row margin-bottom-20"></div>
<?php if($err_user_id){ ?>
      <div class="row">
        <h4>Error occured</h4>
      </div>
<?php }
else{ ?>
      <div class="row">
	<div class='col-md-12 margin-bottom-20'>
<?php	  $user=$auth->getUser($line['uid']); ?>
	  <h2 class='text-center margin-bottom-10'><?php echo $user['userid'];?></h2>
	  <br>
	  <blockquote class='text-center'><p><?php echo $line['sangme'];?></p></blockquote>
	</div>
      </div>
      <hr style="margin-bottom : 0">
      <div class="row">
        <div class="col-md-4">
          <table class="table table-sm">
            <tr>
              <th><?php echo $MSG_RANKING_SOLVED;?></th>
              <td><?php echo $line['solved_once'];?></td>
            </tr>
            <tr>
              <th><?php echo $MSG_RANKING_SUBMIT;?> </th>
              <td><?php echo $line['submit'];?></td>
            </tr>
            <tr>
              <th><?php echo $MSG_INFO_CORRECT;?></th>
              <td><?php echo $line['solved'];?></td>
            </tr>
            <tr>
              <th><?php echo $MSG_INFO_EXPRESSION_ERROR;?></th>
              <td><?php echo $line['exprerr'];?></td>
            </tr>
            <tr>
              <th><?php echo $MSG_INFO_WRONG;?></th>
              <td><?php echo $line['wrong']?></td>
            </tr>
            <tr>
              <th><?php echo $MSG_INFO_TIME_EXCEED;?></th>
              <td><?php echo $line['tle'];?></td>
            </tr>
            <tr>
              <th><?php echo $MSG_INFO_RUNTIME_ERROR;?></th>
              <td><?php echo $line['rterr'];?></td>
            </tr>
            <tr>
              <th><?php echo $MSG_INFO_COMPILE_ERROR;?></th>
              <td><?php echo $line['cperr'];?></td>
            </tr>
          </table>
          <canvas id="summary"></canvas>
        </div>
        <div class="col-md-8">
          <?php 
          
          ?>
        </div>

      </div>
<?php }?>
    </div>
    <?php require("importjs.php");?>
    <?php require("footer.php");?>
    <script>
    var ctxP = document.getElementById("summary").getContext('2d');
    var myPieChart = new Chart(ctxP, {
        type: 'pie',
        data: {
            labels: ["정답", "오답", "시간 초과", "컴파일 에러", "런타임 에러", "표현 오류"],
            datasets: [
                {
                    data: [<?php echo $line['solved'].', '.$line['wrong'].', '.$line['tle'].', '.$line['cperr'].', '.$line['rterr'].', '.$line['exprerr']; ?>],
                    backgroundColor: ["#33CCFF", "#FF1A1A", "#CC33FF", "#CC6600", "#E6E600", "#4DFF4D"],
                    hoverBackgroundColor: ["#66D9FF", "#FF4D4D", "#D966FF", "#FF8000", "#FFFF00", "#80FF80"]
                }
            ]
        },
        options: {
            responsive: true
        }
    });
    </script>
  </body>
</html>
