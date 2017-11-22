<?php
	require_once("include/db_info.php");
	require_once("include/setlang.php");

	if(!isset($_GET['id'])) {
		$err_problem_id = true;
	}
	else {
		$request_id = $_GET['id'];
		$err_problem_id = !$request_id;
		if(!$err_problem_id) {
			$res = $db_conn->prepare("select * from problem where problem_id=".$request_id);
			try {
				$res->execute();
				$res->setFetchMode(PDO::FETCH_ASSOC);
				$err_problem_id = !($problem_data = $res->fetch());
			} catch(PDOException $e) {
				$err_problem_id = true;
			}
		}
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

    <?php if($err_problem_id) echo "    <meta http-equiv='refresh' content='3; url=./problemset.php'>";?>

    <?php require("importcss.php");?>

  </head>
  <body>
    <!-- navbar -->
    <?php require("nav.php");?>

    <main role="main">
      <div class="container" id="problem_expression">
        <div class="row margin-bottom-20"></div>

<?php
if($err_problem_id) { ?>
        <div class='row'>
          <div class='col-md-12'>
            <h4 class='text-center'><?php echo $MSG_ERR_PROBLEM_ID; ?></h4>
          </div>
        </div>
<?php }
else { ?>
        <div class='row'>
          <div class='col-md-12 margin-bottom-20'>
            <h3 class='text-center margin-bottom-10'><?php echo $request_id.": ".$problem_data['title']; ?></h3>
            <p class='text-center'><?php echo $MSG_PROBLEM_TL.": ".$problem_data['time_limit'];?>sec&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $MSG_PROBLEM_ML.": ".$problem_data['memory_limit'];?>MB</p>
          </div>
          <div class='col-md-12 margin-bottom-30' id='hide_when_iframe_div'>
            <ul class='nav justify-content-center'>
              <li class='nav-item'>
                <a class='nav-link' href='./editor.php?id=<?php echo $request_id;?>'><?php echo $MSG_SUBMIT;?></a>
              </li>
              <li class='nav-item'>
                <a class='nav-link' href='./status.php?pid=<?php echo $_GET['id'];?>'><?php echo $MSG_STATUS;?></a>
              </li>
              <li class='nav-item'>
                <a class='nav-link' href='./problemrank.php?id=<?php echo $_GET['id'];?>'><?php echo $MSG_RANK;?></a>
              </li>
            </ul>
          </div>
          <div class='col-md-12 margin-bottom-50'>
            <h4><?php echo $MSG_PROBLEM_DESC;?></h4>
            <hr>
            <p><?php echo $problem_data['description']; ?></p>
          </div>
          <div class='col-md-12 margin-bottom-50'>
            <h4><?php echo $MSG_PROBLEM_INPUT;?></h4>
            <hr>
            <p><?php echo $problem_data['input'];?></p>
          </div>
          <div class='col-md-12 margin-bottom-50'>
            <h4><?php echo $MSG_PROBLEM_OUTPUT; ?></h4>
            <hr>
            <p><?php echo $problem_data['output'];?></p>
          </div>
          <div class='col-md-6 margin-bottom-50'>
            <h4><?php echo $MSG_PROBLEM_INPUT_EX;?></h4>
            <hr>
            <p><?php echo $problem_data['sample_input'];?></p>
          </div>
          <div class='col-md-6 margin-bottom-50'>
            <h4><?php echo $MSG_PROBLEM_OUTPUT_EX;?></h4>
            <hr>
            <p><?php echo $problem_data['sample_output'];?></p>
          </div>
          <div class='col-md-12 margin-bottom-50'>
            <h4><?php echo $MSG_PROBLEM_HINT;?></h4>
            <hr>
            <p><?php echo $problem_data['hint'];?></p>
          </div>
          <div class='col-md-12 margin-bottom-50'>
            <h4><?php echo $MSG_PROBLEM_SOURCE;?></h4>
            <hr>
            <p><?php echo $problem_data['source'];?></p>
          </div>
        </div>
<?php } ?>
      </div>
    </main>
    <script src="problem.js"></script>
    <?php require("importjs.php");?>
    <?php require("footer.php");?>

  </body>
</html>
