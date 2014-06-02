<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="zh-CN" xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico">
  <title>webdev</title>
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <link rel="stylesheet" href="/css/channel.css" type="text/css" media="screen">
  <link rel="stylesheet" type="text/css" href="/css/jquery.css" media="screen">
  <link rel="stylesheet" href="/css/oschina2013.css" type="text/css" media="screen">
  <style type="text/css">
    body,table,input,textarea,select {font-family:Verdana,sans-serif,宋体;}
  </style>
  <script src="/js/jquery.js" type="text/javascript"></script>
</head>
<body>
  <div id="OSC_NavTop">
    <div class="wp998">
      <div id="OSC_Channels">
        <ul>
          <li class="item">
            <a href="/" class="home">首页</a>
          </li>
        </ul>
      </div>
      <div id="OSC_Userbar"> 
<?php if(!$this->userinfo):?>
        当前访客身份：游客 [
        <a href="/login.html">登录</a> |
        <a href="/register.html">注册</a> ]
<?php else:?>
  <em><?php echo $this->userinfo->username?></em>,您好
        <span class="control_select">
          <a title="我的空间" id="MySpace" href="">我的空间</a>
          <ul class="cs_content cs_myspace">
            <li class="msg_">
              <a href="/">站内留言</a>
            </li>
          </ul>
        </span>
        &nbsp;|&nbsp;
        <a href="#" class="login_out" id="logout">退出</a>
<?php endif;?>
      </div>
      <div class="clear"></div>
    </div>
  </div>

<script type="text/javascript">
// 退出
$("#logout").click(function() {
  $.getJSON('/logout.html?callback=?', null, function(json) {
    window.location.href = json.refer;
  });
});
</script>
</body>
</html>