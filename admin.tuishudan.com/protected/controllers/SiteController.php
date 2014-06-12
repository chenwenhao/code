<?php
/**
 * 后台主控制器
 * @author xiaoling
 */
class SiteController extends Controller
{
	/**
	 * 主页
	 */
	public function actionIndex()
	{
		// 显示
		$this->pageTitle = '后台首页';
		$data = array();
		$this->render('index', $data);
	}

	/**
	 * 登录页
	 */
	public function actionLogin()
	{
		// 参数
		$is_submit = trim(Yii::app()->request->getParam('is_submit'));
		$username = trim(Yii::app()->request->getParam('username'));
		$password = trim(Yii::app()->request->getParam('password'));

		// 提交
		if($is_submit)
		{
			if(!$username)
				self::showMsg('请填写用户名');
			if(!$password)
				self::showMsg('请填写密码');

			// 登录
			$identity = new MyUserIdentity($username, $password);
			if(!$identity->admin_authenticate())
			{
				self::showMsg('用户名或密码错误');
			}
			else
			{
				Yii::app()->user->login($identity, 3600); // 设置登录过期时间
				$this->redirect('/site/index');
			}
		}
		else
		{
			self::showMsg('请登录');
		}
	}

	/**
	 * 注销
	 */
	public function actionLogin_out()
	{
		$refer = Yii::app()->request->getParam('refer');
		$forward = Yii::app()->request->getParam('forward');
		if(!$refer)
		{
			$refer = '/';
		}
		if(!$forward)
		{
			$forward = '/';
		}

		Yii::app()->user->logout();
		if($refer && $forward == '/')
		{
			$this->redirect($refer);
		}
	}

	/**
	 * 显示错误信息函数
	 */
	private function showMsg($msg)
	{
		$this->renderPartial('login', array('msg'=>$msg));
		die;
	}
}