<div class="pageContent">
  <form method="post" action="<?php echo Yii::app()->request->requestUri?>" enctype="multipart/form-data" class="pageForm required-validate" onsubmit="return iframeCallback(this, dialogAjaxDone);">
    <div class="pageFormContent" layouth="56">
      <input type="hidden" name="submit" value="true" />
      <div class="unit">
        <label>分类名称：</label>
        <?php echo $category->name?>
      </div>
      <div class="unit">
        <label>标题：</label>
        <input type="text" name="title" size="30" class="required textInput" />
      </div>
      <div class="unit">
        <label>排序ID：</label>
        <input type="text" name="order_id" size="4" class="textInput" />
      </div>
      <div class="unit">
        <label>内容：</label>
        <?php if($category->text_show_type == 2):?>
        <textarea name="content" id="xheditor"></textarea>
        <?php else:?>
        <textarea name="content" cols="100" rows="20"></textarea>
        <?php endif;?>
      </div>
      <div class="unit">
        <label>文件名：</label>
        <input type="text" name="file_name" size="30" class="textInput" />
      </div>
      <div class="unit">
        <label>图片：</label>
        <input type="file" name="photo" />
      </div>
      <div class="unit">
        <label>链接：</label>
        <input type="text" name="link" size="60" class="textInput" />
      </div>
      <?php if($fields):?>
      <?php foreach($fields as $f):?>
      <?php if($f->field_type == 'textarea'):?>
      <label><?php echo $f->name?>：</label>
      <textarea name="<?php echo $f->field_name?>" rows="5" cols="50"></textarea>
    <?php else:?>
      <div class="unit">
        <label><?php echo $f->name?>：</label>
        <input type="<?php echo $f->field_type?>" name="<?php echo $f->field_name?>" class="textInput" value="<?php if($f->default_value)echo $f->default_value?>" />
      </div>
    <?php endif;?>
    <?php endforeach?>
    <?php endif;?>
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
<script type="text/javascript">
$('#xheditor').xheditor({tools:'mfull', upImgUrl:"/content/upload",upImgExt:"jpg,jpeg,gif,png",width:800,height:400});
</script>