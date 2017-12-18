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
				$err_problem_id = !($problem_data = $res->fetch(PDO::FETCH_ASSOC));
			} catch(PDOException $e) {
				$err_problem_id = true;
			}
		}
	}
?>
<!DOCTYPE html>
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

    <!-- For mathematics -->
    <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
    </script>
    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
    <script src="http://cdn.jsdelivr.net/npm/clipboard@1/dist/clipboard.min.js"></script>
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
            <h4 class='text-center'><?php echo sprintf($MSG_ERR_NOT_FOUND, "ID"); ?></h4>
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
            <h4><?php echo $MSG_PROBLEM_INPUT_EX;?>
	      <button type='button' style="padding: 0px" class='btn btn-link copy-button' data-clipboard-target='#sample-input'>복사</button>
	    </h4>
            <hr>
            <p><code id='sample-input'><?php echo $problem_data['sample_input'];?></code></p>
          </div>
          <div class='col-md-6 margin-bottom-50'>
            <h4><?php echo $MSG_PROBLEM_OUTPUT_EX;?>
	      <button type='button' style="padding: 0px" class='btn btn-link copy-button' data-clipboard-target='#sample-output'>복사</button>
   	    </h4>
            <hr>
            <p><code id='sample-output'><?php echo $problem_data['sample_output'];?></code></p>
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
    <script>
      var clipboard = new Clipboard('.copy-button');
      clipboard.on('success', function(e){
	e.clearSelection();
      });
    </script>
    <script src="problem.js"></script>
    <?php require("importjs.php");?>
    <?php require("footer.php");?>

  </body>
</html>
