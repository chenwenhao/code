<?php
/**
* @author xiaoling
* @package Models
*/
class Admin extends CActiveRecord
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