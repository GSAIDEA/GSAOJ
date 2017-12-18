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
    <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
    </script>
    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

    <?php require("importcss.php");?>

  </head>
  <body>
    <!-- navbar -->
    <?php require("nav.php");?>

    <main role="main">
      <div class="jumbotron">
        <h1>GSA Online Judge</h1>
        <p class="lead">v0.9.8 beta testing</p>
        <hr>
        <h2><strong>주의사항</strong></h2>
        <p>
        github에 업로드되었습니다. url은 <code><a href="https://github.com/GSAIDEA/GSAOJ">https://github.com/GSAIDEA/GSAOJ/</a></code>입니다.<br><strong>앞으로 패치 시마다 index.php와 Github의 Issue에 모두 변경사항을 작성해주시기 바랍니다.</strong><br>
        채점이 되지 않는 언어로 제출하지 마세요!(예: Python, Java, C# 등)<br>
        </p>
        <hr>
        <h3>패치노트</h3>
        <p>
        Python2, Python3 채점이 가능합니다.<br>
        채점 결과에 '표현 에러'가 추가되었습니다. 또한 출력 맨 마지막 공백과 무관하게 채점됩니다. 자세한 사항은 1001번 문제를 통해 확인하세요!<br>
	userinfo.php가 만들어졌습니다.<br>
	개인정보 수정 페이지가 완성되었습니다.
        </p>
        <hr>
        <h3>개선요망</h3>
        <p>
        Python의 경우 종종 runtime error를 stderr가 아닌 stdout로 뱉는 오류가 있습니다.<br>
        프로그램 실행 시간, 메모리가 표시되지 않습니다.
        </p>
        <hr>
        <h3>역할 분담</h3>
        Frontend: FINUE<br>
        Front~Back~Deep-Dark-end: Rhythmstar<br>
        Front~Deep-Dark-end: appleseed<br>
        Problem Management: applist<br>
      </div>

    </main>

    <?php require("importjs.php");?>
    <?php require("footer.php");?>

  </body>
</html>
