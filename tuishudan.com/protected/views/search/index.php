<div class="fsb_title"><p><span class="f1">"<?php echo $search_name?>"相关的书</span></p></div>
<div style="margin-top: 20px;"><img src="/images/line.png" /></div>
<div id="main">
<?php foreach($rows as $row):?>
	<div class="list">
	    <div class="pic">
	        <a title="<?php echo $row->name?>" href="/book/<?php echo $row->id?>.html">
	            <img src="<?php echo Yii::app()->params['cover_img_url'] . $row->cover_img?>" alt="<?php echo $row->name?>" height="150" width="120">
	        </a>
	    </div>
	    <div class="content">
	        <h3>
	            <a title="<?php echo $row->name?>" class="top-title" href="/book/<?php echo $row->id?>.html"><?php echo $row->name?></a>
	        </h3>
	        <p>作者：<?php echo $row->author?></p>
	        <p><span class="vote-star"><i style="width:50%"></i></span></p>
	    </div>
	</div>
<?php endforeach;?>
</div>