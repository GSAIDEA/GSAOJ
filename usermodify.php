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
    <?php
    if(!$auth->islogged()){
      echo "<script>window.location = \"./login.php\";</script>";
      die();
    }
    ?>
  </head>
  <body>
    <!-- navbar -->
    <?php require("nav.php");
    $uid = $auth->getSessionUID($auth->getSessionHash());
    $user = $auth->getUser($uid);
    $stmt_userdata = $db_conn->prepare("select sangme from userdata where uid=:uid");
    $stmt_userdata->execute([":uid"=>$uid]);
    $sangme = $stmt_userdata->fetch()['sangme'];
    if(isset($_POST['motopw'])){
      try{
        $motopw = $_POST['motopw'];
        if(!$auth->comparePasswords($uid, $motopw)){
          echo "<script>alert(\"비밀번호가 틀립니다.\");</script>";
        }
	      else {
          $db_conn->beginTransaction();
          $stmt_update_sangme = $db_conn->prepare("update userdata set sangme=:sangme where uid=:uid");
          $stmt_update_sangme->execute([":sangme" => $_POST['sangme'], ":uid" => $uid]);
          if(isset($_POST['pw']) && isset($_POST['pwvf']) && strcmp($_POST['pw'], "") != 0){
            $newpw = $_POST['pw'];
            $newpwvf = $_POST['pwvf'];
            $result = $auth->changePassword($uid, $motopw, $newpw, $newpwvf);
            if($result['error']){
              echo "<script>alert(\"".$result['message']."\")</script>";
            }
            else{
              $db_conn->commit();
              echo "<script>alert(\"".$result['message']."\")</script>";
              echo "<script type='text/javascript'>window.location = \"./userinfo.php?uid=".$uid['id']."\";</script>";
              die();
            }
          }
          else{
            $db_conn->commit();
            echo "<script type='text/javascript'>window.location = \"./userinfo.php?uid=".$uid['id']."\";</script>";            
            die();
          }
        }
      } catch(PDOException $e){
        $db_conn->rollBack();
        die();
#        echo $e->getMessage();
      }
    }

    ?>

    <main role="main">
      <div class="container">
        <form class="form-modify" action="usermodify.php" method="post">
	  <br>
          <h2 class="margin-bottom-30"><?php echo $MSG_MODIFY;?></h2>
          <label for="userid"><?php echo $MSG_LOGIN_ID;?></label>
          <input type="text" name="id" class="form-control margin-bottom-20" value="<?php echo $user['userid'];?>" disabled>
          <label for="modifySangme"><?php echo $MSG_MODIFY_SANGME;?></label>
          <input type="text" name="sangme" class="form-control margin-bottom-20" value="<?php echo $sangme;?>">
          <label for="inputPassword"><?php echo $MSG_MOTO_PW;?></label>
          <input type="password" name="motopw" class="form-control margin-bottom-20">
          <label for="changePassword"><?php echo $MSG_MODIFY_PW;?></label>
          <input type="password" name="pw" class="form-control margin-bottom-20" onkeyup="validatePwd();" placeholder="<?php echo $MSG_NOT_CHANGE_PW;?>">
          <label><?php echo $MSG_REG_PW_STRENGTH;?></label>
	  <div class="progress">
	    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100" id="strength"></div>
          </div><br>
          <label for="inputPasswordVerify"><?php echo $MSG_MODIFY_PW_VERIFY;?></label>
          <input type="password" name="pwvf" class="form-control margin-bottom-20" placeholder="<?php echo $MSG_NOT_CHANGE_PW;?>">
          <button class="btn btn-primary btn-block" type="submit"><?php echo $MSG_MODIFY_SUBMIT;?></button>
        </form>
      </div>
    </main>
    <script type="text/javascript" src="./Zxcvbn/zxcvbn.js">
    </script>
    <script>
      var id = document.getElementsByName("id")[0];
      var password = document.getElementsByName("pw")[0];
      var str1 = document.getElementById("str1");
      var str2 = document.getElementById("str2");
      var str3 = document.getElementById("str3");
      var str4 = document.getElementById("str4");
      var strength = document.getElementById("strength");
      function validatePwd() {
          var score = zxcvbn(password.value, [id.value]);
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
