<form id="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>">
  <input type="hidden" name="pageNum" value="<?php echo $pages->currentPage + 1?>"/>
  <input type="hidden" name="category_id" value="<?php echo $category_id?>"/>
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
                <td>标题：
                  <input type="text" name="title" class="textInput" value="<?php echo $title?>"></td>
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
          <a target="navTab" href="/content/add?category_id=<?php echo $category_id?>" class="add">
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
          <th>标题</th>
          <th>所属分类</th>
          <th>排序ID</th>
          <th>图片</th>
          <th>链接</th>
          <th>提交时间</th>
          <th>扩展信息</th>
          <th>文件目录</th>
          <th>文件名</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($rows as $row):?>
        <tr target="id" rel="<?php echo $row->id?>">
          <td><?php echo $row->id?></td>
          <td><a target="navTab" href="/content/edit?id=<?php echo $row->id?>&category_id=<?php echo $category_id?>" title="<?php echo strip_tags($row->content);?>"><?php echo $row->title?></a></td>
          <td><?php echo $row->category->name?></td>
          <td><?php echo $row->order_id?></td>
          <td>
            <?php if($row->photo)
            {
              echo '<img src="' .$row->photo. '" width="100" height="50" />';
            }?>
          </td>
          <td><?php echo $row->link?></td>
          <td><?php echo $row->submit_time?></td>
          <td>
            <?php 
            $ext = MyContentCategory::getContent_ext($row->id);
            if($ext)
            {
              foreach($ext as $e)
              {
                echo $e->ext_name . '：' . $e->ext_value . ' | ';
              }
            }
            ?>
          </td>
          <td><?php if(isset($row->category->file_dir))echo $row->category->file_dir?></td>
          <td><?php echo $row->file_name?></td>
          <td>
            <a target="navTab" href="/content/edit?id=<?php echo $row->id?>&category_id=<?php echo $category_id?>">修改</a>
            <a target="ajaxToDo" href="/content/delete?id=<?php echo $row->id?>" title="确定删除吗？">删除</a>
            <?php if(isset($row->category->is_create_file) && $row->category->is_create_file):?>
            <?php if(file_exists(ROOT.$row->category->file_dir.$row->file_name) && $row->file_name):?>
            <a target="ajaxToDo" href="/content/create_file?id=<?php echo $row->id?>" title="确定重新生成文件吗？"><span style="line-height:22px;color:green;">已生成</span></a>
            <?php else:?>
            <a target="ajaxToDo" href="/content/create_file?id=<?php echo $row->id?>" title="确定生成文件吗？">生成文件</a>
            <?php endif;?>
            <?php endif;?>
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