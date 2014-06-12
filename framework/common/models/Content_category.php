<?php 
class Content_category extends CActiveRecord
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
			'childs'=>array(self::HAS_MANY, 'Content_category', 'parent_id'),
			'parent'=>array(self::BELONGS_TO, 'Content_category', 'parent_id'),
		);
	}
}