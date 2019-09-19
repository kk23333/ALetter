<?php
header("Content-Type: text/html; charset=UTF-8");
include_once '../mysqli/opDB.class.php';
$response = array("statue" => '');
$con = new opDB();
if (isset($_POST['account']) && $_POST['account']
    && isset($_POST['password']) && $_POST['password']) {
	$account = test_input($_POST['account']);
	$password = test_input($_POST['password']);
	$sql = "SELECT a_id FROM admin WHERE account='{$account}' && password='{$password}'";
	$res = $con->excute_dql($sql);
	if($res == 1){
		echo 1;
		exit ;
	}else{
		echo -2;
		exit ;
	}
}else{
	echo -1;
	exit ;
}
function test_input($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>