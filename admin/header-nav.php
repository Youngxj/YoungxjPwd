<?php 
/**
 * 网站头部
 */
if ($islogin == 1||$Ulogin==1) {} else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<!-- logo -->
<div class="am-fl tpl-header-logo">
    <a href="index.php"><img src="/assets/img/logo.png" alt=""></a>
</div>
<!-- 右侧内容 -->
<div class="tpl-header-fluid">
    <!-- 侧边切换 -->
    <div class="am-fl tpl-header-switch-button am-icon-list">
        <span>

        </span>
    </div>
    <!-- 搜索 -->
    <!-- <div class="am-fl tpl-header-search">
        <form class="tpl-header-search-form" action="javascript:;">
            <button class="tpl-header-search-btn am-icon-search"></button>
            <input class="tpl-header-search-box" type="text" placeholder="搜索内容...">
        </form>
    </div> -->
    <!-- 其它功能-->
    <div class="am-fr tpl-header-navbar">
        <ul>
            <!-- 欢迎语 -->
            <li class="am-text-sm tpl-header-navbar-welcome">
                <a href="javascript:;">欢迎你, <span><?=$udata['username'];?></span> </a>
            </li>

            <!-- 新邮件 -->
            <!-- <li class="am-dropdown tpl-dropdown" data-am-dropdown>
                <a href="javascript:;" class="am-dropdown-toggle tpl-dropdown-toggle" data-am-dropdown-toggle>
                    <i class="am-icon-envelope"></i>
                    <span class="am-badge am-badge-success am-round item-feed-badge">4</span>
                </a>
                <!-- 弹出列表 -->
                <!-- <ul class="am-dropdown-content tpl-dropdown-content">
                    <li class="tpl-dropdown-menu-messages">
                        <a href="javascript:;" class="tpl-dropdown-menu-messages-item am-cf">
                            <div class="menu-messages-ico">
                                <img src="/assets/img/user04.png" alt="">
                            </div>
                            <div class="menu-messages-time">
                                3小时前
                            </div>
                            <div class="menu-messages-content">
                                <div class="menu-messages-content-title">
                                    <i class="am-icon-circle-o am-text-success"></i>
                                    <span>夕风色</span>
                                </div>
                                <div class="am-text-truncate"> Amaze UI 的诞生，依托于 GitHub 及其他技术社区上一些优秀的资源；Amaze UI 的成长，则离不开用户的支持。 </div>
                                <div class="menu-messages-content-time">2016-09-21 下午 16:40</div>
                            </div>
                        </a>
                    </li>

                    <li class="tpl-dropdown-menu-messages">
                        <a href="javascript:;" class="tpl-dropdown-menu-messages-item am-cf">
                            <div class="menu-messages-ico">
                                <img src="/assets/img/user02.png" alt="">
                            </div>
                            <div class="menu-messages-time">
                                5天前
                            </div>
                            <div class="menu-messages-content">
                                <div class="menu-messages-content-title">
                                    <i class="am-icon-circle-o am-text-warning"></i>
                                    <span>禁言小张</span>
                                </div>
                                <div class="am-text-truncate"> 为了能最准确的传达所描述的问题， 建议你在反馈时附上演示，方便我们理解。 </div>
                                <div class="menu-messages-content-time">2016-09-16 上午 09:23</div>
                            </div>
                        </a>
                    </li>
                    <li class="tpl-dropdown-menu-messages">
                        <a href="javascript:;" class="tpl-dropdown-menu-messages-item am-cf">
                            <i class="am-icon-circle-o"></i> 进入列表…
                        </a>
                    </li>
                </ul>
            </li> -->

            <!-- 新提示 -->
            <li class="am-dropdown" data-am-dropdown>
                <?php 
                $set->table_name = 'pwd_notepad';
                $arr = array('uid'=>$udata['id'],'type'=>0);
                $count = $set->findCount($arr,'','');
                ?>
                <a href="javascript:;" onclick="notepad_type()" class="am-dropdown-toggle" data-am-dropdown-toggle>
                    <i class="am-icon-bell"></i>
                    <span class="am-badge am-badge-warning am-round item-feed-badge" onclick="notepad_type()"><?=$count;?></span>
                </a>

                <!-- 弹出列表 -->
                <ul class="am-dropdown-content tpl-dropdown-content" id="notepad_type">
                    正在获取……
                </ul>
            </li>

            <!-- 退出 -->
            <li class="am-text-sm">
                <a href="javascript:;">
                    <a href="login.php?logout=1"><span class="am-icon-sign-out"></span> 退出</a>
                </a>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    function notepad_type(){
        $.ajax({
            url: 'ajax.php?action=notepad_type',
            type: 'GET',
            dataType: 'json',
        })
        .done(function(res) {
            $('#notepad_type').html('');
            for (var i = 0; i < res['data'].length; i++) {
                var text = '<li class="tpl-dropdown-menu-notifications">\
                <a href="notepad.php" class="tpl-dropdown-menu-notifications-item am-cf">\
                <div class="tpl-dropdown-menu-notifications-title" title="'+res['data'][i]['title']+'">\
                <i class="am-icon-star"></i>\
                <span> '+res['data'][i]['title']+'</span>\
                </div>\
                <div class="tpl-dropdown-menu-notifications-time" title="'+res['data'][i]['stime']+'">'+res['data'][i]['stime']+'</div>\
                </a>\
                </li>';
                console.log(res['data'][i]['id']);
                $('#notepad_type').append(text);
            }
            $('#notepad_type').append('\
                <li class="tpl-dropdown-menu-notifications">\
                <a href="notepad.php" class="tpl-dropdown-menu-notifications-item am-cf">\
                <i class="am-icon-bell"></i> 进入列表…\
                </a>\
                </li>'
                );
        })
        .fail(function(res) {
            
        })
        
    }
</script>