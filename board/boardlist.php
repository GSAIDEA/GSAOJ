<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <?php
    require_once '../include/include_auth.php';
    require_once '../include/setlang.php';
    require_once '../include/db_info.php';
    require_once '../importcss.php';
    if (isset($_GET['page'])) {
        $request_page = $_GET['page'];
    } else {
        $request_page = 0;
    }

    ?>
    <title>
      <?php echo $OJ_NAME; ?>
    </title>
</head>

<body>
  <?php require_once '../nav.php'; ?>
  <main role="main">
    <div class="container">
      <div class="row margin-bottom-20">
      </div>
      <div class="row margin-bottom-20">
        <h3 class="mx-auto"><?php echo $MSG_BOARDLIST; ?></h3>
      </div>
      <div class="row margin-bottom-20">
        <nav class="mx-auto">
          <ul class="pagination">
            <li class="page-item"><a class="page-link" href="boardlist.php">&lt;&lt;</a></li>
            <li class="page-item <?php if ($request_page == 0) {
        echo " active ";
    }?>"><a class="page-link" href="boardlist.php">1</a></li>
            <?php
              for ($i=1; $i<=$page_count; $i++) {
                  if ($i == $request_page) {
                      $temp_active = " active";
                  } else {
                      $temp_active = "";
                  } ?>
              <li class="page-item<?php echo $temp_active; ?>">
                <a class="page-link" href="boardlist.php?page=<?php echo $i; ?>">
                  <?php echo $i+1; ?>
                </a>
              </li>
              <?php
              }?>
                <li class="page-item"><a class="page-link" href="boardlist.php?page=<?php echo $page_count;?>">&gt;&gt;</a></li>
                <?php $db_conn->prepare("select post_num, title, ") ?>
          </ul>
        </nav>
      </div>
    </div>
  </main>
  <?php require_once '../importjs.php'; require_once '../footer.php';?>
</body>

</html>
