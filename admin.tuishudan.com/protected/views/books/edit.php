<div class="pageContent">
  <form method="post" action="<?php echo Yii::app()->request->requestUri?>" enctype="multipart/form-data" class="pageForm required-validate" onsubmit="return iframeCallback(this, dialogAjaxDone);">
    <div class="pageFormContent" layouth="56">
      <input type="hidden" name="is_submit" value="true" />
      <div class="unit">
        <label>书名：</label>
        <input type="text" name="name" size="30" class="required textInput" value="<?php echo $row->name?>" />
      </div>
      <div class="unit">
        <label>作者：</label>
        <input type="text" name="author" size="30" class="required textInput" value="<?php echo $row->author?>" />
      </div>
      <div class="unit">
        <label>封面图：</label>
        <input type="file" name="cover_img" />
      </div>
      <div class="unit">
        <label>来源：</label>
        <input type="text" name="from" value="<?php echo $row->from?>" />
      </div>
      <div class="unit">
        <label>标签：</label>
        <input type="text" name="tag" value="<?php echo $row->tag?>" />
      </div>
      <div class="unit">
        <label>状态：</label>
        <input type="radio" name="status" value="0" <?php if($row->status == 0) echo 'checked="checked"';?> />连载
        <input type="radio" name="status" value="1" <?php if($row->status == 1) echo 'checked="checked"';?> />完结
      </div>
      <div class="unit">
        <label>标记为已审核：</label>
        <input type="checkbox" name="checked" value="1" <?php if($row->checked) echo 'checked="checked"';?> />
      </div>
      <div class="unit">
        <label>内容简介：</label>
        <textarea name="intro" cols="50" rows="10"><?php echo $row->intro?></textarea>
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