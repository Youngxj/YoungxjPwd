<?php
include("../include/init.php");
if ($islogin == 1||$Ulogin==1) {} else exit("<script language='javascript'>window.location.href='./login.php';</script>");
if($islogin == 1){
	$set->table_name = 'pwd_user';
	$udata = $set->find(array('id'=>1),'','');
	$count_user = $set->findCount('','','');
	$count_user = $count_user ? $count_user : 0;
	$set->table_name = 'pwd_pwd';
	$day_time = date("Y-m-d");
	$count_day = $set->findCount(array("intime like :intime", ":intime" => '%'.$day_time.'%'),'','');
	$count_day = $count_day ? $count_day : 0;
	$count_pwd = $set->findCount('','','');
	$count_pwd = $count_pwd ? $count_pwd : 0;
}elseif($Ulogin==1){
	$set->table_name = 'pwd_user';
	$count_user = $set->findCount('','','');
	$count_user = $count_user ? $count_user : 0;
	$set->table_name = 'pwd_pwd';
	$day_time = date("Y-m-d");
	$count_day = $set->findCount(array("intime like :intime AND uid = :uid", ":intime" => '%'.$day_time.'%','uid'=>$udata['id']),'','');
	$count_day = $count_day ? $count_day : 0;
	$count_pwd = $set->findCount(array('uid'=>$udata['id']),'','');
	$count_pwd = $count_pwd ? $count_pwd : 0;
}
$title = '首页';
include 'header.php';
?>

<body data-type="index">
	<div class="am-g tpl-g">
		<?php include 'left-nav.php';?>
		<!-- 内容区域 -->
		<div class="tpl-content-wrapper">
			<?php include 'breadcrumb.php';?>

			<div class="row-content am-cf">
				<div class="row  am-cf">
					<div class="am-u-sm-12 am-u-md-6 am-u-lg-4">
						<div class="widget widget-block am-cf">
							<div class="widget-block-header">
								今日增加记录
							</div>
							<div class="widget-statistic-body">
								<div class="widget-statistic-value">
									<?=number_format($count_day);?>
								</div>
								<div class="widget-block-description">

								</div>
								<span class="widget-statistic-icon am-icon-rocket"></span>
							</div>
						</div>
					</div>
					<div class="am-u-sm-12 am-u-md-6 am-u-lg-4">
						<div class="widget widget-primary am-cf">
							<div class="widget-statistic-header">
								当前记录总计
							</div>
							<div class="widget-statistic-body">
								<div class="widget-statistic-value">
									<?=number_format($count_pwd);?>
								</div>
								<div class="widget-statistic-description">

								</div>
								<span class="widget-statistic-icon am-icon-credit-card-alt"></span>
							</div>
						</div>
					</div>
					<div class="am-u-sm-12 am-u-md-6 am-u-lg-4">
						<div class="widget widget-purple am-cf">
							<div class="widget-statistic-header">
								当前活跃用户
							</div>
							<div class="widget-statistic-body">
								<div class="widget-statistic-value">
									<?=number_format($count_user);?>
								</div>
								<div class="widget-statistic-description">

								</div>
								<span class="widget-statistic-icon am-icon-support"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="row am-cf">
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-4 widget-margin-bottom-lg ">
						<div class="tpl-user-card am-text-center widget-body-lg">
							<div class="tpl-user-card-title">
								<?=$udata['username'];?>
							</div>
							<div class="achievement-subheading">
								<?php if ($islogin == 1){echo '管理员';}else{echo '网站会员';}?>
							</div>
							<?php
							if(count(explode('@qq.com',$udata['email']))>1){
								$qq = str_replace('@qq.com','',$udata['email']);
								$img = 'https://api.yum6.cn/qq.php?qq='.$qq.'&type=img';
							}else{
								$img = 'https://cn.gravatar.com/avatar/'.md5($udata['email']);
							}
							?>
							<img class="achievement-image" src="<?=$img;?>" alt="<?=$udata['username'];?>" title="<?=$udata['username'];?>">
							<div class="achievement-description">
								上次登录时间：<strong><?=$udata['ltime'];?></strong><br/>
								上次登录IP：<strong><?=$udata['lip'];?></strong>
							</div>
						</div>
					</div>
					<div class="am-u-sm-12 am-u-md-8">
						<div class="widget am-cf widget-body-lg">
							<div class="widget-head am-cf">
								<div class="widget-title am-fl">公告</div>
								<div class="widget-function am-fr">
									<a href="javascript:;" class="am-icon-cog"></a>
								</div>
							</div>
							<div class="widget-body-md widget-body tpl-amendment-echarts am-fr">
								<div id="notice_list"></div>
							</div>
						</div>
					</div>

				</div>
				<div class="row am-cf">
					<div class="am-u-sm-12 am-u-md-12">
						<div class="widget am-cf widget-body-lg">
							<div class="widget-head am-cf">
								<div class="widget-title am-fl">事件</div>
								<div class="widget-function am-fr">
									<a href="javascript:;" class="am-icon-cog"></a>
								</div>
							</div>
							<div class="widget-body  widget-body-lg am-fr">
								<table class="layui-hide layui-bg-black" id="log_list" lay-filter="log_list"></table>
							</div>
						</div>
					</div>

				</div>



			</div>
		</div>
	</div>
	<script>
		layui.use('table', function(){
			var table = layui.table
			,form = layui.form;
			table.render({
				skin: 'nob'
				,even: false
				,elem: '#log_list'
				,url:'ajax.php?action=log_list'
				,cols: [[
				{type:'numbers'}
				,{field:'username',title:'用户'}
				,{field:'ip', title:'IP'}
				,{field:'time', title:'时间'}
				,{field:'record', title:'事件',sort: true}
				]]
				,page: true
			});
		});
		$.ajax({
			url: 'ajax.php?action=notice_list',
			type: 'GET',
			dataType: 'json',
		})
		.done(function(res) {
			if(res['code']==0){
				for (var i = 0; i < res['data'].length; i++) {
					
					$('#notice_list').append('<blockquote><p>'+res['data'][i]['content']+'</p><small>'+res['data'][i]['time']+'</small></blockquote><br/>');
					//$('#notice_list').append('<p>'+res['data'][i]['time']+' -> '+res['data'][i]['content']+'</p>');
				}
			}else{
				$('#notice_list').append(res['msg']);
			}
			
		})	
		.fail(function() {
			$('#notice_list').append('公告获取失败');
		})
		
		
	</script>
	<script src="/assets/js/amazeui.min.js"></script>
	<script src="/assets/js/amazeui.datatables.min.js"></script>
	<script src="/assets/js/dataTables.responsive.min.js"></script>
	<script src="/assets/js/app.js"></script>

</body>

</html>