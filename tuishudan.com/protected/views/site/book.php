<div id="left">
	<p class="title"><?php echo $book->name?></p>
	<hr>
	<div class="top">
		<div class="pic"><img src="<?php echo Yii::app()->params['cover_img_url'] . $book->cover_img?>"></div>
		<div class="content">
			<dl>
				<dt>作者：<?php echo $book->author?></dt>
				<dt>标签：
				<?php
				$tag_arr = explode(',', $book->tag);
				foreach ($tag_arr as $key => $value) {
					echo '<span>'. $value .'</span> ';
				}
				?>
				</dt>
				<dt>主角：张无</dt>
				<dt>来自：起点</dt>	
				<dt>已完本 (2007)</dt>
			</dl>
		</div>
		<div class="pj">
			<p><span class="vote-star"><i style="width:75%"></i></span><strong>8.8</strong></p>
			<p><span class="pj_num">（120001人评论）</span></p>
			<p><span class="vote-star"><i style="width:50%"></i></span><span class="jdt" style="width:34px;"></span><span class="percent">89%</span></p>
			<p><span class="vote-star"><i style="width:75%"></i></span></p>
			<p><span class="vote-star"><i style="width:75%"></i></span></p>
		</div>
	</div>
	<div class="mid"><img src="/images/xkan.png" />&nbsp;&nbsp;&nbsp;<img src="/images/kanguo.png"></div>
	<div class="pj2">评价</div>
	<div class="main_title"><?php echo $book->name?></div>
	<div class="book_intro"><?php echo $book->intro?></div>
</div>
<div id="right">
	<dl>
		<dt>推书单评星</dt>
		<dd>5星，还要再读一遍，能封神</dd>
		<dd>4分，多一点点情怀就好了</dd>
		<dd>3分，打发时间</dd>
		<dd>2分，扑街这本，换马甲再来</dd>
		<dd>1分，呵呵</dd>
	</dl>
</div>