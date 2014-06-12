<div class="pageContent">
  <form method="post" action="<?php echo Yii::app()->request->requestUri?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
    <div class="pageFormContent" layouth="56">
      <input type="hidden" name="is_submit" value="true" />
      <p>
        <label>上级分类：</label>
        <select name="parent_id">
	      <?php if(!$parent_category):?>
		  <option value="0">根分类</option>
		  <?php else:?>
		  <option value="<?php echo $parent_category->id?>"><?php echo $parent_category->name?></option>
		  <?php endif;?>
		</select>
      </p>
      <p>
        <label>分类名称：</label>
        <input type="text" name="name" size="30" class="required textInput" />
      </p>
      <p>
        <label>是否显示编译器：</label>
        <input type="radio" name="text_show_type" class="" value="1" checked="checked" />纯文本
        <input type="radio" name="text_show_type" class="" value="2" />编辑器
      </p>
      <p>
        <label>是否启用生成文件：</label>
        <input type="radio" name="is_create_file" class="" value="1"  />是
        <input type="radio" name="is_create_file" class="" value="2" checked="checked" />否
      </p>
       <p>
        <label>文件目录：</label>
        <input type="text" name="file_dir" size="30" class="textInput" />
      </p>
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
