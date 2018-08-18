<?php
/*
反腾讯网址安全检测系统
Description:屏蔽腾讯电脑管家网址安全检测
Version:2.7
Author:消失的彩虹海&墨渊
*/
//IP屏蔽
$iptables='977012992~977013247|977084416~977084927|1743654912~1743655935|1949957632~1949958143|2006126336~2006127359|2111446272~2111446527|3418570752~3418578943|3419242496~3419250687|3419250688~3419275263|3682941952~3682942207|3682942464~3682942719|3682986660~3682986663|1707474944~1707606015|1709318400~1709318655|3070488320~3070488574|1902905856~1902906110|236000768~236001023|1884967642|1884967620|1893733510|1709332858|1709325774|1709342057|1709341968|1709330358|1709335492|1709327575|1709327041|1709327557|1709327573|1975065457|1902908741|1902908705|3029946827|2077187986|2345090787|236000818|';
$remoteiplong=bindec(decbin(ip2long(real_ip())));
foreach(explode('|',$iptables) as $iprows){
	if($remoteiplong==$iprows)exit(pr_html('欢迎使用！'));
	$ipbanrange=explode('~',$iprows);
	if($remoteiplong>=$ipbanrange[0] && $remoteiplong<=$ipbanrange[1])
		exit('欢迎使用！');
}

//HEADER特征屏蔽
if(preg_match("/manager/", strtolower($_SERVER['HTTP_USER_AGENT'])) || strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla')===false && strpos($_SERVER['HTTP_USER_AGENT'], 'ozilla')!==false || isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'urls.tr.com')!==false || isset($_COOKIE['ASPSESSIONIDQASBQDRC']) || empty($_SERVER['HTTP_USER_AGENT']) || strpos($_SERVER['HTTP_USER_AGENT'], 'HUAWEI G700-U00')!==false && !isset($_SERVER['HTTP_ACCEPT']) || preg_match("/Alibaba.Security.Heimdall/", $_SERVER['HTTP_USER_AGENT'])) {
	exit(pr_html('欢迎使用！'));
}
if( strpos($_SERVER['HTTP_USER_AGENT'], '360Spider')!==false || strpos($_SERVER['HTTP_USER_AGENT'], 'haosouspider')!==false ) {
	exit(pr_html('欢迎使用！'));
}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone OS 9_3_4')!==false && $_SERVER['HTTP_ACCEPT']=='*/*' || strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone OS 8_4')!==false && $_SERVER['HTTP_ACCEPT']=='*/*' || strpos($_SERVER['HTTP_USER_AGENT'], 'Android 6.0.1')!==false && strpos($_SERVER['HTTP_USER_AGENT'], 'MQQBrowser/6.8')!==false && $_SERVER['HTTP_ACCEPT']=='*/*' || strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'en')!==false && strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'zh')===false || strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')!==false && strpos($_SERVER['HTTP_USER_AGENT'], 'en-')!==false && strpos($_SERVER['HTTP_USER_AGENT'], 'zh')===false) {
	exit(pr_html('您当前浏览器不支持或操作系统语言设置非中文，无法访问本站！'));
}
//if(preg_match("/Windows NT 6.1/", $_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_ACCEPT']=='*/*'|| preg_match("/Windows NT 5.1/", $_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_ACCEPT']=='*/*' || preg_match("/vnd.wap.wml/", $_SERVER['HTTP_ACCEPT']) && preg_match("/Windows NT 5.1/", $_SERVER['HTTP_USER_AGENT'])){
//	exit(pr_html('该设备太落后了，请更新设备！'));
//}
function pr_html($text){
echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="refresh" content="2;url=../" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>正在进入，请稍等</title>
</head>

<body>
<p>{$text}</p>
</body>
</html>
EOT;
}

?>
