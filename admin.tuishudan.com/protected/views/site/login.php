<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->pageTitle?></title>
<link href="/dwz/themes/css/login.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="login">
		<div id="login_content">
			<div class="loginForm">
				<form method="post">
					<input type="hidden" name="is_submit" value="true" />
				<div align="center"><h1>后台管理系统</h1></div>
				<p style="color:red;"><?php echo $msg?></p>
					<p>
						<label>用户名：</label>
						<input type="text" name="username" size="20" class="login_input" />
					</p>
					<p>
						<label>密码：</label>
						<input type="password" name="password" size="20" class="login_input" />
					</p>
					<!-- <p>
						<label>验证码：</label>
						<input class="code" type="text" size="5" name="verifyCode" />
						<span><img src="/site/seccode" alt="" width="75" height="24" onclick="this.src='/site/seccode?'+Math.random();" /></span>
					</p> -->
					<div class="login_bar">
						<input class="sub" type="submit" value=" " />
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>