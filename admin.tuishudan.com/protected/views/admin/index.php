<form id="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>">
  <input type="hidden" name="pageNum" value="<?php echo $pages->currentPage + 1?>"/>
</form>
<div class="page">
  <div class="pageContent">
    <!-- action start -->
    <div class="panelBar">
      <ul class="toolBar">
		<li>
			<a target="dialog" href="/admin/add" class="add">
			<span>添加</span>
			</a>
		</li>
		<li>
			<a target="dialog" href="/admin/edit?id={id}" class="edit">
			<span>修改</span>
			</a>
		</li>
		<li>
			<a target="ajaxTodo" href="/admin/del?id={id}" class="delete" title="确定删除吗？">
			<span>删除</span>
			</a>
		</li>
      </ul>
    </div>
    <!-- action end -->
    <table width="100%" layouth="75" class="table">
      <thead>
        <tr>
		<th>ID</th>
		<th>用户名</th>
          <th>权限组</th>
          <th>最后登录IP</th>
          <th>最后登录时间</th>
          <th>登录次数</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($rows as $row):?>
        <tr target="id" rel="<?php echo $row->id?>">
	        <td><?php echo $row->id?></td>
	        <td><?php echo $row->username?></td>
              <td><?php echo $this->access_group[$row->role]?></td>
              <td><?php echo $row->login_ip?></td>
              <td><?php echo $row->login_time?></td>
              <td><?php echo $row->login_times?></td>
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
