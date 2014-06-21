<form id="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>">
  <input type="hidden" name="pageNum" value="<?php echo $pages->currentPage + 1?>"/>
</form>
<div class="page">
  <div class="pageContent">
    <!-- action start -->
    <div class="panelBar">
      <ul class="toolBar">
		<li>
			<a target="dialog" href="/books_category/add" class="add">
			<span>添加</span>
			</a>
		</li>
      </ul>
    </div>
    <!-- action end -->
    <table width="100%" layouth="75" class="table">
      <thead>
        <tr>
		<th>ID</th>
		<th>名称</th>
    <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($rows as $row):?>
        <tr target="id" rel="<?php echo $row->id?>">
	        <td><?php echo $row->id?></td>
	        <td><?php echo $row->title?></td>
          <td><a href="/books_category/edit?id=<?php echo $row->id?>" target="dialog">修改</a> 、<a href="/books_category/del?id=<?php echo $row->id?>" target="ajaxTodo" title="确定删除吗？">删除</a></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
    <!-- fenye start -->
    <?php if(isset($pages)):?>
    <div class="panelBar">
    <div class="pages">
    <span>共<?php echo $pages->itemCount?>条</span>
    </div>
    <div class="pagination" targetType="navTab" totalCount="<?php echo $pages->itemCount?>" numPerPage="<?php echo $pages->pageSize?>" pageNumShown="10" currentPage="<?php echo $pages->currentPage + 1?>"></div>
    </div>
    <?php endif;?>
    <!-- fenye end -->
  </div>
</div>
