<form id="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>">
  <input type="hidden" name="pageNum" value="<?php echo $pages->currentPage + 1?>"/>
  <input type="hidden" name="tag_name" value="<?php echo $tag_name?>" />
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
                <td>标签名：
                  <input type="text" name="tag_name" class="textInput" value="<?php echo $tag_name?>">
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
          <a target="dialog" href="/tags/add" class="add" height="500">
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
          <th>标签名</th>
          <th>书本数量</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($rows as $row):?>
        <tr target="id" rel="<?php echo $row->id?>">
          <td><?php echo $row->id?></td>
          <td><?php echo $row->tag_name?></td>
          <td><?php echo $row->num?></td>
          <td>
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