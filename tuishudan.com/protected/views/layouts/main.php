<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="wb:webmaster" content="2a61e43fc8fc208f" />
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
  <div class="logo"><img src="/images/logo.png"></div>
  <dl><dd>发现分享高品质网络小说</dd><dd>tuishudan.com</dd></dl>
  <ul><li><a href="#">发现小说</a></li><li><a href="#">我的书库</a></li></ul>
  <div class="search_bg"></div>
  <div class="search_bg2">
  <form>
  <input type="text" name="search" placeholder="作者、小说" autocomplete="off" />  
  </form>
  </div>
  <div class="reg_login"><span class="reg"><a href="#">注册</a></span><span class="login"><a href="#">登录</a></span></div>
  <div class="menu"><img src="/images/trigon.png" /><img src="/images/hui.png" style="margin: 17px 0 0 -27px;"><span class="fsb_font">封神榜</span></div>
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
</script>

<?php
if($this->js)
{
  echo '<script type="text/javascript" src="/js/'. $this->js .'.js"></script>';
}
?>
</body>
</html>