<?php
require_once('header.php');
echo "<script type=\"text/javascript\" src=\"script.js\"></script>";

if ($_SESSION['user'] === NULL)
	href("index.php");

if (strlen($_GET['IDuser']) > 0 && $_GET['IDuser'] != $_SESSION['user']->IDuser){
	$user = new friend($_SESSION['user']->IDuser,$_GET['IDuser']);
}
else{
	$user = $_SESSION['user'];
}

echo "안녕하세요 ".$_SESSION['user']->name."님";
$q = "select picPath from user where username = '".$_SESSION['user']->username."'";
$rs = query($q);
while($row = fetch($rs)){
	if(strlen($row['picPath'])>0)
	{
		$picpath = $row['picPath'];
		echo "<img src=".$picpath." width='100' height=100>";
	}
	else
	{
		//프로필 사진 없을때 처리
	}
}
?>


<form action="logout.php">
<input type="submit" value="로그아웃">
</form>

<?php
lb(1);

echo $user->name."님의 친구목록\n";
lb(1);

$q = "select * from friend where userID1 = '".$user->IDuser."' OR userID2 = '".$user->IDuser."'";
$rs = query($q);
while ($row = fetch($rs)){
	$link = "<a href=\"userpage.php?IDuser=";
	if ($row['userID1'] == $user->IDuser)
		$link .= $row['userID2']."\">".$row['name2'];
	else
		$link .= $row['userID1']."\">".$row['name1'];
	$link .= "</a>\n";
	echo $link;
	lb(1);
}

lb(1);

echo $user->name."님의 평가\n"; lb(1);
$user->showEvaluate();

?>

