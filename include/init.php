<?php
/**
 * 全局项加载
 * @copyright (c) Emlog All Rights Reserved
 */
ob_start();
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set("PRC");
define('IN_CRONLITE', true);
define('SYSTEM_ROOT', dirname(__FILE__).'/');
define('ROOT', dirname(SYSTEM_ROOT).'/');
//cookie加密密钥
define('SYS_KEY', 'Youngxjpwd');

require_once (SYSTEM_ROOT.'/lib/model.php');
require_once (SYSTEM_ROOT.'/lib/function.base.php');


//全局删除反斜杠
doStripslashes();

$password_hash = '@#%^#$%&*^*#';
$date = date("Y-m-d H:i:s");
session_start();

$set = new Model("pwd_set");
$conf = $set->find(array("id = 1"),"","*");

//IP黑名单
$ip = funip(getIp()) ? getIp() : '';
$ip_arr = explode(',',$conf['ipadmin']);
if(in_array($ip, $ip_arr)){
	exit('黑名单');
}
//DEBUG
if($conf['debug']!=1){error_reporting(0);}

//weburl
$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
$WebUrl = $http_type . $_SERVER['HTTP_HOST'];

loader('member');
loader('mcrypt.class');

?>