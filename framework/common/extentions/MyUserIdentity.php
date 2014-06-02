<?php
class MyUserIdentity extends CUserIdentity
{
	/**
	* 管理员验证
	*/
	public function admin_authenticate()
	{
		// 执行防注入处理
		$row = Admin::model()->find('username=:name', array(':name' => $this->username));
		if(!$row || $row->password !== MyController::hash_password($this->password))
		{
			return FALSE;
		}
		else
		{
			//更新登录后的信息
			$row->login_time = date('Y-m-d H:i:s', time());
			$row->login_ip = MyController::getUserHostAddress();
			$row->login_times = $row->login_times + 1;
			$row->save();

			$this->setState('admin_is_login', TRUE);
			$this->setState('uid', $row->id);
			$this->setState('username', $row->username);
			$this->setState('role',$row->role);
			$this->username = $row->username;

			return $row->id;
		}
	}
    
	/**
	* 用户登录
	*/
	public function authenticate()
	{
		$cdb = new CDbCriteria;
		$cdb->condition = "username = :username OR email = :username";
		$cdb->params = array(':username' => $this->username);
		$row = User::model()->find($cdb);

		if(!$row)
		{
			MyController::jsonp(false, '用户名不存在');
		}
		else
		{
            // 存放登录信息
			$this->setState('user_is_login', TRUE);
			$this->setState('user_id', $row->id);
			$this->setState('name', $row->name);
			$this->setState('username', $row->username);
			$this->username = $row->username;
			return $row->id;
		}
	}
}