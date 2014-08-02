<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="wb:webmaster" content="4a68579cc26ed37b" />
<meta property="qc:admins" content="26561317513054166375" />
<link rel="shortcut icon" href="/images/favicon.ico" />
<title><?php echo $this->pageTitle?></title>
<link rel="stylesheet" type="text/css" href="/css/basic.css?<?php echo Yii::app()->params['css']?>" />
<?php
if($this->css)
{
  echo '<link rel="stylesheet" type="text/css" href="/css/'. $this->css .'.css?'. Yii::app()->params['css'] .'" />';
}
?>
<script type="text/javascript" src="/js/jquery.js?<?php echo Yii::app()->params['js']?>"></script>
</head>
<body>
<div id="header">
  <div class="logo"><a href="/"><img src="/images/logo.png"></a></div>
  <dl><dd>发现分享高品质网络小说</dd><dd>tuishudan.com</dd></dl>
  <ul><li><a href="/">发现小说</a></li><li><a href="/member/mybook">我的书库</a></li></ul>
  <div class="search_bg"></div>
  <div class="search_bg2">
  <form method="get" action="/search/">
  <input type="text" id="search" name="search" value="作者、小说" autocomplete="off" />  
  </form>
  </div>
  
  <!-- <span class="sina"><a href="sina"><img src="/images/sina.png" width="32" height="32"></a></span>&nbsp;&nbsp;&nbsp;&nbsp; -->
  <?php
  if ($this->userinfo) {
    echo '<div class="login_on"><img width="30px" height="30px" src="'. $this->userinfo->avatar .'" /><span style="color:#fff;position: relative;top:-10px;left:9px;">'. $this->userinfo->name .' <a href="#" id="login_out" style="color:#fff">退出</a></span></div>';
  }
  else
  {
    echo '<div class="reg_login"><span class="sina"><a href="/member/sina_login"><img src="/images/sina.png" width="32" height="32"></a></span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="qq"><a href="/member/tencent_login"><img src="/images/qq.png" width="32" height="32"></a></span></div>';
  }
  ?>
  
  <!-- <div class="menu">
  <?php
  if ($this->css == 'mybook' || $this->css == 'book_add') {
    echo '<img src="/images/trigon.png" class="current_addbook"/><img src="/images/hui.png" class="addbook_bj">';
    echo '<span class="add_book"><a href="/member/book_add">加书</a></span>';
    echo '<img src="/images/hui.png" class="addbook_bj">';
    echo '<span class="add_book"><a href="/member/mybook?like=mid">在看</a></span>';
      echo '<img src="/images/hui.png" class="addbook_bj">';
      echo '<span class="add_book"><a href="/member/mybook?like=yes">看过</a></span>';
  } else {
    echo '<img src="/images/trigon.png" class="current"/><img src="/images/hui.png" class="fsb_font_1">';
    echo '<span class="fsb_font">封神榜</span>';
  }
  ?>
  </div> -->
</div>
<div class="menu">
    <ul>
      <?php
      if($this->css == 'mybook' || $this->css == 'book_add')
      {
        echo '<li class="width20 choice_at"></li>';
        if($this->action == 'add')
        {
          echo '<li class="current_choice width55" style="left:286px">加书</li>';
          echo '<li class="current_txt width55" style="left:306px"><a href="/member/mybook?like=mid">在看</a></li>';
          echo '<li class="current_txt width55" style="left:326px"><a href="/member/mybook?like=yes">看过</a></li>';
        }
        if($this->action == 'mid')
        {
          echo '<li class="current_txt width55" style="left:286px"><a href="/member/book_add">加书</a></li>';
          echo '<li class="current_choice width55" style="left:306px">在看</li>';
          echo '<li class="current_txt width55" style="left:326px"><a href="/member/mybook?like=yes">看过</a></li>';
        }
        if($this->action == 'yes' || $this->action == 'no')
        {
          echo '<li class="current_txt width55" style="left:286px"><a href="/member/book_add">加书</a></li>';
          echo '<li class="current_txt width55" style="left:306px"><a href="/member/mybook?like=mid">在看</a></li>';
          echo '<li class="current_choice width55" style="left:326px">看过</li>';
        }
      }
      else
      {
        echo '<li class="width20 choice_at_index"></li>';
        echo '<li class="current_choice_index width55" style="left:279px">封神榜</li>';
      }
      ?>
    </ul>
  </div>
<?php echo $content?>
<div id="clear_both"></div>
<div style="margin-top: 60px;"><img src="/images/line.png"></div>
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

 // function toLogin()
 // {
 //   //以下为按钮点击事件的逻辑。注意这里要重新打开窗口
 //   //否则后面跳转到QQ登录，授权页面时会直接缩小当前浏览器的窗口，而不是打开新窗口
 //   var A=window.open("/member/tencent_login","TencentLogin","width=450,height=320,menubar=0,scrollbars=1,resizable=1,status=1,titlebar=0,toolbar=0,location=1");
 // } 
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
  echo '<script type="text/javascript" src="/js/'. $this->js .'.js?'. Yii::app()->params['js'] .'"></script>';
}
?>
<!-- baidu tongji -->
<span style="display:none">
  <script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fce1a8ecf99017c231cf872d4aa62e7d4' type='text/javascript'%3E%3C/script%3E"));
</script>
</span>
</body>
</html>
