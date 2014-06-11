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
		<form id="form_profile_edit" onsubmit="return false;">
		<input type="hidden" name="user_id" value="<?php echo $row->id?>" />
		<input type="hidden" name="avatar" id="avatar" />
		<dl>
			<dd>用 户 名：<?php echo $row->username?></dd>
			<dd>密　　码：<input type="password" class="text" name="password"> (留空则不修改)</dd>
			<dd>昵   称：<input type="text" name="name" value="<?php echo $row->name?>" /></dd>
			<dd>电子邮件：<input type="text" class="text" name="email" value="<?php echo $row->email?>"></dd>
			<dd>头像：<input type="button" value="上传头像" id="avatar_upload" />
 			</dd>
			<dd id="avatar_pre"></dd>
			<dd><input type="submit" class="submit" value="修改资料" id="profile_edit"></dd>
		</dl>
		</form>
	</div>
</div>