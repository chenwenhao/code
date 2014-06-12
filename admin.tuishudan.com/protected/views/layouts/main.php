<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title><?php echo $this->pageTitle?></title>

<link href="/dwz/themes/default/style.css?<?php echo time()?>" rel="stylesheet" type="text/css" media="screen"/>
<link href="/dwz/themes/css/core.css?<?php echo time()?>" rel="stylesheet" type="text/css" media="screen"/>
<link href="/dwz/themes/css/print.css?<?php echo time()?>" rel="stylesheet" type="text/css" media="print"/>
<link href="/dwz/uploadify/css/uploadify.css?<?php echo time()?>" rel="stylesheet" type="text/css" media="screen"/>
<!--[if IE]>
<link href="/dwz/themes/css/ieHack.css?<?php echo time()?>" rel="stylesheet" type="text/css" media="screen"/>
<![endif]-->

<!--[if lte IE 9]>
<script src="/dwz/js/speedup.js?time=<?php echo time()?>" type="text/javascript"></script>
<![endif]-->

<script src="/dwz/js/jquery-1.7.2.js?time=<?php echo time()?>" type="text/javascript"></script>
<script src="/dwz/js/jquery.cookie.js?time=<?php echo time()?>" type="text/javascript"></script>
<script src="/dwz/js/jquery.validate.js?time=<?php echo time()?>" type="text/javascript"></script>
<script src="/dwz/js/jquery.bgiframe.js?time=<?php echo time()?>" type="text/javascript"></script>
<script src="/dwz/xheditor/xheditor-1.1.14-zh-cn.min.js?time=<?php echo time()?>" type="text/javascript"></script>
<script src="/dwz/uploadify/scripts/jquery.uploadify.js?time=<?php echo time()?>" type="text/javascript"></script>

<script src="/dwz/bin/dwz.min.js?time=<?php echo time()?>" type="text/javascript"></script>
<script src="/dwz/js/dwz.regional.zh.js?time=<?php echo time()?>" type="text/javascript"></script>

<script type="text/javascript">
$(function(){
	DWZ.init("/dwz/dwz.frag.xml", {
		loginUrl:"/login.html", loginTitle:"登录",	// 弹出登录对话框
//		loginUrl:"login.html",	// 跳到登录页面
		statusCode:{ok:200, error:300, timeout:301}, //【可选】
		pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"orderField", orderDirection:"orderDirection"}, //【可选】
		debug:false,	// 调试模式 【true|false】
		callback:function(){
			initEnv();
			$("#themeList").theme({themeBase:"/dwz/themes"}); // themeBase 相对于index页面的主题base路径
		}
	});
});

</script>
<style type="text/css">
.grid .gridTbody td div {
    display: block;
    height: auto !important;
    line-height: 21px;
    overflow: visible !important;
    white-space: normal !important;
}
a{
	margin:0px 3px !important;
}
span.error{
	position:static;
	display:inline;
}
</style>
</head>

<body scroll="no">
	<div id="layout">
<?php echo $content?>
	</div>
</body>
</html>