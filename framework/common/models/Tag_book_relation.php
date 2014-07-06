<?php
/**
* @author xiaoling
* @package Models
*/
class Tag_book_relation extends CActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return strtolower(get_class($this));
	}

	/**
	 * 添加关联数据
	 * @param [type] $tag_id  [description]
	 * @param [type] $book_id [description]
	 */
	public function add($tag_id, $book_id)
	{
		$row = new self();
		$row->tag_id = $tag_id;
		$row->book_id = $book_id;
		$row->save();
	}

	/**
	 * 删除关联数据
	 * @param  [type] $tag_id  [description]
	 * @param  [type] $book_id [description]
	 * @return [type]          [description]
	 */
	public function del($tag_id, $book_id)
	{
		$cdb = new CDbCriteria();
		$cdb->condition = "tag_id = {$tag_id} AND book_id = ". $book_id;
		$row = self::model()->find($cdb);
		$row->delete();
	}

	/**
	 * 根据tag_id,book_id获取一条关联数据
	 * @param  [type] $tag_id  [description]
	 * @param  [type] $book_id [description]
	 * @return [type]          [description]
	 */
	public function get($tag_id, $book_id)
	{
		$cdb = new CDbCriteria();
		$cdb->condition = "tag_id = {$tag_id} AND book_id = ". $book_id;
		$row = self::model()->find($cdb);
		return $row;
	}

	/**
	 * 获取一本书所有的tag
	 * @param  [type] $tag_id  [description]
	 * @param  [type] $book_id [description]
	 * @return [type]          [description]
	 */
	public function getAllTag($book_id)
	{
		$cdb = new CDbCriteria();
		$cdb->condition = "book_id = ". $book_id;
		$rows = self::model()->findAll($cdb);
		return $rows;
	}
}