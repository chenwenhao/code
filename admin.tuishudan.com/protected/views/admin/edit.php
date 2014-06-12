<div class="pageContent">
  <form method="post" action="<?php echo Yii::app()->request->requestUri?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
    <div layouth="58" class="pageFormContent" style="height: 203px; overflow: auto;">
      <div class="unit">
        <label>权限选择：</label>
        <select name="role">
          <?php foreach($this->access_group as $key => $g):?>
          <option value="<?php echo $key?>"<?php if($key == $row->role):?> selected="selected"<?php endif;?>><?php echo $g?></option>
          <?php endforeach;?>
        </select>
      </div>
      <div class="unit">
        <label>用户名：</label>
        <input type="text" name="username" size="25" class="textInput required" value="<?php echo $row->username?>" />
      </div>
      <div class="unit">
        <label>密码：</label>
        <input type="text" name="password" size="25" class="textInput" />
        <span style="color:red; line-height:20px;"> *留空表示不修改</span>
      </div>
    </div>
    <div class="formBar">
      <ul>
        <li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
      </ul>
    </div>
  </form>
</div>