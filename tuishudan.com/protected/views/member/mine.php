<div class="qa-main">
<h1>
	我的账户
</h1>
<form action="./account" method="POST" enctype="multipart/form-data">
	<table class="qa-form-wide-table">
		<tbody><tr>
			<td class="qa-form-wide-label">
				会员:
			</td>
			<td class="qa-form-wide-data">
				<span class="qa-form-wide-static">2 天</span>
			</td>
		</tr>
		<tr>
			<td class="qa-form-wide-label">
				分类:
			</td>
			<td class="qa-form-wide-data">
				<span class="qa-form-wide-static">注册用户</span>
			</td>
		</tr>
		<tr>
			<td class="qa-form-wide-label">
				用户名:
			</td>
			<td class="qa-form-wide-data">
				<input type="text" class="qa-form-wide-text" value="x303429874" name="handle">
			</td>
		</tr>
		<tr>
			<td class="qa-form-wide-label">
				邮箱:
			</td>
			<td class="qa-form-wide-data">
				<input type="text" class="qa-form-wide-text" value="303429874@qq.com" name="email">
			</td>
		</tr>
		<tr>
			<td class="qa-form-wide-label">
				私信:
			</td>
			<td class="qa-form-wide-data">
				<input type="checkbox" class="qa-form-wide-checkbox" checked="" value="1" name="messages">
				<span class="qa-form-wide-note">允许给我发送邮件(隐藏我的邮箱地址)</span>
			</td>
		</tr>
		<tr>
			
			</tr>
			<tr>
				<td class="qa-form-wide-label">
					全名:
				</td>
				<td class="qa-form-wide-data">
					<input type="text" class="qa-form-wide-text" value="" name="field_1">
				</td>
			</tr>
			<tr>
				<td class="qa-form-wide-label">
					所在地:
				</td>
				<td class="qa-form-wide-data">
					<input type="text" class="qa-form-wide-text" value="" name="field_2">
				</td>
			</tr>
			<tr>
				<td class="qa-form-wide-label">
					网站:
				</td>
				<td class="qa-form-wide-data">
					<input type="text" class="qa-form-wide-text" value="" name="field_3">
				</td>
			</tr>
			<tr>
				<td style="vertical-align:top;" class="qa-form-wide-label">
					关于:
				</td>
				<td class="qa-form-wide-data">
					<textarea class="qa-form-wide-text" cols="40" rows="8" name="field_4"></textarea>
				</td>
			</tr>
			<tr>
				<td class="qa-form-wide-buttons" colspan="3">
					<input type="submit" onmouseout="this.className='qa-form-wide-button qa-form-wide-button-save';" onmouseover="this.className='qa-form-wide-hover qa-form-wide-hover-save';" class="qa-form-wide-button qa-form-wide-button-save" title="" value="保存资料">
				</td>
			</tr>
		</tbody></table>
		<input type="hidden" value="1" name="dosaveprofile">
	</form>
	<h2>修改密码</h2>
	<form id="form_edit_password" onsubmit="return false;" method="POST">
		<table class="qa-form-wide-table">
			<tbody><tr>
				<td class="qa-form-wide-label">
					旧密码:
				</td>
				<td class="qa-form-wide-data">
					<input type="password" class="qa-form-wide-text" value="" name="old_password">
				</td>
			</tr>
			<tr>
				<td class="qa-form-wide-label">
					新密码:
				</td>
				<td class="qa-form-wide-data">
					<input type="password" class="qa-form-wide-text" value="" name="new_password">
				</td>
			</tr>
			<tr>
				<td class="qa-form-wide-label">
					重新输入密码:
				</td>
				<td class="qa-form-wide-data">
					<input type="password" class="qa-form-wide-text" value="" name="new_re_password">
				</td>
			</tr>
			<tr>
				<td class="qa-form-wide-buttons" colspan="3">
					<input id="edit_password" type="button" class="qa-form-wide-button qa-form-wide-button-change" title="" value="修改密码">
				</td>
			</tr>
		</tbody></table>
		<div id="msg" style="display:none; color:red;"></div>
		<input type="hidden" value="true" name="is_submit">
	</form>
</div>
<script type="text/javascript">
$("#edit_password").click(function() {
	var form_edit_password_data = $("#form_edit_password").serialize();
	$.getJSON('/member/edit_password', form_edit_password_data, function(json) {
		if(json.status == true)
		{
			alert('修改成功');
		}
		else
		{
			$("#msg").show().html(json.msg);
		}
	});
});
</script>