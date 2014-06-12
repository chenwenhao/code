<?php
class MyImgUploader
{
	/**
	 * 
	 * 上传文件。注意，此方法暂时不区分文件的类型，所以不保证安全。
	 * @param string $name
	 * @param string $savepath
	 * @param string $access_path
	 * @return 返回数组，status 正常/错误  savefile 硬盘路径  url 访问URL
	 */
	public static function upload($name,$savepath,$access_path)
	{
		$return  = array('status'=>'ok', 'savefile'=>'', 'url'=>'', 'thumb_url'=>'');
		if(!empty($_FILES[$name]['name']) && $_FILES[$name]['error'] === UPLOAD_ERR_OK)
		{
			$upload = CUploadedFile::getInstanceByName($name);
			if($upload)
			{
				//按时间分文件夹
				$attachDir = $savepath .'/day_'. date('ymd');
				if(!is_dir($attachDir))
				{
					@mkdir($attachDir, 0755);
					@fclose(fopen($attachDir .'/index.html', 'w'));
				}
				//保存文件
				$newFilename = date("His") . str_replace(' ', '', $_FILES[$name]['name']);
				$upload->saveAs($attachDir .'/'. $newFilename);

				// 生成缩略图
				$thumb_path = $savepath. '/thumb/day_'. date('ymd') .'/';
				if(!file_exists($thumb_path))
				{
					@mkdir($thumb_path);
					Thumb::img2thumb($attachDir .'/'. $newFilename, $thumb_path . $newFilename); 
				}
				
				//TODO 可能有FTP等其他操作
				$return['savefile'] = $attachDir .'/'. $newFilename;
				$return['thumb_url'] = '/'. $thumb_path . $newFilename;
				$return['url'] = $access_path . substr($return['savefile'], strlen($savepath));
			}
		}
		return $return;
	}
}