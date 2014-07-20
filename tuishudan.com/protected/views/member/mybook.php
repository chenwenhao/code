<div class="fsb_title"><p><span class="f1">我看过的书</span><span class="f2">这是我们失去的青春呐</span></p></div>
<div style="margin-top: 20px;"><img src="/images/line.png" /></div>
<div class="book"><a href="/member/mybook?like=yes"<?php if($like == 'yes'){echo ' style="color:#999;text-decoration:none;"';}?>>我喜欢的书</a> / 
<a href="/member/mybook?like=no"<?php if($like == 'no'){echo ' style="color:#999;text-decoration:none;"';}?>>烂书</a></div>
<div id="main">
<?php foreach($rows as $row):?>
	<div class="list">
	    <div class="pic">
	        <a title="<?php echo $row->book->name?>" target="_blank" href="/book/<?php echo $row->book_id?>.html">
	            <img src="<?php echo Yii::app()->params['cover_img_url'] . $row->book->cover_img?>" alt="<?php echo $row->book->name?>" height="150" width="120">
	        </a>
	    </div>
	    <div class="content">
	        <h3>
	            <a title="<?php echo $row->book->name?>" target="_blank" class="top-title" href="/book/<?php echo $row->book_id?>.html"><?php echo $row->book->name?></a>
	        </h3>
	        <p>作者：跳舞</p>
	        <p><span class="vote-star"><i style="width:<?php echo $row->score * 20?>%"></i></span></p>
	        <p><a href="/book/<?php echo $row->book_id?>.html" target="_blank" style="text-decoration: none; color:#25539e;">修改评分</a> <!-- <span>↑</span> <span>↓</span> --></p>
	    </div>
	</div>
<?php endforeach;?>
<?php if($count > 2):?>
<div id="clear_both"></div>
<div id="list_pagecut">
<?php echo $this->widget('CLinkPager', array('pages'=>$pages, 'prevPageLabel'=>'上一页', 'nextPageLabel'=> '下一页', 'header'=>'', 'firstPageLabel'=>'首页', 'lastPageLabel'=>'末页', 'htmlOptions' => array('class' => 'wp-pagenavi')), TRUE)?>
</div>
<?php endif;?>
</div>