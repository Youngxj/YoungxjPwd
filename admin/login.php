<?php 
/**
 * 登录
**/
include("../include/init.php");
if(isset($_GET['logout'])&&$_GET['logout']==1){
    if ($islogin != 1&&$Ulogin!=1) {exit("<script language='javascript'>alert('未登录');window.location.href='login.php';</script>");}
    setcookie("admin_token", "", time() - 604800);
    setcookie("user_token", "", time() - 604800);
    exit("<script language='javascript'>alert('您已成功注销本次登陆！');window.location.href='login.php';</script>");
}
if($islogin==1){
    exit("<script language='javascript'>alert('您已登陆！');window.location.href='./';</script>");
}elseif($Ulogin==1){
    exit("<script language='javascript'>alert('您已登陆！');window.location.href='./';</script>");
}else{}
$title='用户登录';
include 'header.php';
?>

<body>
    <script src="/assets/js/theme.js"></script>
    <div class="am-g tpl-g">
        <!-- 风格切换 -->
        <div class="tpl-skiner">
            <div class="tpl-skiner-toggle am-icon-cog"></div>
            <div class="tpl-skiner-content">
                <div class="tpl-skiner-content-title">选择主题</div>
                <div class="tpl-skiner-content-bar">
                    <span class="skiner-color skiner-white" data-color="theme-white"></span>
                    <span class="skiner-color skiner-black" data-color="theme-black"></span>
                </div>
            </div>
        </div>
        <div class="tpl-login">
            <div class="tpl-login-content">
                <a href="/index.html"><div class="tpl-login-logo"></div></a>
                <style type="text/css">
                #login-msg small{color:red;}
            </style>
            <form class="am-form tpl-form-line-form" action="ajax.php?action=login" method="post" id="login-msg">
                <div class="am-form-group">
                    <input type="text" class="tpl-form-input" id="user-name" placeholder="输入用户名或者邮箱" required name="user" minlength="3">
                    <small id="info"></small>
                </div>
                <div class="am-form-group">
                    <input type="password" class="tpl-form-input" id="user-pass" placeholder="请输入密码" name="pass" minlength="6" required>
                    <small id="info"></small>
                </div>
                <div class="am-form-group">
                  <div class="col-sm-10">
                    <input type="text" style="width:calc(100% - 82px);float: left;" name="verifycode" class="tpl-form-input" required　placeholder="验证码" minlength="4" id="verifycode" />
                    <img style="width:82px;float: right;" src="../include/lib/verifycode.php?<?=time();?>" onclick="re_code(this)" id="verifycode_img"> </div>
                    <small id="info"></small>
                </div>
                
                <div class="am-form-group">
                    <label for="user-intro" class="am-u-sm-6 am-form-label tpl-form-input">管理员登陆</label>
                    <div class="am-u-sm-6">
                        <div class="tpl-switch">
                            <input type="checkbox" class="ios-switch bigswitch tpl-switch-btn" name="admin" id="admin">
                            <div class="tpl-switch-btn-view">
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="am-form-group" >
                    <div class="am-u-sm-12" >
                        <div class="tpl-switch" style="text-align: right;">
                            <a href="sign-up.php" style="color:#999;">注册</a>|<a href="reset_pwd.php" style="color:#999;">忘记密码？</a>
                        </div>
                    </div>
                </div>
                <div class="am-form-group">
                    <button type="button" class="am-btn am-btn-primary  am-btn-block tpl-btn-bg-color-success  tpl-login-btn"  name="submit" id="submit" disabled onclick="login();">提交</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('#login-msg').validator({
            onValid: function(validity) {
                $(validity.field).closest('.am-form-group').find('#info').hide();
                $('#submit').removeAttr('disabled');
            },

            onInValid: function(validity) {
                var $field = $(validity.field);
                var $group = $field.closest('.am-form-group');
                var $alert = $group.find('#info');
                var msg = $field.data('validationMessage') || this.getValidationMessage(validity);
                $('#submit').attr('disabled','');
                $alert.html(msg).show();
            }
        });
    });
    function re_code(obj){
        d = new Date();
        $(obj).attr("src","../include/lib/verifycode.php?"+d.getTime());
    }
    function login(){
        var user = $('#user-name').val();
        var pass = $('#user-pass').val();
        var verifycode = $('#verifycode').val();
        var admin = $("#admin").is(':checked') ? 1 : '';
        if(!user&&!pass&&!verifycode){
            layui.use('layer', function(){
                layer.msg('所有内容都不能为空')
            });
            return false;
        }
        $.post('ajax.php?action=login',{user:user,pass:pass,verifycode:verifycode,admin:admin},function(res){
            if(res['code']==200){
                layui.use('layer', function(){
                    layer.open({
                      type: 1
                      ,btn: ['首页', '确认']
                      ,content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">登录成功</div>'
                      ,success: function(layero){
                        var btn = layero.find('.layui-layer-btn');
                        btn.find('.layui-layer-btn0').attr({
                          href: 'index.php'
                      });
                    }
                });
                });
                $('#verifycode').val('');
            }else{
                layui.use('layer', function(){
                    layer.msg(res['msg'])
                });
                $('#verifycode_img').click();
            }
        })
        .error(function(res){
            layui.use('layer', function(){
                layer.msg('请求服务器失败')
            });
            $('#verifycode_img').click();
        })
    }
</script>
<script src="/assets/js/amazeui.min.js"></script>
<script src="/assets/js/app.js"></script>

</body>

</html>