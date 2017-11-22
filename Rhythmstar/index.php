<?php
require_once("./include/constants.php")
require_once("./include/db_info.inc.php")
function judge(int $submit_code, int $problem_code, $lang_extension){
    //$result = $db_conn->mysqli_query("select * from compileinfo where solution_id = " + $submit_code);
    //$info= $result->fetch_field()
    $right = 1;
    $path = $OJ_DATA+"/";
    $spath = $OJ_DATA+"/submit/" + $submit_code;
    $ppath = $OJ_DATA+"/" + $problem_code + "/";
    $setting = fopen($ppath + "properties" + fileextension::Text);
    $sol_count = intval(fgets($setting));
    fclose($setting);
    $judgeresult = array();
    //state: compiling
    switch($lang_extension){
        case fileextension::Cpp:
        exec("g++ "+ $path + $submit_code + fileextension::Cpp + " -o " + $spath + " -std=c++1z");
        exec("cd " + $path + "submit/");
	for($i = 1; $i <= $sol_count; $i++){
            $result = exec("./" + $submit_code + " < " + $ppath + "input" + $i + fileextension::Text);
	    $solution = exec("cat " + $ppath + "answer" + $i + fileextension::Text);
	    if(strcmp($result, $solution) == 0){
	        array.push($judgeresult, "O");
	    }
	    else{
		array.push($judgeresult, "X");
		right = 0;
	    }
	}
        break;
        case fileextension::Java:
	exec("javac " + $path + $submit_code + fileextension::Java);
	for($i = 1; $i <= $sol_count; $i++){
	    $input = exec("cat " + $ppath + "input" + $i + fileextension::Text);
            $result = exec("./" + $submit_code + $input);
	    $solution = exec("cat " + $ppath + "answer" + $i + fileextension::Text);
	    if(strcmp($result, $solution) == 0){
	        array.push($judgeresult, "O");
	    }
	    else{
		array.push($judgeresult, "X");
		right = 0;
	    }
	}
        break;
    }
}
?>
