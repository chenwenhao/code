<?php
/**
* @author xiaoling
* @package Models
*/
class User_book extends CActiveRecord
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
	 * 查询用户看这本书的信息
	 */
	public function getUserbook($uid, $book_id)
	{
		$cdb = new CDbCriteria();
		$cdb->condition = "uid = :uid AND book_id = :book_id";
		$cdb->params = array(":uid" => $uid,":book_id" => $book_id);
		$row = self::model()->find($cdb);
		return $row;
	}
}