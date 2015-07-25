<?php  
if(!isset($_SESSION))
{
	session_start();
}
//检测是否登录，若没登录则转向登录界面  
if(!isset($_SESSION['username']))
{  
	header("Location:login.html");  
	exit();  
}  
//包含数据库连接文件  
include('conn.php');  
$username = $_SESSION['username'];  
$user_query = mysql_query("select * from userlists where username = '$username' limit 1");  
$row = mysql_fetch_array($user_query);  
echo '<meta charset="utf-8">用户已登录<br />';  
echo '<meta charset="utf-8">用户名：',$username,'<br />';  
echo '<meta charset="utf-8"><a href="/public/login.php?action=logout">注销</a> 登录<br />';  
?>  
<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <title>智能物联</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="format-detection" content="telephone=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="alternate icon" type="image/png" href="assets/i/favicon.png">
  <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
  <style>
    .header {
      text-align: center;
    }
    .header h1 {
      font-size: 200%;
      color: #333;
      margin-top: 30px;
    }
    .header p {
      font-size: 14px;
    }
  </style>
</head>
<body>
<!-- Header -->
<header data-am-widget="header" class="am-header am-header-default">
<h1 class="am-header-title">
    <a href="#">智能捂脸</a>
</h1>
<div class="am-header-left am-header-nav">
    <a data-bind="click: link_user, visible: showuinfo" href="#">
        <i class="am-header-icon am-icon-user"></i>
        <span class="am-header-nav-title" data-bind="text: uid"></span>
    </a>
    <a href="#" data-bind="click: gopage, visible: showback">
        <i class="am-header-icon am-icon-chevron-left"></i>
        <span class="am-header-nav-title">返回</span>
    </a>
</div>
</header>
<!-- Menu -->
<nav data-bind="visible: shownav" data-am-widget="menu" class="am-menu  am-menu-offcanvas1" data-am-menu-offcanvas>
<a href="javascript: void(0)" class="am-menu-toggle">
    <i class="am-menu-toggle-icon am-icon-bars"></i>
</a>
<div id="menu1" class="am-offcanvas">
    <div class="am-offcanvas-bar am-offcanvas-bar-flip">
        <ul class="am-menu-nav am-avg-sm-1">
            <li data-bind="visible: showuser" class="am-parent">
                <a href="##">用户</a>
                <ul class="am-menu-sub am-collapse  am-avg-sm-2 ">
                    <li class="">
                        <a href="##" data-bind="click:link_acaddus">添加用户</a>
                    </li>
                    <li class="">
                        <a href="##" data-bind="click:link_acuss">管理用户</a>
                    </li>
                </ul>
            </li>
            <li class="">
                <a data-bind="click: link_nav" href="##">快速指南</a>
            </li>
            <li class="">
                <a data-bind="click: link_user_center" href="##">我的设备</a>
            </li>
            <li class="am-parent">
                <a href="##">账户</a>
                <ul class="am-menu-sub am-collapse  am-avg-sm-2 ">
                    <li class="">
                        <a data-bind="click: link_account" href="##">我的账号设置</a>
                    </li>
                    <li class="">
                        <a data-bind="click: link_accountEditPwd" href="##">修改密码</a>
                    </li>
                </ul>
            </li>
            <li class="am-parent">
                <a href="##">设备中心</a>
                <ul class="am-menu-sub am-collapse  am-avg-sm-2 ">
                    <li class="">
                        <a data-bind="click: link_adddv" href="##">增加新设备</a>
                    </li>
                    <li class="">
                        <a data-bind="click: link_alldvs" href="##">管理设备</a>
                    </li>
                    <li class="">
                        <a href="##">管理动作</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</nav>
<!-- Content -->
<div id="render">
<div class="am-panel am-panel-default">
    <div class="am-panel-hd"></div>
    <div class="am-panel-bd">
        <div class="am-form" >
	 <form name="LoginForm" method="post" action="login.php" onSubmit="return InputCheck(this)"> 
            <label for="username" class="label">用户名:</label>
            <input  id="username" name="username" type="text" class="input"/>
            <br>
            <label for="password" class="label">密码:</label>
            <input id="password" name="password" type="password" class="input" />
            <br>
            <label for="remember-me">
                <input id="remember-me" type="checkbox" data-bind="checked: rembme">
                记住密码
            </label>
            <br />
	    <div class="am-cf">
		<input type="submit"  name="submit" value="别 点" class="am-btn am-btn-primary am-btn-sm am-fl">
		<input type="submit" name="" value="敢输密码 ? " class="am-btn am-btn-default am-btn-sm am-fr">
	    </div>
	 </form>
        </div>
    </div>
</div>
</div>
<!-- Content -->
   <!-- Navbar -->

    <div data-am-widget="gotop" class="am-gotop am-gotop-fixed">
        <a href="#top" title="回到顶部">
            <span class="am-gotop-title">回到顶部</span>
            <i class="am-gotop-icon am-icon-chevron-up"></i>
        </a>
    </div>

    <div class="am-modal am-modal-confirm" tabindex="-1" id="exit-confirm">
        <div class="am-modal-dialog">
            <div class="am-modal-hd">酷痞物联平台</div>
            <div id="dialog" class="am-modal-bd">
                你确定想退出系统吗？
            </div>
            <div class="am-modal-footer">
                <span class="am-modal-btn" data-am-modal-cancel>取消</span>
                <span class="am-modal-btn" data-am-modal-confirm>确定</span>
            </div>
        </div>
    </div>

    <div class="am-modal am-modal-prompt" tabindex="-1" id="my-prompt">
        <div class="am-modal-dialog">
            <div class="am-modal-hd">酷痞系统消息</div>
            <div id="msg" class="am-modal-bd">
                未知错误
            </div>
            <div class="am-modal-footer">
                <span class="am-modal-btn" data-am-modal-cancel>知道了</span>
            </div>
        </div>
    </div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/amazeui.min.js"></script>
<script src="assets/js/knockout-3.2.0.js"></script>
<script src="assets/js/knockout.validation.js"></script>
<script src="assets/js/knockout.validation.zh-CN.js"></script>
<script src="assets/js/footable/js/footable.min.js"></script>
<script src="assets/js/footable/js/footable.filter.min.js"></script>
<script src="assets/js/footable/js/footable.paginate.min.js"></script>
<script src="assets/js/jquery-ui-1.11.2.custom/jquery-ui.min.js"></script>
<script src="assets/js/logic/app.js"></script>
</body>
</html>
