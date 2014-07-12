<?php
/**
 * 搜索
 * @author xiaoling
 */
class SearchController extends MyController
{
	public function actionIndex()
	{
		// 参数
		$search_name = trim(Yii::app()->request->getParam('search'));

		// 查询书
		$cdb = new CDbCriteria();
		if($search_name)
		{
			$cdb->addCondition("name like :name");
			$cdb->params = array(":name" => "%{$search_name}%");
		}
		$rows = Books::model()->findAll($cdb);

		// 显示
		$data = array('rows' => $rows, 'search_name' => $search_name);
		$this->css = 'mybook';
		$this->render('index', $data);
	}
}