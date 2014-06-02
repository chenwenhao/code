$(document).ready(function() {
	$("#register").click(function() {
		formdata = $("#form_register").serialize();
		$.getJSON('/member/register_submit', formdata, function(json) {
			if(json.status == true)
			{
				alert('注册成功');
				window.location.reload();
			}
			else
			{
				$("#error_msg").html(json.msg);
			}
		});
		return false;
	});
});