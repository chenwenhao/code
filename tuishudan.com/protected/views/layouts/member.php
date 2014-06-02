<!DOCtype html PUBliC "-//W3C//Dtd html 4.01 Transitional//EN" "http://www.w3.org/tr/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>注册新用户</title>
	<link rel="stylesheet" type="text/css" href="/css/qa-styles.css">
	<script src="/js/jquery-1.js" type="text/javascript"></script>
</head>
<body class="qa-template-login qa-body-js-off">
	<div class="qa-body-wrapper">

		<div class="qa-header">
			<div class="qa-logo">
				<a href="./" class="qa-logo-link">Web专业问答平台</a>
			</div>
			<div class="qa-nav-user">
			<?php if(!$this->userinfo):?>
				<ul class="qa-nav-user-list">
					<li class="qa-nav-user-item qa-nav-user-login">
						<a href="/login.html" class="qa-nav-user-link">登录</a>
					</li>
					<li class="qa-nav-user-item qa-nav-user-login">
						<a href="/register.html" class="qa-nav-user-link qa-nav-user-selected">注册</a>
					</li>
				</ul>
			<?php else:?>
			<div class="qa-logged-in">
						<span class="qa-logged-in-pad">你好</span><span class="qa-logged-in-data"><a class="qa-user-link" href="./user/x303429874"><?php echo $this->userinfo->username?></a></span>
					</div>
					<ul class="qa-nav-user-list">
						<li class="qa-nav-user-item qa-nav-user-account">
							<a class="qa-nav-user-link" href="/mine.html">我的帐号</a>
						</li>
						<li class="qa-nav-user-item qa-nav-user-updates">
							<a class="qa-nav-user-link" href="./updates">我的更新</a>
						</li>
						<li class="qa-nav-user-item qa-nav-user-logout">
							<a class="qa-nav-user-link" href="#" id="logout">退出</a>
						</li>
					</ul>
			<?php endif;?>
				<div class="qa-nav-user-clear"></div>
			</div>
			<div class="qa-search">
				<form method="get" action="./search">
					<input name="q" value="" class="qa-search-field">
					<input type="submit" value="搜索" class="qa-search-button"></form>
			</div>
			<div class="qa-nav-main">
				<ul class="qa-nav-main-list">
					<li class="qa-nav-main-item qa-nav-main-custom-1">
						<a href="/" class="qa-nav-main-link">Linux运维首页</a>
					</li>
					<li class="qa-nav-main-item qa-nav-main-custom-2">
						<a href="/faq/" class="qa-nav-main-link">问答首页</a>
					</li>
					<li class="qa-nav-main-item qa-nav-main-questions">
						<a href="./questions" class="qa-nav-main-link">问题</a>
					</li>
					<li class="qa-nav-main-item qa-nav-main-unanswered">
						<a href="./unanswered" class="qa-nav-main-link">待回复</a>
					</li>
					<li class="qa-nav-main-item qa-nav-main-user">
						<a href="./users" class="qa-nav-main-link">用户</a>
					</li>
					<li class="qa-nav-main-item qa-nav-main-ask">
						<a href="./ask" class="qa-nav-main-link">提问</a>
					</li>
				</ul>
				<div class="qa-nav-main-clear"></div>
			</div>
			<div class="qa-header-clear"></div>
		</div>
		<!-- END qa-header -->
		<div class="qa-sidepanel"></div>
<?php echo $content?>
		<div class="qa-footer">
			<div class="qa-nav-footer">
				<ul class="qa-nav-footer-list">
					<li class="qa-nav-footer-item qa-nav-footer-feedback">
						<a href="./feedback" class="qa-nav-footer-link">反馈</a>
					</li>
				</ul>
				<div class="qa-nav-footer-clear"></div>
			</div>
			<div class="qa-footer-clear"></div>
		</div>
		<!-- END qa-footer -->
	</div>
	<!-- END body-wrapper -->
<script type="text/javascript">
// 退出
$("#logout").click(function() {
	$.getJSON('/logout.html?callback=?', null, function(json) {
		window.location.href = json.refer;
	});
});
</script>
</body>
</html>