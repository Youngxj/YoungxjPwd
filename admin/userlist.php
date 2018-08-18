<?php
include("../include/init.php");
$title = '用户管理中心';
include 'header.php';
if ($islogin == 1) {} else exit("<script language='javascript'>window.location.href='./404.php';</script>");
?>

<body data-type="userlist">
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
                                <div class="widget-title am-fl">用户管理中心</div>
                                <div class="widget-function am-fr">
                                    <a href="javascript:;" class="am-icon-cog"></a>
                                </div>
                            </div>
                            <div class="widget-body  widget-body-lg am-fr">
                                <div>
                                    <select id="js-selected" data-am-selected="{btnWidth: '20%', btnSize: 'sm', btnStyle: 'secondary'}" lay-verify="test" name="test">
                                        <option value="1">id</option>
                                        <option value="2" selected>用户名</option>
                                        <option value="3">邮箱</option>
                                        <option value="4">QQ</option>
                                        <option value="5">IP</option>
                                    </select>
                                    <form class="tpl-header-search-form" action="javascript:;" style="display:inline">
                                        <button class="tpl-header-search-btn am-icon-search"></button>
                                        <input class="tpl-header-search-box" type="text" placeholder="搜索内容,回车提交" id="search">
                                    </form>
                                </div>
                                <div class="am-fl tpl-header-search">


                                </div>


                                <table class="layui-hide layui-bg-black" id="userList" lay-filter="userList"></table>
                                <script type="text/html" id="switchTpl">
                                    <input type="checkbox" name="status"  value="{{d.id}}" lay-skin="switch" lay-text="启用|禁用" lay-filter="Status" {{ d.status == 1 ? 'checked' : '' }}>
                                </script>
                                <script type="text/html" id="chaozuo">
                                    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                                </script>
                            </div>
                            <style type="text/css">
                            .layui-form input{color: green;}
                        </style>
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
        ,elem: '#userList'
        ,url:'ajax.php?action=get_list'
        ,cellMinWidth: 80
        ,cols: [[
        {type: 'checkbox'}
        ,{field:'id', title:'ID', sort: true}
        ,{field:'username', title:'用户名', templet: '#usernameTpl'}
        ,{field:'email', title:'邮箱'}
        ,{field:'qq', title:'QQ'}
        ,{field:'stime', title:'注册时间',sort: true}
        ,{field:'sip', title:'注册IP'}
        ,{field:'ltime', title:'最后登录时间',sort: true}
        ,{field:'lip', title:'最后登陆IP'}
        ,{field:'status', title:'状态', width:85, templet: '#switchTpl', unresize: true,sort: true}
        ,{title:'操作',templet: '#chaozuo', width:180}
        ]]
        ,page: true
    });

      form.on('switch(Status)', function(obj){
        code = obj.elem.checked ? 1 : 0;
        var id = this.value;
        console.log(id);
        $.post('ajax.php?action=set_status', {id:id,code:code}, function(res) {
            layui.use('layer', function(){
                layer.msg('修改成功')
            });
        });
    });
      table.on('tool(userList)', function(obj){
        var data = obj.data;
        if(obj.event === 'del'){
          layer.confirm('真的删除行么', function(index){
            del(data.id);
            obj.del();
            layer.close(index);
        });
      } else if(obj.event === 'edit'){
        var text = `
        <form class="layui-form" action="" lay-filter="info" >
        <div class="layui-fluid">
        <input type="hidden" id="id_info" name="id">
        <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-block">
        <input type="text"  lay-verify="title"  placeholder="用户名" class="layui-input"  name="username" id="username_info">
        </div>
        </div>
        <div class="layui-form-item">
        <label class="layui-form-label">邮箱</label>
        <div class="layui-input-block">
        <input type="text"  lay-verify="email" autocomplete="off" placeholder="邮箱" class="layui-input"  name="email" id="email_info">
        </div>
        </div>
        <div class="layui-form-item">
        <label class="layui-form-label">QQ</label>
        <div class="layui-input-block">
        <input type="text"  lay-verify="number" autocomplete="off" placeholder="QQ" class="layui-input"  name="qq" id="qq_info">
        </div>
        </div>
        <div class="layui-form-item">
        <label class="layui-form-label">密码重置</label>
        <div class="layui-input-block">
        <input type="text"  lay-verify="password" autocomplete="off" placeholder="重置密码,不改为空" class="layui-input"  name="password" id="password">
        </div>
        </div>
        <div class="layui-form-item">
        <label class="layui-form-label">邮箱激活</label>
        <div class="layui-input-block">
        <p id="status_info"></p>
        </div>
        </div>
        <div class="layui-form-item">
        <div class="layui-input-block">
        <button class="layui-btn" lay-submit="" lay-filter="formGet">立即提交</button>
        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
        </div>
        </div>
        </form>`;
        layer.open({
          type: 1,
          title: '信息修改',
          skin: 'layui-layer-rim',
          area: ['460px', '460px'],
          content: text
      });
        layui.use('form', function(){
          var form = layui.form;
          
          $('#id_info').val(data.id);
          $('#username_info').val(data.username);
          $('#email_info').val(data.email);
          $('#qq_info').val(data.qq);
          if(data.status==3){
            $('#status_info').append('邮箱未激活');
        }else{
            $('#status_info').append('邮箱已激活');
        }
        form.render();
    });
    }
});

  });
</script>
<script type="text/javascript">

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
            table.reload('userList', {
                url: 'ajax.php?action=search'
                ,method:'post'
                ,where: {type:v,content:content}
                ,page: {curr: 1}
            });
        });
    }
</script>

<script type="text/javascript">

    function del(id){
      $.post('ajax.php?action=delete',{id:id}, function(res){
        if(res['code']==200){
            layui.use('layer', function(){
                layer.msg('删除账号成功');
            });
        }else{
            layui.use('layer', function(){
                layer.msg('删除失败')
            });
        }
    })

  }
  layui.use('form', function(){
      var form = layui.form;
      form.on('submit(formGet)', function(data){
        console.log(data.field);

        var email = data.field['email'];
        var qq = data.field['qq'];
        var id = data.field['id'];
        var username = data.field['username'];
        var password = data.field['password'];
        var status = data.field['status_on'];
        $.post('ajax.php?action=setuser', {email:email,qq:qq,id:id,username:username,password:password}, function(res){
            if(res['code']==200){
                layui.use('layer', function(){
                    layer.closeAll();
                    layer.msg('修改成功')
                });
            }else{
                layui.use('layer', function(){
                    layer.closeAll();
                    layer.msg(res['msg']);
                });
                
            }
        })
        .error(function(res){
            layer.closeAll();
            layer.msg('服务器连接失败');
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