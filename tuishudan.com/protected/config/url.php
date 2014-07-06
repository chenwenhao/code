<?php
return array(
	'index.html' => 'site/index', // 首页
	'<page_num:\d>.html' => 'site/index',
	'book/<book_id:\d>.html' => 'site/book', // 书详细页
	'register.html' => 'member/register', // 注册
	'login.html' => 'member/login', // 登录
	'login_out.html' => 'member/login_out', // 退出
	'mine.html' => 'member/mine', // 我的账户
);