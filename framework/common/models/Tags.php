<?php
/**
* @author xiaoling
* @package Models
*/
class Tags extends CActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return strtolower(get_class($this));
	}

	public function relations()
	{
		return array(
			'book'=>array(self::BELONGS_TO, 'Books', 'book_id'),
		);
	}

	/**
	 * 标签名查询标签
	 */
	public function getTagByName($tag_name)
	{
		$cdb = new CDbCriteria();
		$cdb->condition = "tag_name = :tag_name";
		$cdb->params = array(":tag_name" => $tag_name);
		$row = self::model()->find($cdb);
		return $row;
	}

	/**
	 * 处理标签
	 */
	public function dispose($book_id, $post_tag)
	{
		// 查询书本所有标签
		$book_all_tag = Tag_book_relation::model()->getAllTag($book_id);
		$book_all_tag_ids = array(); // 标签ID数组
		if ($book_all_tag) {
			foreach ($book_all_tag as $key => $all_tag) {
				$book_all_tag_ids[] = $all_tag->tag_id;
			}
		}

		$post_tag_arr = explode(',', $post_tag);

		foreach ($post_tag_arr as $key => $tag_name)
		{
			// 判断标签存在否
			$tag_exsit = self::getTagByName($tag_name);
			if (! $tag_exsit) {

				// add tag
				$tags = new self();
				$tags->tag_name = $tag_name;
				$tags->num += 1;
				$tags->save();
				
				Tag_book_relation::model()->add($tags->id, $book_id); // add re
				
				continue;
			}

			// 判断关联数据存在否
			if (in_array($tag_exsit->id, $book_all_tag_ids)) {
				$book_tag_key = array_search($tag_exsit->id, $book_all_tag_ids);
				unset($book_all_tag_ids[$book_tag_key]);
			} else {
				Tag_book_relation::model()->add($tag_exsit->id, $book_id); // add re

				// tag num +1
				$tag_exsit->num += 1;
				$tag_exsit->save();
			}
		}

		// 删除书本老的关联数据
		if (! empty($book_all_tag_ids)) {
			$cdb = new CDbCriteria();
			$cdb->condition = "book_id = " . $book_id;
			$cdb->addInCondition('tag_id', $book_all_tag_ids);
			Tag_book_relation::model()->deleteAll($cdb);

			// tag -1
			$cdb = new CDbCriteria();
			$cdb->addInCondition('id', $book_all_tag_ids);
			$tags_rows = Tags::model()->findAll($cdb);
			foreach ($tags_rows as $key => $tags) {
				$tags->num -= 1;
				$tags->save();
			}
		}
	}

}