<?php
/**
* @author xiaoling
* @package Models
*/
class Books_category extends CActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return strtolower(get_class($this));
	}
}