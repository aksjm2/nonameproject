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

echo "�ȳ��ϼ��� ".$_SESSION['user']->name."��";
?>


<form action="logout.php">
<input type="submit" value="�α׾ƿ�">
</form>

<?php
lb(1);

echo "<".$user->name."���� ģ�����>\n";
lb(1);

$q = "select * from friend where userID1 = ".$user->IDuser." OR userID2 = ".$user->IDuser;
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

echo "<".$user->name."���� ��>\n"; lb(1);
$user->showEvaluate();

?>

