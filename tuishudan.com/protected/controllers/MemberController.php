<?php
/**
 * 会员-主控制器
 * @author xiaoling
 */
class MemberController extends MyController
{
	public function init()
	{
		//Yii::app()->layout = '//layouts/member';
		$this->userinfo = $this->getUserinfo();
	}

	/** 
	 * 注册显示
	 */
	public function actionRegister()
	{
		$this->css = 'register';
		$this->js = 'register';
		// 显示
		$this->render('register');
	}

	public function actionRegister_submit()
	{
		// 参数
		$is_submit = trim(Yii::app()->request->getParam('is_submit'));
		$openid = trim(Yii::app()->request->getParam('openid'));
		$nickname = Yii::app()->request->getParam('nickname');
		$gender = Yii::app()->request->getParam('gender');
		$login_msg = Yii::app()->request->getParam('login_msg');

		// 提交
		if(!$openid || !$nickname || !$gender)
		{
			$this->jsonp(false, '参数错误');
		}

		// 用户或邮箱 已经存在
		$cdb = new CDbCriteria();
		$cdb->condition = "openid = :openid";
		$cdb->params = array(":openid" => $openid);
		$exsit = User::model()->find($cdb);
		if($exsit)
		{
			$identity = new MyUserIdentity($exsit->openid, '');
			if($identity->authenticate())
			{
				Yii::app()->user->login($identity, 3600*24*7);
				$this->jsonp(true, '', '', $refer);
			}
		}
		
		$row = new User();
		$row->openid = $openid;
		$row->name = $nickname;
		$row->gender = $gender;
		$row->login_msg = $login_msg;
		if($row->save())
		{
			// 注册成功后直接登录
			$identity = new MyUserIdentity($openid, '');
			if($identity->authenticate())
			{
				Yii::app()->user->login($identity, 3600*24*7);
				$this->jsonp(true, '', '', $refer);
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
			$this->css = 'login';
			$this->js = 'login';
			$this->render('login');
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
		$openid = trim(Yii::app()->request->getParam('openid'));
		$refer = trim(Yii::app()->request->getParam('refer'));

		if(!$openid)
		{
			$this->jsonp(false, 'openid不能为空');
		}

		$cdb = new CDbCriteria();
		$cdb->condition = "openid = :openid";
		$cdb->params = array(":openid"=>$openid);
		$row = User::model()->find($cdb);
		if(!$row)
		{
			$this->jsonp(false, '用户不存在');
		}

		// 登录
		$identity = new MyUserIdentity($openid);
		if($identity->authenticate())
		{
			Yii::app()->user->login($identity, 3600*24*7);
			$this->jsonp(true, '', '', $refer);
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

		$this->css = 'mine';
		$this->render('mine');
	}

	/*
	 修改资料-显示
	 */
	public function actionProfile_edit()
	{
		if(!$this->userinfo)
		{
			$this->redirect('/');
		}

		$row = User::model()->findByPk($this->userinfo->id);
		if(!$row)
		{
			$this->redirect('/');
		}

		$data['row'] = $row;
		$this->css = 'profile_edit';
		$this->js = 'profile_edit';
		$this->render('profile_edit', $data);
	}
	

	/**
	 * 修改资料-提交
	 */
	public function actionProfile_edit_submit()
	{
		// 参数
		$user_id = intval(Yii::app()->request->getParam('user_id'));
		$password = Yii::app()->request->getParam('password');
		$email = trim(Yii::app()->request->getParam('email'));
		$avatar = trim(Yii::app()->request->getParam('avatar'));
		$name = trim(Yii::app()->request->getParam('name'));

		$row = User::model()->findByPk($user_id);
		if(!$row)
		{
			$this->jsonp(false, '账号不存在');
		}

		// 提交
		if(!$password)
		{
			$password = $row->password;
		}
		else
		{
			$password = $this->hash_password($password);
		}

		if($avatar)
		{
			$avatar = $avatar;
		}
		else
		{
			$avatar = $row->avatar;
		}

		$row->name = $name;
		$row->password = $password;
		$row->email = $email;
		$row->avatar = $avatar;
		if($row->save())
		{
			$this->jsonp(true);
		}
		else
		{
			$this->jsonp(false, '修改失败');
		}
	}

	/*
	 上传头像
	 */
	public function actionUp_avatar()
	{
		$save_path = APP_ROOT .'/public/avatar/';  //图片存储路径
		$save_pic_name = $this->userinfo->id;  //图片存储名称

		$file_src = $save_path . $save_pic_name . '_src.jpg';
		$filename162 = $save_path .'/big/'. $save_pic_name . '.jpg'; 
		$filename48 = $save_path .'/mid/'. $save_pic_name . '.jpg'; 
		$filename20 = $save_path .'/small/'. $save_pic_name . '.jpg';    

		$src = base64_decode($_POST['pic']);
		$pic1 = base64_decode($_POST['pic1']);   
		$pic2 = base64_decode($_POST['pic2']);  
		$pic3 = base64_decode($_POST['pic3']);  

		if($src) {
			file_put_contents($file_src, $src);
		}

		file_put_contents($filename162, $pic1);
		file_put_contents($filename48, $pic2);
		file_put_contents($filename20, $pic3);

		$rs['status'] = 1;
		//$rs['picUrl'] = '/avatar/'. $save_pic_name;
		$rs['picUrl'][0] = '/avatar/big/'. $save_pic_name . '.jpg';
		$rs['picUrl'][1] = '/avatar/mid/'. $save_pic_name . '.jpg';
		$rs['picUrl'][2] = '/avatar/small/'. $save_pic_name . '.jpg';

		print json_encode($rs);
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

	public function actionSina_login()
	{
        require 'libweibo/config.php';
        require 'libweibo/saetv2.ex.class.php';
		$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

		if (isset($_REQUEST['code'])) {
			$keys = array();
			$keys['code'] = $_REQUEST['code'];
			$keys['redirect_uri'] = WB_CALLBACK_URL;
			try {
				$token = $o->getAccessToken( 'code', $keys ) ;
			} catch (OAuthException $e) {
			}
		}

		if ($token) {
			$_SESSION['token'] = $token;
			setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
			echo 111;exit();
		} else {
			echo 2222;exit();
		}
	}

	public function actionTencent_login()
	{
		require_once("libtencent/qqConnectAPI.php");
		$qc = new QC();
		$qc->qq_login();
	}

	public function actionTencent_back()
	{
        require_once("libtencent/qqConnectAPI.php");
        $qc = new QC();
		$acs = $qc->qq_callback();
		$oid = $qc->get_openid();
		$qc = new QC($acs,$oid);
		$uinfo = $qc->get_user_info();
		$refer = trim(Yii::app()->request->getParams('refer'));

		$login_msg = json_encode($uinfo);

		if ($uinfo) {
			$this->redirect('/member/register_submit?openid='. $oid .'&nickname='. $uinfo['nickname'] .'&gender='. $uinfo['gender'] .'&login_msg='. $login_msg . '&refer='. $refer);
		}
        // var_dump($uinfo);
        // var_dump(Yii::app()->session);exit;
	}

	/**
	 * 用户加书
	 */
	public function actionBook_add()
	{
		$this->css = 'book_add';
		$this->render('book_add');
	}
}