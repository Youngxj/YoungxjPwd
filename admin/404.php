<?php
include("../include/init.php");
$title = '404页面';
include 'header.php';
if ($islogin == 1||$Ulogin==1) {} else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>

<body>
  <div class="am-g tpl-g">
    <?php include 'left-nav.php';?>
    <!-- 内容区域 -->
    <div class="tpl-content-wrapper">
      <div class="row-content am-cf">
        <div class="widget am-cf">
          <div class="widget-body">
            <div class="tpl-page-state">
              <div class="tpl-page-state-title am-text-center tpl-error-title">404</div>
              <div class="tpl-error-title-info">Page Not Found</div>
              <div class="tpl-page-state-content tpl-error-content">

                <p>对不起,没有找到您所需要的页面,可能是URL不确定,或者页面已被移除。</p>
                <button type="button" class="am-btn am-btn-secondary am-radius tpl-error-btn">Back Home</button>
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

</body>

</html>