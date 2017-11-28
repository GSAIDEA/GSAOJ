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
        <p class="lead">v0.9.6 beta testing</p>
        <hr>
        <h2><strong>주의사항</strong></h2>
        <p>
        GITHUB에 업로드되었습니다. url은 <code><a href="https://github.com/GSAIDEA/GSAOJ">https://github.com/GSAIDEA/GSAOJ/</a></code>입니다.<br><strong>앞으로 패치 시마다 index.php와 Github의 Issue에 모두 변경사항을 작성해주시기 바랍니다.</strong><br>
        채점이 되지 않는 언어로 제출하지 마세요!(예: Python, Java, C# 등)<br>
        </p>
        <hr>
        <h3>패치노트</h3>
        <p>
        채점 프로세스를 다시 한번 개선하고, DB 구조를 개선했습니다.
        </p>
        <hr>
        <h3>개선요망</h3>
        <p>
        FINUE씨 일하세요<br>
        $ cos 2\theta = cos^2\theta - sin^2\theta $<br>
        <strong>문제 목록에서 자신이 푼 문제를 표시하게 해주세요!ㅠㅠ</strong>
        </p>
        <hr>
        수정요망<br>
        <code>userinfo.php</code><br>
	오답이유/에러 출력 페이지(이름 미정)<br>
        <p>제출한 답안이 틀린 이유는 <code>/home/judge/problem/[problem_id]/submit/[submit_id]</code>에 잘 들어가 있습니다. 다만 현재 정답과 완전히 같은데도 틀리는 오류가 있는 것으로 보이고, 오류 내용을 웹서버로 출력하는 기능이 없습니다.</p>
        <p>
        </p>
        <hr>
        <h3>역할 분담</h3>
        Frontend: FINUE<br>
        Front~Backend: Rhythmstar<br>
        Deep-Dark-end: appleseed<br>
        Unknown: applist<br>
      </div>

    </main>

    <?php require("importjs.php");?>
    <?php require("footer.php");?>

  </body>
</html>
