<div id="left">
	<p class="title"><?php echo $book->name?></p>
	<hr>
	<div class="top">
		<div class="pic"><img src="<?php echo Yii::app()->params['cover_img_url'] . $book->cover_img?>" title="<?php echo $book->name?>" width="120" height="150"></div>
		<div class="content">
			<dl>
				<dd>作者：<?php echo $book->author?></dd>
				<dd>标签：<div>
				<?php
				if ($book->tag) {
					$tag_arr = explode(',', $book->tag);
					foreach ($tag_arr as $key => $value) {
						echo '<span>'. $value .'</span> ';
					}
				}
				?></div>
				</dd>
				<!-- <dd>主角：</dd> -->
				<dd>来自：起点</dd>	
				<dd><?php echo Yii::app()->params['book_status'][$book->status]?> <!-- (2007) --></dd>
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

	<?php if(isset($user_book_info->status) && $user_book_info->status == 2):?>
	<div id="my_book_info" style="clear:both;margin-top:30px;height:20px;width:200px;" class="mid">我在看这本书<a href="###" onclick="edit_user_book('my_user_book','edit_user_book')" style="padding-left:10px;color:#25539e;">修改</a> <a href="###" style="padding-left:10px;color:#999999;"  onclick="del_userbook()">删除</a></div>
	<?php elseif (isset($user_book_info->status) && $user_book_info->status == 1):?>
	<div id="my_book_info">
	<div style="clear:both;margin-top:30px;height:20px;width:200px;" class="mid">我看过这本书<a href="###" onclick="edit_user_book('my_user_book','edit_user_book')" style="padding-left:10px;color:#25539e;">修改</a> <a href="###" style="padding-left:10px;color:#999999;"  onclick="del_userbook()">删除</a></div>
	<div style="float:left;clear:both;">我的评价:
		<span class="pingxing"><i <?php if(isset($user_book_info->score) && $user_book_info->score >= 1):?>style="width:100%"<?php endif;?> ></i></span>
		<span class="pingxing"><i <?php if(isset($user_book_info->score) && $user_book_info->score >= 2):?>style="width:100%"<?php endif;?> ></i></span>
		<span class="pingxing"><i <?php if(isset($user_book_info->score) && $user_book_info->score >= 3):?>style="width:100%"<?php endif;?> ></i></span>
		<span class="pingxing"><i <?php if(isset($user_book_info->score) && $user_book_info->score >= 4):?>style="width:100%"<?php endif;?> ></i></span>
		<span class="pingxing"><i <?php if(isset($user_book_info->score) && $user_book_info->score >= 5):?>style="width:100%"<?php endif;?> ></i></span>
	</div>
	</div>
	<?php else: ?>

    <?php endif;?>
    <div id="edit_book_info" <?php if(isset($user_book_info->status)):?>style="display:none;"<?php endif;?>>
	<div class="mid" >
		<a href="###" id="reading_book" ><img src="/images/zkan.png"/></a><a href="###" style="padding-left:15px;"><img src="/images/kanguo.png"></a>
	</div>
	<div class="pj2">评价:
		<span class="pingxing" id="px1" score="1"><i></i></span>
		<span class="pingxing" id="px2" score="2"><i></i></span>
		<span class="pingxing" id="px3" score="3"><i></i></span>
		<span class="pingxing" id="px4" score="4"><i></i></span>
		<span class="pingxing" id="px5" score="5"><i></i></span>
	</div>
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

<script>
var book_id = <?php echo $book->id;?>;
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
	  var score = $(this).attr('score');
	  $.getJSON("/book/score",{score:score,book_id:book_id},
	  function(data){
	  	alert(data.msg);
	  	window.location.reload();
	  });
	});
	$("#reading_book").bind("click",function(){
	  $.getJSON("/book/score",{score:0,book_id:book_id},
	  function(data){
	  	alert(data.msg);
	  	window.location.reload();
	  });
	});
});
function del_userbook() {
	$.getJSON("/book/del_score",{book_id:book_id},
  	function(data){
  		alert(data.msg);
  		window.location.reload();
  	});
}
function id_hide_show(id1,id2) {
	if ($("#"+id1).is(":hidden")) {
		$("#"+id1).show();
		$("#"+id2).hide();
	}
	if ($("#"+id2).is(":hidden")) {
		$("#"+id2).show();
		$("#"+id1).hide();
	}
}
function edit_user_book() {
	if ($("#my_book_info").is(":hidden")) {
		$("#my_book_info").show();
		$("#edit_book_info").hide();
	}
	if ($("#edit_book_info").is(":hidden")) {
		$("#edit_book_info").show();
		$("#my_book_info").hide();
	}
}
</script>
