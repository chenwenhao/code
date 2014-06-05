<div id="register">
<h2>会员注册</h2>
	<form method="post" id="form_register"  onsubmit="return false;">
	<dl>
		<dt>请认真填写一下内容</dt>
		<dd><span>用 户 名：</span><input type="text" name="username" class="text"> (*必填，至少两位)</dd>
		<dd><span>密      码：</span><input type="password" name="password" class="text"> (*必填，至少六位)</dd>
		<dd><span>确认密码：</span><input type="password" name="password2" class="text"> (*必填，同上)</dd>
		<dd><span>性      别：</span><input type="radio" name="sex" value="男" checked="checked">男 <input type="radio" name="sex" value="女">女</dd>
		<dd><span>电子邮件：</span><input type="text" name="email" class="text"> (*必填，激活账户)</dd>
		<dd><span>验 证 码：</span><input type="text" name="v_code" class="text yzm"> <img id="img_vcode" src="/member/seccode" /> <a href="#" onclick="change_vcode();">换另外一个图</a></dd>
		<dd><input type="submit" class="submit" value="注册" id="register"></dd>
		<dd><span id="error_msg"></span></dd>
	</dl>
</form>
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