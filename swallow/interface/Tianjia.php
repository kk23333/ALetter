<?php

header("Content-Type: text/html; charset=UTF-8");
require_once '../phpanalysis2.0/phpanalysis.class.php';
include_once '../mysqli/opDB.class.php';
$response = array("statue" => '');
$con = new opDB();
if(isset($_POST['account']) && isset($_POST['letter'])){
	$account = test_input($_POST['account']);
	$letter = test_input($_POST['letter']);
	$sql01 ="SELECT * FROM myletter where account='{$account}' and letter='{$letter}'";
	$res = $con->excute_dql($sql01);
	if($res == 1){
		echo -3;
		exit;
	}else{
		$sql = "INSERT INTO myletter(letter,account) values('{$letter}','$account')";
		$res = $con->excute_dml($sql);
		if($res == 1){
			echo 1;		
			exit;
		}else{
			echo -2;
			exit;
		}
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
