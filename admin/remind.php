<?php
include("../include/init.php");
$title = '预约提醒服务';
include 'header.php';
if ($islogin == 1||$Ulogin==1) {} else exit("<script language='javascript'>window.location.href='./404.php';</script>");
?>
<body data-type="remind">
	<div class="am-g tpl-g">
		<?php include 'left-nav.php';?>

		<!-- 内容区域 -->
		<div class="tpl-content-wrapper">
			<div class="container-fluid am-cf">
				<ol class="am-breadcrumb am-breadcrumb-slash">
					<li><a href="#" class="am-icon-home">首页</a></li>
					<li class="am-active">预约提醒服务</li>
				</ol>

			</div>

			<div class="row-content am-cf">


				<div class="row">

					<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
						<div class="widget am-cf">
							<div class="widget-head am-cf">
								<div class="widget-title am-fl">创建提醒服务</div>
								<div class="widget-function am-fr">
									<a href="javascript:;" class="am-icon-cog"></a>
								</div>
							</div>
							<div class="widget-body am-fr">
								<form class="am-form tpl-form-line-form" id="doc-vld-msg">
									<div class="am-form-group">
										<label for="user-name" class="am-u-sm-3 am-form-label">天数</label>
										<div class="am-u-sm-9">
											<input type="text"  class="tpl-form-input" id="date" placeholder="多少天后邮件提示" name="date" required min="1" max="365">
											<small id="info">当前只能预约一次，预约过期后才能重新预约</small>
										</div>
									</div>
									<div class="am-form-group">
										<div class="am-u-sm-9 am-u-sm-push-3">
											<button type="button" class="am-btn am-btn-primary tpl-btn-bg-color-success" onclick="remind()">提交</button>
										</div>
									</div>
									<button type="button" class="am-btn am-btn-primary" data-am-modal="{target: '#my-alert'}" style="display: none;" id="alt_msg"></button>
								</form>
							</div>
						</div>
					</div>
					<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
						<div class="widget am-cf">
							<div class="widget-head am-cf">
								<div class="widget-title am-fl">功能说明</div>
								<div class="widget-function am-fr">
									<a href="javascript:;" class="am-icon-cog"></a>
								</div>
							</div>
							<div class="widget-body am-fr">
								<p>为防止长时间不修改密码导致的安全问题</p>
								<p>所以特别设立该功能，为了及时提醒您的密码修改</p>
								<p>预约时填写天数即可，系统记录你的预约天数，并在那天邮件提示您</p>
								<p>该服务仅可预约一次，到期后才可以重新预约</p>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<script src="/assets/js/amazeui.min.js"></script>
	<script src="/assets/js/amazeui.datatables.min.js"></script>
	<script src="/assets/js/dataTables.responsive.min.js"></script>
	<script src="/assets/js/app.js"></script>
	<script>
		$(function() {
			$('#doc-vld-msg').validator({
				onValid: function(validity) {
					$(validity.field).closest('.am-form-group').find('#info').hide();
				},

				onInValid: function(validity) {
					var $field = $(validity.field);
					var $group = $field.closest('.am-form-group');
					var $alert = $group.find('#info');
					var msg = $field.data('validationMessage') || this.getValidationMessage(validity);

					$alert.html(msg).show();
				}
			});
		});
		function remind(){
			var date=$('#date').val();
			$.post('ajax.php?action=remind', {stime:date}, function(res){
				if(res['code']==200){
					layui.use('layer', function(){
						layer.msg(res['msg'])
					});
				}else{
					layui.use('layer', function(){
						layer.msg(res['msg'])
					});
				}
			})
			.error(function(res) {
				layui.use('layer', function(){
					layer.msg('请求服务器失败:'+res)
				});
			});
		}
	</script>
</body>

</html>