<?php
    require_once("../include/db_info.php");
    require_once("../include/setlang.php");
?>
<nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
	<ul class="nav nav-pills flex-column">
		<li class="nav-item">
			<a class="nav-link" href="./addnews.php">
				<?php echo $MSG_ADMIN_ADD_NEWS;?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="./listnews.php">
				<?php echo $MSG_ADMIN_LIST_NEWS;?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="./addproblem.php">
				<?php echo $MSG_ADMIN_ADD_PROBLEM;?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="./listproblem.php">
				<?php echo $MSG_ADMIN_LIST_PROBLEM;?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="./user.php">
				<?php echo $MSG_ADMIN_USER;?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="./addcontest.php">
				<?php echo $MSG_ADMIN_ADD_CONTEST;?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="./listcontest.php">
				<?php echo $MSG_ADMIN_LIST_CONTEST;?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="./changepasswd.php">
				<?php echo $MSG_ADMIN_CHANGE_PASSWD;?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="./addprivilege.php">
				<?php echo $MSG_ADMIN_ADD_PRIVILEGE;?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="./listprivilege.php">
				<?php echo $MSG_ADMIN_LIST_PRIVILEGE;?>
			</a>
		</li>
	</ul>
</nav>
