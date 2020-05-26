<!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8" />
		<title>bootstrap案例</title>
		<!--用百度的静态资源库的cdn安装bootstrap环境-->
		<!-- Bootstrap 核心 CSS 文件 -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!-- 在bootstrap.min.js 之前引入 -->
		<script src="js/jquery.min.js"></script>
		<!-- Bootstrap 核心 JavaScript 文件 -->
		<script src="js/bootstrap.min.js"></script>
		<!--jquery.validate-->
		<script src="js/jquery.validate.min.js"></script>

		<style type="text/css">
			body{background: url(img/4.jpg) no-repeat;background-size: cover;font-size: 16px;}
			.form{background: rgba(255,255,255,0.2);width:400px;margin:100px auto;}
			#login_form{display: block;}
			#register_form{display: none;}
			.fa{display: inline-block;top: 27px;left: 6px;position: relative;color: #ccc;}
			input[type="text"],input[type="password"]{padding-left:26px;}
			.checkbox{padding-left:21px;}
		</style>
	</head>
	<body>
		<!--
			基础知识：
			网格系统:通过行和列布局
			行必须放在container内
			手机用col-xs-*
			平板用col-sm-*
			笔记本或普通台式电脑用col-md-*
			大型设备台式电脑用col-lg-*
			为了兼容多个设备，可以用多个col-*-*来控制；
		-->
		<!--
			从案例学知识，来做一个登录，注册页面
			用到font-awesome 4.3.0；bootstrap 3.3.0；jQuery Validate
		-->
	<div class="container">
		<div class="form row">
			<form class="form-horizontal col-sm-offset-3 col-md-offset-3" id="login_form" method="post" action="doAction.php?act=login">
				<h4 class="form-title">欢迎登陆五子棋在线系统</h4>
				<div class="col-sm-9 col-md-9">
					<div class="form-group">
						<i class="fa fa-user fa-lg"></i>
						<input class="form-control required" type="text" placeholder="Username" name="username" autofocus="autofocus" maxlength="20"/>
					</div>
					<div class="form-group">
							<i class="fa fa-lock fa-lg"></i>
							<input class="form-control required" type="password" placeholder="密码" name="password" maxlength="8"/>
					</div>
					<div class="form-group" style="background: #5CB85C;">
						
						<div style="text-align: center;overflow: hidden;">
							
							<input type="submit"  id="login" class="btn btn-success pull-center" style="width: 100%;" value="登陆 "/> 
						</div>
						
					</div>
					<div class="form-group">
					   
					   	
					   	<a href="javascript:;" id="register_btn" class="btn btn-success pull-left">创建新账户</a>

					   	<a href="index.php"  class="btn btn-success pull-right">返回</a>
					   
						  
					</div>
				</div>
			</form>
		</div>

		<div class="form row">
			<form class="form-horizontal col-sm-offset-3 col-md-offset-3" id="register_form" action="doAction.php?act=reg" method="post">
				<h3 class="form-title">注册你的账户</h3>
				<div class="col-sm-9 col-md-9">
					<div class="form-group">
						<i class="fa fa-user fa-lg"></i>
						<input class="form-control required" type="text" placeholder="用户名" name="username" autofocus="autofocus"/>
					</div>
					<div class="form-group">
							<i class="fa fa-lock fa-lg"></i>
							<input class="form-control required" type="password" placeholder="密码" id="register_password" name="password"/>
					</div>
					<div class="form-group">
							<i class="fa fa-check fa-lg"></i>
							<input class="form-control required" type="password" placeholder="请重复密码" name="rpassword"/>
					</div>
					<div class="form-group">
							<i class="fa fa-envelope fa-lg"></i>
							<input class="form-control eamil" type="text" placeholder="邮箱" name="email"/>
					</div>
					<div class="form-group">
						<input type="submit" id="reg" class="btn btn-success pull-right" value="注 册"/>
						<input type="button" class="btn btn-info pull-left" id="back_btn" value="返回"/>
					</div>
				</div>
			</form>
		</div>
		</div>
	<script type="text/javascript" src="js/main.js" ></script>

	</body>
	
</html>
