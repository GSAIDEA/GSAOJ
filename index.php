<?php
	require_once("include/db_info.php");
	require_once("include/setlang.php");
?>
<!doctype html>
<html lang="en">
  <head>

    <title><?php echo $OJ_NAME;?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php require("importcss.php");?>

  </head>
  <body>
    <!-- navbar -->
    <?php require("nav.php");?>

    <main role="main">
      <div class="jumbotron">
        <h1>GSA Online Judge</h1>
        <p class="lead">v0.9.4 beta testing</p>
        <hr>
        <h2><strong>주의사항</strong></h2>
        <p>
        현재 채점 시스템을 개선하고 있습니다. <span style="color:red"><strong>코드를 제출하지 마세요!</strong></span><br>
        채점이 되지 않는 언어로 제출하지 마세요!(예: Python, Java, C# 등)<br>
        </p>
        <hr>
        <h3>패치노트</h3>
        <p>
        채점 프로세스가 개선되었습니다.<br>
        DB 구조가 크게 개선되었습니다.<br>
        <code>problem_upload</code>를 통해 문제를 업로드할 수 있습니다. 사용방법: <code>$ /home/judge/problem_upload</code> 이후 instruction을 잘 따르면 됩니다.<br>
        <code>create_answer</code>를 통해 정답 소스가 있다면 넣어둔 <code>n.in</code>들에 대한 <code>n.out</code> 파일을 자동으로 생성할 수 있습니다. (다만 <code>n.in</code>은 직접 넣어야 합니다.) 사용방법: <code>$ /home/judge/create_answer [problem_id] [solution executable path]</code>
        </p>
        <hr>
        <h3>발견된 오류</h3>
        <p>
        <code>problem</code> 테이블의 <code>solved</code> 값이 정답이 나올 때마다 값이 증가하지 않는 오류가 있습니다.<br>
        <code>testoj/template</code>이 아닌 <code>testoj</code>나 다른 디렉터리로 접근을 요청하는 경우 서버 내 파일/디렉터리를 전부 보여주는 심각한 보안 오류가 있습니다.<br>
        한 문제를 여러 번 맞췄을 때 <code>submit</code>과 <code>solved</code>가 모두 증가하는 오류가 있습니다.<br>
        <code>C++</code>은 채점이 되지만 <code>C</code>는 채점이 되지 않습니다.<br>
        비밀번호 난이도 조건을 <strong>며느리</strong>도 모릅니다.<br>
        자신이 제출한 코드를 확인할 수 있으나, 보안 오류가 있는 것으로 보입니다.(주소창에서 <code>submit_id</code>로 접근 가능)<br>
        <code>submit</code> 테이블의 <code>select</code> 쿼리에 심각한 문제가 있는 것으로 예상됩니다.<br>
        </p>
        <hr>
        수정요망<br>
        <code>userinfo.php</code><br>
	<p>제출한 답안이 틀린 이유를 시어머님도 모릅니다. 채점 프로그램은 답안이 왜 틀렸는지 제출된 코드와 같은 디렉토리에 넣어주시길 바랍니다.</p>
        <p>
        </p>
      </div>

    </main>

    <?php require("importjs.php");?>
    <?php require("footer.php");?>

  </body>
</html>
