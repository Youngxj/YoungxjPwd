<?php
include("../include/init.php");
$title = '备忘录';
include 'header.php';
if ($islogin == 1||$Ulogin==1) {} else exit("<script language='javascript'>window.location.href='./404.php';</script>");
?>

<style type="text/css">
.default {background: #eeeeee ;}
.weak {background: #FF0000 !important;}
.medium {background: #FF9900 !important;}
.strong {background: #33CC00 !important;}
#passqd span {display: inline-block;width: 70px;height: 10px;line-height: 30px;background: #ddd;text-align: center;margin: 4px 2px;}
</style>
<body data-type="notepad">
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
								<div class="widget-title am-fl">备忘录管理</div>
								<div class="widget-function am-fr">
									<a href="javascript:inc_notepad();" class="am-icon-plus-square" title="新增备忘录"></a>
								</div>
							</div>
							<div class="widget-body  widget-body-lg am-fr">
								<div>
									<select id="js-selected" data-am-selected="{btnWidth: '20%', btnSize: 'sm', btnStyle: 'secondary'}" lay-verify="test" name="test">
										<option value="1" selected>备注</option>
										<option value="2" >内容</option>
									</select>
									<form class="tpl-header-search-form" action="javascript:;" style="display:inline">
										<button class="tpl-header-search-btn am-icon-search"></button>
										<input class="tpl-header-search-box" type="text" placeholder="搜索内容,回车提交" id="search">
									</form>
								</div>
								<div class="am-fl tpl-header-search"></div>


								<table class="layui-hide layui-bg-black" id="notepad_list" lay-filter="notepad_list"></table>
								<script type="text/html" id="switchTpl">
									<input type="checkbox" name="type"  value="{{d.id}}" lay-skin="switch" lay-text="完成|未完成" lay-filter="Status" {{ d.type == 1 ? 'checked' : '' }}>
								</script>
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
				,elem: '#notepad_list'
				,url:'ajax.php?action=notepad_list'
				,cellMinWidth: 80
				,cols: [[
				{type:'numbers'}
				,{field:'title', title:'备注'}
				,{field:'content', title:'内容'}
				,{field:'stime', title:'时间', width:200}
				,{title:'状态',templet: '#switchTpl', unresize: true,sort: true, width:100}
				,{title:'操作',templet: '#chaozuo', width:100}
				]]
				,page: true
			});
			table.on('tool(notepad_list)', function(obj){
				var data = obj.data;
				if(obj.event === 'del'){
					layer.confirm('真的删除行么', function(index){
						del(data.id);
						obj.del();
						layer.closeAll();
					});
				}
			});

			form.on('switch(Status)', function(obj){
				code = obj.elem.checked ? 1 : 0;
				var id = this.value;
				console.log(id);
				if(code){
					var msge = '已完成';
				}else{
					var msge = '未完成';
				}
				$.post('ajax.php?action=notepad_status', {id:id,code:code}, function(res) {
					layui.use('layer', function(){
						layer.msg(msge)
					});
				});
			});

		});

		function del(id){
			$.post('ajax.php?action=notepad_del',{id:id}, function(res){
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

		function inc_notepad(){
			var text = '<form class="layui-form" action="" lay-filter="info" >\
			<div class="layui-fluid">\
			<input type="hidden" id="id_info" name="id">\
			<div class="layui-form-item">\
			<label class="layui-form-label">备注</label>\
			<div class="layui-input-block">\
			<input type="text"  lay-verify="title"  placeholder="备注" class="layui-input"  name="title" id="title_info">\
			</div>\
			</div>\
			<div class="layui-form-item">\
			<label class="layui-form-label">内容</label>\
			<div class="layui-input-block">\
			<textarea placeholder="请输入内容" class="layui-textarea" id="content_info" name="content"></textarea>\
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
				title: '新增备忘录',
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
				var title = $('#title_info').val();
				$.post('ajax.php?action=notepad_inc', {content:content,title:title}, function(res){
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
		$("#search").keydown(function() {
			if(event.keyCode == "13") {
				search()
			}
		})
		$("#search").blur(function(){
			var v = $("#js-selected option:selected").val();
			console.log(v);
		});
		function search(){
			var v = $("#js-selected option:selected").val();
			var content = $('#search').val();
			layui.use('table', function(){
				var table = layui.table;
				table.reload('notepad_list', {
					url: 'ajax.php?action=notepad_search'
					,method:'post'
					,where: {type:v,content:content}
					,page: {curr: 1}
				});
			});
		}
	</script>
	<script src="/assets/js/amazeui.min.js"></script>
	<script src="/assets/js/amazeui.datatables.min.js"></script>
	<script src="/assets/js/dataTables.responsive.min.js"></script>
	<script src="/assets/js/app.js"></script>

</body>

</html>