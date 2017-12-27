<?php
    require_once "include/db_info.php";
    require_once "include/setlang.php";
    require_once "include/include_auth.php";

    $id=$_GET['id'];
    if (!isset($_GET['page'])) {
        $request_page = 0;
    } else {
        $request_page = $_GET['page'];
    }
    if (isset($id)) {
        $res = $db_conn->prepare("select count(*) as row_count from submit where problem_id = ?;");
        $res->execute(array($id));
    } else {
        echo "<script>alert(\"".$MSG_ERR_WRONG_APPROACH."\")</script>";
        echo "<script>location.href = \" ./index.php\";</script>";
    }
    $res->setFetchMode(PDO::FETCH_ASSOC);
    $row_count = $res->fetch()['row_count'];

    if ($row_count == 0) {
        $page_count = 0;
    } else {
        $page_count = floor(($row_count-1)/$PAGE_LINE);
    }

    $err_status_page = $page_count < $request_page || $request_page < 0;
?>
  <!doctype html>
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

    <?php if ($err_status_page) {
    ?>
    <meta http-equiv='refresh' content='3; url=./status.php'>
    <?php
}
    require_once "importcss.php";
    ?>

  </head>

  <body>
    <!-- navbar -->
    <?php require_once "./nav.php";?>

    <main role="main">
      <div class="container">
        <div class="row margin-bottom-20"></div>

        <div class="row margin-bottom-20">
          <h3 class="mx-auto"><?php echo "문제 ".$_GET['id']." 순위" ;?></h3>
        </div>

        <div class="row margin-bottom-20">
          <nav class="mx-auto">
            <ul class="pagination">
              <li class="page-item"><a class="page-link" href="status.php">&lt;&lt;</a></li>
              <li class="page-item <?php if ($request_page == 0) {
        echo " active ";
    }?>"><a class="page-link" href="status.php">1</a></li>
              <?php
              for ($i=1; $i<=$page_count; $i++) {
                  if ($i == $request_page) {
                      $temp_active = " active";
                  } else {
                      $temp_active = "";
                  } ?>
                <li class='page-item<?php echo $temp_active; ?>'>
                  <a class='page-link' href='status.php?page=<?php echo $i; ?>'>
                    <?php echo $i+1; ?>
                  </a>
                </li>
                <?php
              }
            ?>
                  <li class='page-item'><a class='page-link' href='status.php?page=<?php echo $page_count;?>'>&gt;&gt;</a></li>
            </ul>
          </nav>
        </div>

        <div class="row">
          <?php
if ($err_status_page) {
                ?>
            <div class='col-md-12'>
              <h4 class='text-center'><?php echo sprintf($MSG_ERR_NOT_FOUND, "페이지"); ?></h4>
            </div>
            <?php
            } else {
    ?>
              <table class='table table-sm'>
                <thead>
                  <tr>
                    <th>
                      <?php echo $MSG_RANKING_RANK; ?>
                    </th>
                    <th>
                      <?php echo $MSG_STATUS_USER; ?>
                    </th>
                    <th>
                      <?php echo $MSG_STATUS_PROBLEM_NUM; ?>
                    </th>
                    <th>
                      <?php echo $MSG_STATUS_TIME_USAGE; ?>
                    </th>
                    <th>
                      <?php echo $MSG_STATUS_MEMORY_USAGE; ?>
                    </th>
                    <th>
                      <?php echo $MSG_STATUS_CODE_LENGTH; ?>
                    </th>
                    <th>
                      <?php echo $MSG_STATUS_LANGUAGE; ?>
                    </th>
                    <th>
                      <?php echo $MSG_STATUS_SUBMIT_DATE; ?>
                    </th>

                  </tr>
                </thead>
                <tbody>
                  <?php
    $res = $db_conn->prepare("select submit_id, uid, problem_id, state, time_usage, memory_usage, language, code_length, submit_date from submit where problem_id=:id and state=:state order by code_length asc,time_usage asc, memory_usage asc, submit_id desc limit ".($request_page*$PAGE_LINE).",".$PAGE_LINE.";");
    $res->execute([":id"=>$id, ":state"=>"correct"]);
    $res->setFetchMode(PDO::FETCH_ASSOC);
    $cnt=1;
    while ($line = $res->fetch()) {
        $user=$auth->getUser($line['uid']); ?>
                    <tr>
                      <th>
                        <?php echo $cnt; ?>
                      </th>
                      <th>
                        <a href='./userinfo.php?id=<?php echo $line['uid']; ?>'>
                          <?php echo $user['userid']; ?>
                        </a>
                      </th>
                      <th>
                        <a href='./problem.php?id=<?php echo $line['problem_id']?>'>
                          <?php echo $line['problem_id']; ?>
                      </th>
                      <th>
                        <?php echo $line['time_usage']; ?>MS</th>
                      <th>
                        <?php echo $line['memory_usage'] ?>KB</th>
                      <th>
                        <?php echo $line['code_length'] ?>B</th>
                      <th>
                        <?php echo $line['language'] ?>
                      </th>
                      <th>
                        <?php echo $line['submit_date'] ?>
                      </th>
                    </tr>
                    <?php
        $cnt=$cnt+1;
    } ?>
                </tbody>
              </table>
              <?php
} ?>
        </div>
      </div>
    </main>

    <?php require_once "importjs.php";?>
    <?php require_once "footer.php";?>

  </body>

  </html>
