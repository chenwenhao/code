<?php
/**
 * 主控制器
 * @author xiaoling
 */
class SiteController extends MyController
{
	/**
	 * 主页
	 */
	public function actionIndex()
	{
		$data = array();

		$this->renderPartial('index', $data);
	}
}