<form id="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>">
  <input type="hidden" name="pageNum" value="<?php echo $pages->currentPage + 1?>"/>
  <input type="hidden" name="category_id" value="<?php echo $category_id?>"/>
  <input type="hidden" name="name" value="<?php echo $name?>"/>
  <input type="hidden" name="author" value="<?php echo $author?>"/>
</form>
<div class="page">
  <div class="pageContent">
    <!-- search start -->
    <div class="pageHeader">
      <form method="post" action="<?php echo Yii::app()->request->requestUri?>" onsubmit="return navTabSearch(this);">
        <div class="searchBar">
          <table class="searchContent">
            <tbody>
              <tr>
                <td>书名：
                  <input type="text" name="name" class="textInput" value="<?php echo $name?>">
                </td>
                <td>作者：
                  <input type="text" name="author" class="textInput" value="<?php echo $author?>">
                </td>
                <td><div class="subBar">
                    <ul>
                      <li>
                        <div class="buttonActive">
                          <div class="buttonContent">
                            <button type="submit">检索</button>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div></td>
              </tr>
            </tbody>
          </table>
        </div>
      </form>
    </div>
    <!-- search end -->
    <!-- action start -->
    <div class="panelBar">
      <ul class="toolBar">
        <li>
          <a target="dialog" href="/books/add" class="add" height="500">
            <span>添加</span>
          </a>
        </li>
      </ul>
    </div>
    <!-- action end -->
    <table width="100%" layouth="110" class="table">
      <thead>
        <tr>
          <th width="50">ID</th>
          <th>书名</th>
          <th>作者</th>
          <th>封面图</th>
          <th>来源</th>
          <th>状态</th>
          <th>标签</th>
          <th>评论数</th>
          <th>是否审核</th>
          <th>添加时间</th>
          <th>添加人</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($rows as $row):?>
        <tr target="id" rel="<?php echo $row->id?>">
          <td><?php echo $row->id?></td>
          <td><a width="500" target="dialog" href="/books/edit?id=<?php echo $row->id?>" name="<?php echo strip_tags($row->name);?>"><?php echo $row->name?></a></td>
          <td><?php echo $row->author?></td>
          <td>
            <?php
            if($row->cover_img)
            {
              echo '<a href="'. Yii::app()->params['cover_img_url'] . $row->cover_img .'" target="_blank"><img src="'. Yii::app()->params['cover_img_url'] . $row->cover_img .'" width="100" height="50" /></a>';
            }
            ?>
          </td>
          <td><?php echo $row->from?></td>
          <td><?php echo $row->status?></td>
          <td><?php echo $row->tag?></td>
          <td><?php echo $row->comment_times?></td>
          <td><?php if($row->checked){echo '是';}else{echo '<span style="color:red;">否</span>';}?></td>
          <td><?php echo $row->create_time?></td>
          <td><?php echo $row->uid?></td>
          <td>
            <a target="dialog" href="/books/edit?id=<?php echo $row->id?>" width="500">修改</a>
            <a target="ajaxToDo" href="/books/delete?id=<?php echo $row->id?>" name="确定删除吗？">删除</a>
          </td>
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