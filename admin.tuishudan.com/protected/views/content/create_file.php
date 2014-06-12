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
        <?php echo $row->title?>
      </div>
      <div class="unit">
        <label>文件名：</label>
        <input type="text" name="file_name" />
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
<script type="text/javascript">
$('#elm').xheditor({tools:'mfull', upImgUrl:"/article/upload",upImgExt:"jpg,jpeg,gif,png", nternalStyle:false,width:800,height:400});
</script>
