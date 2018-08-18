<?php
if ($islogin == 1||$Ulogin==1) {} else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<div class="container-fluid am-cf">
	<ol class="am-breadcrumb am-breadcrumb-slash">
		<li><a href="index.php" class="am-icon-home">首页</a></li>
		<li class="am-active"><?=$title;?></li>
	</ol>
</div>