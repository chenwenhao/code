<div class="pageContent">
  <form method="post" action="<?php echo Yii::app()->request->requestUri?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
    <div class="pageFormContent" layouth="56">
      <input type="hidden" name="is_submit" value="true" />
      <p>
        <label>分类名：</label>
        <?php echo $category->name?>
      </p>
      <p>
        <label>名称：</label>
        <input type="text" name="name" size="30" class="required textInput" />
      </p>
      <p>
        <label>默认值：</label>
        <input type="text" name="default_value" size="30" class="textInput" />
      </p>
      <p>
        <label>字段名：</label>
        <input type="text" name="field_name" size="30" class="textInput required" />
      </p>
      <p>
        <label>字段类型：</label>
        <select name="field_type">
<?php foreach ($this->fields as $key => $value) {
  echo '<option value="' . $value . '">' . $key . '</option>';
}?>
        </select>
      </p>
      <p>
        <label>描述：</label>
        <input type="text" name="desc" size="30" class="textInput" />
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
