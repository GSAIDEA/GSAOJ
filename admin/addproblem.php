<?php
require_once("../include/db_info.php");
require_once("../include/setlang.php");
require("checkprivilege.php");
?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $OJ_NAME;?></title>

    <?php require("importcss.php");?>
  </head>

  <body>
    <?php require("nav-admin-top.php");?>
    <div class="container-fluid">
      <div class="row">
        <?php require("nav-admin.php");?>
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
          <h1><?php echo $MSG_ADMIN_ADD_PROBLEM;?></h1>
          <hr>
          <form class="form-group" action="addproblem.php" method="post">
            <label for="id"><?php echo $MSG_PROBLEM_ID;?></label>
            <input type="number" class="form-control" id="id" min="1">
            <label for="title"><?php echo $MSG_PROBLEM_TITLE;?></label>
            <input type="text" class="form-control" id="title">
            <label for="desc"><?php echo $MSG_PROBLEM_DESC;?></label>
            <textarea class="form-control" rows="5" id="desc"></textarea>
            <div class="row">
              <div class="col-md-6">
                <label for="input"><?php echo $MSG_PROBLEM_INPUT;?></label>
                <textarea class="form-control" rows="3" id="input"></textarea>
                <label for="input_ex"><?php echo $MSG_PROBLEM_INPUT_EX;?></label>
                <textarea class="form-control" rows="3" id="input_ex"></textarea>
              </div>
              <div class="col-md-6">
                <label for="output"><?php echo $MSG_PROBLEM_OUTPUT;?></label>
                <textarea class="form-control" rows="3" id="output"></textarea>
                <label for="output_ex"><?php echo $MSG_PROBLEM_OUTPUT_EX;?></label>
                <textarea class="form-control" rows="3" id="output_ex"></textarea>
              </div>
            </div>
            <label for="hint"><?php echo $MSG_PROBLEM_HINT;?></label>
            <textarea class="form-control" rows="2" id="hint"></textarea>
            <label for="source"><?php echo $MSG_PROBLEM_SOURCE;?></label>
            <input type="text" class="form-control" id="source">
            <div class="row">
              <div class="col-md-6">
                <label for="tl"><?php echo $MSG_PROBLEM_TL;?></label>
                <input type="number" class="form-control" id="tl" min="1">
              </div>
              <div class="col-md-6">
                <label for="ml"><?php echo $MSG_PROBLEM_ML;?></label>
                <input type="number" class="form-control" id="ml" min="1">
              </div>
            </div>
	    <button class="btn btn-primary" type="submit"><?php echo $MSG_PROBLEM_SUBMIT;?></button>
          </form>
          <div class="row">
            <div class="col-md-12">
              <button type="button" class="btn btn-primary"><?php echo $MSG_ADMIN_ADD_PROBLEM_PREVIEW;?></button>
              <button type="button" class="btn btn-primary"><?php echo $MSG_ADMIN_ADD_PROBLEM_SUBMIT;?></button>
            </div>
          </div>
        </main>
      </div>
    </div>
    <?php require("../importjs.php");?>
  </body>

</html>
