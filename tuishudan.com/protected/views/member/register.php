<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="zh-CN" xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico">
	<title>网站开发 - 注册</title>
	<link rel="stylesheet" href="/css/channel.css" type="text/css" media="screen">
	<link rel="stylesheet" type="text/css" href="/css/jquery.css" media="screen">
	<script type="text/javascript" src="/js/jquery.js"></script>
</head>
<body>
	<div id="OSC_NavTop">
		<div class="wp998">
			<div id="OSC_Channels">
				<ul>
					<li class="item">
						<a href="http://www.oschina.net/" class="home">首页</a>
					</li>
				</ul>
			</div>
			<div id="OSC_Userbar">
<?php if(!$this->userinfo):?>
				当前访客身份：游客 [
				<a href="/login.html">登录</a> |
				<a href="/register.html">注册</a> ]
<?php else:?>
	<em><?php echo $this->userinfo->username?></em>,您好
        <span class="control_select">
          <a title="我的空间" id="MySpace" href="">我的空间</a>
          <ul class="cs_content cs_myspace">
            <li class="msg_">
              <a href="/">站内留言</a>
            </li>
          </ul>
        </span>
        &nbsp;|&nbsp;
<?php endif;?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div id="OSC_Screen">
		<div id="OSC_Content" class="CenterDiv">
			<div id="user_page">
				<form id="form_register"  onsubmit="return false;" style="float:left; width:620px;">
					<h2>注册会员</h2>
					<table cellpadding="0" cellspacing="0">
						<tbody>
						<tr>
							<th nowrap="nowrap">用户名：</th>
							<td>
								<input name="username" id="username" class="TEXT" style="width:200px;" type="text">
								<span id="username_msg"></span>
							</td>
						</tr>
						<tr id="tr_email">
							<th nowrap="nowrap">电子邮箱：</th>
							<td>
								<input name="email" id="email" class="TEXT" style="width:200px;" type="text">
								<span id="email_tip"></span>
							</td>
						</tr>
						<tr>
							<th>昵称：</th>
							<td>
								<input name="name" id="name" maxlength="20" class="TEXT" style="width:150px;" type="text">
								<span id="name_msg">不能超过10个字</span>
							</td>
						</tr>
						<tr>
							<th>登录密码：</th>
							<td>
								<input name="password" id="password" class="TEXT" style="width:150px;" type="password">
								<span id="password_msg">至少6位</span>
							</td>
						</tr>
						<tr>
							<th>密码确认：</th>
							<td>
								<input name="password2" id="password2" class="TEXT" style="width:150px;" type="password">
							</td>
						</tr>
						<tr id="tr_gender">
							<th>性别：</th>
							<td>
								<input name="sex" value="1" id="sex" type="radio">
								<label for="gender_1">男</label>
								&nbsp;&nbsp;&nbsp;
								<input name="sex" value="2" id="sex2" type="radio">
								<label for="gender_2">女</label>
								<span class="nodisp">请选择性别</span>
							</td>
						</tr>
						<tr id="tr_area">
							<th>居住地区：</th>
							<td>
								<select onchange="showcity(this.value, document.getElementById('userCity'));" name="province" id="userProvince">
									<option selected="selected" value="">--请选择省份--</option>
									<option value="北京">北京</option>
								</select>
								<select name="city" id="userCity"></select>
								<span class="nodisp">请选择您所在的地区</span>
							</td>
						</tr>
						<tr>
							<th>验证码：</th>
							<td>
								<input id="validate" name="v_code" size="6" class="TEXT" type="text">
								<span>
									<a href="javascript:change_vcode();">换另外一个图</a>
								</span>
							</td>
						</tr>
						<tr>
							<th>&nbsp;</th>
							<td>
								<img id="img_vcode" alt="..." src="/member/seccode" style="border:2px solid #ccc;" align="absmiddle"></td>
						</tr>
						<tr class="buttons">
							<th>&nbsp;</th>
							<td style="padding:20px 0;">
								<input value=" 注册新用户 " class="BUTTON SUBMIT" type="submit" id="register">
								<span id="error_msg" class="error_msg"></span>
							</td>
						</tr>
						</tbody>
					</table>
				</form>
				<div id="login_tip">
					已有帐号？
					<a href="/home/login">直接登录</a>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
<script type="text/javascript">
// 点击改变验证码
function change_vcode()
{
	$("#img_vcode").attr({
		src: '/member/seccode?'+Math.random(),
	});
}
</script>
<script type="text/javascript" src="/js/register.js"></script>
<script type="text/javascript" src="/js/getcity.js"></script>
</body>
</html>