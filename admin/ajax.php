<?php
include("../include/init.php");
if(!isset($_GET['action'])){exit();}
/**
 * 请求获取用户id信息
 */
if($_GET['action']=='get_id'){
	if ($islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if(isset($_POST['id'])&&$_POST['id']&&is_numeric($_POST['id'])){
		$set->table_name = 'pwd_user';
		$id = daddslashes($_POST['id']);
		$sql = $set->find(array('id'=>$id),'id desc','id,username,email,qq,stime,ltime,sip,lip,status');
		echo EchoMsg(200,'请求获取用户id信息成功',$sql,'','1');
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求修改用户信息
 */
if($_GET['action']=='setuser'){
	if($islogin == 1&&isset($_POST['id'])){
		if (isset($_POST['username'])&&isset($_POST['email'])&&isset($_POST['qq'])) {
			$set->table_name = 'pwd_user';
			$id = daddslashes($_POST['id']);
			$arr = array(
				'username'=>daddslashes($_POST['username']),
				'email'=>daddslashes($_POST['email']),
				'qq'=>daddslashes($_POST['qq']),
			);
			//var_dump($arr);
			if(isset($_POST['password'])&&!empty($_POST['password'])){
				$arr['passw']=md5(daddslashes($_POST['password']).$password_hash);
			}
			$sql = $set->update(array('id'=>$id),$arr);
			if($sql){
				echo EchoMsg(200,'请求修改用户信息成功');
			}else{
				echo EchoMsg(201,'数据请求错误');
			}
			exit();
		}else{
			echo EchoMsg(201,'数据请求错误');
		}
		
	}elseif($islogin == 1){
		$id = $conf['id'];
		$set->table_name = 'pwd_set';
	}elseif($Ulogin==1){
		$id = $udata['id'];
		$set->table_name = 'pwd_user';
	}
	if (isset($id)&&isset($_POST['username'])&&isset($_POST['email'])) {
		$arr = array(
			'username'=>daddslashes($_POST['username']),
			'email'=>daddslashes($_POST['email']),
			'qq'=>daddslashes($_POST['qq']),
		);
		if(isset($_POST['password'])&&!empty($_POST['password'])){
			$arr['passw']=md5(daddslashes($_POST['password']).$password_hash);
		}
		$sql = $set->update(array('id'=>$id),$arr);
		if($sql){
			echo EchoMsg(200,'请求修改用户信息成功');
		}else{
			echo EchoMsg(201,'数据请求错误');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求删除用户id信息
 */
if($_GET['action']=='delete'){
	if ($islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if (isset($_POST['id'])&&is_numeric($_POST['id'])) {
		$id = daddslashes($_POST['id']);
		$set->table_name = 'pwd_user';
		$sql = $set->delete(array('id'=>$id));
		if ($sql) {
			echo EchoMsg(200,'请求删除用户id信息成功','','','1');
		}else{
			echo EchoMsg(201,'数据请求错误');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
	
}
/**
 * 请求账号注册
 */
if($_GET['action']=='sign_up1'){
	if($conf['sign']!=1){exit(EchoMsg('202','本站已关闭注册功能'));}

	if(!isset($_POST['email'])||!$_POST['email']){
		exit(EchoMsg(201,'邮件必填的，不填你怎么享受VIP级别的待遇呢'));
	}
	if (isset($_POST['username'])&&$_POST['username']&&isset($_POST['pass'])&&$_POST['pass']&&isset($_POST['read'])&&$_POST['read']=='on') {
		if(!isset($_POST["verifycode"])||strtolower($_POST["verifycode"])!=$_SESSION['verifycode']){
			unset($_SESSION['verifycode']);
			exit(EchoMsg(203,'验证码不正确'));
		}
		$time = $date;
		$token = getRandStr(8);
		$set->table_name = 'pwd_user';
		$condition = array("username = :c1 OR email = :c2 ", 
			":c1"    => daddslashes($_POST['username']),
			":c2"    => daddslashes($_POST['email']),
		);
		$name_jc = $set->find($condition,'id desc','id,username');
		if($name_jc){
			unset($_SESSION['verifycode']);
			exit(EchoMsg('202','该账号已存在'));
		} 
		
		$arr = array(
			'username'=>daddslashes($_POST['username']),
			'email'=>daddslashes($_POST['email']),
			'passw'=>md5(daddslashes($_POST['pass']).$password_hash),
			'sip'=>$ip,
			'lip'=>$ip,
			'stime'=>$time,
			'ltime'=>$time,
			'token'=>$token,
			'status'=>'1'
		);
		$sql = $set->create($arr);
		if ($sql) {
			unset($_SESSION['verifycode']);
			echo EchoMsg(200,'注册成功,稍后就会收到激活邮件','','','2',$arr['username']);
		}else{
			unset($_SESSION['verifycode']);
			echo EchoMsg(201,'数据请求错误');
		}
	}else{
		
		unset($_SESSION['verifycode']);
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求账号注册(发信版)
 */
if($_GET['action']=='sign_up'){
	if($conf['sign']!=1){exit(EchoMsg('202','本站已关闭注册功能'));}
	if(!isset($_POST['email'])||!$_POST['email']){
		exit(EchoMsg(201,'邮件必填的，不填你怎么享受VIP级别的待遇呢'));
	}
	if (isset($_POST['username'])&&$_POST['username']&&isset($_POST['pass'])&&$_POST['pass']&&isset($_POST['read'])&&$_POST['read']=='on') {
		if(!isset($_POST['verifycode'])||strtolower($_POST["verifycode"])!=$_SESSION['verifycode']){
			unset($_SESSION['verifycode']);
			exit(EchoMsg(203,'验证码不正确'));
		}
		$time = $date;
		$token = getRandStr(8);
		$set->table_name = 'pwd_user';
		$condition = array("username = :c1 OR email = :c2 ", 
			":c1"    => daddslashes($_POST['username']),
			":c2"    => daddslashes($_POST['email']),
		);
		$name_jc = $set->find($condition,'id desc','id,username');
		if($name_jc){
			unset($_SESSION['verifycode']);
			exit(EchoMsg('202','该账号已存在','','','1'));
		} 
		
		$regtime = time();
		$email_token = md5(daddslashes($_POST['username']).daddslashes($_POST['pass']).$regtime);
		$token_exptime = time()+60*60*24;
		$arr = array(
			'username'=>daddslashes($_POST['username']),
			'email'=>daddslashes($_POST['email']),
			'passw'=>md5(daddslashes($_POST['pass']).$password_hash),
			'sip'=>$ip,
			'stime'=>$time,
			'token'=>$token,
			'status'=>'3',
			'email_token'=>$email_token,
			'token_exptime'=>$token_exptime,
		);
		$sql = $set->create($arr);
		if ($sql) {
			if($conf['email_sign']==1){
				$stime = time();
				$username = $arr['username'];
				$email = $arr['email'];
				$content = "亲爱的" . $username . "：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/>
				<a href='".$WebUrl."/admin/ajax.php?action=verify&verify=" . $email_token . "' target='_blank'>".$WebUrl."/admin/ajax.php?action=verify&verify=" . $email_token . "</a>
				<br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。<br/>如果此次激活请求非你本人所发，请忽略本邮件。<br/>
				";
				$type = '2';
				$set->table_name = 'pwd_plan';
				$sql = $set->create(array('stime'=>$stime,'username'=>$username,'email'=>$email,'content'=>$content,'type'=>$type));
				if($sql){
					EchoMsg(200,'请求数据成功(注册)','','','2',$username);
				}else{
					EchoMsg(201,'请求数据失败(注册)');
				}
			}
			unset($_SESSION['verifycode']);
			echo EchoMsg(200,'注册成功','','','2',$arr['username']);
		}else{
			unset($_SESSION['verifycode']);
			echo EchoMsg(201,'数据请求错误');
		}
	}else{
		unset($_SESSION['verifycode']);
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求网站配置修改
 */
if($_GET['action']=='setting'){
	if ($islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if (isset($_POST['title'])&&isset($_POST['describe'])&&isset($_POST['keywords'])&&isset($_POST['ipadmin'])&&isset($_POST['sign'])&&isset($_POST['debug'])) {
		$arr = array(
			"title"=>daddslashes($_POST['title']),
			"describe"=>daddslashes($_POST['describe']),
			"keywords"=>daddslashes($_POST['keywords']),
			"ipadmin"=>daddslashes($_POST['ipadmin']),
			"sign"=>daddslashes($_POST['sign']),
			"debug"=>daddslashes($_POST['debug']),
		);
		$set->table_name="pwd_set";
		$sql = $set->update(array('id'=>1),$arr);
		if ($sql) {
			echo EchoMsg(200,'请求成功');
		}else{
			echo EchoMsg(201,'数据请求错误');
		}

	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求网站SMTP修改
 */
if($_GET['action']=='set_smtp'){
	if ($islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if (isset($_POST['host'])&&isset($_POST['port'])&&isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['sub'])&&isset($_POST['ssl'])) {
		$arr = array(
			"host"=>daddslashes($_POST['host']),
			"port"=>daddslashes($_POST['port']),
			"username"=>daddslashes($_POST['username']),
			"password"=>daddslashes($_POST['password']),
			"sub"=>daddslashes($_POST['sub']),
			"ssl"=>daddslashes($_POST['ssl']),
		);
		$set->table_name="pwd_smtp";
		$sql = $set->update(array('id'=>1),$arr);
		if ($sql) {
			echo EchoMsg(200,'请求网站SMTP修改成功');
		}else{
			echo EchoMsg(201,'数据请求错误');
		}

	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求获取用户列表
 */
if($_GET['action']=='get_list'){
	if ($islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if(isset($_GET['page'])&&isset($_GET['limit'])){
		$page = (daddslashes($_GET['page'])-1)*daddslashes($_GET['limit']);
		$limit = daddslashes($_GET['limit']);
		$set->table_name = 'pwd_user';
		$count = $set->findCount('','','');
		$sql = $set->findall(null, " id DESC  ", "*", " {$page}, {$limit} ");
		//var_dump($set);
		if ($sql) {
			echo EchoMsg('0','请求获取用户列表成功',$sql,$count);
		}else{
			echo EchoMsg('201','当前没有用户','','','1');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求修改用户状态
 */
if($_GET['action']=='set_status'){
	if ($islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if(isset($_POST['id'])&&isset($_POST['code'])){
		$id = daddslashes($_POST['id']);
		$status = daddslashes($_POST['code']);
		$set->table_name = 'pwd_user';
		$arr = array(
			'status'=>daddslashes($_POST['code'])
		);
		$sql = $set->update(array('id'=>$id),$arr);
		if($sql){
			echo EchoMsg(200,'请求修改用户状态成功','','','1');
		}else{
			echo EchoMsg(201,'数据请求错误');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求查找用户
 */
if($_GET['action']=='search'){
	if ($islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if(isset($_POST['type'])&&isset($_POST['content'])){
		$type = daddslashes($_POST['type']);
		$content = daddslashes($_POST['content']);
		$set->table_name = 'pwd_user';
		switch ($type) {
			case '1':
			$arr = array('id'=>$content);
			break;
			case '2':
			$arr = array("username like :user", ":user" => '%'.$content.'%');
			break;
			case '3':
			$arr = array('email'=>$content);
			break;
			case '4':
			$arr = array('qq'=>$content);
			break;
			case '5':
			$arr = array("sip like :sip OR lip like :lip", ":sip" => '%'.$content.'%',":lip" => '%'.$content.'%');
			break;
			default:
			exit(EchoMsg(201,'数据请求格式错误'));
			break;
		}
		$page = (daddslashes($_POST['page'])-1)*daddslashes($_POST['limit']);
		$limit = daddslashes($_POST['limit']);
		$count = $set->findCount($arr,'','');
		$sql = $set->findall($arr,'','id,username,email,qq,stime,ltime,sip,lip,status', " {$page}, {$limit} ");
		if($sql){
			echo EchoMsg('0','请求查找用户成功',$sql,$count,'1');
		}else{
			echo EchoMsg('201','找不到用户……');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求用户登录操作
 */
if ($_GET['action']=='login') {
	
	if(isset($_POST['user']) && isset($_POST['pass'])){
		if(!isset($_POST["verifycode"])||strtolower($_POST["verifycode"])!=$_SESSION['verifycode'])   {
			unset($_SESSION['verifycode']);

			exit(EchoMsg(203,'验证码不正确'));
		}
		$user=daddslashes($_POST['user']);
		$pass=md5(daddslashes($_POST['pass']).$password_hash);
		$set->table_name = 'pwd_user';
		if(isset($_POST['admin'])&&$_POST['admin']){
			if($user==$conf['username'] && $pass==$conf['passw']) {
				$session=md5($user.$pass.$password_hash);
				$token=authcode("$user\t$session", 'ENCODE', SYS_KEY);
				setcookie("admin_token", $token, time() + 604800);
				$update = $set->update(array('id'=>1),array('ltime'=>$date,'lip'=>$ip));
				exit(EchoMsg(200,'登陆后台管理成功！','','','2','1'));
			}elseif ($user!=$conf['username'] || $pass!=$conf['passw']) {
				//var_dump($pass);
				exit(EchoMsg(204,'用户名或密码不正确！','','','2',$user));
			}
		}else{
			$condition = array("passw = :passw AND ( username = :c1 OR email = :c1 )", 
				":passw" => $pass,
				":c1"    => $user,
			);

			$username = $set->find($condition,'','*');
			$num = $set->find(array('username'=>$user),'','error_num');

			if($num['error_num']>5){
				$update = $set->update(array('username'=>$user),array('status'=>0));
				exit(EchoMsg(204,'密码错误五次,账号锁定','','','2',$user));
			}
			if ($username) {
				switch ($username['status']) {
					case '0':
					exit(EchoMsg(204,'账号已锁定','','','2',$user));
					break;
					case '3':
					exit(EchoMsg(204,'账号未激活','','','2',$user));
					break;
					case '1':
					//账号已启用
					break;
					default:
					exit(EchoMsg(204,'账号已锁定','','','2',$user));
					break;
				}
				
				$session=md5($username['username'].$pass.$password_hash);
				$token=authcode("{$username['username']}\t{$session}", 'ENCODE', SYS_KEY);
				setcookie("user_token", $token, time() + 604800);
				@header('Content-Type: text/html; charset=UTF-8');
				unset($_SESSION['verifycode']);
				$update = $set->update(array('username'=>$user),array('ltime'=>$date,'lip'=>$ip));
				exit(EchoMsg(200,'登录成功','','','2',$user));
			}else{
				unset($_SESSION['verifycode']);
				$sql = $set->incr(array('username'=>$user), 'error_num');
				exit(EchoMsg(204,'用户名或密码不正确！','','','2',$user));
			}
		} 
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求邮箱激活
 */
if ($_GET['action']=='verify') {
	if (isset($_GET['verify'])&&$_GET['verify']) {
		$verify = daddslashes(trim($_GET['verify']));
		$nowtime = time();
		$set->table_name = 'pwd_user';
		$sql = $set->find(array('status'=>3,'email_token'=>$verify),'','id,token_exptime');
		if ($sql) {
			if($nowtime>$sql['token_exptime']){
				$msg = '您的激活有效期已过，请登录您的帐号重新发送激活邮件.';
			}else{
				$update = $set->update(array('id'=>$sql['id']),array('status'=>1,'email_token'=>'','token_exptime'=>''));
				if ($update) {
					$msg = '激活成功';
				}else{
					$msg = '激活失败';
				}
			}
		}else{
			$msg = '数据请求失败';
		}

	}else{
		$msg = '数据请求格式错误';
	}
	exit("<script language='javascript'>alert('".$msg."');window.location.href='./login.php';</script>");
}
/**
 * 请求找回密码
 */
if ($_GET['action']=='reset_pwd') {
	if(strtolower($_POST["verifycode"])!=$_SESSION['verifycode'])   {
		unset($_SESSION['verifycode']);
		exit(EchoMsg(203,'验证码不正确'));
	}
	if(isset($_POST['val'])&&$_POST['val']){
		$val = daddslashes($_POST['val']);
		$set->table_name = 'pwd_user';
		$condition = array("username = :c1 OR email = :c1 ", 
			":c1"    => $val,
		);
		$sql = $set->find($condition,'',"email,username,id");
		if($sql['email']){
			$regtime = time();
			$email_token = md5(getRandStr(8).$val.$regtime);
			$token_exptime = time()+60*60*24;

			$email = $sql['email'];
			$content = "亲爱的" . $sql['username']. "：<br/>您正在进行找回密码操作。<br/>请点击链接重新设置您的密码。<br/>
			<a href='".$WebUrl."/admin/reset_pwd.php?reset_pwd_verify=" . $email_token . "' target='_blank'>".$WebUrl."/admin/reset_pwd.php?reset_pwd_verify=" . $email_token . "</a>
			<br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。<br/>如果此次密码找回请求非你本人所发，说明有人盯上你的账号了。<br/>
			";
			$type = '3';
			$set->table_name = 'pwd_plan';
			$sql_plan = $set->create(array('stime'=>$regtime,'uid'=>$sql['id'],'email'=>$email,'content'=>$content,'type'=>$type));
			var_dump($sql_plan);
			if ($sql_plan) {
				$set->table_name = 'pwd_user';
				$arr = array(
					'status'=>'0',
					'email_token'=>$email_token,
					'token_exptime'=>$token_exptime,
				);
				$update_sql = $set->update(array('id'=>$sql['id']),$arr);
				if($update_sql){
					echo EchoMsg(200,'找回密码链接稍后发送到您的邮箱');
				}else{
					echo EchoMsg(201,'邮件发送成功,但数据请求错误');
				}
			}else{
				echo EchoMsg(201,'邮件发送失败,请联系站长','','','1');
			}
		}else{
			echo EchoMsg(201,'账号或邮箱不存在','','','1');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求密码重置
 */
if ($_GET['action']=='reset_pwd_verify') {
	if(strtolower($_POST["verifycode"])!=$_SESSION['verifycode'])   {
		unset($_SESSION['verifycode']);
		exit(EchoMsg(203,'验证码不正确'));
	}
	if (isset($_POST['reset_pwd_verify'])&&$_POST['reset_pwd_verify']&&isset($_POST['pass'])&&$_POST['pass']) {
		$pass = md5(daddslashes(trim($_POST['pass'])).$password_hash);
		$verify = daddslashes(trim($_POST['reset_pwd_verify']));
		$nowtime = time();
		$set->table_name = 'pwd_user';
		$sql = $set->find(array('status'=>0,'email_token'=>$verify),'','id,token_exptime,username');
		if ($sql) {
			if($nowtime>$sql['token_exptime']){ //24hour
				echo EchoMsg('201','您的激活有效期已过，请登录您的帐号重新发送激活邮件.','','','1'); 
			}else{
				$update = $set->update(array('id'=>$sql['id']),array('status'=>1,'email_token'=>'','token_exptime'=>'','passw'=>$pass,'error_num'=>'0'));
				if ($update) {
					echo EchoMsg(200,'密码重置成功','','','2',$sql['username']); 
				}else{
					echo EchoMsg(201,'数据请求错误'); 
				}
			}
		}else{
			echo EchoMsg(201,'数据请求错误'); 
		}
	}
}
/**
 * 请求获取密码本列表
 */
if($_GET['action']=='pwd_list'){
	if (!$udata['id']) {exit(EchoMsg('403','权限不足','','','1'));}
	if(isset($_GET['page'])&&isset($_GET['limit'])){
		$page = (daddslashes($_GET['page'])-1)*daddslashes($_GET['limit']);
		$limit = daddslashes($_GET['limit']);
		$set->table_name = 'pwd_pwd';
		$count = $set->findCount(array('uid'=>$udata['id'],'status'=>1),'','');
		$sql = $set->findall(array('uid'=>$udata['id'],'status'=>1),'id desc','*',"{$page},{$limit}");
		if($sql){
			foreach ($sql as $key => $value) {
				if($sql[$key]['type']==0){
					$sql[$key]['pwd_decode'] = Mcrypt::decode($sql[$key]['passw'],$sql[$key]['tpass']) ? Mcrypt::decode($sql[$key]['passw'],$sql[$key]['tpass']) : '解密失败';
				}
			}
			echo EchoMsg('0','请求获取密码本列表',$sql,$count,'1',$udata['username']);
		}else{
			echo EchoMsg('201','当前没有记录','','','1');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}

}
/**
 * 请求修改密码本参数
 */
if($_GET['action']=='set_pwd'){
	if (!$Ulogin&&$islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if(isset($_POST['id_info'])&&$_POST['id_info']){
		$id = daddslashes($_POST['id_info']);
		$title = daddslashes($_POST['title_info']);
		$descr = daddslashes($_POST['descr_info']);
		$weburl = daddslashes($_POST['weburl_info']);
		$uid = $udata['id'];
		$set->table_name = "pwd_pwd";
		$tpass = getRandStr(8);
		$arr = array('title'=>$title,'descr'=>$descr,'weburl'=>$weburl,'lasttime'=>$date,'tpass'=>$tpass);
		if(isset($_POST['user_info'])&&$_POST['user_info']!=''){
			$arr['user'] = daddslashes($_POST['user_info']);
		}
		if(isset($_POST['key'])&&$_POST['key']){
			$key = daddslashes($_POST['key']);
			$arr['type'] = 1;
		}else{
			$key = $tpass;
			$arr['type'] = 0;
		}
		if(isset($_POST['pass_info'])&&$_POST['pass_info']!=''){
			$pass = daddslashes($_POST['pass_info']);
			$pass_encode = Mcrypt::encode($pass,$key);
			$arr['passw'] = $pass_encode;
		}
		
		$sql = $set->update(array('uid'=>$uid,'id'=>$id),$arr);
		if($sql){
			echo EchoMsg(200,'修改密码记录成功','','','2',$udata['username']);
		}else{
			echo EchoMsg(201,'数据请求失败');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求删除密码本
 */
if($_GET['action']=='pwd_delete'){
	if (!$Ulogin&&$islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if (isset($_POST['id'])&&is_numeric($_POST['id'])) {
		$id = daddslashes($_POST['id']);
		$uid = $udata['id'];
		$set->table_name = 'pwd_pwd';
		$sql = $set->delete(array('id'=>$id,'uid'=>$uid));
		if ($sql) {
			echo EchoMsg(200,'删除密码记录成功','','','2',$udata['username']);
		}else{
			echo EchoMsg(201,'数据请求错误');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
	
}
/**
 * 请求查找密码本
 */
if($_GET['action']=='pwd_search'){
	if (!$Ulogin&&$islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if(isset($_POST['type'])&&isset($_POST['content'])){
		$type = daddslashes($_POST['type']);
		$content = daddslashes($_POST['content']);
		$uid = $udata['id'];
		$set->table_name = 'pwd_pwd';
		switch ($type) {
			case '1':
			$arr = array("title like :title AND uid = :uid", ":title" => '%'.$content.'%',':uid'=>$uid);
			break;
			case '2':
			$arr = array("user like :user AND uid = :uid", ":user" => '%'.$content.'%',':uid'=>$uid);
			break;
			case '3':
			$arr = array("weburl like :weburl AND uid = :uid", ":weburl" => '%'.$content.'%',':uid'=>$uid);
			break;
			default:
			exit(EchoMsg(201,'数据请求格式错误'));
			break;
		}
		$page = (daddslashes($_POST['page'])-1)*daddslashes($_POST['limit']);
		$limit = daddslashes($_POST['limit']);
		$count = $set->findCount($arr,'','');
		$sql = $set->findall($arr,'','id,uid,title,descr,user,weburl,intime,lasttime,status', " {$page}, {$limit} ");
		if($sql){
			echo EchoMsg('0','查找密码记录成功',$sql,$count,'2',$udata['username']);
		}else{
			echo EchoMsg('201','找不到密码记录……');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求增加密码本记录
 */
if($_GET['action']=='inc_pwd'){
	if (!$Ulogin&&$islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if(isset($_POST['title_info'])&&isset($_POST['descr_info'])&&isset($_POST['weburl_info'])&&isset($_POST['user_info'])&&isset($_POST['pass_info'])){
		$set->table_name = 'pwd_pwd';
		$uid = $udata['id'];
		$type = daddslashes($_POST['type']);
		$title = daddslashes($_POST['title_info']);
		$descr = daddslashes($_POST['descr_info']);
		$weburl = daddslashes($_POST['weburl_info']);
		$user = daddslashes($_POST['user_info']);
		$pass = daddslashes($_POST['pass_info']);
		$tpass = getRandStr(8);
		if(isset($_POST['key'])&&$_POST['key']&&isset($_POST['type'])){
			$key = daddslashes($_POST['key']);
		}else{
			$key = $tpass;
		}
		$pass_pwd = Mcrypt::encode($pass,$key);
		$arr  = array(
			'uid'=>$uid
			,'title'=>$title
			,'descr'=>$descr
			,'weburl'=>$weburl
			,'user'=>$user
			,'passw'=>$pass_pwd
			,'intime'=>$date
			,'lasttime'=>$date
			,'tpass'=>$tpass
			,'type'=>$type
			,'status'=>1
		);
		$sql = $set->create($arr);
		if($sql){
			echo EchoMsg(200,'新增密码记录成功','','','2',$udata['username']);
		}else{
			echo EchoMsg(201,'数据请求失败');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 批量导入密码
 */
if($_GET['action']=='import'){
	if (!$Ulogin&&$islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if(isset($_POST['json'])&&$_POST['json']){
		$json_arr = isJson($_POST['json'],true);
		if($json_arr){
			$set->table_name = 'pwd_pwd';
			$uid = $udata['id'];
			$i=0;
			foreach ($json_arr as $key => $value) {
				$arr = array();

				$title = $json_arr[$key]['title'] ? daddslashes($json_arr[$key]['title']) : '';
				$descr = $json_arr[$key]['descr'] ? daddslashes($json_arr[$key]['descr']) : '';
				$user = $json_arr[$key]['user'] ? daddslashes($json_arr[$key]['user']) : '';
				$passw = $json_arr[$key]['passw'] ? daddslashes($json_arr[$key]['passw']) : '';
				$weburl = $json_arr[$key]['weburl'] ? daddslashes($json_arr[$key]['weburl']) : '';
				if($title==''||$descr==''||$user==''||$passw==''||$weburl==''){
					continue;
				}
				$tpass = getRandStr(8);

				if(isset($json_arr[$key]['key'])&&$json_arr[$key]['key']){
					$key = daddslashes($json_arr[$key]['key']);
					$type = 1;
				}else{
					$key = $tpass;
					$type = 0;
				}
				$pass_pwd = Mcrypt::encode($passw,$key);
				$arr  = array(
					'uid'=>$uid
					,'title'=>$title
					,'descr'=>$descr
					,'weburl'=>$weburl
					,'user'=>$user
					,'passw'=>$pass_pwd
					,'intime'=>$date
					,'lasttime'=>$date
					,'tpass'=>$tpass
					,'type'=>$type
					,'status'=>1
				);
				$sql = $set->create($arr);
				$i++;
				if($sql){
					$err_msg = '1';
				}else{
					$err_msg = '0';
				}
			}
			if($err_msg){
				echo EchoMsg(200,'批量导入'.$i.'条密码记录成功','','','2',$udata['username']);
			}else{
				echo EchoMsg(201,'数据请求失败');
			}
		}else{
			echo EchoMsg(201,'json格式错误');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求查看密码
 */
if($_GET['action']=='see_pwd'){
	if (!$Ulogin&&$islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if(isset($_POST['list_id'])&&$_POST['list_id']&&isset($_POST['key'])&&$_POST['key']){
		
		$uid = $udata['id'];
		$id = daddslashes($_POST['list_id']);
		$key  =daddslashes($_POST['key']);
		$set->table_name = 'pwd_pwd';
		$sql = $set->find(array('id'=>$id,'uid'=>$uid),'','');
		if($sql){
			$pass_decode = Mcrypt::decode($sql['passw'],$key);
			if($pass_decode){
				echo EchoMsg(200,$pass_decode);
			}else{
				echo EchoMsg(201,'二代密码有误','','','2',$udata['username']);
			}
		}else{
			echo EchoMsg(201,'数据请求失败');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求日志输出
 */
if($_GET['action']=='log_list'){
	if(isset($_GET['page'])&&isset($_GET['limit'])){
		$page = (daddslashes($_GET['page'])-1)*daddslashes($_GET['limit']);
		$limit = daddslashes($_GET['limit']);
		$set->table_name = 'pwd_log';
		if($islogin==1){
			$count = $set->findCount(null,'','');
			$sql = $set->findall(null,'id desc','*'," {$page}, {$limit} ");

		}elseif($Ulogin==1){
			$uid = $udata['id'];
			$username = $udata['username'];
			$count = $set->findCount(array("ev = :c3 AND (username = :c1 OR uid = :c2 )", 
				":c1"    => $username,
				":c2"    => $uid,
				":c3"	 => '2'
			),'','*');
			$sql = $set->findall(
				array("ev = :c3 AND (username = :c1 OR uid = :c2 )", 
					":c1"    => $username,
					":c2"    => $uid,
					":c3"	 => '2'
				),
				'id desc',
				'id,ip,time,record,username',
				" {$page}, {$limit} "
			);
		}
		if($sql){
			foreach ($sql as $key => $value) {
				$sql[$key]['time'] = date("Y-m-d H:i:s", $sql[$key]['time']);
			}
			echo EchoMsg(0,'数据请求成功',$sql,$count);
		}else{
			echo EchoMsg(201,'数据请求失败');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求增加公告
 */
if($_GET['action']=='notice_inc'){
	if(isset($_POST['content'])&&$_POST['content']&&isset($_POST['level'])&&$_POST['level']){
		$content = daddslashes($_POST['content']);
		$level = daddslashes($_POST['level']);
		$arr = array('content'=>$content,'level'=>$level,'time'=>time());
		$set->table_name = 'pwd_notice';
		$sql = $set->create($arr);
		if($sql){
			echo EchoMsg(200,'发布公告成功','','','1');
		}else{
			echo EchoMsg(201,'数据请求失败');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求输出公告列表
 */
if($_GET['action']=='notice_list'){
	if (!$Ulogin&&$islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	$set->table_name = 'pwd_notice';
	$sql = $set->findall(null,'id desc','*',"0,5");
	if($sql){
		foreach ($sql as $key => $value) {
			$sql[$key]['time'] = date("Y-m-d H:i:s", $sql[$key]['time']);
		}
		echo EchoMsg(0,'数据请求成功',$sql);
	}else{
		echo EchoMsg(201,'当前没有公告');
	}
}
/**
 * 请求删除公告
 */
if($_GET['action']=='notice_del'){
	if (!$Ulogin&&$islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if(isset($_POST['id'])&&$_POST['id']){
		$id = daddslashes($_POST['id']);
		$set->table_name = 'pwd_notice';
		$sql = $set->delete(array('id'=>$id));
		if($sql){
			echo EchoMsg(200,'数据请求成功',$sql);
		}else{
			echo EchoMsg(201,'当前没有内容');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求增加备忘录
 */
if($_GET['action']=='notepad_inc'){
	if (!$Ulogin&&$islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if(isset($_POST['content'])&&$_POST['content']&&isset($_POST['title'])&&$_POST['title']){
		$content = daddslashes($_POST['content']);
		$title = daddslashes($_POST['title']);
		$arr = array('uid'=>$udata['id'],'content'=>$content,'title'=>$title,'stime'=>time(),'type'=>0);
		$set->table_name = 'pwd_notepad';
		$sql = $set->create($arr);
		if($sql){
			echo EchoMsg(200,'增加备忘录成功');
		}else{
			echo EchoMsg(201,'数据请求失败');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求输出备忘录列表
 */
if($_GET['action']=='notepad_list'){
	if (!$Ulogin&&$islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	$page = (daddslashes($_GET['page'])-1)*daddslashes($_GET['limit']);
	$limit = daddslashes($_GET['limit']);
	$set->table_name = 'pwd_notepad';
	$count = $set->findCount(array('uid'=>$udata['id']),'','');
	$sql = $set->findall(array('uid'=>$udata['id']),'id desc','*',"{$page},{$limit}");
	if($sql){
		foreach ($sql as $key => $value) {
			$sql[$key]['stime'] = date("Y-m-d H:i:s", $sql[$key]['stime']);
		}
		echo EchoMsg(0,'请求输出备忘录列表成功',$sql,$count);
	}else{
		echo EchoMsg(201,'当前没有备忘录');
	}
}
/**
 * 请求删除备忘录
 */
if($_GET['action']=='notepad_del'){
	if (!$Ulogin&&$islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if(isset($_POST['id'])&&$_POST['id']){
		$id = daddslashes($_POST['id']);
		$set->table_name = 'pwd_notepad';
		$sql = $set->delete(array('id'=>$id,'uid'=>$udata['id']));
		if($sql){
			echo EchoMsg(200,'请求删除备忘录成功',$sql,'','2',$udata['username']);
		}else{
			echo EchoMsg(201,'当前没有内容');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求修改备忘录状态
 */
if($_GET['action']=='notepad_status'){
	if (!$Ulogin&&$islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if(isset($_POST['id'])&&isset($_POST['code'])){
		$id = daddslashes($_POST['id']);
		$status = daddslashes($_POST['code']);
		$set->table_name = 'pwd_notepad';
		$arr = array(
			'type'=>daddslashes($_POST['code'])
		);
		$sql = $set->update(array('id'=>$id),$arr);
		if($sql){
			echo EchoMsg(200,'请求修改备忘录状态成功','','','2',$udata['username']);
		}else{
			echo EchoMsg(201,'数据请求错误');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 请求查找备忘录
 */
if($_GET['action']=='notepad_search'){
	if (!$Ulogin&&$islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	if(isset($_POST['type'])&&isset($_POST['content'])){
		$type = daddslashes($_POST['type']);
		$content = daddslashes($_POST['content']);
		$set->table_name = 'pwd_notepad';
		switch ($type) {
			case '1':
			$arr = array("title like :title AND uid = :uid", ":title" => '%'.$content.'%',':uid'=>$udata['id']);
			break;
			case '2':
			$arr = array("content like :content AND uid = :uid", ":content" => '%'.$content.'%',':uid'=>$udata['id']);
			break;
			default:
			exit(EchoMsg(201,'数据请求格式错误'));
			break;
		}
		$page = (daddslashes($_POST['page'])-1)*daddslashes($_POST['limit']);
		$limit = daddslashes($_POST['limit']);
		$count = $set->findCount($arr,'','');
		$sql = $set->findall($arr,'','id,uid,title,content,stime,type', " {$page}, {$limit} ");
		if($sql){
			foreach ($sql as $key => $value) {
				$sql[$key]['stime'] = date("Y-m-d H:i:s", $sql[$key]['stime']);
			}
			echo EchoMsg('0','请求查找备忘录成功',$sql,$count,'2',$udata['username']);
		}else{
			echo EchoMsg('201','找不到备忘录……');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 备忘录待办事项
 */
if($_GET['action']=='notepad_type'){
	if (!$Ulogin&&$islogin != 1) {exit(EchoMsg('403','权限不足','','','1'));}
	$set->table_name = 'pwd_notepad';
	$sql = $set->findAll(array('uid'=>$udata['id'],'type'=>0),'id desc','','0,5');
	foreach ($sql as $key => $value) {
		$sql[$key]['stime'] = smartDate($sql[$key]['stime']);
	}
	echo EchoMsg(200,'请求成功',$sql);
}
/**
 * 请求添加预约计划
 */
if($_GET['action']=='remind'){
	if(isset($_POST['stime'])&&$_POST['stime']&&is_numeric($_POST['stime'])&&$_POST['stime']>=1&&$_POST['stime']<=365){
		$stime = time()+(60*60*24*daddslashes($_POST['stime']));
		$uid = $udata['id'];
		$email = $udata['email'];
		$content = "亲爱的用户，您好<br/>
		您在本章托管保存的账号密码已经达到你设置的保管时间，为了安全起见请尽快到本站修改所保存的账号密码<br/>
		<a href='".$WebUrl."'>".$WebUrl."</a>
		<br/>温馨提示：账号密码都不要长时间不修改。也不要使用同样的密码.<br/>
		如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问<br/>
		如果此次请求非你本人所发，请忽略本邮件。";
		$type = '1';
		$set->table_name = 'pwd_plan';
		$xy = $set->find(array('uid'=>$uid,'status'=>0),'','*');
		if($xy){
			exit(EchoMsg(201,'已存在预约计划,请过期后重新预约，您预约的提醒将在'.date("Y-m-d H:i:s", $xy['stime']).'发送到您的邮箱'));
		}
		$sql = $set->create(array('stime'=>$stime,'uid'=>$uid,'email'=>$email,'content'=>$content,'type'=>$type));
		if($sql){
			echo EchoMsg(200,'添加预约提醒服务成功','','','1',$uid);
		}else{
			echo EchoMsg(201,'数据请求失败');
		}
	}else{
		echo EchoMsg(201,'数据请求格式错误');
	}
}
/**
 * 计划监控
 */
if($_GET['action']=='monitor'&&$_GET['key']=='Youngxjpwd'){
	$set->table_name = 'pwd_plan';
	$stime = time();
	$condition = array("stime < :stime AND status=:c1", 
		":stime" => $stime,
		":c1"    => "0",
	);
	$arr =array();
	$sql = $set->findAll($condition);
	if (!$sql) {
		exit(EchoMsg(200,'当前无任务'));
	}
	$set->table_name = 'pwd_smtp';
	$email_conf = $set->find(array('id'=>1),'','*');
	if(!$email_conf['host']||!$email_conf['port']||!$email_conf['username']||!$email_conf['password']||!$email_conf['sub']){
		exit(EchoMsg(201,'邮件smtp未配置','','','1',$uid));
	}
	loader('smtp.class');
	foreach ($sql as $key => $value) {
		$id = $sql[$key]['id'];
		$uid = $sql[$key]['uid'];
		$email = $sql[$key]['email'];
		$stime = $sql[$key]['stime'];
		$content = $sql[$key]['content'];
		$type = $sql[$key]['type'];
		if($type==1){
			$msgTitle = '系统信息';
			$msg = '(预约)';
		}else if($type==2){
			$msgTitle = '用户帐号激活';
			$msg = '(注册)';
		}else if($type==3){
			$msgTitle = '用户帐号重置';
			$msg = '(重置)';
		}

		$x = new SMTP($email_conf['host'],$email_conf['port'],true,$email_conf['username'],$email_conf['password'],$email_conf['ssl']);
		$val = $x->send($email,$email_conf['username'],$msgTitle,$content,$email_conf['sub']);
		$set->table_name = 'pwd_plan';
		if($val){
			$arr = $set->update(array('id'=>$id),array('status'=>'1'));
			if($arr){
				echo EchoMsg(200,'邮件发送成功'.$msg,'','','1',$uid);
			}else{
				echo EchoMsg(201,'数据请求失败'.$msg,'','','1',$uid);
			}
		}else{
			echo EchoMsg(201,'邮件发送失败'.$msg,'','','1',$uid);
		}
	}
}
if($_GET['action']=='encode'){
	$key = $_GET['key'];
	$pass = $_GET['pass'];
	
	echo Mcrypt::encode($pass,$key);
}
if($_GET['action']=='decode'){
	$key = $_GET['key'];
	$pass = $_GET['pass'];
	
	echo Mcrypt::decode($pass,$key);
}
/**
 * 修改用户状态
 * @param string  $id     ID
 * @param integer $status 状态码
 */
function set_status($id='',$status=0){
	$set->table_name = 'pwd_user';
	$arr = array(
		'status'=>$status
	);
	$sql = $set->update(array('id'=>$id),$arr);

	if ($sql) {
		return true;
	}else{
		return false;
	}
}
?>
