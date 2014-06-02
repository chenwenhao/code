<?php
/**
 * 会员-主控制器
 * @author xiaoling
 */
class MemberController extends MyController
{
	public function init()
	{
		Yii::app()->layout = '//layouts/member';
		$this->userinfo = $this->getUserinfo();
	}

	/** 
	 * 注册显示
	 */
	public function actionRegister()
	{
		// 显示
		$this->renderPartial('register');
	}

	public function actionRegister_submit()
	{
		// 参数
		$is_submit = trim(Yii::app()->request->getParam('is_submit'));
		$username = trim(Yii::app()->request->getParam('username'));
		$password = Yii::app()->request->getParam('password');
		$password2 = Yii::app()->request->getParam('password2');
		$email = trim(Yii::app()->request->getParam('email'));
		$name = trim(Yii::app()->request->getParam('name'));
		$v_code = trim(Yii::app()->request->getParam('v_code'));

		// 提交
		if(!$username || strlen($username) < 3)
		{
			$this->jsonp(false, '用户名格式错误');
		}

		if(!$password || strlen($password) < 6)
		{
			$this->jsonp(false, '密码不能小于6位');
		}

		if($password != $password2)
		{
			$this->jsonp(false, '两次密码输入不一致');
		}

		if(!$email)
		{
			$this->jsonp(false, '请填写邮箱地址');
		}

		if($this->checkEmail($email) == false)
		{
			$this->jsonp(false, '邮箱格式错误');
		}

		if($v_code != strtolower(Yii::app()->user->getState('re_code')))
		{
			$this->jsonp(false, '验证码错误');
		}

		// 用户或邮箱 已经存在
		$cdb = new CDbCriteria();
		$cdb->condition = "username = :username OR email = :email";
		$cdb->params = array(":username" => $username, ":email" => $email);
		$exsit = User::model()->find($cdb);
		if($exsit)
		{
			$this->jsonp(false, '用户名或邮箱已存在');
		}

		// 论坛注册
			require_once APP_ROOT .'/protected/uc_client/config.inc.php';
			require_once APP_ROOT .'/protected/uc_client/client.php';

			

			uc_user_register($username, $password, $email);
			if($uid)
			{
				$this->jsonp(false, $uid . 'here');
			}
			else
			{
				$this->jsonp(false, 'error');
			}
			$this->jsonp(false, UC_DBHOST);

		$row = new User();
		$row->username = $username;
		$row->password = $this->hash_password($password);
		$row->email = $email;
		$row->name = $name;
		if($row->save())
		{
			//$this->jsonp(false, 'here');
			

			// 注册成功后直接登录
			$identity = new MyUserIdentity($username, $password);
			if($identity->authenticate())
			{
				Yii::app()->user->login($identity, 3600*24*7);
				$this->jsonp(true);
			}
		}
		else
		{
			$this->jsonp(false, '注册失败');
		}
	}

	/**
	 * 登陆页面
	 */
	public function actionLogin()
	{
		if(!$this->userinfo)
		{
			$this->renderPartial('login');
		}
		else
		{
			$this->redirect('/');
		}
	}

	/**
	 * 登录提交
	 */
	public function actionLogin_submit()
	{
		// 参数
		$username = trim(Yii::app()->request->getParam('username'));
		$password = Yii::app()->request->getParam('password');

		if(!$username)
		{
			$this->jsonp(false, '用户名不能为空');
		}

		$cdb = new CDbCriteria();
		$cdb->condition = "username = :username OR email = :username";
		$cdb->params = array(":username"=>$username);
		$row = User::model()->find($cdb);
		if(!$row || $row->password != $this->hash_password($password))
		{
			$this->jsonp(false, '用户名，邮箱或密码错误');
		}

		// 登录
		$identity = new MyUserIdentity($username, $password);
		if($identity->authenticate())
		{
			Yii::app()->user->login($identity, 3600*24*7);
			$this->jsonp(true);
		}
		else
		{
			$this->jsonp(false, '登录失败');
		}
	}

	/**
	 * 我的账户
	 */
	public function actionMine()
	{
		if(!$this->userinfo)
		{
			$this->redirect('/');
		}

		$this->render('mine');
	}

	/**
	 * 修改密码
	 */
	public function actionEdit_password()
	{
		if(!$this->userinfo)
		{
			$this->redirect('/');
		}

		// 参数
		$is_submit = trim(Yii::app()->request->getParam('is_submit'));
		$old_password = Yii::app()->request->getParam('old_password');
		$new_password = Yii::app()->request->getParam('new_password');
		$new_re_password = Yii::app()->request->getParam('new_re_password');

		$row = User::model()->findByPk($this->userinfo->id);
		if(!$row)
		{
			$this->redirect('/');
		}

		// 提交
		if($is_submit)
		{
			if($row->password != $this->hash_password($old_password))
			{
				$this->jsonp(false, '旧密码错误');
			}

			if(!$new_password || strlen($new_password) < 6)
			{
				$this->jsonp(false, '新密码不能小于6位');
			}

			if($new_password != $new_re_password)
			{
				$this->jsonp(false, '两次新密码输入不一致');
			}

			$row->password = $this->hash_password($new_password);
			if($row->save())
			{
				$this->jsonp(true);
			}
			else
			{
				$this->jsonp(false, '修改失败');
			}
		}
	}

	/**
	 * 退出
	 */
	public function actionLogin_out()
	{
		$refer = trim(Yii::app()->request->getParam('refer'));
		Yii::app()->user->logout();

		if(!$refer)
			$refer = '/';

		$this->jsonp(true, '', '', $refer);
	}

	/**
	 * 验证码
	 */
	public function actionSeccode()
	{
		echo MySecCode::show();
	}
}