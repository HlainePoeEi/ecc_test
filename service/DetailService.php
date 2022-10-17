<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_DetailDao.php';
require_once 'service/BaseService.php';

/**
 * 詳細サービス
 */
class DetailService extends BaseService{

	public function getWritingData($course_detail_no) {

		// データベース接続
		$dao = new T_DetailDao();
		return $dao-> getWritingData($course_detail_no);
	}

	public function getSpeakingQuestion($course_detail_no) {

		// データベース接続
		$dao = new T_DetailDao();
		return $dao-> getSpeakingQuestion($course_detail_no);
	}

	public function getWritingFeedbackAllData($form){

		// データベース接続
		$dao = new T_DetailDao();
		return $dao-> getWritingFeedbackData($form->org_no, $form->student_no, $form->course_id, '', $form->offer_no, $form->test_kbn);
	}

	public function getWritingFeedbackData($form){

		// データベース接続
		$dao = new T_DetailDao();
		return $dao-> getWritingFeedbackData($form->org_no, $form->student_no,  $form->course_id, $form->course_detail_no, $form->offer_no, $form->test_kbn);
	}

	/*SpeakingFeedback一覧*/

	public function getSpeakingCourseListByStudent($org_no, $student_no, $offer_no){

		$dao = new T_DetailDao();
		return $dao->getSpeakingCourseListByStudent($org_no, $student_no, $offer_no);
	}

	public function getCoursesAnswerByStudent($student_no, $offer_no, $course_id, $test_kbn){

		$dao = new T_DetailDao();
		return $dao->getCoursesAnswerByStudent($student_no, $offer_no, $course_id, $test_kbn);
	}

	public function getCoursesFinishByStudent($student_no, $offer_no, $course_id, $test_kbn){

		$dao = new T_DetailDao();
		return $dao->getCoursesFinishByStudent($student_no, $offer_no, $course_id, $test_kbn);
	}

	public function getCourseDetailList($form , $flg){
		// データベース接続
		$dao = new T_DetailDao();
		// ユーザ名とパスワード取得
		return $dao->getCourseDetailList($form, $flg);
	}

	// コースデータ更新
	public function delCourseDetailData($dto) {

		// データベース接続
		$dao = new T_DetailDao($this->pdo);

		return $dao->delCourseDetailData( $dto );
	}

	// コースンデータ取得
	public function getCourseDetailInfo($form) {

		// データベース接続
		$dao = new T_DetailDao($this->pdo);

		return $dao->getCourseDetailInfo($form);
	}

	// 次のコース番号取得
	public function getNextCourseDetailNo() {

		// データベース接続
		$dao = new T_DetailDao($this->pdo);
		return $dao->getNextCourseDetailNo();
	}

	// コース番号の重複チェック処理
	public function checkExistDetailInfo($dto) {

		// データベース接続
		$dao = new T_DetailDao($this->pdo);

		return $dao->checkExistDetailInfo($dto);
	}

	// コースデータ登録
	public function registCourseDetailData($dto) {

		// データベース接続
		$dao = new T_DetailDao($this->pdo);

		return $dao->insert ( $dto );
	}

	// コースデータ更新
	public function updateCourseDetailData($dto) {

		// データベース接続
		$dao = new T_DetailDao($this->pdo);

		return $dao->updateCourseDetailData( $dto );
	}
}

?>