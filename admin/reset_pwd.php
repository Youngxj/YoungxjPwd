<?php 
/**
 * 登录
**/
include("../include/init.php");
$title='密码找回';
$type="reset_pwd";
if (isset($_GET['reset_pwd_verify'])&&$_GET['reset_pwd_verify']) {
    $verify = daddslashes(trim($_GET['reset_pwd_verify']));
    $nowtime = time();
    $set->table_name = 'pwd_user';
    $sql = $set->find(array('status'=>0,'email_token'=>$verify),'','id,token_exptime');
    if ($sql) {
        if($nowtime>$sql['token_exptime']){ //24hour
            exit("<script language='javascript'>alert('您的链接有效期已过，请重新找回密码');window.location.href='./login.php';</script>");
        }else{
            $type="reset_pwd_verify";
        }
    }else{
        exit("<script language='javascript'>window.location.href='./login.php';</script>");
    }
}

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
                <?php if($type == 'reset_pwd_verify'): ?>
                    <div class="tpl-login-title">忘记密码</div>
                    <span class="tpl-login-content-info">请填写新密码</span>
                    <?php else: ?>
                        <div class="tpl-login-title">忘记密码</div>
                        <span class="tpl-login-content-info">使用邮箱或者账号找回密码</span>
                    <?php endif; ?>
                    <style type="text/css">
                    #reset-msg small{color:red;}
                </style>
                <form class="am-form tpl-form-line-form" action="" method="post" id="reset-msg">
                    <?php if($type == 'reset_pwd_verify'): ?>
                        <input type="hidden" name="reset_pwd_verify" id="reset_pwd_verify" value="<?php echo $verify;?>">
                        <div class="am-form-group">
                            <input type="text" class="tpl-form-input" id="user-pass" placeholder="输入新密码" required name="pass" minlength="6">
                            <small id="info"></small>
                        </div>
                        <?php else: ?>
                            <div class="am-form-group">
                                <input type="text" class="tpl-form-input" id="user-name" placeholder="输入用户名或者邮箱" required name="user" minlength="3">
                                <small id="info"></small>
                            </div>
                        <?php endif; ?>

                        <div class="am-form-group">
                            <div class="col-sm-10">
                                <input type="text" style="width:calc(100% - 82px);float: left;" name="verifycode" class="tpl-form-input" required　placeholder="验证码" minlength="4" id="verifycode" />
                                <img style="width:82px;float: right;" src="../include/lib/verifycode.php?<?=time();?>" onclick="re_code(this)" id="verifycode_img"> </div>
                                <small id="info"></small>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-12">
                                    <div class="tpl-switch" style="text-align: right;">
                                        <a href="login.php" style="color:#999;">登录</a>|<a href="sign-up.php" style="color:#999;">注册</a>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <button type="button" class="am-btn am-btn-primary  am-btn-block tpl-btn-bg-color-success  tpl-login-btn"  name="submit" id="submit" disabled <?php if($type == 'reset_pwd_verify'){echo 'onclick="reset_pwd_verifys();"';}else{echo 'onclick="reset_pwd();"';}?>>提交</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(function() {
                    $('#reset-msg').validator({
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
                function reset_pwd(){
                    var user = $('#user-name').val();
                    var verifycode = $('#verifycode').val();
                    if(!user&&!verifycode){
                        layui.use('layer', function(){
                            layer.msg('所有内容都不能为空')
                        });
                        return false;
                    }
                    $.post('ajax.php?action=reset_pwd',{val:user,verifycode:verifycode},function(res){
                        if(res['code']==200){
                            layui.use('layer', function(){
                                layer.msg(res['msg'])
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
                <?php if ($type =='reset_pwd_verify') {?>
                function reset_pwd_verifys(){
                    var pass = $('#user-pass').val();
                    var verifycode = $('#verifycode').val();
                    var reset_pwd_verify = $('#reset_pwd_verify').val();
                    if(!pass&&!verifycode){
                        layui.use('layer', function(){
                            layer.msg('所有内容都不能为空')
                        });
                        return false;
                    }
                    $.post('ajax.php?action=reset_pwd_verify',{pass:pass,verifycode:verifycode,reset_pwd_verify:reset_pwd_verify},function(res){
                        if(res['code']==200){
                            alert(res['msg']);
                            window.location.href='./login.php';
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
                <?php }?>
            </script>
            <script src="/assets/js/amazeui.min.js"></script>
            <script src="/assets/js/app.js"></script>

        </body>

        </html>