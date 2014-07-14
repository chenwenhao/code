<?php
/**
 * 标签管理-主控制器
 */
class TagsController extends Controller
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
		$tag_name = trim(Yii::app()->request->getParam('tag_name'));

		// 查询数据
		$cdb = new CDbCriteria();
		if($tag_name)
		{
			$cdb->addCondition("tag_name like :tag_name");
			$cdb->params = array(":tag_name" => "%{$tag_name}%");
		}
		$cdb->order = "id ASC";

		// 分页
		$count = Tags::model()->count($cdb);
		$pages = new CPagination($count);
		$pages->pageSize = 30;
		$pages->currentPage = $page;
		$pages->applyLimit($cdb);
		$rows = Tags::model()->findAll($cdb);

		// 显示到页面的信息
		$data = array(
			'rows' => $rows,
			'pages' => $pages,
			'tag_name' => $tag_name,
		);
		$this->renderPartial('index', $data);
	}

	/**
	 * 添加
	 */
	public function actionAdd()
	{
		// 参数
		$is_submit = trim(Yii::app()->request->getParam('is_submit'));
		$tag_name = trim(Yii::app()->request->getParam('tag_name'));

		// 提交
		if($is_submit)
		{
			// 判断参数
			if(!$tag_name)
			{
				$this->alert_error('标签名不能为空');
			}

			// 根据书名和作者判断书本否存在
			$cdb = new CDbCriteria();
			$cdb->condition = "tag_name = :tag_name";
			$cdb->params = array(":tag_name" => $tag_name);
			$row_exsit = Tags::model()->find($cdb);
			if($row_exsit)
			{
				$this->alert_error('标签名已经存在');
			}
			
			// 入库
			$row = new Tags();
			$row->tag_name = $tag_name;
			if($row->save())
			{
				$this->alert_ok('操作成功', array('callbackType'=>'closeCurrent', 'navTabId'=>'tagsindex'));
			}
			else
			{
				$this->alert_error();
			}
		}

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
		$tag_name = trim(Yii::app()->request->getParam('tag_name'));

		$row = Tags::model()->findByPk($id);
		// 提交
		if($is_submit)
		{
			// 判断参数
			if(!$tag_name)
			{
				$this->alert_error('标签名不能为空');
			}

			// 根据书名和作者判断书本否存在
			$cdb = new CDbCriteria();
			$cdb->condition = "tag_name = :tag_name AND id != ". $id;
			$cdb->params = array(":tag_name" => $tag_name);
			$row_exsit = Tags::model()->find($cdb);
			if($row_exsit)
			{
				$this->alert_error('标签名已经存在');
			}
			
			// 入库
			$row->tag_name = $tag_name;
			if($row->save())
			{
				$this->alert_ok('操作成功', array('callbackType'=>'closeCurrent', 'navTabId'=>'tagsindex'));
			}
			else
			{
				$this->alert_error();
			}
		}

		$data = array('row' => $row, 'tag_name' => $tag_name);
		$this->renderPartial('edit', $data);
	}
}