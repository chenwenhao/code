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
		// 查询书
		$books = Books::model()->findAll();

		$data = array('books' => $books);
		$this->css = 'index';
		$this->render('index', $data);
	}

	/**
	 * 详细页
	 */
	public function actionBook()
	{
		// 参数
		$book_id = intval(Yii::app()->request->getParam('book_id'));

		// 判断书是否存在
		$book = Books::model()->findByPk($book_id);
		if (!$book || !$book_id) {
			$this->redirect('/');
		}

		$data = array('book' => $book);

		if (!$this->userinfo) {
			$user_book_info = User_book::model()->getUserbook($this->userinfo['id'],$book_id);			
		}

		$this->css = 'book';
		$this->render('book', $data);
	}
}