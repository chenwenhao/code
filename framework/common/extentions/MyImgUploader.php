<?php
class MyImgUploader
{
	/**
	 * 上传文件。注意，此方法暂时不区分文件的类型，所以不保证安全。
	 * @param string $name // 表单里面的名字
	 * @param string $savepath
	 * @param string $access_path
	 * @return 返回数组，status 正常/错误  savefile 硬盘路径  url 访问URL
	 */
	public static function upload($name, $savepath, $access_path, $thumb = 0, $filename = '')
	{
		$return  = array('status' => 'ok', 'savefile' => '', 'url' => '', 'thumb_url' => '');

		if (!empty($_FILES[$name]['name']) && $_FILES[$name]['error'] === UPLOAD_ERR_OK) {

			$upload = CUploadedFile::getInstanceByName($name);
			if ($upload) {

				// 判断保存图片的路径是否存在
				if(!is_dir($savepath))
				{
					@mkdir($savepath, 0755);
					@fclose(fopen($savepath .'/index.html', 'w'));
				}

				// 图片名
				$ext = array_pop(explode('.', $_FILES[$name]['name']));
				if(!$filename)
				{
					$newFilename = date("His") . $ext;
				}
				else
				{
					$newFilename = $filename . $ext;
				}
				
				// 保存图片
				$upload->saveAs($savepath .'/'. $newFilename);

				if($is_thumb)
				{
					// 生成缩略图
					$thumb_path = $savepath . '/thumb/';
					if(!file_exists($thumb_path))
					{
						@mkdir($thumb_path);
						Thumb::img2thumb($attachDir .'/'. $newFilename, $thumb_path . $newFilename); 
					}
				}
				
				//TODO 可能有FTP等其他操作
				$return['savefile'] = $savepath . $newFilename;
				$return['thumb_url'] = $thumb_path . $newFilename;
				$return['url'] = $access_path . substr($return['savefile'], strlen($savepath));
			}
		}
		return $return;
	}

	/**
	 * 书本封面图上传
	 * @param $name 表单里面的名字
	 * @param $book_id 书本ID
	 */
	public static function upload_cover_img($name, $book_id)
	{
		if (! $book_id) {
			return false;
		}

		if (! empty($_FILES[$name]['name']) && $_FILES[$name]['error'] === UPLOAD_ERR_OK) {

			$upload = CUploadedFile::getInstanceByName($name);
			if ($upload) {

				$arr = explode('.', $_FILES[$name]['name']);
				$ext = array_pop($arr); // 图片扩展名
				$filename = $book_id .'.'. $ext; // 封面图名字

				// 查询删除旧图片
				$book = Books::model()->findByPk($book_id);
				if ($book && file_exists(Yii::app()->params['cover_img_path'] . $book->cover_img)) {
					@unlink(Yii::app()->params['cover_img_path'] . $book->cover_img);
				}

				// 保存图片
				if ($upload->saveAs(Yii::app()->params['cover_img_path'] . $filename)) {
					return $filename;
				}
			}
		}

		return false;
	}
}