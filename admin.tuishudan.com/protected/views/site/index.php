<div id="header">
	<div class="headerNav">
		<a class="logo">标志</a>
		<ul class="nav">
			<li><a><?php echo $this->getAdminUserinfo()->username?></a></li>
			<li><a href="/site/login_out">退出</a></li>
		</ul>
	</div>
	<!-- navMenu -->
</div>

<div id="leftside">
	<div id="sidebar_s">
		<div class="collapse">
			<div class="toggleCollapse"><div></div></div>
		</div>
	</div>
	<div id="sidebar">
		<div class="toggleCollapse"><h2>主菜单</h2><div>收缩</div></div>
		<div class="accordion" fillSpace="sidebar">
<?php foreach(Roles::getrole($this->getAdminUserinfo()->role) as $lv1):?>
		<div class="accordionHeader">
			<h2><span>Folder</span><?php echo $lv1['name']?></h2>
		</div>
		<div class="accordionContent">
			<ul class="tree treeFolder">
	<?php foreach ($lv1['submenu'] as $lv2):?>
				<li><a><?php echo $lv2['name'];?></a>
					<ul>
		<?php foreach ($lv2['submenu'] as $lv3):?>
						<li><a href="/<?php echo $lv3['path']?>" target="navTab" title="<?php echo $lv3['name']?>" rel="<?php echo $lv3['rel']?>"><?php echo $lv3['name']?></a></li>
		<?php endforeach;?>
					</ul>
				</li>
	<?php endforeach;?>
			</ul>
		</div>
<?php endforeach;?>
		</div>
	</div>
</div>
<div id="container">
	<div id="navTab" class="tabsPage">
		<div class="tabsPageHeader">
			<div class="tabsPageHeaderContent"><!-- 显示左右控制时添加 class="tabsPageHeaderMargin" -->
				<ul class="navTab-tab">
					<li tabid="main" class="main"><a href="javascript:;"><span><span class="home_icon">我的主页</span></span></a></li>
				</ul>
			</div>
			<div class="tabsLeft">left</div><!-- 禁用只需要添加一个样式 class="tabsLeft tabsLeftDisabled" -->
			<div class="tabsRight">right</div><!-- 禁用只需要添加一个样式 class="tabsRight tabsRightDisabled" -->
			<div class="tabsMore">more</div>
		</div>
		<ul class="tabsMoreList">
			<li><a href="javascript:void(0)">我的主页</a></li>
		</ul>
		<div class="navTab-panel tabsPageContent layoutBox">
			<div class="page unitBox">
			</div>
		</div>
	</div>
</div>