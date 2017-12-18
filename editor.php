<?php
require_once("include/db_info.php");
require_once("include/setlang.php");
require_once("include/include_auth.php");
if (!$auth->islogged()) {
    echo "<script>window.location = \"./login.php\";</script>";
    die();
}
$sessionuid=$auth->getSessionUID($auth->getSessionHash());
if (isset($_GET['submitid'])) {
    $stmt = $db_conn->prepare("select uid, language from submit where submit_id=:sub");
    $stmt->execute([":sub"=>$_GET['submitid']]);
    $res = $stmt->fetch();
    if ($res['uid'] != $auth->getSessionUID($auth->getSessionHash())) {
        echo "<script>alert($MSG_WRONG_APPROACH); window.history.back();</script>";
        die();
    }
}
require("include/setlang.php");
?>
  <!doctype html>
  <html lang="en">

  <head>

    <title>
      <?php echo $OJ_NAME;?>
    </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php require("importcss.php");?>

  </head>

  <body style="padding-top:0;">
    <header>
      <nav class="navbar navbar-expand navbar-light bg-light">
        <ul class="nav navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="./problem.php?id=<?php echo $_GET['id'];?>">
              <?php echo $MSG_EDITOR_BACK;?>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:;" id="select_code" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $MSG_EDITOR_C;?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <?php
$langq=$db_conn->query("select * from language");
foreach ($langq as $lang) {
    ?>
                <a class="dropdown-item" href="javascript:sel_lang('<?php echo $lang['language']; ?>')">
                  <?php echo $lang['language']; ?>
                </a>
                <?php
}?>
            </div>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="nav-item">
            <a class="nav-link" href="javascript:submitfunction();">
              <?php echo $MSG_SUBMIT;?>
            </a>
          </li>
        </ul>
      </nav>
    </header>
    <div id="editor"></div>
    <iframe id="right" src="./problem.php?id=<?php echo $_GET['id'];?>" align="right" width="49%" frameBorder="0">인터넷 익스플로러를 사용하지 마세요</iframe>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.9/ace.js" type="text/javascript" charset="utf-8"></script>
    <script>
      var language = "C";
      var editor = ace.edit("editor");
      editor.setTheme("ace/theme/monokai");
      editor.getSession().setMode("ace/mode/c_cpp");
      editor.setFontSize(20);
      editor.focus();
      document.getElementById('editor').style.top = '56px';
      editor.renderer.setPadding(10);
      editor.container.style.lineHeight = 1.5
      editor.renderer.updateFontSize();

      <?php
if (isset($_GET['submitid'])) {
        $ext_stmt = $db_conn->prepare("select extension from language where language=:lang");
        $ext_stmt->execute([":lang"=>$res['language']]);
        $extension = $ext_stmt->fetch()['extension'];
        $fp = fopen("/home/judge/problem/".$_GET['id']."/submit/".$_GET['submitid']."/Main".$extension, "r");
        $code = fread($fp, filesize("/home/judge/problem/".$_GET['id']."/submit/".$_GET['submitid']."/Main".$extension)); ?>
      sel_lang("<?php echo $res['language']; ?>");
      editor.insert(<?php echo json_encode($code); ?>);
      <?php
    }?>

      function submitfunction() {
        var code = editor.getValue();
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", <?php echo "\"./submit.php?id=".$_GET['id']."&lang=\"";?> + editor.getSession().getMode().$id);

        var codeinput = document.createElement("input");
        codeinput.setAttribute("type", "hidden");
        codeinput.setAttribute("name", "code");
        codeinput.setAttribute("value", code);
        var langinput = document.createElement("input");
        langinput.setAttribute("type", "hidden");
        langinput.setAttribute("name", "lang");
        langinput.setAttribute("value", language);
        form.appendChild(codeinput);
        form.appendChild(langinput);
        document.body.appendChild(form);
        form.submit();
      }

      function sel_lang(lang) {
        switch (lang) {
          case 'C':
            editor.getSession().setMode("ace/mode/c_cpp");
            document.getElementById("select_code").innerHTML = "C";
            language = "C";
            break;
          case 'C++':
            editor.getSession().setMode("ace/mode/c_cpp");
            document.getElementById("select_code").innerHTML = "C++";
            language = "C++";
            break;
          case 'C++11':
            editor.getSession().setMode("ace/mode/c_cpp");
            document.getElementById("select_code").innerHTML = "C++11";
            language = "C++11";
            break;
          case 'C++14':
            editor.getSession().setMode("ace/mode/c_cpp");
            document.getElementById("select_code").innerHTML = "C++14";
            language = "C++14";
            break;
          case 'C++1z':
            editor.getSession().setMode("ace/mode/c_cpp");
            document.getElementById("select_code").innerHTML = "C++1z";
            language = "C++1z";
            break;
          case 'Java':
            alert("C/C++ 이외는 준비중입니다!");
            //          editor.getSession().setMode("ace/mode/java");
            //          document.getElementById("select_code").innerHTML = "Java"
            //          language = "Java";
            document.getElementById("select_code").innerHTML = "C++"
            break;
          case 'Python2':
            language = "Python2";
            editor.getSession().setMode("ace/mode/python");
            document.getElementById("select_code").innerHTML = "Python2"
            break;
          case 'Python3':
            language = "Python3";
            editor.getSession().setMode("ace/mode/python");
            document.getElementById("select_code").innerHTML = "Python3";
            break;
          case 'C#':
            alert("C/C++ 이외는 준비중입니다!");
            //          $language = "C#";
            //          editor.getSession().setMode("ace/mode/csharp");
            //          document.getElementById("select_code").innerHTML = "C#"
            document.getElementById("select_code").innerHTML = "C++"
            break;
          default:
            alert("시도는 좋았지만 그런 언어는 없어요");
            break;
        }
      }
      var jedit = document.getElementById("editor");
      jedit.ondragover = function() {
        return false;
      }
      jedit.ondragend = function() {
        return false;
      }
      jedit.ondrop = function(e) {
        e.preventDefault();
        var file = e.dataTransfer.files[0];
        var reader = new FileReader();
        reader.onload = function(event) {
          editor.navigateFileEnd();
          editor.insert(event.target.result);
        }
        reader.readAsText(file);
        return false;
      }
      window.addEventListener("resize", function() {
        if (window.innerWidth < window.screen.availWidth / 2) {
          document.getElementById("right").style.display = "none";
          jedit.style.right = "0";
        } else {
          document.getElementById("right").style.display = "inline";
          jedit.style.right = "49%";
        }
      })
    </script>
    <?php require("importjs.php");?>
  </body>

  </html>
