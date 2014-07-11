<div class="fsb_title"><p><span class="f1">推书</span><span class="f2">让烂书滚蛋</span></p></div>
<div style="margin-top: 20px;"><img src="/images/line.png" /></div>
<div id="main">
<?php foreach($books as $key => $row):?>
	<div class="fsb">
	    <div class="pic">
	        <a title="<?php echo $row->name?>" target="_blank" href="/book/<?php echo $row->id?>.html">
	            <img src="<?php echo Yii::app()->params['cover_img_url'] . $row->cover_img?>" alt="<?php echo $row->name?>" height="148" width="120">
	        </a>
	    </div>
	    <div class="content">
	        <h3>
	            <a title="<?php echo $row->name?>" target="_blank" class="top-title" href="/book/<?php echo $row->id?>.html"><?php echo $row->name?></a>
	        </h3>
	        <dl>
	            <dt>作者：<?php echo $row->author?></dt>
	        </dl>
	        <p class="desc"><?php echo mb_substr($row->intro, 0, 350, 'utf8')?>……</p>
	    </div>
	</div>
	<?php if(($key+1) % 2 == 0):?>
	<div class="line"><img src="/images/line.png" /></div>
	<?php endif;?>
<?php endforeach;?>
</div>