<?php
$file = fopen("code.txt", "w");
if(fwrite($file, $_POST['code']) == false){
  fclose($file);
  die('save failure');
}
fclose($file);
echo 'save success look at the code.txt!';
?>
