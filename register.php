<?php
	require_once("include/db_info.php");
	require_once("include/setlang.php");
	require_once("include/include_auth.php");
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
    <?php require("nav.php");
    if(isset($_POST['id']) && isset($_POST['pw']) && isset($_POST['pwvf']) && isset($_POST['email'])){
        $id = $_POST['id'];
        $email = $_POST['email'];
        $pw = $_POST['pw'];
        $pwvf = $_POST['pwvf'];
//        $captcha = $_POST['capcha'];
        $result = $auth->register($id, $email, $pw, $pwvf);
        if($result['error']){
            echo "<script>alert(\"".$result['message']."\");</script>";
        }
        else{
            try{
	        $getuid = $db_conn->prepare("select id from users where userid=:id");
	        $getuid->execute([':id' => $id]);
	        $uid = $getuid->fetch(PDO::FETCH_ASSOC);
                $res = $db_conn->prepare("INSERT INTO userdata (`uid`) VALUES (:uid)");
                $res -> execute([':uid'=>$uid['id']]);
            } catch(PDOException $e){
                echo $e->getMessage();
            }
	    echo "<script type='text/javascript'>window.location = \"./activate.php\";</script>";
	}
    }
    ?>

    <main role="main">
      <div class="container">
        <form class="form-register" action="register.php" method="post">
          <h2 class="margin-bottom-30"><?php echo $MSG_REG_PLZ;?></h2>
          <label for="inputId"><?php echo $MSG_REG_ID;?></label>
          <input type="text" name="id" class="form-control margin-bottom-20" placeholder="<?php echo $MSG_REG_ID_EX;?>" required>
          <label for="inputEmail"><?php echo $MSG_REG_EMAIL;?></label>
          <input type="email" name="email" class="form-control margin-bottom-20" placeholder="<?php echo $MSG_REG_EMAIL_EX;?>" required>
          <label for="inputPassword"><?php echo $MSG_REG_PW;?></label>
          <input type="password" name="pw" class="form-control margin-bottom-20" onkeyup="validatePwd();" required>
          <label><?php echo $MSG_REG_PW_STRENGTH; ?></label>
	  <div class="progress">
	    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100" id="strength"></div>
          </div><br>
          <label for="inputPasswordVerify"><?php echo $MSG_REG_PW_VERIFY;?></label>
          <input type="password" name="pwvf" class="form-control margin-bottom-20" required>
          <button class="btn btn-primary btn-block" type="submit"><?php echo $MSG_REG_SUBMIT;?></button>
        </form>
      </div>
    </main>
    <script type="text/javascript" src="./Zxcvbn/zxcvbn.js">
    </script>
    <script>
      var id = document.getElementsByName("id")[0];
      var email = document.getElementsByName("email")[0];
      var password = document.getElementsByName("pw")[0];
      var str1 = document.getElementById("str1");
      var str2 = document.getElementById("str2");
      var str3 = document.getElementById("str3");
      var str4 = document.getElementById("str4");
      var strength = document.getElementById("strength");
      function validatePwd() {
          var score = zxcvbn(password.value, [id.value, email.value]);
          strength.style.width=""+(score.score*25)+"%";
	  switch(score.score) {
              case 0:
              break;
	      case 1:
              strength.style.backgroundColor="red";
              break;
              case 2:
              strength.style.backgroundColor="yellow";
              break;
              case 3:
              strength.style.backgroundColor="lightgreen";
              break;
              case 4:
              strength.style.backgroundColor="skyblue";
              break;
          }
      }
    </script>

    <?php require("importjs.php");?>
    <?php require("footer.php");?>

  </body>
</html>
