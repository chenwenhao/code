<?php
class MyContentCategory extends CComponent
{
	static $parent_tree;

	/**
	 * 根据ID获取分类
	 */
	static function getById($id)
	{
		$id = intval($id);
		return Content_category::model()->findByPk($id);
	}

	/**
	 * 获取分类下的内容数量
	 */
	static public function getContentNumber(Content_category $category, &$content_number = 0)
	{
		if($category->childs)
		{
			foreach ($category->childs as $row)
			{
				$content_number = self::getContentNumber($row, $content_number);
			}
		}
		
		$cdb = new CDbCriteria();
		$cdb->condition = "category_id = :category_id";
		$cdb->params = array(":category_id"=>$category->id);
		$content_number += Content::model()->count($cdb);
		return $content_number;
	}

	/**
	 * 得到一个分类的上一级到最顶级的所有分类
	 * 
	 * @param Object $category	// 分类
	 * 
	 * @return Array $data	// 返回一个按分类层级关系的数组，数组的第一个元素是级别最高的分类
	 */
	static function getParentTree(Content_category $category, &$data = array())
	{
		if($category)
		{
			if(empty(self::$parent_tree[$category->id]))
			{
				// 将分类加到入数据的最上层排序
				array_unshift($data, $category);

				if($category->parent)
				{
					self::getParentTree($category->parent, $data);
				}
				self::$parent_tree[$category->id] = $data;
			}
			return self::$parent_tree[$category->id];
		}
	}

	/**
	 * 获取一个分类的所有子分类，按树型结构存放于数组中
	 */
	static function getChildTree(Content_category $parent_category, $category = null, &$data = array())
	{
		if($category || $parent_category)
		{
			if($parent_category)
			{
				$category = $parent_category;
			}
			else
			{
				// 将分类加到入数据的最上层排序
				array_unshift($data, $category);
			}

			if(!empty($category->childs))
			{
				foreach ($category->childs as $row)
				{
					self::getChildTree(null, $row, $data);
				}
			}
		}
		return $data;
	}

	/**
	 * 得到所有所有一级分类
	 */
	static function getTopCategory()
	{
		$cdb = new CDbCriteria;
		$cdb->condition = "parent_id = 0";
		return Content_category::model()->findAll($cdb);
	}

	/**
	 * 以树型结构显示分类
	 *
	 * @param 
	 * Array $category // 顶级分类
	 *
	 */
	static public function showAsTree(Array $category, $form = false, $num = 0)
	{
		$html = "";
		if($category)
		{
			foreach($category as $k=>$v)
			{
				// 显示为目录或文件
				if(!empty($v->childs))
				{
					$img = 'open';
				}
				else
				{
					$img = 'file';
				}

				$html .= '<tr id="hang0">';
				$html .= '<td>';
				$html .= '<span style="float:left;">';
				if($num)
				{
					for ($i = 0; $i < $num; $i++)
					{
						$html .= '<img width="18" height="18" border="0" align="absmiddle" src="/images/admin/treeimg/shu.gif">';
					}
				}

				if(!$num)
				{
					switch($k)
					{
						case 0:
							$html .= '<img src="/images/admin/treeimg/fsub.gif" width="18" height="18" align="absmiddle" border="0">';
							break;
						case count($category) -1:
							$html .= '<img src="/images/admin/treeimg/zzhe.gif" width="18" height="18" align="absmiddle" border="0">';
							break;
						default:
							$html .= '<img src="/images/admin/treeimg/sub.gif" width="18" height="18" align="absmiddle" border="0">';
							break;
					}
				}
				else
				{
					switch($k)
					{
						case count($category) -1:
							$html .= '<img src="/images/admin/treeimg/zzhe.gif" width="18" height="18" align="absmiddle" border="0">';
							break;
						default:
							$html .= '<img src="/images/admin/treeimg/sub.gif" width="18" height="18" align="absmiddle" border="0">';
							break;
					}
				}

				$html .= "<img src='/images/admin/treeimg/{$img}.gif' width='18' height='18' align='absmiddle' border='0'>【ID:{$v->id}】{$v->name}(" . self::getContentNumber($v) . ")";
				$html .= "</span>";
				$html .= "<span style='line-height:20px;float:right'>";
				if($form)
				{
					$checked = $form == $v->id ? 'checked' : '';
					$html .= "<input type='radio' name='category_id' value='{$v->id}' {$checked} />";
				}
				else
				{
					$html .= "<a href='/content_category/ext_field_list?id={$v->id}' target='dialog'>查看扩展字段</a>/<a href='/content_category/ext_field_add?id={$v->id}' target='dialog'>添加扩展字段</a>/";
					$html .= "<a href='/content/add?category_id={$v->id}' target='navTab' rel='aca'>添加内容</a>/<a href='/content/index?category_id={$v->id}' target='navTab' rel='acv' title='". $v->name ." - 内容管理'>内容管理</a>/";
					$html .= "<a href='/content_category/add?parent_id={$v->id}' target='dialog'>添加子分类</a>/";
					$html .= "<a href='/content_category/edit?id={$v->id}' target='dialog'>修改</a>/<a href='/content_category/delete?id={$v->id}' target='ajaxTodo' title='确定删除吗?'>删除</a>";
				}
				$html .="</span>";
				$html .= "</td>";
				$html .= '</tr>';

				if(!empty($v->childs))
				{
					$cnum = $num;
					$cnum++;
					$html .= self::showAsTree($v->childs, $form, $cnum);
				}
			}
		}
		return $html;
	}

	/**
	 * 根据分类ID查询扩展字段
	 *@param int $category_id
	 *@return array
	 */
	static public function getFields($category_id)
	{
		$category_id = intval($category_id);
		$cdb = new CDbCriteria();
		$cdb->condition = "category_id = " . $category_id;
		$rows = Content_category_extension::model()->findAll($cdb);
		return $rows;
	}

	/**
	 * 根据分类ID查询内容和内容扩展信息
	 *@param int $category_id 分类ID int $limit 条数
	 *@return array
	 */
	static public function getContent($category_id, $limit = 0)
	{
		$category_id = intval($category_id);
		$cdb = new CDbCriteria();
		$cdb->condition = "category_id = " . $category_id;
		$cdb->order = "order_id ASC, submit_time DESC";
		if($limit)
			$cdb->limit = $limit;
		$rows = Content::model()->findAll($cdb);
		$new_rows = array();
		$ext_arr = array();
		foreach($rows as $key=>$row)
		{
			$exts = self::getContent_ext($row->id);
			if($exts)
			{
				foreach($exts as $e)
				{
					$ext_arr[$row->id][$e->ext_name] = $e->ext_value;
				}
			}
		}
		$new_rows['content'] = $rows;
		$new_rows['ext'] = $ext_arr;
		return $new_rows;
	}

	/**
	 * 根据内容ID查询扩展信息
	 *@param int $content_id
	 *@return array
	 */
	static public function getContent_ext($content_id)
	{
		$content_id = intval($content_id);
		$cdb = new CDbCriteria();
		$cdb->condition = "content_id = " . $content_id;
		$rows = Content_extension::model()->findAll($cdb);
		return $rows;
	}

	/**
	 * 根据内容ID查询扩展信息，返回处理后的扩展信息
	 *@param int $content_id
	 *@return array
	 */
	static public function getContent_ext_new($content_id)
	{
		$content_id = intval($content_id);
		$cdb = new CDbCriteria();
		$cdb->condition = "content_id = " . $content_id;
		$rows = Content_extension::model()->findAll($cdb);
		$new_rows = array();
		foreach($rows as $key=>$row)
		{
			$new_rows[$content_id][$row->ext_name] = $row->ext_value;
		}
		return $new_rows;
	}

	/**
	 *判断此扩展字段是否有内容
	 *@param int $category_id vachar ext_name
	 *@return bool
	 */
	static public function extFieldHasContent($category_id, $ext_name)
	{
		$category_id = intval($category_id);
		$cdb = new CDbCriteria();
		$cdb->condition = "category_id = " . $category_id;
		$content = Content::model()->findAll($cdb);
		if($content)
		{
			foreach($content as $c)
			{
				$content_ids[] = $c->id;
			}
			$cdb = new CDbCriteria();
			$cdb->addCondition('content_id', $content_ids);
			$cdb->addCondition("ext_name = '{$ext_name}' AND ext_value != '' ");
			$res = Content_extension::model()->findAll($cdb);
			if($res)
			{
				return true;
			}
		}
		return false;
	}

	/**
	 *查询目录名相同的分类
	 *@param varchar $file_dir
	 *@return array
	 */
	static public function getCategoryByFile($file_dir)
	{
		$category_ids = array();
		$cdb = new CDbCriteria();
		$cdb->condition = "file_dir = '{$file_dir}' ";
		$res = Content_category::model()->findAll($cdb);
		if($res)
		{
			foreach($res as $row)
			{
				$category_ids[] = $row->id;
			}
		}

		return $category_ids;
	}
}