<style type="text/css">
#hang0:hover {
	background:#ddd;
}
#hang0:hover #fspan {
	color:#fff;
	font-weight:bold;
}
#fspan {
	padding-left:5px;
	color:#ddd;
}
</style>

<div class="pageHeader">
  <div class="searchBar">
    <table>
      <tr>
        <td>
          <div class="buttonActive">
            <div class="buttonContent">
              <a href="/content_category/add/" target="dialog">
                <button type="button">添加一级分类</button>
              </a>
            </div>
          </div>
        </td>
      </tr>
    </table>
  </div>
</div>
<table class="table"  width="100%" layouth="65">
  <thead>
    <tr>
      <th>分类名称</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><table width="100%">
          <?php echo $html?>
        </table></td>
    </tr>
  </tbody>
</table>