<?php
/**
* 网站左侧栏
*/
if ($islogin == 1||$Ulogin==1) {} else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<script src="/assets/js/theme.js"></script>
<!-- 头部 -->
<header>
    <?php include 'header-nav.php';?>
</header>
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
<!-- 侧边导航栏 -->
<div class="left-sidebar">
    <!-- 用户信息 -->
    <div class="tpl-sidebar-user-panel">
        <div class="tpl-user-panel-slide-toggleable">
            <div class="tpl-user-panel-profile-picture">
                <?php
                if(count(explode('@qq.com',$udata['email']))>1){
                    $qq = str_replace('@qq.com','',$udata['email']);
                    $img = 'https://api.yum6.cn/qq.php?qq='.$qq.'&type=img';
                }else{
                    $img = 'https://cn.gravatar.com/avatar/'.md5($udata['email']);
                }
                ?>
                <img src="<?=$img;?>" alt="<?=$udata['username'];?>" title="<?=$udata['username'];?>">
            </div>
            <span class="user-panel-logged-in-text">
                <i class="am-icon-circle-o am-text-success tpl-user-panel-status-icon"></i>
                <?=$udata['username'];?>
            </span>
            <a href="set_user.php" class="tpl-user-panel-action-link"> <span class="am-icon-pencil"></span> 账号设置</a>
        </div>
    </div>

    <!-- 菜单 -->
    <ul class="sidebar-nav">
        <li class="sidebar-nav-link">
            <a href="index.php" id="index_nav">
                <i class="am-icon-home sidebar-nav-link-logo"></i> 首页
            </a>
        </li>
        <li class="sidebar-nav-link">
            <a href="pwd_list.php" id="pwd_list_nav">
                <i class="am-icon-edit sidebar-nav-link-logo"></i> 密码本
            </a>
        </li>
        <li class="sidebar-nav-link">
            <a href="rand_key.php" id="rand_key_nav">
                <i class="am-icon-envira sidebar-nav-link-logo"></i> 密码生成
            </a>
        </li>

        <li class="sidebar-nav-link">
            <a href="remind.php" id="remind_nav">
                <i class="am-icon-clock-o sidebar-nav-link-logo"></i> 预约提醒
            </a>
        </li>
        <li class="sidebar-nav-link">
            <a href="notepad.php" id="notepad_nav">
                <i class="am-icon-sticky-note-o sidebar-nav-link-logo"></i> 备忘录
            </a>
        </li>
        <?php if($islogin == 1):?>
            <li class="sidebar-nav-link">
                <a href="javascript:;" class="sidebar-nav-sub-title">
                    <i class="am-icon-table sidebar-nav-link-logo"></i> 管理员操作
                    <span class="am-icon-chevron-down am-fr am-margin-right-sm sidebar-nav-sub-ico"></span>
                </a>
                <ul class="sidebar-nav sidebar-nav-sub">
                    <li class="sidebar-nav-link">
                        <a href="userlist.php" id="userlist_nav">
                            <span class="am-icon-angle-right sidebar-nav-link-logo"></span> 用户列表
                        </a>
                    </li>
                    <li class="sidebar-nav-link" >
                        <a href="setting.php" id="setting_nav">
                            <span class="am-icon-angle-right sidebar-nav-link-logo"></span> 网站配置
                        </a>
                    </li>
                    <li class="sidebar-nav-link">
                        <a href="notice.php" id="notice_nav">
                            <i class="am-icon-angle-right sidebar-nav-link-logo"></i> 网站公告
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>
    </ul>
</div>