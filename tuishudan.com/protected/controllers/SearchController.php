<?php
/**
 * 搜索
 * @author xiaoling
 */
class SearchController extends MyController
{
	public function actionIndex()
	{
		$search_name = trim(Yii::app()->request->getParam('search'));

		Books::model()->findAll("username=:name",array(":name"=>$username));    


		$search_name = Yii::app()->request->getParam('search');
		// 查询书
		$books = Books::model()->findAll();

		$data = array('books' => $books);
		$this->css = 'index';
		$this->render('index', $data);


		$dataProvider=new CActiveDataProvider('Post', array(
		    'criteria'=>array(
		        'condition'=>'status=1',
		        'order'=>'create_time DESC',
		        'with'=>array('author'),
		    ),
		    'pagination'=>array(
		        'pageSize'=>20,
		    ),
		));
	}
}