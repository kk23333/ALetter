<?php
header("Content-Type: text/html; charset=UTF-8");
require_once '../phpanalysis2.0/phpanalysis.class.php';
include_once '../mysqli/opDB.class.php';
$response = array("statue" => '');
$con = new opDB();
$pa=new PhpAnalysis();
$result = array();
$json = array();
if(isset($_POST['query'])){
	$query = $_POST['query'];
	$pa->SetSource($query);
	$pa->resultType=2;
	$pa->differMax=true;
	$pa->StartAnalysis();
	$arr=$pa->GetFinallyIndex();
	foreach($arr as $key=>$value){
		$result[] = "'".$key."'";
	}
	$arr_string = implode(',', $result);
	$sql = "SELECT * FROM letter WHERE jianjie like '%".$query."%' or type in(".$arr_string.") or cw in(".$arr_string.")";
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
			echo -3;
			exit;
		}
	}else{
		echo urldecode(json_encode($json));
		exit;
	}
}else{
	echo -1;
	exit ;
}
?>