<?php
/*  查看个人信件 接口
 * */
header("Content-Type: text/html; charset=UTF-8");
require_once '../phpanalysis2.0/phpanalysis.class.php';
include_once '../mysqli/opDB.class.php';
$json = array();
$con = new opDB();
if(isset($_POST['account'])){
	$account = test_input($_POST['account']);
	$sql = "SELECT * FROM myletter where account='{$account}'";
	$res = $con -> get_result($sql);
	while($row = mysqli_fetch_assoc($res)){
		array_push($json,$row);
	}
	if(empty($json)){
		$res = $con -> get_result($sql);
		if($roww = mysqli_fetch_assoc($res)){
			echo json_encode($roww);
			exit;
		}else{
			echo -2;
			exit;
		}
	}else{
		echo urldecode(json_encode($json));
		exit;
	}
}else{
	echo -1;
	exit;
}
function test_input($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}