<?php

header("Content-Type: text/html; charset=UTF-8");
//设置 得到当前路径
set_include_path(get_include_path() . PATH_SEPARATOR . '../');
//引用 文件 
include_once '../mysqli/opDB.class.php';
include 'PHPExcel/IOFactory.php';
//设置 时区
date_default_timezone_set('Asia/shanghai');
$destination_folder = '../';
//设置 读取文件的类型
$inputFileType = 'Excel5';
//设置 文档 位置
$sheetname = 'Data Sheet #1';
			
$response = array("statue" => '');
$con = new opDB();
$sql = "SELECT content FROM letter order by rnd()";
$res = $con->get_result($sql);
$row = mysqli_fetch_assoc($res);
echo($row['content']);

?>