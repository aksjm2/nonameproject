<?php
class user{
	var $IDuser, $username, $gender, $dateofbirth, $name, $registerDate, $viewCnt, $picPath;

	function __construct($row){
		$this->IDuser = $row['IDuser'];
		$this->username = $row['username'];
		$this->gender = $row['gender'];
		$this->dateofbirth = $row['dateofbirth'];
		$this->name = $row['name'];
		$this->registerDate = $row['registerDate'];
		$this->viewCnt = $row['viewCnt'];
		$this->picPath = $row['picPath'];
	}

	function showEvaluate(){
		$cnt = 0;
		$q = "select * from evaluate";
		$rs = query($q);
		while ($row = fetch($rs)){
			$eq = "select * from userevaluate where userID = ".$this->IDuser." and evaluateID = ".$row['IDevaluate'];
			$ers = query($eq);
			$cnt++;
			$average = 0;
			if ($erow = fetch($ers)){
				$average = $erow['sum'] / $erow['count'];
			}
			echo "$cnt. ".$row['evaluateName']."은 $average"."점입니다.\n";
			lb(1);
		}
	}
}

class friend extends user{
	var $IDowner;
	function __construct($IDuser, $IDfriend){
		$q = "select * from friend where (userID1 = $IDuser  AND userID2 = $IDfriend) OR (userID2 = $IDuser  AND userID1 = $IDfriend)";
		$rs = query($q);
		if ($row = fetch($rs)){
			if ($row['userID1'] == $IDuser)
				$q = "select * from user where IDuser = ".$row['userID2'];
			else
				$q = "select * from user where IDuser = ".$row['userID1'];

			$rs = query($q);
			$row = fetch($rs);
			$this->IDowner = $IDuser;
			parent::__construct($row);
		}
	}

	function showEvaluate(){
		$cnt = 0;
		$x = 0;
		$q = "select * from evaluate";
		$rs = query($q);
		echo "<form id='evalForm' action='evaluate.php' method='post'>\n";
		echo "<input type='hidden' name='from' value='".$this->IDuser."'>\n";
		echo "<input type='hidden' name='delete' id='delete'>\n";
		while ($row = fetch($rs)){
			$cnt++;
			$eq = "select * from userevaluate where userID = ".$this->IDuser." and evaluateID = ".$row['IDevaluate'];
			$ers = query($eq);
			$average = 0;
			if ($erow = fetch($ers)){
				$average = $erow['sum'] / $erow['count'];
			}

			echo "$cnt. ".$row['evaluateName']."은 $average"."점입니다.\n";
			lb(1);
			$cq = "select * from useruserevaluate where userID1 = ".$this->IDuser." and userID2 = ".$_SESSION['user']->IDuser." and evaluateID = ".$row['IDevaluate'];
			$crs = query($cq);
			if ($crow = fetch($crs)){
				echo $crow['date']."에 ".$crow['rate']."점을 주셨습니다! <input type='button' value='삭제' onclick='javascript:evalDelete(".$row['IDevaluate'].")'>";
			}
			else{
				echo "<input type='hidden' name='eval[$x][0]' value='".$row['IDevaluate']."'>\n";
				for ($i=1;$i<=5;$i++){
					echo "<input type='radio' name='eval[$x][1]' value='$i'>".$i."점 \n";
				}
				$x++;
			}
			lb(2);
		}
		echo "<input type='submit' value='나도 평가하기' ></form>\n";
	}
}
?>