<div class="pageContent">
  <form method="post" action="<?php echo Yii::app()->request->requestUri?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
    <div layouth="58" class="pageFormContent" style="height: 203px; overflow: auto;">
      <div class="unit">
        <label>权限选择：</label>
        <select name="role">
          <?php foreach($this->access_group as $key => $row):?>
          <option value="<?php echo $key?>"><?php echo $row?></option>
          <?php endforeach;?>
        </select>
      </div>
      <div class="unit">
        <label>用户名：</label>
        <input type="text" name="username" size="25" class="textInput required" />
      </div>
      <div class="unit">
        <label>密码：</label>
        <input type="text" name="password" size="25" class="textInput required" />
      </div>
    </div>
    <div class="formBar">
      <ul>
        <li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
      </ul>
    </div>
  </form>
</div>