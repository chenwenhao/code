<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="wb:webmaster" content="2a61e43fc8fc208f" />
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
  <h1><a href="/">推书单</a></h1>
  <ul>
    <li><a href="/">首页</a></li>
    <?php
    if($this->userinfo)
    {
      echo '<li><a href="/mine.html">'. $this->userinfo->username .'·个人中心</a></li>
      <li><a href="#" id="login_out">退出</a></li>';
    }
    else
    {
      echo '<li><a href="/login.html">登录</a></li>
      <li><a href="/register.html">注册</a></li>';
    }
    ?>
  </ul>
</div>
<?php echo $content?>
<div id="footer">
  <p>本程序执行耗时为: 0.003秒</p>
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