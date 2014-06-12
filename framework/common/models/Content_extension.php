<?php 
class Content_extension extends CActiveRecord
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
			'content' => array(self::BELONGS_TO, 'Content', 'article_id'),
		);
	}
}