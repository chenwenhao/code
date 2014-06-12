<div class="pageContent">
  <form method="post" action="<?php echo Yii::app()->request->requestUri?>" enctype="multipart/form-data" class="pageForm required-validate" onsubmit="return iframeCallback(this, dialogAjaxDone);">
    <div class="pageFormContent" layouth="56">
      <input type="hidden" name="submit" value="true" />
      <div class="unit">
        <label>分类名称：</label>
        <?php echo $row->category->name?>
      </div>
      <div class="unit">
        <label>标题：</label>
        <input type="text" name="title" size="30" class="required textInput" value="<?php echo $row->title?>" />
      </div>
      <div class="unit">
        <label>排序ID：</label>
        <input type="text" name="order_id" size="4" class="textInput" value="<?php echo $row->order_id?>" />
      </div>
      <div class="unit">
        <label>内容：</label>
        <?php if($row->category->text_show_type == 2):?>
        <textarea name="content" id="xheditor"><?php echo $row->content?></textarea>
        <?php else:?>
        <textarea name="content" cols="100" rows="20"><?php echo $row->content?></textarea>
        <?php endif;?>
      </div>
      <div class="unit">
        <label>文件名：</label>
        <input type="text" name="file_name" size="30" class="textInput" value="<?php echo $row->file_name?>" />
      </div>
      <div class="unit">
        <label>图片：</label>
        <input type="file" name="photo" />
      </div>
      <div class="unit">
        <label>原图：</label>
        <?php if($row->photo)
        {
          echo '<img src="' . $row->photo . '" width="100" height="50" />';
        }?>
      </div>
      <div class="unit">
        <label>链接：</label>
        <input type="text" name="link" size="60" class="textInput" value="<?php echo $row->link?>" />
      </div>
      <?php if($fields):?>
      <?php foreach($fields as $f):?>
      <?php if($f->field_type == 'textarea'):?>
      <div class="unit">
      <label><?php echo $f->name?>：</label>
      <textarea name="<?php echo $f->field_name?>" rows="5" cols="50"><?php echo $ext_arr[$f->field_name]?></textarea></div>
    <?php else:?>
      <div class="unit">
        <label><?php echo $f->name?>：</label>
        <input type="<?php echo $f->field_type?>" name="<?php echo $f->field_name?>" class="textInput" value="<?php if(isset($ext_arr[$f->field_name])){echo $ext_arr[$f->field_name];}else{if($f->default_value)echo $f->default_value;}?>" />
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
