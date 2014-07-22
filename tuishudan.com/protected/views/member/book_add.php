<div class="fsb_title"><p><span class="f1">推书</span><span class="f2">让烂书滚蛋</span></p></div>
<div style="margin-top: 20px;"><img src="/images/line.png" /></div>
<div id="main">
	<form id="book_add_form" method="post" onsubmit="return false;">
	<input type="hidden" name="is_submit" value="true" />
	<dl>
		<dd><span>书名</span><input id="book_name" type="text" name="book_name" class="text" /> <font color="red" id="err_msg">* 必填</font></dd>
		<dd><span>地址</span><input type="text" name="url" class="text" /></dd>
		<dd><span class="bc">补充</span><textarea rows="10" cols="50" name="intro"></textarea></dd>
		<dd><input type="submit" value="提交" class="submit" id="book_add" /></dd>
	</dl>
	</form>
	<span id="error_msg" style="color:red; font-size:12px;"></span>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$("#book_add").click(function() {

		// 检查书名
		if (!checkBookname) {
			return false;
		};

		formdata = $("#book_add_form").serialize();
		$.getJSON('/member/add_book_submit', formdata, function(json) {
			if(json.status == true)
			{
				alert('添加成功');
				window.location.reload();
			}
			else
			{
				$("#error_msg").html(json.msg);
			}
		});
		return false;
	});

	$("#book_name").blur(checkBookname);
});
checkBookname = function(){
		var book_name = $("#book_name").val();
		if (!book_name) {
			$("#err_msg").css('color', 'red').html("书名不能为空");
			return false;
		}

		$.getJSON('/member/check_book_name', {book_name:book_name}, function(json) {
			if (json.status == false) {
				$("#err_msg").css('color', 'red').html(json.msg);
				return false;
			}
		});
	}
</script>