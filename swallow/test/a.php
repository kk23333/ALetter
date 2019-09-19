<?php
/*
 * */
header("Content-Type: text/html; charset=UTF-8");
include_once '../mysqli/opDB.class.php';
$response = array("statue" => '');
$con = new opDB();
if(isset($_POST['content']) && isset($_POST['type']) ){
	$content = $_POST['content'];
	//$co = str_replace("\r\n", '<br>', $content);
//	echo $co;
	$type = $_POST['type'];
	$jianjie = $_POST['jianjie'];
	//
	$sql="insert into letter(content,type,jianjie) values ('$content','$type','$jianjie')";
	//
	$con ->excute_dml($sql);
}else{
	$response['statue'] = -1;
	$con->for_close();
	echo json_encode($response);
	exit ;
}

?>