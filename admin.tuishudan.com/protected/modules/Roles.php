<?php
class Roles
{
	/**
	 * 
	 * 定义右侧菜单
	 * @var array
	 */
	public static $menus = array(
		array(
			'name'=>'内容系统',
			'submenu'=>array(
				array(
					'name'=>'内容管理',
					'submenu'=>array(
						array('name'=>'分类管理', 'path'=>'content_category/index', 'rel'=>'c_c_index', 'role'=>array(3)),
					),
				),
			),
		),

		array(
			'name'=>'管理员管理',
			'submenu'=>array(
				array(
    				'name'=>'管理员列表',
    				'submenu'=>array(
    					array('name'=>'管理员列表', 'path'=>'admin/index', 'rel'=>'adminlist', 'role'=>array(1)),
    				),
				),
			),
		),
	);
	
	/**
	 * 
	 * 根据role_id获得应显示的菜单
	 * @param int $role_id
	 */
	public static function getrole($role_id)
	{
		if($role_id == 1)
			return self::$menus;
		$role = false;//Yii::app()->cache->get('left_menu_group_role'.$role_id);
		if($role === false)
		{
			$role = self::$menus;
			foreach ($role as $k1=>$lv1)
			{
				foreach ($lv1['submenu'] as $k2=>$lv2)
				{
					foreach ($lv2['submenu'] as $k3=>$role_items)
					{
						if(!in_array($role_id, $role_items['role']))
						{
							unset($role[$k1]['submenu'][$k2]['submenu'][$k3]);
						}
					}
					if(empty($role[$k1]['submenu'][$k2]['submenu']))
					{
						unset($role[$k1]['submenu'][$k2]);
					}
				}
				if(empty($role[$k1]['submenu']))
				{
					unset($role[$k1]);
				}
			}
		}
		return $role;
	}
}