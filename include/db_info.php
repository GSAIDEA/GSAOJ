<?php @session_start();
ini_set("display_errors","Off");  //set this to "On" for debugging  ,especially when no reason blank shows up.
ini_set("session.cookie_httponly", 1);
header('X-Frame-Options:SAMEORIGIN');

// connect db
static 	$DB_HOST="localhost";
static 	$DB_NAME="testoj";
static 	$DB_USER="testoj";
static 	$DB_PASS="Testoj1111!";

static 	$OJ_NAME="GSA Online Judge";
static 	$OJ_HOME="./";
static 	$OJ_ADMIN="root@localhost";
static 	$OJ_DATA="/home/judge/data";
static  $OJ_LANG="ko";
static	$PAGE_LINE=50;

date_default_timezone_set("Asia/Seoul");
try{
	$db_conn = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS);
	$db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex){
	echo "데이터베이스에 연결할 수 없습니다.".PHP_EOL; //user friendly message
	echo $ex->getMessage();
}
?>
