<?php
    require_once("include/include_auth.php");
    require_once("include/db_info.php");
    require_once("include/setlang.php");
?>
<head>
    <title><?php echo $OJ_NAME;?> </title>
</head>
<body>
<?php
    if(!$auth->isLogged()){
        header('HTTP/1.0 403 Forbidden');
        echo "<script>alert(\"".$MSG_ERR_NOT_LOGGEDIN."\")</script>";
	echo "<script>history.back()</script>";
    }
    else{
        $auth->logout($auth->getSessionHash());
        echo "<script type='text/javascript'>window.location =\"./index.php\";</script>";
    }
?>
</body>
