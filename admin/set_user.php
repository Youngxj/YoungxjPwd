<?php
include("../include/init.php");
$title = '账号设置';
include 'header.php';
if ($islogin == 1||$Ulogin==1) {} else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<body>
	<div class="am-g tpl-g">
		<?php include 'left-nav.php';?>

		<!-- 内容区域 -->
		<div class="tpl-content-wrapper">
			<div class="container-fluid am-cf">
				<ol class="am-breadcrumb am-breadcrumb-slash">
					<li><a href="#" class="am-icon-home">首页</a></li>
					<li class="am-active">用户信息修改</li>
				</ol>

			</div>

			<div class="row-content am-cf">


				<div class="row">

					<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
						<div class="widget am-cf">
							<div class="widget-head am-cf">
								<div class="widget-title am-fl">用户信息修改</div>
								<div class="widget-function am-fr">
									<a href="javascript:;" class="am-icon-cog"></a>
								</div>
							</div>
							<div class="widget-body am-fr">

								<form class="am-form tpl-form-line-form" id="doc-vld-msg">
									<div class="am-form-group">
										<label for="user-name" class="am-u-sm-3 am-form-label">用户名</label>
										<div class="am-u-sm-9">
											<input type="text" value="<?=$udata['username'];?>" class="tpl-form-input" id="username" placeholder="请填写用户名" name="username" required minlength="3">
											<small id="info"></small>
										</div>
									</div>
									<div class="am-form-group">
										<label for="user-name" class="am-u-sm-3 am-form-label">邮箱</label>
										<div class="am-u-sm-9">
											<input type="email" value="<?=$udata['email'];?>" class="tpl-form-input js-pattern-email" id="email" placeholder="请填写邮箱地址" name="email" required>
											<small id="info"></small>
										</div>
									</div>
									<div class="am-form-group">
										<label for="user-name" class="am-u-sm-3 am-form-label">QQ号</label>
										<div class="am-u-sm-9">
											<input type="number" value="<?=$udata['qq'];?>" class="tpl-form-input" id="qq" placeholder="qq号" name="qq" required pattern="^[1-9][0-9]{4,}$">
											<small id="info"></small>
										</div>
									</div>
									<div class="am-form-group">
										<label for="user-name" class="am-u-sm-3 am-form-label">修改密码</label>
										<div class="am-u-sm-9">
											<input type="password"  class="tpl-form-input" id="password" placeholder="不改留空" name="password" minlength="6">
											<small id="info"></small>
										</div>
									</div>
									<div class="am-form-group">
										<div class="am-u-sm-9 am-u-sm-push-3">
											<button type="button" class="am-btn am-btn-primary tpl-btn-bg-color-success" onclick="set_user()">提交</button>
										</div>
									</div>
									<button type="button" class="am-btn am-btn-primary" data-am-modal="{target: '#my-alert'}" style="display: none;" id="alt_msg"></button>
								</form>
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
		function set_user(){
			var username=$('#username').val();
			var email=$('#email').val();
			var qq=$('#qq').val();
			var password=$('#password').val();
			$.post('ajax.php?action=setuser', {username:username,email:email,qq:qq,password:password}, function(res){
				if(res['code']==200){
					layui.use('layer', function(){
						layer.msg('修改成功')
					});
				}else{
					layui.use('layer', function(){
						layer.msg('修改失败:'+res['msg'])
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