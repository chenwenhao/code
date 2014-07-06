<?php
/**
 * 书管理-主控制器
 */
class BooksController extends Controller
{
	public function init()
	{
		parent::init();
	}
	
	/**
	 * 内容列表
	 */
	public function actionIndex()
	{
		// 参数
		$page = intval(Yii::app()->request->getParam('pageNum')) - 1;
		$name = trim(Yii::app()->request->getParam('name'));
		$author = trim(Yii::app()->request->getParam('author'));

		// 查询数据
		$cdb = new CDbCriteria();
		if($name)
		{
			$cdb->addCondition("name like :name");
			$cdb->params = array(":name" => "%{$name}%");
		}
		if($author)
		{
			$cdb->addCondition("author = :author");
			$cdb->params = array(":author" => $author);
		}
		$cdb->order = "create_time DESC";

		// 分页
		$count = Books::model()->count($cdb);
		$pages = new CPagination($count);
		$pages->pageSize = 30;
		$pages->currentPage = $page;
		$pages->applyLimit($cdb);
		$rows = Books::model()->findAll($cdb);

		// 显示到页面的信息
		$data = array(
			'name' => $name,
			'author' => $author,
			'pages' => $pages,
			'rows' => $rows,
		);
		$this->renderPartial('index', $data);
	}

	/**
	 * 添加书本
	 */
	public function actionAdd()
	{
		// 参数
		$is_submit = trim(Yii::app()->request->getParam('is_submit'));
		$name = trim(Yii::app()->request->getParam('name'));
		$author = trim(Yii::app()->request->getParam('author'));
		$from = trim(Yii::app()->request->getParam('from'));
		$status = intval(Yii::app()->request->getParam('status'));
		$checked = intval(Yii::app()->request->getParam('checked'));
		$tag = trim(Yii::app()->request->getParam('tag'));
		$intro = trim(Yii::app()->request->getParam('intro'));

		// 提交
		if($is_submit)
		{
			// 判断参数
			if(!$name)
			{
				$this->alert_error('书名不能为空');
			}
			if(!$author)
			{
				$this->alert_error('作者不能为空');
			}

			// 根据书名和作者判断书本否存在
			$cdb = new CDbCriteria();
			$cdb->condition = "name = :name AND author = :author";
			$cdb->params = array(":name" => $name, ":author" => $author);
			$row_exsit = Books::model()->find($cdb);
			if($row_exsit)
			{
				$this->alert_error('书本已经存在');
			}
			
			// 入库
			$row = new Books();
			$row->name = $name;
			$row->author = $author;
			$row->from = $from;
			$row->status = $status;
			$row->checked = $checked;
			$row->tag = $tag;
			$row->intro = $intro;

			if($row->save())
			{
				// 上传图片
				$cover_img = MyImgUploader::upload_cover_img('cover_img', $row->id);
				$row->cover_img = $cover_img;
				$row->save();

				// tag入库
				Tags::model()->dispose($row->id, $tag);

				$this->alert_ok('操作成功', array('callbackType'=>'closeCurrent', 'navTabId'=>'booksindex'));
			}
			else
			{
				$this->alert_error();
			}
		}

		$this->renderPartial('add');
	}

	/**
	 * 修改书本
	 */
	public function actionEdit()
	{
		// 参数
		$is_submit = trim(Yii::app()->request->getParam('is_submit'));
		$id = intval(Yii::app()->request->getParam('id'));
		$name = trim(Yii::app()->request->getParam('name'));
		$from = trim(Yii::app()->request->getParam('from'));
		$author = trim(Yii::app()->request->getParam('author'));
		$status = intval(Yii::app()->request->getParam('status'));
		$checked = intval(Yii::app()->request->getParam('checked'));
		$tag = trim(Yii::app()->request->getParam('tag'));
		$intro = trim(Yii::app()->request->getParam('intro'));

		// 查询当前修改记录
		$row = Books::model()->findByPk($id);
		if (! $id || ! $row) {
			$this->alert_error('书本不存在');
		}

		// 提交
		if($is_submit)
		{
			// 判断参数
			if(!$name)
			{
				$this->alert_error('书名不能为空');
			}
			if(!$author)
			{
				$this->alert_error('作者不能为空');
			}

			// 根据书名和作者判断书本否存在
			$cdb = new CDbCriteria();
			$cdb->condition = "name = :name AND author = :author AND id != :id";
			$cdb->params = array(":name" => $name, ":author" => $author, ":id" => $id);
			$row_exsit = Books::model()->find($cdb);
			if($row_exsit)
			{
				$this->alert_error('书本已经存在');
			}

			$cover_img = $row->cover_img;
			// 上传图片
			$new_cover_img = MyImgUploader::upload_cover_img('cover_img', $row->id);
			if ($new_cover_img) {
				$cover_img = $new_cover_img;
			}
			
			$old_tag = $row->tag;

			// 入库
			$row->name = $name;
			$row->author = $author;
			$row->from = $from;
			$row->status = $status;
			$row->checked = $checked;
			$row->tag = $tag;
			$row->intro = $intro;
			$row->cover_img = $cover_img;
			if($row->save())
			{
				if ($tag && $tag != $old_tag) {
					// tag入库
					Tags::model()->dispose($row->id, $tag);
				}

				$this->alert_ok('操作成功', array('callbackType'=>'closeCurrent', 'navTabId'=>'booksindex'));
			}
			else
			{
				$this->alert_error();
			}
		}

		// 查询所有书本分类
		$categorys = Books_category::model()->findAll();
		
		// 显示
		$data = array('categorys' => $categorys, 'row' => $row);
		$this->renderPartial('edit', $data);
	}

	/**
	 * 删除书本
	 */
	public function actionDelete()
	{
		// 参数
		$id = intval(Yii::app()->request->getParam('id'));

		$row = Books::model()->findByPk($id);

		if (! $row || ! $id) {
			$this->alert_error('书本不存在');
		}

		$row->delete();
		$this->alert_ok();
	}
}