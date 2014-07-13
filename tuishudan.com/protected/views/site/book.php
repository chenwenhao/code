<div id="left">
	<p class="title"><?php echo $book->name?></p>
	<hr>
	<div class="top">
		<div class="pic"><img src="<?php echo Yii::app()->params['cover_img_url'] . $book->cover_img?>" title="<?php echo $book->name?>" width="120" height="150"></div>
		<div class="content">
			<dl>
				<dt>作者：<?php echo $book->author?></dt>
				<dt>标签：
				<?php
				if ($book->tag) {
					$tag_arr = explode(',', $book->tag);
					foreach ($tag_arr as $key => $value) {
						echo '<span>'. $value .'</span> ';
					}
				}
				?>
				</dt>
				<!-- <dt>主角：</dt> -->
				<dt>来自：起点</dt>	
				<dt><?php echo Yii::app()->params['book_status'][$book->status]?> <!-- (2007) --></dt>
			</dl>
		</div>
		<div class="pj">
			<p><span class="vote-star"><i style="width:75%"></i></span><strong>8.8</strong></p>
			<p><span class="pj_num">（<?php echo $book->comment_times?>人评论）</span></p>
			<p><span class="vote-star"><i style="width:50%"></i></span><span class="jdt" style="width:34px;"></span><span class="percent">89%</span></p>
			<p><span class="vote-star"><i style="width:75%"></i></span><span class="jdt" style="width:34px;"></span><span class="percent">89%</span></p>
			<p><span class="vote-star"><i style="width:75%"></i></span><span class="jdt" style="width:34px;"></span><span class="percent">89%</span></p>
		</div>
	</div>
	<div class="mid">
		<?php if($user_book_info->status == 1):?>
		<img src="/images/xkan.png" />
		<?php elseif ($user_book_info->status == 2):?>
			<img src="/images/kanguo.png">
		<?php else: ?>
			<img src="/images/xkan.png" />&nbsp;&nbsp;&nbsp;<img src="/images/kanguo.png">
		<?php endif;?>
	</div>
	<div class="pj2">评价:
		<span class="pingxing" id="px1" <?php if($user_book_info->sorce >= 1):?>style="width:100%"<?php endif;?> sorce="1"><i></i></span>
		<span class="pingxing" id="px2" <?php if($user_book_info->sorce >= 2):?>style="width:100%"<?php endif;?> sorce="2"><i></i></span>
		<span class="pingxing" id="px3" <?php if($user_book_info->sorce >= 3):?>style="width:100%"<?php endif;?> sorce="3"><i></i></span>
		<span class="pingxing" id="px4" <?php if($user_book_info->sorce >= 4):?>style="width:100%"<?php endif;?> sorce="4"><i></i></span>
		<span class="pingxing" id="px5" <?php if($user_book_info->sorce >= 5):?>style="width:100%"<?php endif;?>sorce="5"><i></i></span>
	</div>
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
<?php if (!empty($user_book_info->status)):?>
<script>
var book_id = <?php echo $book->id?>;
$(function () {
	$("#px1,#px2,#px3,#px4,#px5").bind("mouseover",function(){
	  $(this).find("i").attr("style","width:100%");
	  $(this).prevAll().find("i").attr("style","width:100%");
	});
	$("#px1,#px2,#px3,#px4,#px5").bind("mouseout",function(){
	  $(this).find("i").attr("style","width:0%");
	  $(this).prevAll().find("i").attr("style","width:0%");
	});
	$("#px1,#px2,#px3,#px4,#px5").bind("click",function(){
	  $(this).find("i").attr("style","width:100%");
	  var sorce = $(this).attr('value');
	  $.post("/book/sorce",{sorce:sorce,book_id:book_id},
	  function(data){
	    alert("Data: " + data);
	  });
	});
});
</script>
<?php endif;?>