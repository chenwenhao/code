<div class="pageContent">
  <form method="post" action="<?php echo Yii::app()->request->requestUri?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
    <div class="pageFormContent" layouth="56">
      <input type="hidden" name="is_submit" value="true" />
      <p>
        <label>上级分类：</label>
        <select name="parent_id">
          <option value="0">根分类</option>
          <?php foreach (MyContentCategory::getTopCategory() as $c):?>
          <?php if($c->id == $category->id)continue?>
          <option value="<?php echo $c->id?>" <?php if($c->id == $category->id):?>selected<?php endif;?>><?php echo $c->name?></option>
          <?php if($c->childs):?>
          <?php foreach ($c->childs as $key => $cc):?>
          <?php if($cc->id == $category->id)continue?>
          <option value="<?php echo $cc->id?>" <?php if($category->parent_id == $cc->id):?>selected<?php endif;?> <?php if($cc->id == $category->id):?>selected<?php endif;?>><?php echo "&nbsp;&nbsp;",$cc->name?></option>
          <?php endforeach;?>
          <?php endif;?>
          <?php endforeach;?>
        </select>
      </p>
      <p>
        <label>分类名称：</label>
        <input type="text" name="name" size="30" class="required textInput" value="<?php echo $category->name?>" />
      </p>
      <div class="unit">
        <label>文本域显示方式：</label>
        <input type="radio" name="text_show_type" class="" value="1" <?php if($category->text_show_type == 1)echo ' checked="checked"';?> />纯文本
        <input type="radio" name="text_show_type" class="" value="2" <?php if($category->text_show_type == 2)echo ' checked="checked"';?> />编辑器
      </div>
      <div class="unit">
        <label>是否启用生成文件：</label>
        <input type="radio" name="is_create_file" class="" value="1" <?php if($category->is_create_file)echo ' checked="checked"';?> />是
        <input type="radio" name="is_create_file" class="" value="0" <?php if(!$category->is_create_file)echo ' checked="checked"';?> />否
      </div>
      <div class="unit">
        <label>文件目录：</label>
        <input type="text" name="file_dir" size="60" class="textInput" value="<?php echo $category->file_dir?>" />
      </div>
    </div>
    <div class="formBar">
      <ul>
        <li>
          <div class="buttonActive">
            <div class="buttonContent">
              <button type="submit">保存</button>
            </div>
          </div>
        </li>
        <li>
          <div class="button">
            <div class="buttonContent">
              <button type="button" class="close">取消</button>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </form>
</div>
