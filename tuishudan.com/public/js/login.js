$(document).ready(function() {
	$("#login").click(function() {
		var form_data = $("#form_login").serialize();
		$.getJSON('/member/login_submit?callback=?', form_data, function(json) {
				if(json.status == true)
				{
					alert('登录成功');
					window.location.href = '/';
				}
				else
				{
					$("#error_msg").html(json.msg);
				}
		});
		return false;
	});
});