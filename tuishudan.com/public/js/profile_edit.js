$(document).ready(function() {
	// 提交表单
	$("#profile_edit").click(function() {
		formdata = $("#form_profile_edit").serialize();
		$.getJSON('/member/profile_edit_submit', formdata, function(json) {
			if(json.status == true)
			{
				alert('修改成功');
				window.location.reload();
			}
			else
			{
				$("#error_msg").html(json.msg);
			}
		});
		return false;
	});

	// 上传图像
	$("#avatar_upload").click(function() {
		window.open('/avatar_upload/index.html', 'avatar_upload', 'width=750, height=700, top=0, left=0, scrollbars=1');
	});
});