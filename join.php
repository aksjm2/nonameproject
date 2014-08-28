<?php
require_once('header.php');
?>

<html>
 <head>
  <title>:: Join Page ::</title>
  <h2>check</h2>
 </head>
 <body>
<?php
$id = $_POST['uid'];
$mail = $_POST['umail'];
$fid = $id.$mail;
$upw = $_POST['pw'];
$uname = $_POST['name'];
$ubirth = date("Y-m-d",$_POST['year'].$_POST['month'].$_POST['day']);
$gender = $_POST['sex'];
date_default_timezone_set("Asia/Seoul");
$registerdate = date("Y-m-d h:i:s",time());

$file_name = $_FILES['upload_file']['name'];
$tmp_file = $_FILES['upload_file']['tmp_name'];

$file_path = './image/'.$file_name;

$r = move_uploaded_file($tmp_file, $file_path);

if($r)
{
	echo "uploaded";
}
else
{
	echo "error";
}

$q = "insert into user(username,password,gender,dateofbirth,name,registerDate) values('$fid','$upw','$gender','$ubirth','$uname','$registerdate')";
//query($q);
//href('index.php');
?>
</body>
</html>