<?php
    require_once("include/db_info.php");
    require_once("include/setlang.php");
    require_once("include/include_auth.php");
    $nav_url = basename($_SERVER['REQUEST_URI']);
    $nav_uid = $auth->getSessionUID($auth->getSessionHash());
?>

  <header class="margin-bottom-20" id="hide_when_iframe_nav">
    <nav class="navbar navbar-expand-md fixed-top navbar-light bg-light">
      <a class="navbar-brand" href="./index.php">
        <?php echo $OJ_NAME;?>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      <div class="navbar-collapse collapse" id="navbarCollapse">
        <ul class="nav navbar-nav mr-auto">
          <li class="nav-item <?php if (explode(" ? ", $nav_url)[0] == "problemset.php ") {
    echo "active ";
}?>">
            <a class="nav-link" href="./problemset.php">
              <?php echo $MSG_PROBLEMSET;?>
            </a>
          </li>
          <li class="nav-item <?php if (explode(" ? ", $nav_url)[0] == "status.php ") {
    echo "active ";
}?>">
            <a class="nav-link" href="./status.php">
              <?php echo $MSG_STATUS;?>
            </a>
          </li>
          <li class="nav-item <?php if (explode(" ? ", $nav_url)[0] == "rank.php ") {
    echo "active ";
}?>">
            <a class="nav-link" href="./rank.php">
              <?php echo $MSG_RANK;?>
            </a>
          </li>
        </ul>
        <ul class="nav navbar-nav">
          <li class="nav-item dropdown">
            <!-- here should be changed when user logs in -->
            <?php if (!$auth->islogged()) {
    ?>
            <a class="nav-link dropdown-toggle" href="javascript:;" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">LOGIN</a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="./login.php">
                <?php echo $MSG_LOGIN; ?>
              </a>
              <a class="dropdown-item" href="./register.php">
                <?php echo $MSG_CREATEACCOUNT; ?>
              </a>
            </div>
            <?php
} else {
        ?>
              <a class="nav-link dropdown-toggle" href="javascript:;" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php $id = $auth->getUser($auth->getSessionUID($auth->getSessionHash()));
        echo $id['userid']; ?>
</a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="userinfo.php?uid=<?php echo $nav_uid; ?>">
                  <?php echo $MSG_ACCOUNTINFO; ?>
                </a>
                <a class="dropdown-item" href="status.php?uid=<?php echo $nav_uid; ?>">
                  <?php echo $MSG_SUBMITINFO; ?>
                </a>
                <a class="dropdown-item" href="logout.php">
                  <?php echo $MSG_LOGOUT; ?>
                </a>
                <?php
        $privilege_stmt = $db_conn->prepare("select type from privilege where id=".$nav_uid);
        $privilege_stmt->execute();
        $privilege = $privilege_stmt->fetch();
        if (strcmp($privilege['type'], "admin") == 0) {
            echo "<a class=\"dropdown-item\" href=\"./admin/\">".$MSG_ADMIN."</a>";
        } ?>
              </div>

              <?php
    } ?>
          </li>
        </ul>
      </div>
    </nav>
  </header>
