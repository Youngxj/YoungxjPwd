<?php
global $conf,$islogin,$Ulogin,$udata,$password_hash;
if(!defined('IN_CRONLITE'))exit();
if(isset($_COOKIE["admin_token"])){
	$token=authcode(daddslashes($_COOKIE['admin_token']), 'DECODE', SYS_KEY);
	list($user, $sid) = explode("\t", $token);
	$session=md5($conf['username'].$conf['passw'].$password_hash);
	$udata = $conf;
	if($session==$sid) $islogin=1;
	if(!$user) $islogin=0;
}
if(isset($_COOKIE["user_token"])){
	$token=authcode(daddslashes($_COOKIE['user_token']), 'DECODE', SYS_KEY);
	list($user, $sid) = explode("\t", $token);
	require_once (SYSTEM_ROOT.'/lib/model.php');
	$set = new Model();
	$set->table_name = "pwd_user";
	$udata = $set->find(array("username = :c1 OR email = :c1",":c1"=>$user),"","*");
	//$udata = $DB->get_row("SELECT * FROM `uomg_user` WHERE username='$user' limit 1");
	$session=md5($udata['username'].$udata['passw'].$password_hash);
	if($session==$sid) $Ulogin=1;
	if(!$user) $Ulogin=0;
}
?>