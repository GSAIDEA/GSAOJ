<?php
require_once(__DIR__."/../PHPAuth/Config.php");
require_once(__DIR__."/../PHPAuth/Auth.php");
require_once(__DIR__."/../include/db_info.php");
$config = new PHPAuth\Config($db_conn);
$auth = new PHPAuth\Auth($db_conn, $config);
