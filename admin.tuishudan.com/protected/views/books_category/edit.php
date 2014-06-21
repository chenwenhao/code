<div class="pageContent">
  <form method="post" action="<?php echo Yii::app()->request->requestUri?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
    <input type="hidden" name="is_submit" value="true" />
    <div layouth="58" class="pageFormContent" style="height: 203px; overflow: auto;">
      <div class="unit">
        <label>标题：</label>
        <input type="text" name="title" size="25" class="textInput required" value="<?php echo $row->title?>" />
      </div>
    </div>
    <div class="formBar">
      <ul>
        <li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
      </ul>
    </div>
  </form>
</div>