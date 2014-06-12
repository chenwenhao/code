<?php
/**
 * 内容管理 主控制器
 * @author ling.xiao
 */
class Content_categoryController extends Controller
{
	public function init()
	{
		parent::init();
	}
	
	/**
	 * 分类列表
	 */
	public function actionIndex()
	{
		// 查询所有顶级栏目
		$tops = MyContentCategory::getTopCategory();
		// 显示树状结构
		$html = MyContentCategory::showAsTree($tops);

		// 显示视图
		$data = array();
		$data['html'] = $html;
		$this->renderPartial('index', $data);
	}

	/**
	 * 添加分类
	 */
	public function actionAdd()
	{
		// 参数
		$parent_id = intval(Yii::app()->request->getParam('parent_id'));
		$name = trim(Yii::app()->request->getParam('name'));
		$text_show_type = intval(Yii::app()->request->getParam('text_show_type'));
		$is_create_file = intval(Yii::app()->request->getParam('is_create_file'));
		$file_dir = trim(Yii::app()->request->getParam('file_dir'));
		$is_submit = Yii::app()->request->getParam("is_submit");

		// 上级分类
		$parent_category = MyContentCategory::getById($parent_id);
		if($parent_id && !$parent_category)
		{
			$this->alert_error("上级分类不存在");
		}
		
		// 提交
		if($is_submit)
		{
			if(!$name)
			{
				$this->alert_error("分类名称不能为空");
			}
			if($is_create_file == 1 && !$file_dir)
			{
				$this->alert_error('如果启用生成文件，请填写文件目录');
			}
			if($file_dir)
			{
				if(!preg_match('#^\/.*\/$#', $file_dir))
				{
					$this->alert_error('目录名格式错误。必须以，斜杠/开头、斜杠/结尾');
				}
				
				//判断目录是否存在
				if(!file_exists(ROOT . $file_dir))
				{
					$this->alert_error('目录不存在');
				}
			}

			// 查询同名分类
			$cdb = new CDbCriteria;
			$cdb->condition = "name = :name AND parent_id = :parent_id";
			$cdb->params = array(":name"=>$name, ":parent_id"=>$parent_id);
			$category = Content_category::model()->find($cdb);
			if($category)
			{
				$this->alert_error("操作出错，分类名已经存在");
			}

			// 入库
			$category = new Content_category;
			$category->name = $name;
			$category->text_show_type = $text_show_type;
			$category->is_create_file = $is_create_file;
			$category->file_dir = $file_dir;
			$category->parent_id = $parent_id;
			if($category->save())
			{
				$this->alert_ok('操作成功', array('callbackType'=>'closeCurrent', 'navTabId'=>'c_c_index'));
			}
			else
			{
				$this->alert_error();
			}
		}

		// 显示
		$data = array();
		$data['name'] = $name;
		$data['parent_category'] = $parent_category;
		$this->renderPartial('add', $data);
	}

	/**
	 * 修改分类
	 */
	public function actionEdit()
	{
		// 参数
		$id = intval(Yii::app()->request->getParam('id'));
		$parent_id = intval(Yii::app()->request->getParam('parent_id'));
		$name = trim(Yii::app()->request->getParam('name'));
		$text_show_type = intval(Yii::app()->request->getParam('text_show_type'));
		$is_create_file = intval(Yii::app()->request->getParam('is_create_file'));
		$file_dir = trim(Yii::app()->request->getParam('file_dir'));
		$is_submit = Yii::app()->request->getParam("is_submit");

		// 查询数据
		$category = MyContentCategory::getById($id);
		if(!$category)
		{
			$this->alert_error("分类不存在");
		}

		// 提交
		if($is_submit)
		{
			if(!$name)
			{
				$this->alert_error("分类名称不能为空");
			}
			if($parent_id)
			{
				$parent_category = MyContentCategory::getById($parent_id);
				if(!$parent_category)
				{
					$this->alert_error("上级分类不存在");
				}
			}
			if($is_create_file == 1 && !$file_dir)
			{
				$this->alert_error('如果启用生成文件，请填写文件目录');
			}
			if($file_dir)
			{
				if(!preg_match('#^\/.*\/$#', $file_dir))
				{
					$this->alert_error('目录名格式错误。必须以，斜杠/开头、斜杠/结尾');
				}

				//判断目录是否存在
				if(!file_exists(ROOT . $file_dir))
				{
					$this->alert_error('目录不存在');
				}
			}

			// 查询同名分类
			$cdb = new CDbCriteria;
			$cdb->condition = "name = :name AND id <> :id AND parent_id = :parent_id";
			$cdb->params = array(":name"=>$name, ":id"=>$id, ":parent_id"=>$category->parent_id);
			if(Content_category::model()->find($cdb))
			{
				$this->alert_error("操作出错，分类名已经存在");
			}

			// 入库
			$category->name = $name;
			$category->parent_id = $parent_id;
			$category->text_show_type = $text_show_type;
			$category->is_create_file = $is_create_file;
			$category->file_dir = $file_dir;
			if($category->save())
			{
				$this->alert_ok('操作成功', array('callbackType'=>'closeCurrent', 'navTabId'=>'c_c_index'));
			}
			else
			{
				$this->alert_error();
			}
		}

		// 显示
		$data = array();
		$data['category'] = $category;
		$this->renderPartial('edit', $data);
	}

	/**
	 * 删除分类
	 */
	public function actionDelete()
	{
		// 参数
		$id = intval(Yii::app()->request->getParam('id'));

		// 查询分类
		$category = MyContentCategory::getById($id);
		if(!$category)
		{
			$this->alert_error("分类不存在");
		}

		// 查询分类下是否还存在子分类
		if($category->childs)
		{
			$this->alert_error("该分类下还存在子分类，不能删除");
		}

		// 查询分类下是否还存在内容（上面已经判断过子分类了，这里无需再查询分类下的子分类下的内容数）
		if(MyContentCategory::getContentNumber($category) > 0)
		{
			$this->alert_error("该分类下还存在内容，不能删除");
		}

		// 查询分类下是否有扩展字段
		$cdb = new CDbCriteria();
		$cdb->condition = "category_id=" . $id;
		$exsit_ext_fields = Content_category_extension::model()->findAll($cdb);
		if($exsit_ext_fields)
		{
			$this->alert_error("该分类下有扩展字段，不能删除");
		}

		if($category->delete())
		{
			$this->alert_ok();
		}
		else
		{
			$this->alert_error();
		}
	}

	/**
	 * 添加分类表扩展字段
	 */
	public function actionExt_field_add()
	{
		// 参数
		$category_id = intval(Yii::app()->request->getParam('id'));
		$name = trim(Yii::app()->request->getParam('name'));
		$default_value = Yii::app()->request->getParam('default_value');
		$field_name = trim(Yii::app()->request->getParam('field_name'));
		$field_type = trim(Yii::app()->request->getParam('field_type'));
		$desc = trim(Yii::app()->request->getParam('desc'));
		$is_submit = Yii::app()->request->getParam("is_submit");

		$category = Content_category::model()->findByPk($category_id);
		if(!$category || !$category_id)
		{
			$this->alert_error('分类不存在');
		}
		
		// 提交
		if($is_submit)
		{
			if(!$name)
			{
				$this->alert_error("名称不能为空");
			}
			if(!$field_name)
			{
				$this->alert_error("字段名不能为空");
			}
			if(!$field_type)
			{
				$this->alert_error("字段类型不能为空");
			}
			
			// 判断是否有相同字段
			$cdb = new CDbCriteria();
			$cdb->condition = "category_id = {$category_id} AND field_name = :field_name";
			$cdb->params = array(":field_name"=>$field_name);
			$exsit = Content_category_extension::model()->find($cdb);
			if($exsit)
			{
				$this->alert_error('字段名已存在 ');
			}

			// 入库
			$row = new Content_category_extension;
			$row->category_id = $category_id;
			$row->name = $name;
			$row->default_value = $default_value;
			$row->field_name = $field_name;
			$row->field_type = $field_type;
			$row->desc = $desc;
			if($row->save())
			{
				$this->alert_ok('操作成功', array('callbackType'=>'closeCurrent', 'navTabId'=>'c_c_index'));
			}
			else
			{
				$this->alert_error();
			}
		}

		// 显示
		$data = array(
			'category'=>$category,
		);
		$this->renderPartial('ext_field_add', $data);
	}

	/**
	 * 修改分类表扩展字段
	 */
	public function actionExt_field_edit()
	{
		// 参数
		$id = intval(Yii::app()->request->getParam('id'));
		$category_id = intval(Yii::app()->request->getParam('category_id'));
		$name = trim(Yii::app()->request->getParam('name'));
		$default_value = Yii::app()->request->getParam('default_value');
		$field_name = trim(Yii::app()->request->getParam('field_name'));
		$field_type = trim(Yii::app()->request->getParam('field_type'));
		$desc = trim(Yii::app()->request->getParam('desc'));
		$is_submit = Yii::app()->request->getParam("is_submit");

		$row = Content_category_extension::model()->findByPk($id);
		if(!$row || !$id)
		{
			$this->alert_error('记录不存在');
		}

		// 判断扩展字段是否有内容
		if(MyContentCategory::extFieldHasContent($category_id, $row->field_name))
		{
			$this->alert_error('此扩展字段下有内容， 不能修改');
		}
		
		// 提交
		if($is_submit)
		{
			if(!$name)
			{
				$this->alert_error("名称不能为空");
			}
			if(!$field_name)
			{
				$this->alert_error("字段名不能为空");
			}
			if(!$field_type)
			{
				$this->alert_error("字段类型不能为空");
			}
			
			// 判断是否有相同字段
			$cdb = new CDbCriteria();
			$cdb->condition = "category_id = {$row->category_id} AND field_name = :field_name AND id <> ".$id;
			$cdb->params = array(":field_name"=>$field_name);
			$exsit = Content_category_extension::model()->find($cdb);
			if($exsit)
			{
				$this->alert_error('字段名已存在 ');
			}

			// 入库
			$row->name = $name;
			$row->default_value = $default_value;
			$row->field_name = $field_name;
			$row->field_type = $field_type;
			$row->desc = $desc;
			if($row->save())
			{
				$this->alert_ok('操作成功', array('callbackType'=>'closeCurrent', 'navTabId'=>'c_c_index'));
			}
			else
			{
				$this->alert_error();
			}
		}
		$data = array(
			'row'=>$row,
		);
		$this->renderPartial('ext_field_edit', $data);
	}

	/**
	 * 查看分类表扩展字段
	 */
	public function actionExt_field_list()
	{
		$category_id = intval(Yii::app()->request->getParam('id'));
		$cdb = new CDbCriteria();
		$cdb->condition = "category_id = " . $category_id;
		$rows = Content_category_extension::model()->findAll($cdb);
		$data = array('rows'=>$rows, 'category_id'=>$category_id);
		$this->renderPartial('ext_field_list', $data);
	}

	/**
	 * 删除扩展字段
	 */
	public function actionExt_field_delete()
	{
		// 参数
		$id = intval(Yii::app()->request->getParam('id'));
		$category_id = intval(Yii::app()->request->getParam('category_id'));

		$row = Content_category_extension::model()->findByPk($id);
		if(!$id || !$row)
		{
			$this->alert_error('记录不存在');
		}

		// 判断扩展字段是否有内容
		if(MyContentCategory::extFieldHasContent($category_id, $row->field_name))
		{
			$this->alert_error('此扩展字段下有内容， 不能删除');
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