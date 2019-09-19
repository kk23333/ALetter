<?php

header("Content-Type: text/html; charset=UTF-8");
include_once '../mysqli/opDB.class.php';

define("CURL_TIMEOUT",   10); 
define("URL",            "http://api.fanyi.115.20.com/api/trans/vip/translate"); 
define("APP_ID",         "20160427000019717"); //替换为您的APPID
define("SEC_KEY",        "HOb1FKchDMejnDtpCUB4");//替换为您的密钥

//翻译入口
function translate($query, $from, $to)
{
    $args = array(
        'q' => $query,
        'appid' => APP_ID,
        'salt' => rand(10000,99999),
        'from' => $from,
        'to' => $to,

    );
    $args['sign'] = buildSign($query, APP_ID, $args['salt'], SEC_KEY);
    $ret = call(URL, $args);
    $ret = json_decode($ret, true);
    return $ret; 
}

//加密
function buildSign($query, $appID, $salt, $secKey)
{/*{{{*/
    $str = $appID . $query . $salt . $secKey;
    $ret = md5($str);
    return $ret;
}/*}}}*/

//发起网络请求
function call($url, $args=null, $method="post", $testflag = 0, $timeout = CURL_TIMEOUT, $headers=array())
{/*{{{*/
    $ret = false;
    $i = 0; 
    while($ret === false) 
    {
        if($i > 1)
            break;
        if($i > 0) 
        {
            sleep(1);
        }
        $ret = callOnce($url, $args, $method, false, $timeout, $headers);
        $i++;
    }
    return $ret;
}/*}}}*/

function callOnce($url, $args=null, $method="post", $withCookie = false, $timeout = CURL_TIMEOUT, $headers=array())
{/*{{{*/
    $ch = curl_init();
    if($method == "post") 
    {
        $data = convert($args);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, 1);
    }
    else 
    {
        $data = convert($args);
        if($data) 
        {
            if(stripos($url, "?") > 0) 
            {
                $url .= "&$data";
            }
            else 
            {
                $url .= "?$data";
            }
        }
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if(!empty($headers)) 
    {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    if($withCookie)
    {
        curl_setopt($ch, CURLOPT_COOKIEJAR, $_COOKIE);
    }
    $r = curl_exec($ch);
    curl_close($ch);
    return $r;
}/*}}}*/

function convert(&$args)
{/*{{{*/
    $data = '';
    if (is_array($args))
    {
        foreach ($args as $key=>$val)
        {
            if (is_array($val))
            {
                foreach ($val as $k=>$v)
                {
                    $data .= $key.'['.$k.']='.rawurlencode($v).'&';
                }
            }
            else
            {
                $data .="$key=".rawurlencode($val)."&";
            }
        }
        return trim($data, "&");
    }
    return $args;
}/*}}}*/

$response = array("jingyu" => '',"qcyjingyu"=>'',
 				  "qici"=>'',"hanxuan"=>'',
				  "jieyu"=>'',"wenhouyu"=>'',
				  "fyresult"=>'',"qibinci"=>'');
$con = new opDB();
if(isset($_POST['kind']) && isset($_POST['chengwei']) 
	&& isset($_POST['hisname']) && isset($_POST['yourname'])
	&& isset($_POST['reason'])){
	$type = $_POST['kind'];
	$cw = $_POST['chengwei'];
	$hisname = $_POST['hisname'];
	$yourname = $_POST['yourname'];
	$reason = $_POST['reason'];
	$res = translate($reason,'zh', 'wyw');
	
	$sql01 = "SELECT men_cw.cw as chengwei,men_qcy.qcy as qingchayu,qici
			FROM object,men_cw,men_qcy,qici
	        WHERE (object.cw like '%".$cw."%') and 
	        (men_cw.bf=object.bf or men_cw.bf like '%Null%') and (men_cw.sex=object.sex or men_cw.sex like '%Null%') and
	        (men_qcy.bf=object.bf or men_qcy.bf like '%Null%') and
	        (qici.bf=object.bf or qici.bf like '%Null%') 
			order by rand() limit 1";
			
	$sql02 = "SELECT a.phx as aphx,b.phx as bphx,hhx
			FROM object,phx as a,phx as b,hhx
	        WHERE (object.cw like '%".$cw."%') and 
	        (a.bf=object.bf or a.bf like '%Null%') and (a.type like '%".$type ."%' or a.type like '%Null%') and 
	        (b.bf=object.bf or b.bf like '%Null%') and (b.type like '%".$type ."%' or b.type like '%Null%') and 
		    a.phx != b.phx and 
		    (hhx.bf=object.bf or hhx.bf like '%Null%') and (hhx.type like '%".$type ."%' or hhx.type like '%Null%')
			order by rand() limit 1";		
	
	$sql03 = "SELECT fend.content as fcontent,send.content as scontent,tend.content as tcontent
				FROM object,fend,send,tend
	        WHERE (object.cw like '%".$cw."%') and 
	        (fend.type like '%".$type."%' or fend.type like '%Null%') and 
	        (send.type like '%".$type."%' or send.type like '%Null%') and 
	        (tend.type like '%".$type."%' or tend.type like '%Null%')
			order by rand() limit 1";
	$sql04 = "SELECT zf,qbc FROM object,zf,qbc 
	        WHERE (object.cw like '%".$cw."%') and 
	        (zf.bf=object.bf or zf.bf like '%Null%') and (zf.sex=object.sex or zf.sex like '%Null%') and
	        (qbc.bf=object.bf or qbc.bf like '%Null%')
			order by rand() limit 1";
	$res01 = $con->get_result($sql01);
	$row01 = mysqli_fetch_assoc($res01);
	$res02 = $con->get_result($sql02);
	$row02 = mysqli_fetch_assoc($res02);
	$res03 = $con->get_result($sql03);
	$row03 = mysqli_fetch_assoc($res03);
	$res04 = $con->get_result($sql04);
	$row04 = mysqli_fetch_assoc($res04);
	
	if(!empty($row01) && !empty($row02) && !empty($row03) && !empty($row04)){
		$response['jingyu'] = $hisname.$row01['chengwei'];
		$response['qcyjingyu'] = $row01['qingchayu'];
		$response['qici'] = $row01['qici'];
		$response['hanxuan'] = $row02['aphx'].$row02['bphx'].$row02['hhx'];
		$response['jieyu'] = $row03['fcontent'].$row03['scontent'].$row03['tcontent'];
		$response['wenhouyu'] = $row04['zf'];
		$response['qibinci'] = $yourname.$row04['qbc'];
		$response['fyresult'] = $res['trans_result'][0]['dst'];
	//	var_dump($response);
		echo urldecode(json_encode($response));
		exit;
	}else{
		echo -2;
		exit;
	}
	
}else{
	echo -1;
	exit ;
}

?>