<?php
/**
 * 后台控制器基类
 * @author xiaoling
 */
class Controller extends MyController
{
	public $admin_userinfo; // 后台用户信息
	public $fields = array();

	public function init()
	{
		$this->fields = array('文本框'=>'text', '文件'=>'file', '文本域'=>'textarea');

		// 设置未登录前允许访问的地址
		$allow_path = array('site/login');

		// 判断如果没有登录或者是来宾用户，进行跳转
		if(!Yii::app()->user->getState('admin_is_login') || Yii::app()->user->isGuest)
		{
			$need_redirect = true;
			foreach($allow_path as $row)
			{
				if(substr(Yii::app()->request->pathInfo, 0, strlen($row)) == $row)
					$need_redirect = false;
			}

			if($need_redirect)
				Yii::app()->request->redirect('site/login');
		}
	}

	/**
	 * 得到当前登录用户的信息
	 */
	public function getAdminUserinfo()
	{
		if(!Yii::app()->user->isGuest && !$this->admin_userinfo)
		{
			$user_id = Yii::app()->user->getState('uid');
			if($user_id)
			{
				$this->admin_userinfo = Admin::model()->findByPk($user_id);
			}
		}
		return $this->admin_userinfo;
	}

	/**
	 * AJAX输出
	 */
	public static function ajaxDisplay($msg)
	{
		header('Content-Type: text/html; charset=utf-8');
		header('Pragma: no-cache');
		header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');

		die($msg);
	}

	/**
	 * 后台管理中心AJAX输出错误！
	 */
	public static function ajaxError($msg, $error = 1)
	{
		header('Content-Type: text/html; charset=utf-8');
		header('Pragma: no-cache');
		header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');

		$result = array();
		$result['msg'] = $msg;
		$result['error'] = $error;
		die(CJSON::encode($result));
	}

	/**
	 * DWZ框架普通AJAX请求错误消息提示
	 */
	public static function alert_error($msg = '操作失败')
	{
		$data = array();
		$data['message'] = $msg;
		$data['statusCode'] = 300;
		self::ajaxDisplay(CJSON::encode($data));
	}

	/**
	 * DWZ框架普通AJAX请求成功消息提示
	 */
	public static function alert_ok($msg = '操作成功', $data = array())
	{
		if(!$data)
		{
			$data['callbackType'] = 'forward';//表示刷新
		}
		$data['message'] = $msg;
		$data['statusCode'] = 200;
		self::ajaxDisplay(CJSON::encode($data));
	}
}