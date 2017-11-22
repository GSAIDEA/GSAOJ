<!DOCTYPE html>
<?php
require("include/include_auth.php");
if(!$auth->islogged()){
	echo "<script>window.location = \"./login.php\";</script>";
    die();
}
require("include/setlang.php");
?>
<head>
  <style type="text/css" media="screen">
    #editor{
      position: absolute;
      top: 0;
      right: 49%;
      bottom: 0;
      left: 0;
      float: left;
    }
    #right{
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      max-width: 49%;
      height: calc(100vh - 56px);
    }
  </style>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <meta charset="utf-8">
</head>

<body>
  <nav class="navbar navbar-expand-md navbar-light bg-light">
    <ul class="nav navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="./problem.php?id=<?php echo $_GET['id'];?>"><?php echo $MSG_EDITOR_BACK;?></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:;" id="select_code" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $MSG_EDITOR_CPP;?></a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="javascript:sel_lang('C++')"><?php echo $MSG_EDITOR_CPP;?></a>
	  <a class="dropdown-item" href="javascript:sel_lang('C')"><?php echo $MSG_EDITOR_C;?></a>
          <a class="dropdown-item" href="javascript:sel_lang('C#')"><?php echo $MSG_EDITOR_CSHARP;?></a>
          <a class="dropdown-item" href="javascript:sel_lang('Java')"><?php echo $MSG_EDITOR_JAVA;?></a>
          <a class="dropdown-item" href="javascript:sel_lang('Python')"><?php echo $MSG_EDITOR_PYTHON;?></a>
        </div>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="nav-item">
        <a class="nav-link" href="javascript:submitfunction();"><?php echo $MSG_SUBMIT;?></a>
      </li>
    </ul>
  </nav>

  <?php
  $sessionuid=$auth->getSessionUID($auth->getSessionHash());
  ?>
  <div id="editor"></div>
  <iframe id="right" src="./problem.php?id=<?php echo $_GET['id'];?>" align="right" width="49%" frameBorder="0">인터넷 익스플로러를 사용하지 마세요</iframe>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.9/ace.js" type="text/javascript" charset="utf-8"></script>
  <script>
    var language = "C++";
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/c_cpp");
    editor.setFontSize(20);
    editor.focus();
    document.getElementById('editor').style.top='56px';
    editor.renderer.setPadding(10);
    editor.container.style.lineHeight = 1.5
    editor.renderer.updateFontSize();

    <?php
    if(isset($_GET['submitid'])){
	$fp = fopen("/home/judge/problem/".$_GET['id']."/submit/".$_GET['submitid']."/Main.cpp","r");
	$code = fread($fp,filesize("/home/judge/problem/".$_GET['id']."/submit/".$_GET['submitid']."/Main.cpp"));
    ?>
	editor.insert(<?php echo json_encode($code);?>);
    <?php
    }
    ?>

    function submitfunction(){
      var code = editor.getValue();
      var form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute("action", <?php echo "\"./submit.php?id=".$_GET['id']."&lang=\"";?> + editor.getSession().getMode().$id);

    //히든으로 값을 주입시킨다.
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

    function sel_lang(lang){
      switch(lang){
	case 'C':
          editor.getSession().setMode("ace/mode/c_cpp");
          document.getElementById("select_code").innerHTML = "C";
          language = "C";
	  break;
        case 'C++':
          editor.getSession().setMode("ace/mode/c_cpp");
          document.getElementById("select_code").innerHTML = "C++"
          language = "C++";
          break;
        case 'Java':
          alert("C/C++ 이외는 준비중입니다!");
//          editor.getSession().setMode("ace/mode/java");
//          document.getElementById("select_code").innerHTML = "Java"
//          language = "Java";
          document.getElementById("select_code").innerHTML = "C++"
          break;
        case 'Python':
          alert("C/C++ 이외는 준비중입니다!");
//          language = "Python";
//          editor.getSession().setMode("ace/mode/python");
//          document.getElementById("select_code").innerHTML = "Python"
          document.getElementById("select_code").innerHTML = "C++"
          break;
        case 'C#':
          alert("C/C++ 이외는 준비중입니다!");
//          $language = "C#";
//          editor.getSession().setMode("ace/mode/csharp");
//          document.getElementById("select_code").innerHTML = "C#"
          document.getElementById("select_code").innerHTML = "C++"
          break;
	default:
	  alert("꺼지세요");
	  break;
      }
    }
    var jedit = document.getElementById("editor");
    jedit.ondragover = function() {
        return false;
    }
    jedit.ondragend = function(){
        return false;
    }
    jedit.ondrop = function(e){
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
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
