<?php
include("../include/init.php");
$title = '公告管理';
include 'header.php';
if ($islogin == 1) {} else exit("<script language='javascript'>window.location.href='./404.php';</script>");
?>


<style type="text/css">
.default {background: #eeeeee ;}
.weak {background: #FF0000 !important;}
.medium {background: #FF9900 !important;}
.strong {background: #33CC00 !important;}
#passqd span {display: inline-block;width: 70px;height: 10px;line-height: 30px;background: #ddd;text-align: center;margin: 4px 2px;}
</style>
<body data-type="notice">
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
								<div class="widget-title am-fl">公告管理</div>
								<div class="widget-function am-fr">
									<a href="javascript:inc_notice();" class="am-icon-plus-square" title="新增密码"></a>
								</div>
							</div>
							<div class="widget-body  widget-body-lg am-fr">
								<div>
								</div>
								<div class="am-fl tpl-header-search"></div>


								<table class="layui-hide layui-bg-black" id="notice_list" lay-filter="notice_list"></table>
								<script type="text/html" id="chaozuo">
									<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
								</script>
							</div>
							<style type="text/css">.layui-form input{color: green;}</style>
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
				,elem: '#notice_list'
				,url:'ajax.php?action=notice_list'
				,cellMinWidth: 80
				,cols: [[
				{type:'numbers'}
				,{field:'content', title:'内容'}
				,{field:'time', title:'时间'}
				,{field:'level', title:'权重',sort: true}
				,{title:'操作',templet: '#chaozuo', width:180}
				]]
				,page: true
			});
			table.on('tool(notice_list)', function(obj){
				var data = obj.data;
				if(obj.event === 'del'){
					layer.confirm('真的删除行么', function(index){
						del(data.id);
						obj.del();
						layer.close(index);
					});
				}
			});

		});

		function del(id){
			$.post('ajax.php?action=notice_del',{id:id}, function(res){
				if(res['code']==200){
					layui.use('layer', function(){
						layer.msg('删除成功');
					});
				}else{
					layui.use('layer', function(){
						layer.msg('删除失败')
					});
				}
			})

		}

		function inc_notice(){
			var text = '<form class="layui-form" action="" lay-filter="info" >\
			<div class="layui-fluid">\
			<input type="hidden" id="id_info" name="id">\
			<div class="layui-form-item">\
			<label class="layui-form-label">内容</label>\
			<div class="layui-input-block">\
			<input type="text"  lay-verify="title"  placeholder="内容" class="layui-input"  name="content" id="content_info">\
			</div>\
			</div>\
			<div class="layui-form-item">\
			<label class="layui-form-label">类别代码</label>\
			<div class="layui-input-block">\
			<input type="text"  lay-verify="text" autocomplete="off" placeholder="类别" class="layui-input"  name="level" id="level_info">\
			</div>\
			</div>\
			<div class="layui-form-item">\
			<div class="layui-input-block">\
			<button class="layui-btn" lay-submit="" lay-filter="formGet_inc">立即提交</button>\
			<button type="reset" class="layui-btn layui-btn-primary">重置</button>\
			</div>\
			</div>\
			</div>\
			</form>'
			layer.open({
				type: 1,
				title: '新增公告',
				skin: 'layui-layer-rim',
				area: ['420px', '300px'],
				content: text
			});
		}
	</script>

	<script type="text/javascript">

		layui.use('form', function(){
			var form = layui.form;
			form.on('submit(formGet_inc)', function(data){
				var content = $('#content_info').val();
				var level = $('#level_info').val();
				$.post('ajax.php?action=notice_inc', {content:content,level:level}, function(res){
					if(res['code']==200){
						layui.use('layer', function(){
							layer.closeAll();
							layer.msg(res['msg'])
						});
					}else{
						layui.use('layer', function(){
							layer.closeAll();
							layer.msg(res['msg'])
						});
					}
				})
				return false;
			});
		});
	</script>
	<script src="/assets/js/amazeui.min.js"></script>
	<script src="/assets/js/amazeui.datatables.min.js"></script>
	<script src="/assets/js/dataTables.responsive.min.js"></script>
	<script src="/assets/js/app.js"></script>

</body>

</html>