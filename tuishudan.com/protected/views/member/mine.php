<div id="member">
	<div id="member_sidebar">
		<h2>中心导航</h2>
		<dl>
			<dt>账号管理</dt>
			<dd><a href="/mine.html">个人信息</a></dd>
			<dd><a href="/member/profile_edit">修改资料</a></dd>
		</dl>
		<dl>
			<dt>其他管理</dt>
		</dl>
	</div>	<div id="member_main">
		<h2>会员管理中心</h2>
		<dl>
			<dd>用 户 名：<?php echo $this->userinfo->username?></dd>
			<dd>电子邮件：<?php echo $this->userinfo->email?></dd>
			<dd>注册时间：<?php echo $this->userinfo->reg_time?></dd>
		</dl>
	</div>
</div>