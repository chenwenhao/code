<div class="page">
  <div class="pageContent">
    <table width="100%" layouth="140" class="table">
      <thead>
        <tr>
          <th width="50">ID</th>
          <th>名称</th>
          <th>字段名</th>
          <th>字段类型</th>
          <th>默认值</th>
          <th>描述</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($rows as $row):?>
        <tr target="id" rel="<?php echo $row->id?>">
          <td><?php echo $row->id?></td>
          <td><?php echo $row->name?></td>
          <td><?php echo $row->field_name?></td>
          <td><?php echo $row->field_type?></td>
          <td><?php echo $row->default_value?></td>
          <td><?php echo $row->desc?></td>
          <td><a href="/content_category/ext_field_edit?id=<?php echo $row->id?>&category_id=<?php echo $category_id?>" target="dialog">修改</a>
            <a href="/content_category/ext_field_delete?id=<?php echo $row->id?>&category_id=<?php echo $category_id?>" target="ajaxToDo" title="确定删除吗？">删除</a></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>