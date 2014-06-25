<?php 
/**
 * 书本采集脚本
 */
class Book_collectCommand extends CConsoleCommand
{
	public function actionIndex()
	{
		$links = array();
		for ($i=1; $i<5; $i++) { 
			$links[] .= 'http://www.lkong.net/book/'. $i .'.html';
		}

		foreach ($links as $key => $value) {
			$content = MyController::get_url($value);
			
			//
		}
	}


}
?>