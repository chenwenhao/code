<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="wb:webmaster" content="4a68579cc26ed37b" />
<meta property="qc:admins" content="26561317513054166375" />
<title>推书单</title>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="/css/basic.css" />
<?php
if($this->css)
{
  echo '<link rel="stylesheet" type="text/css" href="/css/'. $this->css .'.css" />';
}
?>
<script type="text/javascript" src="/js/jquery.js"></script>
</head>
<body>
<div id="header">
  <div class="logo"><a href="/"><img src="/images/logo.png"></a></div>
  <dl><dd>发现分享高品质网络小说</dd><dd>tuishudan.com</dd></dl>
  <ul><li><a href="/">发现小说</a></li><li><a href="#">我的书库</a></li></ul>
  <div class="search_bg"></div>
  <div class="search_bg2">
  <form method="get" action="/search/">
  <input type="text" id="search" name="search" value="作者、小说" autocomplete="off" />  
  </form>
  </div>
  
  <!-- <span class="sina"><a href="sina"><img src="/images/sina.png" width="32" height="32"></a></span>&nbsp;&nbsp;&nbsp;&nbsp; -->
  <?php
  if ($this->userinfo) {
    echo '<div class="login_on"><img src="'. $this->userinfo->avatar .'" /><span style="color:#fff;">'. $this->userinfo->name .' <a href="#" id="login_out">退出</a></span></div>';
  }
  else
  {
    echo '<div class="reg_login"><span class="qq"><a href="javascript:void(0)" onclick="toLogin();"><img src="/images/qqnew.png" width="63" height="24"></a></span></div>';
  }
  ?>
  
  <div class="menu"><img src="/images/trigon.png" class="current"/><img src="/images/hui.png" class="fsb_font_1"><span class="fsb_font">封神榜</span></div>
</div>
<?php echo $content?>
<div id="footer">
  <p>© 2014 tuishudan.com, all rights reserved    <a href="http://www.miitbeian.gov.cn/" target="_blank">沪ICP备14025332号</a></p>
</div>
<script type="text/javascript">
// 退出
$("#login_out").click(function() {
  $.getJSON('/login_out.html?callback=?', null, function(json) {
    window.location.href = json.refer;
  });
});

 function toLogin()
 {
   //以下为按钮点击事件的逻辑。注意这里要重新打开窗口
   //否则后面跳转到QQ登录，授权页面时会直接缩小当前浏览器的窗口，而不是打开新窗口
   var A=window.open("/member/tencent_login","TencentLogin","width=450,height=320,menubar=0,scrollbars=1,resizable=1,status=1,titlebar=0,toolbar=0,location=1");
 } 
$(function () {
  $("#search").focus(function(){
    $(this).val("").css("color","#565656");
  });
  $("#search").blur(function(){     
    if($(this).val()==""){
      $(this).val(this.defaultValue).css("color","#ccc");
    } 
  })
});
</script>

<?php
if($this->js)
{
  echo '<script type="text/javascript" src="/js/'. $this->js .'.js"></script>';
}
?>
</body>
</html>
