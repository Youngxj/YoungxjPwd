<?php
/**
 * 基础函数库
 * @copyright (c) Emlog All Rights Reserved
 */
function __autoload($class) {
	$class = strtolower($class);
	if (file_exists(SYSTEM_ROOT . '/model/' . $class . '.class.php')) {
		require_once(SYSTEM_ROOT . '/model/' . $class . '.class.php');
	} elseif (file_exists(SYSTEM_ROOT . '/lib/' . $class . '.class.php')) {
		require_once(SYSTEM_ROOT . '/lib/' . $class . '.class.php');
	} else {
		sysmsg($class . '加载失败。');
	}
}
function loader($fun) {
	$fun = strtolower($fun);
	if (file_exists(SYSTEM_ROOT . '/model/' . $fun . '.php')) {
		require_once(SYSTEM_ROOT . '/model/' . $fun . '.php');
	} elseif (file_exists(SYSTEM_ROOT . '/lib/' . $fun . '.php')) {
		require_once(SYSTEM_ROOT . '/lib/' . $fun . '.php');
	} else {
		sysmsg($fun . '加载失败。');
	}
}
/**
 * 去除多余的转义字符
 */
function doStripslashes() {
	if (get_magic_quotes_gpc()) {
		$_GET = stripslashesDeep($_GET);
		$_POST = stripslashesDeep($_POST);
		$_COOKIE = stripslashesDeep($_COOKIE);
		$_REQUEST = stripslashesDeep($_REQUEST);
	}
}

/**
 * 递归去除转义字符
 */
function stripslashesDeep($value) {
	$value = is_array($value) ? array_map('stripslashesDeep', $value) : stripslashes($value);
	return $value;
}

/**
 * 转换HTML代码函数
 *
 * @param unknown_type $content
 * @param unknown_type $wrap 是否换行
 */
function htmlClean($content, $nl2br = true) {
	$content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
	if ($nl2br) {
		$content = nl2br($content);
	}
	$content = str_replace('  ', '&nbsp;&nbsp;', $content);
	$content = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $content);
	return $content;
}

/**
 * 获取用户ip地址
 */
function getIp(){
	$ip = $_SERVER['REMOTE_ADDR'];
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
		foreach ($matches[0] AS $xip) {
			if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
				$ip = $xip;
				break;
			}
		}
	} elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
		$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
	} elseif (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_IP'])) {
		$ip = $_SERVER['HTTP_X_REAL_IP'];
	}
	return $ip;
}
/**
 * 检测是否为IP
 * @param  [type] $ip [description]
 * @return [type]     [description]
 */
function funip($ip){
  //IP正则匹配
  //0.0.0.0--- 255.255.255.255
	$pat = "/^(((1?\d{1,2})|(2[0-4]\d)|(25[0-5]))\.){3}((1?\d{1,2})|(2[0-4]\d)|(25[0-5]))$/";
	if(preg_match($pat,$ip)){
		$num = preg_match($pat,$ip);
		return $num;
	}else{
		$num = preg_match($pat,$ip);
		return $num;
	}
}

function isIE6Or7() {
	if (isset($_SERVER['HTTP_USER_AGENT'])) {
		if (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 7.0") || strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 6.0")) {
			return true;
		}
	}
	return false;
}


/**
 * 验证email地址格式
 */
function checkMail($email) {
	if (preg_match("/^[\w\.\-]+@\w+([\.\-]\w+)*\.\w+$/", $email) && strlen($email) <= 60) {
		return true;
	} else {
		return false;
	}
}

/**
 * 截取编码为utf8的字符串
 *
 * @param string $strings 预处理字符串
 * @param int $start 开始处 eg:0
 * @param int $length 截取长度
 */
function subString($strings, $start, $length) {
	if (function_exists('mb_substr') && function_exists('mb_strlen')) {
		$sub_str = mb_substr($strings, $start, $length, 'utf8');
		return mb_strlen($sub_str, 'utf8') < mb_strlen($strings, 'utf8') ? $sub_str . '...' : $sub_str;
	}
	$str = substr($strings, $start, $length);
	$char = 0;
	for ($i = 0; $i < strlen($str); $i++) {
		if (ord($str[$i]) >= 128)
			$char++;
	}
	$str2 = substr($strings, $start, $length + 1);
	$str3 = substr($strings, $start, $length + 2);
	if ($char % 3 == 1) {
		if ($length <= strlen($strings)) {
			$str3 = $str3 .= '...';
		}
		return $str3;
	}
	if ($char % 3 == 2) {
		if ($length <= strlen($strings)) {
			$str2 = $str2 .= '...';
		}
		return $str2;
	}
	if ($char % 3 == 0) {
		if ($length <= strlen($strings)) {
			$str = $str .= '...';
		}
		return $str;
	}
}

/**
 * 转换附件大小单位
 *
 * @param string $fileSize 文件大小 kb
 */
function changeFileSize($fileSize) {
	if ($fileSize >= 1073741824) {
		$fileSize = round($fileSize / 1073741824, 2) . 'GB';
	} elseif ($fileSize >= 1048576) {
		$fileSize = round($fileSize / 1048576, 2) . 'MB';
	} elseif ($fileSize >= 1024) {
		$fileSize = round($fileSize / 1024, 2) . 'KB';
	} else {
		$fileSize = $fileSize . '字节';
	}
	return $fileSize;
}

/**
 * 获取文件名后缀
 */
function getFileSuffix($fileName) {
	return strtolower(pathinfo($fileName,  PATHINFO_EXTENSION));
}

/**
 * 生成一个随机的字符串
 *
 * @param int $length
 * @param boolean $special_chars
 * @return string
 */
function getRandStr($length = 12, $special_chars = true) {
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	if ($special_chars) {
		$chars .= '!@#$%^&*()';
	}
	$randStr = '';
	for ($i = 0; $i < $length; $i++) {
		$randStr .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	}
	return $randStr;
}

/**
 * 删除文件或目录
 */
function emDeleteFile($file) {
	if (empty($file))
		return false;
	if (@is_file($file))
		return @unlink($file);
	$ret = true;
	if ($handle = @opendir($file)) {
		while ($filename = @readdir($handle)) {
			if ($filename == '.' || $filename == '..')
				continue;
			if (!emDeleteFile($file . '/' . $filename))
				$ret = false;
		}
	} else {
		$ret = false;
	}
	@closedir($handle);
	if (file_exists($file) && !rmdir($file)) {
		$ret = false;
	}
	return $ret;
}
/**
 * 判断导航激活
 */
function checkIfActive($string) {
	if(strpos($_SERVER['PHP_SELF'],$string)){return 'class="active"';}else{return null;}
}
/**
 * 页面跳转
 */
function emDirect($directUrl) {
	header("Location: $directUrl");
	exit;
}
/**
 * 计算几分钟前、几小时前、几天前、几月前、几年前。
 * $agoTime string Unix时间
 * @author tangxinzhuan
 * @version 2016-10-28
 */
function smartDate($agoTime)
{
    $agoTime = (int)$agoTime;
    
    // 计算出当前日期时间到之前的日期时间的毫秒数，以便进行下一步的计算
    $time = time() - $agoTime;
    
    if ($time >= 31104000) { // N年前
        $num = (int)($time / 31104000);
        return $num.'年前';
    }
    if ($time >= 2592000) { // N月前
        $num = (int)($time / 2592000);
        return $num.'月前';
    }
    if ($time >= 86400) { // N天前
        $num = (int)($time / 86400);
        return $num.'天前';
    }
    if ($time >= 3600) { // N小时前
        $num = (int)($time / 3600);
        return $num.'小时前';
    }
    if ($time > 60) { // N分钟前
        $num = (int)($time / 60);
        return $num.'分钟前';
    }
    return '1分钟前';
}

/**
 * @param string $data Json 字符串
 * @param bool   $assoc 是否返回关联数组
 * @return bool|array 成功返回转换后的数组，否则返回 false
 */
function isJson($data = '', $assoc = false) {
    $data = json_decode($data, $assoc);
    if (is_array($data) && !empty(current($data))) {
        return $data;
    }
    return false;
}
function curl_get($url){
	$ch=curl_init($url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn; R815T Build/JOP40D) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/4.5 Mobile Safari/533.1');
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$content=curl_exec($ch);
	curl_close($ch);
	return($content);
}
function get_curl($url, $post=0, $referer=0, $cookie=0, $header=0, $ua=0, $nobaody=0){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	$httpheader[] = "Accept:application/json";
	$httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
	$httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
	$httpheader[] = "Connection:close";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
	if ($post) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
	if ($header) {
		curl_setopt($ch, CURLOPT_HEADER, true);
	}
	if ($cookie) {
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	}
	if($referer){
		if($referer==1){
			curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
		}else{
			curl_setopt($ch, CURLOPT_REFERER, $referer);
		}
	}
	if ($ua) {
		curl_setopt($ch, CURLOPT_USERAGENT, $ua);
	}
	else {
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; U; Android 4.0.4; es-mx; HTC_One_X Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0");
	}
	if ($nobaody) {
		curl_setopt($ch, CURLOPT_NOBODY, 1);
	}
	curl_setopt($ch, CURLOPT_TIMEOUT, 3);
	curl_setopt($ch, CURLOPT_ENCODING, "gzip");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$ret = curl_exec($ch);
	curl_close($ch);
	return $ret;
}
function daddslashes($string, $force = 0, $strip = FALSE) {
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if(!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force, $strip);
			}
		} else {
			$string = addslashes($strip ? stripslashes($string) : $string);
		}
	}
	return $string;
}
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key ? $key : ENCRYPT_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}
function showmsg($content = '未知的异常',$type = 4,$back = false,$backstr = false)
{
	switch($type)
	{
		case 1:
		$panel="success";
		break;
		case 2:
		$panel="info";
		break;
		case 3:
		$panel="warning";
		break;
		case 4:
		$panel="danger";
		break;
	}

	echo '<div class="panel panel-'.$panel.'">
	<div class="panel-heading">
	<h3 class="panel-title">提示信息</h3>
	</div>
	<div class="panel-body">';
	echo $content;

	if ($back) {
		echo '<hr/><a href="'.$back.'"><< '.$backstr.'</a>';
	}
	else
		echo '<hr/><a href="javascript:history.back(-1)"><< 返回上一页</a>';

	echo '</div>
	</div>';
}
function sysmsg($msg = '未知的异常',$die = true) {
	?>  
	<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>站点提示信息</title>
		<style type="text/css">
		html{background:#eee}body{background:#fff;color:#333;font-family:"微软雅黑","Microsoft YaHei",sans-serif;margin:2em auto;padding:1em 2em;max-width:700px;-webkit-box-shadow:10px 10px 10px rgba(0,0,0,.13);box-shadow:10px 10px 10px rgba(0,0,0,.13);opacity:.8}h1{border-bottom:1px solid #dadada;clear:both;color:#666;font:24px "微软雅黑","Microsoft YaHei",,sans-serif;margin:30px 0 0 0;padding:0;padding-bottom:7px}#error-page{margin-top:50px}h3{text-align:center}#error-page p{font-size:9px;line-height:1.5;margin:25px 0 20px}#error-page code{font-family:Consolas,Monaco,monospace}ul li{margin-bottom:10px;font-size:9px}a{color:#21759B;text-decoration:none;margin-top:-10px}a:hover{color:#D54E21}.button{background:#f7f7f7;border:1px solid #ccc;color:#555;display:inline-block;text-decoration:none;font-size:9px;line-height:26px;height:28px;margin:0;padding:0 10px 1px;cursor:pointer;-webkit-border-radius:3px;-webkit-appearance:none;border-radius:3px;white-space:nowrap;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;-webkit-box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);vertical-align:top}.button.button-large{height:29px;line-height:28px;padding:0 12px}.button:focus,.button:hover{background:#fafafa;border-color:#999;color:#222}.button:focus{-webkit-box-shadow:1px 1px 1px rgba(0,0,0,.2);box-shadow:1px 1px 1px rgba(0,0,0,.2)}.button:active{background:#eee;border-color:#999;color:#333;-webkit-box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5);box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5)}table{table-layout:auto;border:1px solid #333;empty-cells:show;border-collapse:collapse}th{padding:4px;border:1px solid #333;overflow:hidden;color:#333;background:#eee}td{padding:4px;border:1px solid #333;overflow:hidden;color:#333}
	</style>
</head>
<body id="error-page">
	<?php echo '<h3>站点提示信息</h3>';
	echo $msg; ?>
</body>
</html>
<?php
if ($die == true) {
	exit;
}
}
function EchoMsg($code='200',$msg='请求成功',$date=array(),$count='',$systemLog='',$username='',$uid=''){
	header('Content-type: application/json');
	if($systemLog){
		require_once (SYSTEM_ROOT.'/lib/model.php');
		$set = new Model("pwd_log");
		$ip = daddslashes(getIp());
		$time = time();
		$ua = daddslashes($_SERVER['HTTP_USER_AGENT']);
		$url = daddslashes($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$j = $_POST ? $_POST : $_GET;
		if($systemLog==2){
			$j ='';
		}
		$arr = array(
			'ip' => $ip,
			'time' => $time,
			'ua' => $ua,
			'url' => $url,
			'ev' => $systemLog,
			'json' => daddslashes(json_encode($j)),
			'uid' => $uid,
			'username' => $username,
			'record' => daddslashes($msg)
		);

		$sql = $set->create($arr);
	}
	return json_encode(array('code'=>$code,'msg'=>$msg,'data'=>$date,'count'=>$count));

	
}
/**
 * 日志记录
 * @param  string $ev     事件级别
 * @code 	1管理员 2用户  
 * @param  string $record 备注
 * @param  string $uid    用户id
 * @return [type]         bool
 */
function systemLog($ev='',$record='',$uid='',$username=''){
	
	if($sql){
		return true;
	}else{
		return false;
	}
}
?>