<?php
require_once("include/db_info.php");
require_once("include/include_auth.php");
if(!$auth->islogged()){
	echo "<script>window.location = \"./login.php\";</script>";
	die();
}
if(!isset($_POST['code']) || !isset($_GET['id']) || !isset($_POST['lang'])){
	echo "오류가 생겼네요! 문의해보세요! 2초 후에 메인으로 돌아갑니다!";
	sleep(2);
	echo "<script>window.location = \"./index.php\";</script>";
	die();
}
function reform_lang($lang){
	switch($lang){
		case "C":
		return ".c";
		case "C++":
		case "C++11":
		case "C++14":
		case "C++1z":
		return ".cpp";
		case "Java";
		return ".java";
		case "Python":
		return ".py";
		case "C#":
		return ".cs";
		default:
		return "fuckyou";
	}
}

$userdata=$auth->getUser($auth->getSessionUID($auth->getSessionHash()));
$code = $_POST['code'];
$language = $_POST['lang'];
$extension = reform_lang($language);
$problem_no = $_GET['id'];
if(strlen($code) < 1){
	echo "<script>alert('코드를 작성해주세요');</script>";
	echo "<script>history.back();</script>";
	die();
}
if(strcmp($extension, "fuckyou") == 0){
	echo "<script>alert('오류가 발생했습니다.');</script>";
	echo "<script>history.back();</script>";
	die();
}
try{
$db_conn->beginTransaction();
$stmt = $db_conn->prepare("insert into submit (`state`, `uid`, `problem_id`, `code_length`, `language`) values(:state, :uid, :problem, :length, :language);");
$stmt->execute(array(":state" => "pending",
		":uid" => $auth->getSessionUID($auth->getSessionHash()),
		":problem" => $problem_no,
		":length" => strlen($code),
		":language" => $language
	));
$submit_stmt = $db_conn->prepare("select submit_id from submit where uid=:uid and problem_id=:problem order by submit_id desc");

$submit_stmt->execute(array(":uid" => $auth->getSessionUID($auth->getSessionHash()),
		":problem" => $problem_no,));
$submit_stmt->setFetchMode(PDO::FETCH_ASSOC);
$submit_id = $submit_stmt->fetch()['submit_id'];
$update_stmt = $db_conn->prepare("select submit from problem where problem_id=:problem for update");
$update_stmt -> execute(array(":problem" => $problem_no));
$update_stmt ->setFetchMode(PDO::FETCH_ASSOC);
$upsin = $update_stmt->fetch();
$submit_count = $upsin['submit'];
$insert_stmt = $db_conn->prepare("update problem set submit=:submit where problem_id=:problem");
$insert_stmt ->execute(array(
	":submit"=>$submit_count+1,
	":problem"=>$problem_no
));

$user_stmt = $db_conn->prepare("select submit from userdata where uid=:uid for update");
$user_stmt->execute(array(":uid"=>$userdata['id']));
$user_stmt->setFetchMode(PDO::FETCH_ASSOC);
$upsin2 = $user_stmt->fetch();
$submit_count = $upsin2['submit'];
$uinsert_stmt = $db_conn->prepare("update userdata set submit=:submit where uid=:uid");
$uinsert_stmt->execute(array(
	":submit"=>$submit_count+1,
	":uid"=>$userdata['id']
));
}
catch(Exception $e){
	$db_conn->rollBack();
	print_r($e);
}

mkdir("/home/judge/problem/".$problem_no."/submit/".$submit_id."/", 0711, true);
$submit = fopen("/home/judge/problem/".$problem_no."/submit/".$submit_id."/Main".$extension, "w");
if(fwrite($submit, $code) == false){
	die("file write error!");
	$db_conn->rollBack();
}
fclose($submit);
$db_conn->commit();

echo "<script>window.location = \"./status.php?uid=".$auth->getSessionUID($auth->getSessionHash())."\";</script>";
?>
