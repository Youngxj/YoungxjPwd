<?php
include("../include/init.php");
$title = '后台设置';
include 'header.php';
if ($islogin == 1) {} else exit("<script language='javascript'>window.location.href='./404.php';</script>");
?>
<body data-type="setting">
	<div class="am-g tpl-g">
		<?php include 'left-nav.php';?>

		<!-- 内容区域 -->
		<div class="tpl-content-wrapper">
			<?php include 'breadcrumb.php';?>

			<div class="row-content am-cf">


				<div class="row">

					<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
						<div class="widget am-cf">
							<div class="widget-head am-cf">
								<div class="widget-title am-fl">网站信息修改</div>
								<div class="widget-function am-fr">
									<a href="javascript:;" class="am-icon-cog"></a>
								</div>
							</div>
							<div class="widget-body am-fr">

								<form class="am-form tpl-form-line-form" id="doc-vld-msg">
									<div class="am-form-group">
										<label for="user-name" class="am-u-sm-3 am-form-label">网站标题</label>
										<div class="am-u-sm-9">
											<input type="text" value="<?=$conf['title'];?>" class="tpl-form-input" id="title" placeholder="请填写标题" name="title" required>
											<small id="info"></small>
										</div>
									</div>
									<div class="am-form-group">
										<label for="user-name" class="am-u-sm-3 am-form-label">网站描述</label>
										<div class="am-u-sm-9">
											<input type="text" value="<?=$conf['describe'];?>" class="tpl-form-input" id="describe" placeholder="请填写描述信息" name="describe" required>
											<small id="info"></small>
										</div>
									</div>
									<div class="am-form-group">
										<label for="user-name" class="am-u-sm-3 am-form-label">网站关键词</label>
										<div class="am-u-sm-9">
											<input type="text" value="<?=$conf['keywords'];?>" class="tpl-form-input" id="keywords" placeholder="请填写描述信息" name="keywords" required>
											<small id="info"></small>
										</div>
									</div>
									<div class="am-form-group">
										<label for="user-name" class="am-u-sm-3 am-form-label">IP黑名单</label>
										<div class="am-u-sm-9">
											<textarea class="tpl-form-input" id="ipadmin" name="ipadmin"  placeholder="请填写黑名单"><?=$conf['ipadmin'];?></textarea>
											<small id="info">多ＩＰ用,分隔</small>
										</div>
									</div>
									<div class="am-form-group">
										<label for="user-intro" class="am-u-sm-3 am-form-label">网站注册开关</label>
										<div class="am-u-sm-9">
											<div class="tpl-switch">
												<input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" <?php if($conf['sign']==1){echo 'checked=""';}?> name="sign" id="sign"　data-am-ucheck>
												<div class="tpl-switch-btn-view">
													<div></div>
												</div>
											</div>

										</div>
									</div>
									<div class="am-form-group">
										<label for="user-intro" class="am-u-sm-3 am-form-label">调试模式</label>
										<div class="am-u-sm-9">
											<div class="tpl-switch">
												<input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" <?php if($conf['debug']==1){echo 'checked=""';}?> name="debug" id="debug"　data-am-ucheck>
												<div class="tpl-switch-btn-view">
													<div></div>
												</div>
											</div>

										</div>
									</div>
									<div class="am-form-group">
										<div class="am-u-sm-9 am-u-sm-push-3">
											<button type="button" class="am-btn am-btn-primary tpl-btn-bg-color-success" onclick="set_setting()">提交</button>
										</div>
									</div>
									<button type="button" class="am-btn am-btn-primary" data-am-modal="{target: '#my-alert'}" style="display: none;" id="alt_msg"></button>
								</form>
							</div>
						</div>


						<div class="widget am-cf">
							<div class="widget-head am-cf">
								<div class="widget-title am-fl">SMTP信息配置</div>
								<div class="widget-function am-fr">
									<a href="javascript:;" class="am-icon-cog"></a>
								</div>
							</div>
							<div class="widget-body am-fr">
								<?php
								$set->table_name = 'pwd_smtp';
								$smtp_set = $set->find(array('id'=>1),'','*');
								if(!$smtp_set){exit('获取配置失败');}
								?>
								<form class="am-form tpl-form-line-form" id="doc-vld-msg_smtp">
									<div class="am-form-group">
										<label for="user-name" class="am-u-sm-3 am-form-label">邮件服务器</label>
										<div class="am-u-sm-9">
											<input type="text" value="<?=$smtp_set['host'];?>" class="tpl-form-input" id="host" placeholder="请填写标题" name="host" required>
											<small id="info"></small>
										</div>
									</div>
									<div class="am-form-group">
										<label for="user-name" class="am-u-sm-3 am-form-label">发信端口</label>
										<div class="am-u-sm-9">
											<input type="text" value="<?=$smtp_set['port'];?>" class="tpl-form-input" id="port" placeholder="发信端口" name="port" required>
											<small id="info"></small>
										</div>
									</div>
									<div class="am-form-group">
										<label for="user-name" class="am-u-sm-3 am-form-label">发信账号</label>
										<div class="am-u-sm-9">
											<input type="text" value="<?=$smtp_set['username'];?>" class="tpl-form-input" id="username" placeholder="发信账号" name="username" required>
											<small id="info"></small>
										</div>
									</div>
									<div class="am-form-group">
										<label for="user-name" class="am-u-sm-3 am-form-label">发信密码</label>
										<div class="am-u-sm-9">
											<input type="password" value="<?=$smtp_set['password'];?>" class="tpl-form-input" id="password" placeholder="发信账号" name="password" required>
											<small id="info"></small>
										</div>
									</div>
									<div class="am-form-group">
										<label for="user-name" class="am-u-sm-3 am-form-label">发件人</label>
										<div class="am-u-sm-9">
											<input type="text" value="<?=$smtp_set['sub'];?>" class="tpl-form-input" id="sub" placeholder="发件人" name="sub" required>
											<small id="info"></small>
										</div>
									</div>
									<div class="am-form-group">
										<label for="user-intro" class="am-u-sm-3 am-form-label">ssl开关</label>
										<div class="am-u-sm-9">
											<div class="tpl-switch">
												<input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" <?php if($smtp_set['ssl']==1){echo 'checked=""';}?> name="ssl" id="ssl"　data-am-ucheck>
												<div class="tpl-switch-btn-view">
													<div></div>
												</div>
											</div>

										</div>
									</div>
									<div class="am-form-group">
										<div class="am-u-sm-9 am-u-sm-push-3">
											<button type="button" class="am-btn am-btn-primary tpl-btn-bg-color-success" onclick="set_smtp()">提交</button>
										</div>
									</div>
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
		$(function() {
			$('#doc-vld-msg_smtp').validator({
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
		function set_setting(){
			var title=$('#title').val();
			var describe=$('#describe').val();
			var keywords=$('#keywords').val();
			var ipadmin=$('#ipadmin').val();
			var sign = $("#sign").is(':checked') ? 1 : 0;
			var debug = $("#debug").is(':checked') ? 1 : 0;
			console.log(sign);
			console.log(debug);
			$.post('ajax.php?action=setting', {title:title,describe:describe,keywords:keywords,ipadmin:ipadmin,sign:sign,debug:debug}, function(res){
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
					layer.msg('ERROR:请求服务器失败'+res)
				});
			});
		}

		function set_smtp(){
			var host=$('#host').val();
			var port=$('#port').val();
			var username=$('#username').val();
			var password=$('#password').val();
			var sub = $('#sub').val();
			var ssl = $("#ssl").is(':checked') ? 1 : 0;
			$.post('ajax.php?action=set_smtp', {host:host,port:port,username:username,password:password,sub:sub,ssl:ssl}, function(res){
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
					layer.msg('ERROR:请求服务器失败'+res)
				});
			});
		}

	</script>
</body>

</html>