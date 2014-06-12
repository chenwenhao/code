<?php
/**
 * 内容管理-主控制器
 */
class ContentController extends Controller
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
		$category_id = intval(Yii::app()->request->getParam('category_id'));
		$title = trim(Yii::app()->request->getParam('title'));

		$cdb = new CDbCriteria();
		$cdb->condition = "category_id = " . $category_id;
		if($title)
		{
			$cdb->addCondition("title like :title");
			$cdb->params = array(":title"=>"%{$title}%");
		}
		$cdb->order = "submit_time DESC";

		// 分页
		$count = Content::model()->count($cdb);
		$pages = new CPagination($count);
		$pages->pageSize = 30;
		$pages->currentPage = $page;
		$pages->applyLimit($cdb);
		$rows = Content::model()->findAll($cdb);

		$data = array(
			'rows'=>$rows,
			'title'=>$title,
			'pages'=>$pages,
			'category_id'=>$category_id,
		);
		$this->renderPartial('index', $data);
	}

	/**
	 * 添加内容
	 */
	public function actionAdd()
	{
		// 参数
		$category_id = intval(Yii::app()->request->getParam('category_id'));
		$title = trim(Yii::app()->request->getParam('title'));
		$content = Yii::app()->request->getParam('content');
		$order_id = intval(Yii::app()->request->getParam('order_id'));
		$file_name = trim(Yii::app()->request->getParam('file_name'));
		$photo = trim(Yii::app()->request->getParam('photo'));
		$link = trim(Yii::app()->request->getParam('link'));
		$submit = Yii::app()->request->getParam("submit");
		
		// 查询扩展字段
		$fields = MyContentCategory::getFields($category_id);
		if($fields)
		{
			foreach($fields as $f)
			{
				$field_name = $f->field_name;
				if($f->field_name == 'book_id')
					$$field_name = intval(Yii::app()->request->getParam($field_name)); // 其它参数
				else
					$$field_name = Yii::app()->request->getParam($field_name);
			}
		}

		// 提交
		if($submit)
		{
			if(!$category_id)
			{
				$this->alert_error("请选择分类");
			}
			if(!$title)
			{
				$this->alert_error("请填写标题");
			}

			$photo_arr = MyImgUploader::upload('photo', 'upload_imgs', '/upload_imgs');
			if($photo_arr['url'])
			{
				$photo = $photo_arr['url'];
				$thumb = $photo_arr['thumb_url'];
			}
			else
			{
				$photo = $thumb = '';
			}

			if($file_name)
			{
				$category = Content_category::model()->findByPk($category_id); // 查询分类
				$category_ids = MyContentCategory::getCategoryByFile($category->file_dir); // 查询目录相同的分类ID

				// 判断相同目录下是否有相同文件名
				if($category_ids)
					$category_ids = implode(',', $category_ids);
				$cdb = new CDbCriteria();
				$cdb->condition = "category_id IN ({$category_ids}) AND file_name = :file_name";
				$cdb->params = array(":file_name" => $file_name);
				$exits_file_name = Content::model()->find($cdb);
				if($exits_file_name)
					$this->alert_error("此目录下已存在相同的文件名");
			}

			// 入库
			$row = new Content();
			$row->category_id = $category_id;
			$row->title = $title;
			$row->content = $content;
			$row->order_id = $order_id;
			$row->file_name = $file_name;
			$row->photo = $photo;
			$row->thumb = $thumb;
			$row->link = $link;
			if($row->save())
			{
				if($fields) // 插入扩展内容
				{
					foreach($fields as $field)
					{
						$ext = new Content_extension();
						$fname = $field->field_name;
						$ext->content_id = $row->id;
						$ext->ext_name = $fname;
						// 如果是file字段
						if($field->field_type == 'file')
						{
							$res = MyImgUploader::upload($fname, 'upload', '/upload');
							$ext->ext_value = $res['url'];
						}
						else
						{
							$ext->ext_value = $$fname;
						}
						$ext->save();
					}
				}
				$this->alert_ok();
			}
			else
			{
				$this->alert_error();
			}
		}

		// 查询所有分类
		$category = Content_category::model()->findByPk($category_id);

		$data = array(
			'category'=>$category,
			'fields'=>$fields,
			'category_id'=>$category_id,
		);
		$this->renderPartial('add', $data);
	}

	/**
	 * 修改内容
	 */
	public function actionEdit()
	{
		// 参数
		$id = intval(Yii::app()->request->getParam('id'));
		$category_id = intval(Yii::app()->request->getParam('category_id'));
		$title = trim(Yii::app()->request->getParam('title'));
		$content = Yii::app()->request->getParam('content');
		$order_id = intval(Yii::app()->request->getParam('order_id'));
		$file_name = trim(Yii::app()->request->getParam('file_name'));
		$photo = trim(Yii::app()->request->getParam('photo'));
		$link = trim(Yii::app()->request->getParam('link'));
		$submit = Yii::app()->request->getParam("submit");
		
		$row = Content::model()->findByPk($id);
		if(!$row || !$id)
		{
			$this->alert_error('记录不存在');
		}

		// 查询扩展字段
		$fields = MyContentCategory::getFields($category_id);
		if($fields)
		{
			foreach($fields as $f)
			{
				$field_name = $f->field_name;
				$$field_name = Yii::app()->request->getParam($field_name); // 其它参数
			}
		}

		// 查询扩展信息
		$cdb = new CDbCriteria();
		$cdb->condition = "content_id = " .$id;
		$ext = Content_extension::model()->findAll($cdb);
		$ext_arr = array(); // 扩展信息
		if($ext)
		{
			foreach($ext as $ex)
			{
				$ext_arr[$ex->ext_name] = $ex->ext_value;
			}
		}

		// 提交
		if($submit)
		{
			if(!$category_id)
			{
				$this->alert_error("请选择分类");
			}
			if(!$title)
			{
				$this->alert_error("请填写标题");
			}

			$photo_arr = MyImgUploader::upload('photo', 'upload_imgs', '/upload_imgs');
			if($photo_arr['url'])
			{
				$photo = $photo_arr['url'];
				$thumb = $photo_arr['thumb_url'];
			}
			else
			{
				$photo = $row->photo;
				$thumb = $row->thumb;
			}

			if($file_name)
			{
				$category = Content_category::model()->findByPk($category_id); // 查询分类
				$category_ids = MyContentCategory::getCategoryByFile($category->file_dir); // 查询目录相同的分类ID

				// 判断相同目录下是否有相同文件名
				if($category_ids)
					$category_ids = implode(',', $category_ids);
				$cdb = new CDbCriteria();
				$cdb->condition = "category_id IN ({$category_ids}) AND file_name = :file_name AND id <> ".$id;
				$cdb->params = array(":file_name" => $file_name);
				$exits_file_name = Content::model()->find($cdb);
				if($exits_file_name)
					$this->alert_error("此目录下已存在相同的文件名");

				// 判断删除文件
				if($row->file_name && $row->file_name != $file_name)
				{
					@unlink(ROOT.$row->category->file_dir.$row->file_name);
				}
			}

			// 入库
			$row->title = $title;
			$row->content = $content;
			$row->order_id = $order_id;
			$row->file_name = $file_name;
			$row->link = $link;
			$row->photo = $photo;
			$row->thumb = $thumb;
			if($row->save())
			{
				foreach($fields as $field)
				{
					// 查询扩展信息，根据扩展名和内容ID
					$cdb = new CDbCriteria();
					$cdb->condition = "ext_name = '{$field->field_name}' AND content_id = ".$row->id;
					$ext = Content_extension::model()->find($cdb);
					if(!$ext)
						$ext = new Content_extension();
					$fname = $field->field_name;
					$ext->content_id = $row->id;
					$ext->ext_name = $fname;
					// 如果是file字段
					if($field->field_type == 'file')
					{
						if(isset($ext_arr[$field->field_name]))
							$old_file = $ext_arr[$field->field_name];
						$res = MyImgUploader::upload($field_name, 'upload', '/upload');
						$ext->ext_value = $res['url'];
						if(!$res['url'])
							$ext->ext_value = $old_file;
					}
					else
					{
						$ext->ext_value = $$fname;
					}
					$ext->save();
				}
				$this->alert_ok();
			}
			else
			{
				$this->alert_error();
			}
		}

		// 查询所有分类
		$category = Content_category::model()->findAll();

		$data = array(
			'category'=>$category,
			'row'=>$row,
			'category_id'=>$category_id,
			'ext'=>$ext,
			'ext_arr'=>$ext_arr,
			'fields'=>$fields,
		);
		$this->renderPartial('edit', $data);
	}

	/**
	 * 删除内容
	 */
	public function actionDelete()
	{
		// 参数
		$id = intval(Yii::app()->request->getParam('id'));
		$row = Content::model()->findByPk($id);
		if(!$id || !$row)
		{
			$this->alert_error('记录不存在');
		}

		// 查询扩展内容
		$cdb = new CDbCriteria();
		$cdb->condition = "content_id=". $id;
		$exts = Content_extension::model()->findAll($cdb);

		// 判断删除文件
		if($row->file_name)
		{
			@unlink(ROOT.$row->category->file_dir.$row->file_name);
		}

		// 删除内容同时删除扩展内容
		if($row->delete())
		{
			foreach($exts as $e)
			{
				$e->delete();
			}
			$this->alert_ok();
		}
		else
		{
			$this->alert_error();
		}
	}

	/**
	 * 生成文件
	 */
	public function actionCreate_file()
	{
		// 参数
		$id = intval(Yii::app()->request->getParam('id'));

		$row = Content::model()->findByPk($id);
		if(!$id || !$row)
		{
			$this->alert_error('记录不存在');
		}

		if(!$row->file_name)
		{
			$this->alert_error('此记录没有文件名');
		}

		// 写入内容生成文件
		if(file_put_contents(ROOT.$row->category->file_dir.$row->file_name, $row->content))
		{
			$this->alert_ok();
		}
		else
		{
			$this->alert_error('生成文件失败');
		}
	}

	/**
	 * 编辑器上传图片
	 */
	public function actionUpload()
	{
		$path = APP_ROOT . '/public/upload_imgs';
		UploadImg::upload($path);
	}
}