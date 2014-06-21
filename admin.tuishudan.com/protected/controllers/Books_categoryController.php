<?php
/**
 * 书本分类 控制器
 */

class Books_categoryController extends Controller
{
	public function init()
	{
		parent::init();
	}

	/**
	 * 列表
	 */
	public function actionIndex()
	{
		// 参数
		$page = intval(Yii::app()->request->getParam('pageNum')) - 1;
		// 查库
		$cdb = new CDbCriteria;
	
		// 分页
		$count = Books_category::model()->count($cdb);
		$pages = new CPagination($count);
		$pages->pageSize = 50;
		$pages->currentPage = $page;
		$pages->applyLimit($cdb);
		$rows = Books_category::model()->findAll($cdb);
	
		// 显示
		$data = array('rows' => $rows, 'pages' => $pages);
		$this->renderPartial('index', $data);
	}
	
	/**
	 * 添加
	 */
	public function actionAdd()
	{
		// 参数
		$is_submit = trim(Yii::app()->request->getParam('is_submit'));
		$title = trim(Yii::app()->request->getParam('title'));
		
		// 提交	
		if($is_submit)
		{
			// 判断
			if(!$title)
			{
				$this->alert_error('请填写标题');
			}

			// 查询是否有相同分类名
			$cdb = new CDbCriteria();
			$cdb->condition = "title = :title";
			$cdb->params = array(":title" => $title);
			$row_exist = Books_category::model()->find($cdb);
			if($row_exist)
			{
				$this->alert_error('分类名已存在');
			}

			// 入库
			$row = new Books_category();
			$row->title = $title;
			if($row->save())
			{
				$this->alert_ok('操作成功', array('callbackType'=>'closeCurrent', 'navTabId'=>'b_c_index'));
			}
			else
			{
				$this->alert_error();
			}
		}

		// 显示
		$this->renderPartial('add');
	}

	/**
	 * 修改
	 */
	public function actionEdit()
	{
		// 参数
		$is_submit = trim(Yii::app()->request->getParam('is_submit'));
		$id = intval(Yii::app()->request->getParam('id'));
		$title = trim(Yii::app()->request->getParam('title'));
		
		// 查询当前修改数据
		$row = Books_category::model()->findByPk($id);
		if(!$row || !$id)
		{
			$this->alert_error('记录不存在');
		}

		// 提交
		if($is_submit)
		{
			// 判断
			if(!$title)
			{
				$this->alert_error('请填写标题');
			}

			// 查询是否有相同分类名
			$cdb = new CDbCriteria();
			$cdb->condition = "id != {$id} AND title = :title";
			$cdb->params = array(":title" => $title);
			$row_exist = Books_category::model()->find($cdb);
			if($row_exist)
			{
				$this->alert_error('分类名已存在');
			}

			// 入库
			$row->title = $title;
			if($row->save())
			{
				$this->alert_ok('操作成功', array('callbackType'=>'closeCurrent', 'navTabId'=>'b_c_index'));
			}
			else
			{
				$this->alert_error();
			}
		}

		// 显示
		$data = array('row'=>$row);
		$this->renderPartial('edit', $data);
	}
	
	/**
	 * 删除
	 */
	public function actionDel()
	{
		// 参数
		$id = intval(Yii::app()->request->getParam('id'));
		$category_id = intval(Yii::app()->request->getParam('category_id'));

		$row = Books_category::model()->findByPk($id);
		if(!$row || !$id)
		{
			$this->alert_error('记录不存在');
		}
		else
		{
			// 查询分类下是否有书
			$cdb = new CDbCriteria();
			$cdb->condition = "category_id = " . $category_id;
			$books = Books::model()->find($cdb);
			if ($books) {
				$this->alert_error('分类下还有书本不能删除');
			}
			
			if($row->delete())
			{
				$this->alert_ok();
			}
			else
			{
				$this->alert_error();
			}
		}
	}
}