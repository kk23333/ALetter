<?php

header("Content-Type: text/html; charset=UTF-8");
require_once '../phpanalysis2.0/phpanalysis.class.php';
include_once '../mysqli/opDB.class.php';
$response = array("statue" => '');
$con = new opDB();
if($_POST['account'] && $_POST['id']){
	$account = test_input($_POST['account']);
	$id = test_input($_POST['id']);
	$sql = "DELETE FROM myletter WHERE ml_id='{$id}' and account='{$account}'";
	$res = $con->excute_dml($sql);
	if($res = -1){
		echo -2;
		exit;
	}else{
		echo 1;
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