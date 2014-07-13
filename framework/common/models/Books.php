<?php
/**
* @author xiaoling
* @package Models
*/
class Books extends CActiveRecord
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
			'category'=>array(self::BELONGS_TO, 'Books_category', 'category_id'),
		);
	}

	/**
	 * 根据书名查询书
	 * @param varchar $book_name
	 */
	public static function getBookByName($book_name)
	{
		$cdb = new CDbCriteria();
		$cdb->condition = "name = :name";
		$cdb->params = array(":name" => $book_name);
		return $row = Books::model()->find($cdb);
	}
}