<?php
/**
 * 蜘蛛后台-管理员管理
 * @package SpiderAdminr
 */

class AdminController extends Controller
{
	public $access_group = array(1=>'超级管理员', 2=>'广告', 3=>'运营');
	public function init()
	{
		parent::init();
	}

	/**
	 * 列表
	 */
	public function actionIndex()
	{
		// 参数
		$page = intval(Yii::app()->request->getParam('pageNum')) - 1;
		// 查库
		$cdb = new CDbCriteria;
	
		// 分页
		$count = Admin::model()->count($cdb);
		$pages = new CPagination($count);
		$pages->pageSize = 50;
		$pages->currentPage = $page;
		$pages->applyLimit($cdb);
		$rows = Admin::model()->findAll($cdb);
	
		// 显示
		$data = array('rows' => $rows, 'pages' => $pages);
		$this->renderPartial('index', $data);
	}
	
	/**
	 * 添加
	 */
	public function actionAdd()
	{
		// 参数
		$role = intval(Yii::app()->request->getParam('role'));
		$username = trim(Yii::app()->request->getParam('username'));
		$password = trim(Yii::app()->request->getParam('password'));
		
		if($username)
		{
			// 判断
			if(!$password)
			{
				$this->alert_error('请填写密码');
			}
			// 查询是否有相同用户名
			$exist = Admin::model()->find("username='{$username}'");
			if($exist)
			{
				$this->alert_error('用户名已存在');
			}

			$row = new Admin();
			$row->username = $username;
			$row->password = $this->hash_password($password);
			$row->role = $role;
			if($row->save())
			{
				$this->alert_ok('操作成功', array('callbackType'=>'closeCurrent', 'navTabId'=>'adminlist'));
			}
			else
			{
				$this->alert_error();
			}
		}

		// 显示
		$this->renderPartial('add');
	}

	/**
	 * 修改分类
	 */
	public function actionEdit()
	{
		// 参数
		$id = intval(Yii::app()->request->getParam('id'));
		$role = intval(Yii::app()->request->getParam('role'));
		$username = trim(Yii::app()->request->getParam('username'));
		$password = trim(Yii::app()->request->getParam('password'));
		
		if(!$id)
		{
			$this->alert_error('ID不能为空');
		}
		$row = Admin::model()->findByPk($id);
		if(!$row)
		{
			$this->alert_error('记录不存在');
		}
		if($username)
		{
			// 查询是否有相同用户名
			$exist = Admin::model()->find("username='{$username}' AND id <> ".$id);
			if($exist)
			{
				$this->alert_error('用户名已存在');
			}

			$row->username = $username;
			if($password)
				$row->password = $this->hash_password($password);
			$row->role = $role;
			if($row->save())
			{
				$this->alert_ok('操作成功', array('callbackType'=>'closeCurrent', 'navTabId'=>'adminlist'));
			}
			else
			{
				$this->alert_error();
			}
		}

		// 显示
		$data = array('row'=>$row);
		$this->renderPartial('edit', $data);
	}
	
	/**
	 * 删除
	 */
	public function actionDel()
	{
		// 参数
		$id = intval(Yii::app()->request->getParam('id'));
		if(!$id)
		{
			$this->alert_error('ID不能为空');
		}
		$row = Admin::model()->findByPk($id);
		if(!$row)
		{
			$this->alert_error('记录不存在');
		}
		else
		{
			if($row->delete())
			{
				$this->alert_ok();
			}
			else
			{
				$this->alert_error();
			}
		}
	}
}