<?php
/**
 * 书控制器
 * @author xiaoling
 */
class BookController extends MyController
{
	/**
	 * 书本打分
	 */
	public function actionScore()
	{
		// 参数
		$book_id = intval(Yii::app()->request->getParam('book_id'));
		$score = intval(Yii::app()->request->getParam('score'));

		// 判断书是否存在
		$book = Books::model()->findByPk($book_id);
		if (!$book || !$book_id) {
			$this->jsonp(false, '书本不存在');
		}

		$status = 2;
		if ($score > 0) {
			$status = 1;
		}

		$cdb = new CDbCriteria();
		$cdb->condition = "book_id = ". $book_id;
		$user_book = User_book::model()->find($cdb);
		if (!$user_book) {
			$user_book = new User_book();
		}

		$user_book->uid = $this->userinfo->id;
		$user_book->book_id = $book_id;
		$user_book->score = $score;
		$user_book->status = $status;
		$user_book->add_time = time();
		if ($status == 2) {
			$msg = "标记";
		}else {
			$msg = "评分";
		}
		if ($user_book->save()) {
			$this->jsonp(true, $msg.'成功');
		} else {
			$this->jsonp(false, $msg.'失败');
		}
	}

	/**
	 * 删除评分
	 */
	public function actionDel_score()
	{
		$book_id = intval(Yii::app()->request->getParam('book_id'));

		$cdb = new CDbCriteria();
		$cdb->condition = "book_id = ". $book_id;
		$row = User_book::model()->find($cdb);
		if (!$row || !$book_id) {
			$this->jsonp(false, '记录不存在');
		}

		if ($row->delete()) {
			$this->jsonp(true, '删除成功');
		} else {
			$this->jsonp(false, '删除失败');
		}
	}
}