<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_CourseDao.php';
require_once 'service/BaseService.php';

class CourseService extends BaseService{

	public function getCourseList($form , $flg) {
		// データベース接続
		$dao = new T_CourseDao();
		// ユーザ名とパスワード取得
		return $dao->getCourseList($form, $flg);
	}

	public function getCourseLevel() {
		// データベース接続
		$dao = new T_CourseDao();
		// ユーザ名とパスワード取得
		return $dao->getCourseLevel();
	}

	public function getTestKbn() {
		// データベース接続
		$dao = new T_CourseDao();
		// ユーザ名とパスワード取得
		return $dao->getTestKbn();
	}

	// 次のコース番号取得
	public function getNextCourseNo() {

		// データベース接続
		$dao = new T_CourseDao ($this->pdo);
		return $dao->getNextCourseNo();
	}

	// コース番号の重複チェック処理
	public function checkExistCourseInfo($dto) {

		// データベース接続
		$dao = new T_CourseDao ($this->pdo);

		return $dao->checkExistCourseInfo($dto);
	}

	// コースデータ登録
	public function registCourseData($dto) {

		// データベース接続
		$dao = new T_CourseDao ($this->pdo);

		return $dao->insert ( $dto );
	}

	// コースンデータ取得
	public function getCourseInfo($form) {

		// データベース接続
		$dao = new T_CourseDao($this->pdo);

		return $dao->getCourseInfo($form);
	}

	// コースデータ更新
	public function updateCourseData($dto) {

		// データベース接続
		$dao = new T_CourseDao($this->pdo);

		return $dao->updateCourseData( $dto );
	}

	// コースデータ更新
	public function delCourseData($dto) {

		// データベース接続
		$dao = new T_CourseDao($this->pdo);

		return $dao->delCourseData( $dto );
	}

	// 条件によるコース契約を取得する
	public function getCourseContractList($dto, $flg) {

		// データベース接続
		$dao = new T_CourseDao($this->pdo);

		return $dao->getCourseContractList( $dto, $flg );
	}

	// 条件によるコース契約確認データを取得する
	public function getCourseContractConfirmList($form , $flg) {
		// データベース接続
		$dao = new T_CourseDao();
		// ユーザ名とパスワード取得
		return $dao->getCourseContractConfirmList($form, $flg);
	}

	// コースデータ取得
	public function getSWPracticeCourseList($param, $flg){

		// データベース接続s
		$dao = new T_CourseDao($this->pdo);
		return $dao->getSWPracticeCourseList($param, $flg);
	}
}
?>