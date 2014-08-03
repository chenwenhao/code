<?php
class MyController extends CController
{
	public $css; // 网页样式
	public $js; //脚本
	public $pageTitle; // 网页标题
	public $keywords; // 网页关键词
	public $description; // 网页描述
	public $userinfo; // 登录用户信息
	public $nav_menu; // 导航菜单
	public $category_id = 0;

	public function init()
	{
		parent::init();
		
		self::getUserinfo(); // 当然用户登录信息
	}

	/**
	 * 得到前台登录用户的信息
	 */
	public function getUserinfo()
	{
		if(!Yii::app()->user->isGuest && !$this->userinfo)
		{
			$user_id = Yii::app()->user->getState('user_id');
			if($user_id)
			{
				$this->userinfo = User::model()->findByPk($user_id);
			}
		}
		return $this->userinfo;
	}

	/**
	 * 静态样式的分页处理
	 */
	static public function page($page_html)
	{
		$page_html = preg_replace('/\.html?\?page=([\d]+)/', "_\$1.html", $page_html);
		echo $page_html;
	}

	/**
	 * 截取字符串
	 */
	static public function cutStr($str, $lenght) {
		$str = strip_tags($str);
		if (strlen($str) <= $lenght) {
			return($str);
		} else {
			$not_zh_len = 0;

			for ($i = 0; $i < $lenght; $i++) {
				if (ord(substr($str, $i, 1)) < 128) {
					$not_zh_len = $not_zh_len + 1;
				}
			}

			if ($lenght % 3 == 0 && $not_zh_len % 3 == 1 ) {
				$lenght = $lenght + 1;
			}
			else if ($lenght % 3 == 0 && $not_zh_len % 3 == 2 ) {
				$lenght = $lenght + 2;
			}
			else if ($lenght % 3 == 1 && $not_zh_len % 3 == 0 ) {
				$lenght = $lenght + 2;
			}
			else if ($lenght % 3 == 1 && $not_zh_len % 3 == 2 ) {
				$lenght = $lenght + 1;
			}
			else if ($lenght % 3 == 1 && $not_zh_len % 3 == 3 ) {
				$lenght = $lenght + 1;
			}
			else if ($lenght % 3 == 2 && $not_zh_len % 3 == 1 ) {
				$lenght = $lenght + 2;
			}
			else if ($lenght % 3 == 2 && $not_zh_len % 3 == 3 ) {
				$lenght = $lenght + 2;
			}
			else if ($lenght % 3 == 2 && $not_zh_len % 3 == 0 ) {
				$lenght = $lenght + 1;
			}

			return(substr($str, 0, $lenght) . '…');
		}
	}

	// 判断中文字符个数
	static public function str_word_count_utf8($string, $format = 0)
	{
		$string =  $string = preg_replace("/～|！|｀|·|＃|￥|％|…|—|（|）|＋|－|＝|｛|｝|［|］|\＼|｜|“|”|’|‘|；|：|《|》|〈|〉|、|？|。|，/",' ',$string);
		$string = preg_replace('/[\x80-\xff]{3}/', ' a ', $string);
		switch ($format)
		{
			case 1:
				preg_match_all(WORD_COUNT_MASK, $string, $matches);
				return $matches[0];
			case 2:
				preg_match_all(WORD_COUNT_MASK, $string, $matches, PREG_OFFSET_CAPTURE);
				$result = array();
				foreach ($matches[0] as $match)
				{
					$result[$match[1]] = $match[0];
				}
				return $result;
		}
		return preg_match_all(WORD_COUNT_MASK, $string, $matches);
	}

	/**
	 * 密码加密
	 */
	static public function hash_password($password)
	{
		return md5(md5($password));
	}

	/**
	 * 得到用户的IP
	 */
	static public function getUserHostAddress()
	{
		switch(true)
		{
			case ($ip=getenv("HTTP_X_FORWARDED_FOR")):
				break;
			case ($ip=getenv("HTTP_CLIENT_IP")):
				break;
			default:
				$ip=getenv("REMOTE_ADDR") ? getenv("REMOTE_ADDR") : '127.0.0.1';
		}
		if (strpos($ip, ', ') > 0)
		{
			$ips = explode(', ', $ip);
			$ip = $ips[0];
		}
		return $ip;
	}

	/**
	 * ######
	 * @desc
	 * 判断是否为正确的手机号码
	 *
	 * @param
	 * String $mobile // 手机号码
	 *
	 * @return
	 * 返回Bool值，成功返回TRUE,失败返回FALSE
	 *
	 * @example
	 */
	static public function isMobilePhone($mobile)
	{
		$regex = "/13[0-9]{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|18[0|2|5|6|7|8|9]\d{8}/";
		preg_match($regex, $mobile, $phone);
		if(!empty($phone))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	// 计算中文字符串长度
	static public function utf8Strlen($string = null) 
	{
		preg_match_all("/./us", $string, $match);
		return count($match[0]);
	}

	/**
	 * 邮箱验证
	 */
	static public function checkEmail($email)
	{
		$reg = "/([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?/i";
		if(preg_match($reg, $email))
			return true;
		return false;
	}

	/**
	 * jsonp方式返回数据
	 */
	static public function jsonp($is_ok = true, $msg = '', $moredata = NULL, $refer = '')
	{
		$callback = trim(Yii::app()->request->getParam('callback'));
		$data = array();
		$data['status'] = $is_ok;
		$data['msg'] = $msg;
		$data['data'] = $moredata;
		$data['refer'] = $refer;
		if(!$callback)
		{
			echo (json_encode($data));exit;
		}
		echo ($callback . '(' . json_encode($data) . ');');
		exit;
	}

	/**
	* @desc 返回每页的中间页码
	 * $count 总页数
	 * $page 当前页号
	 * $num 显示的页码数
	 * @return $arr
	 */
	static public function pagebar($count, $page, $num)
	{
		$num = min($count, $num); //处理显示的页码数大于总页数的情况
		if($page > $count || $page < 1) return; //处理非法页号的情况
		$end = $page + floor($num/2) <= $count ? $page + floor($num/2) : $count; //计算结束页号
		$start = $end - $num + 1; //计算开始页号
		if($start < 1)
		{ //处理开始页号小于1的情况
			$end -= $start - 1;
			$start = 1;
		}
		for($i=$start; $i<=$end; $i++)
		{
			$arr[] = $i;
		}
		return $arr;
	}

	public static function get_url($url,$ispost = FALSE,$post_data=null)
    {
        //启动一个CURL会话
        $ch = curl_init();

        // 要访问的地址
        curl_setopt($ch, CURLOPT_URL, $url);

        // 对认证证书来源的检查，0表示阻止对证书的合法性的检查。
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        //模拟用户使用的浏览器，在HTTP请求中包含一个”user-agent”头的字符串。
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");

        //发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
        if ($ispost)
        {
            curl_setopt($ch, CURLOPT_POST, 1);
            //要传送的所有数据，如果要传送一个文件，需要一个@开头的文件名
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }

        

        //连接关闭以后，存放cookie信息的文件名称
        #curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);

        // 包含cookie信息的文件名称，这个cookie文件可以是Netscape格式或者HTTP风格的header信息。
        #curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);

        // 设置curl允许执行的最长秒数
        //curl_setopt($ch, CURLOPT_TIMEOUT, 6);

        // 获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

        // 执行操作
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE);

        // 关闭CURL会话
        curl_close($ch);
        return array('code'=>$httpcode,'content'=>$result);
    }

    /**
     * js提示
     */
    public static function alert($msg)
    {
    	echo '<script type="text/javascript">alert(\''. $msg .'\');history.go(-1);</script>';die;
    }
}