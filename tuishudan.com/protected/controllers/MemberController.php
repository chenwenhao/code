<?php
/**
 * 会员-主控制器
 * @author xiaoling
 */
class MemberController extends MyController
{
	public function init()
	{
		$this->userinfo = $this->getUserinfo();
	}

	/**
	 * 注册
	 */
	public function actionRegister_submit()
	{
		// 参数
		$is_submit = trim(Yii::app()->request->getParam('is_submit'));
		$openid = trim(Yii::app()->request->getParam('openid'));
		$nickname = Yii::app()->request->getParam('nickname');
		$gender = Yii::app()->request->getParam('gender');
		$login_msg = Yii::app()->request->getParam('login_msg');
		$refer = trim(Yii::app()->request->getParam('refer'));
		$avatar = trim(Yii::app()->request->getParam('avatar'));
		$login_from = Yii::app()->request->getParam('login_from');

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
				$this->redirect($refer);
			}
		}
		
		$row = new User();
		$row->openid = $openid;
		$row->name = $nickname;
		$row->gender = $gender;
		$row->login_msg = $login_msg;
		$row->avatar = $avatar;
		$row->login_from = $login_from;
		if($row->save())
		{
			// 注册成功后直接登录
			$identity = new MyUserIdentity($openid, '');
			if($identity->authenticate())
			{
				Yii::app()->user->login($identity, 3600*24*7);
				$this->redirect($refer);
			}
		}
		else
		{
			$this->jsonp(false, '注册失败');
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
		$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );
		$this->redirect($code_url);
	}

	public function actionSina_back()
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
			Yii::app()->session['wb_token'] = $token;

			$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$token['access_token']);
			$uid_get = $c->get_uid();
			$uid = $uid_get['uid'];
			$uinfo = $c->show_user_by_id($uid);//根据ID获取用户等基本信息
			$login_msg = json_encode($uinfo);
			$refer = urlencode('http://www.tuishudan.com');
			if ($uinfo) {
				$url = '/member/register_submit?openid=';
				$url .= $uid .'&nickname='. $uinfo['name'];
				$url .= '&gender='. $uinfo['gender'];
				$url .= '&login_msg='. $login_msg;
				$url .= '&refer='. $refer;
				$url .='&avatar='. $uinfo['profile_image_url'];
				$url .='&login_from=2';
				$this->redirect($url);
			}
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
		$refer = urlencode('http://www.tuishudan.com');

		$login_msg = json_encode($uinfo);

		if ($uinfo) {
			$this->redirect('/member/register_submit?openid='. $oid .'&nickname='. $uinfo['nickname'] .'&gender='. $uinfo['gender'] .'&login_msg='. $login_msg . '&refer='. $refer . '&avatar='. $uinfo['figureurl'].'&login_from=1');
		}
	}

	/**
	 * 用户加书 - 显示
	 */
	public function actionBook_add()
	{
		if (! $this->userinfo) {
			echo '<script>alert("请先登录");window.location.href="/";</script>';
		}

		$this->pageTitle = '推书单 - 用户加书';
		$this->css = 'book_add';
		$this->render('book_add');
	}

	/**
	 * 用户加书 - 提交
	 */
	public function actionAdd_book_submit()
	{
		if (! $this->userinfo) {
			$this->jsonp(false, '请先登录');
		}

		// 参数
		$is_submit = trim(Yii::app()->request->getParam('is_submit'));
		$book_name = trim(Yii::app()->request->getParam('book_name'));
		$url = trim(Yii::app()->request->getParam('url'));
		$intro = trim(Yii::app()->request->getParam('intro'));

		// 提交
		if ($is_submit)
		{
			if(! $book_name) {
				$this->jsonp(false, '书名不能为空');
			}

			// 查询书本是否已添加过
			$exsit = Books::model()->getBookByName($book_name);
			if ($exsit) {
				$this->jsonp(false, '书本已添加');
			}

			// 入库
			$book = new Books();
			$book->name = $book_name;
			$book->from = $url;
			$book->intro = $intro;
			$book->uid = $this->userinfo->id;
			if ($book->save())
			{
				$this->jsonp(true, '添加成功，请等待审核');
			}
		}
	}

	/**
	 * 检查书名是否存在
	 */
	public function actionCheck_book_name()
	{
		$book_name = trim(Yii::app()->request->getParam('book_name'));
		$exsit = Books::model()->getBookByName($book_name);
		if ($exsit) {
			$this->jsonp(false, '书本已添加');
		}
	}

	/**
	 * 我的书库
	 */
	public function actionMybook()
	{
		if (!$this->userinfo) {
			echo '<script>alert("请先登录");window.location.href="/";</script>';die;
		}
		
		$page = intval(Yii::app()->request->getParam('page', 1)) - 1;
		$like = trim(Yii::app()->request->getParam('like'));

		if (!$like) {
			$like = 'yes';
		}

		$cdb = new CDbCriteria();
		if ($like == 'yes') {
			$cdb->addCondition("status = 2");
		}
		if ($like == 'no') {
			$cdb->addCondition("status = 1");
		}
		$cdb->addCondition("uid = ". $this->userinfo->id);

		// 分页
		$count = User_book::model()->count($cdb);
		$pages = new CPagination($count);
		$pages->pageSize = 2;
		$pages->currentPage = $page;
		$pages->applyLimit($cdb);
		$rows = User_book::model()->findAll($cdb);

		// 显示
		$data = array('rows' => $rows, 'pages' => $pages, 'page' => $page, 'like' => $like, 'count' => $count);
		$this->pageTitle = '推书单 - 我的书库';
		$this->css = 'mybook';
		$this->render('mybook', $data);
	}
}