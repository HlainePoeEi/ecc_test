<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseService.php';
require_once 'helper/LogHelper.php';
require_once 'util/CommonUtil.php';
require_once 'dao/M_OrganizationDao.php';
require_once 'dao/M_LessonDao.php';
require_once 'dao/M_Lesson_ManagerDao.php';


class LessonService extends BaseService {

	/* レッソン名重複のチェック　*/
	public function checkedLessonExistInfo($org_no,$lesson_name) {
		// データベース接続
		$lessDao = new M_LessonDao( $this->pdo );
		return  $lessDao->checkedLessonExistInfo($org_no,$lesson_name);
	}

	/* 学年情報取得　*/
	public function getGradetListByName($org_no,$grade_name) {
		// データベース接続
		$gradeDao = new M_LessonDao($this->pdo);
		return  $gradeDao->getGradetListByName($org_no,$grade_name);
	}

	/* 科目情報取得　*/
	public function getSubjectListByName($org_no,$subject_name) {
		// データベース接続
		$subDao = new M_LessonDao( $this->pdo );
		return  $subDao->getSubjectListByName($org_no,$subject_name);
	}

	/* 科目の担当者情報取得　*/
	public function getManagerListBySubject($org_no,$subject_no,$mLoginIdArr) {
		// データベース接続
		$subDao = new M_LessonDao( $this->pdo );
		return  $subDao->getManagerListBySubject($org_no,$subject_no,$mLoginIdArr);
	}

	/* 次のレッスン番号取得　*/
	public function getNextLessonNo() {
		// データベース接続
		$dao = new M_LessonDao();
		return $dao->getNextLessonNo();
	}

	/* レッスン情報登録処理　*/
	public function insertData($less_dto,$lm_dto_arr) {
		// データベース接続
		$dao = new M_LessonDao($this->pdo);
		$res=$dao->insertData($less_dto,$lm_dto_arr , $this->pdo);
		return $res;
	}
	/**
	 * データ抽出ためレッスン情報を取得処理
	 * @param $org_no:組織№
	 * @param $param:画面からのデータ
	 * @return リスト
	 */
	public function getLessonCsvData($org_no,$param) {
		// データベース接続
		$dao = new M_LessonDao();
		// データ抽出ためレッスン情報を取得
		return $dao->getLessonCsvData($org_no,$param);
	}

	public function getLessonGroupStudentCsvData($params) {
		// データベース接続
		$dao = new M_LessonDao();
		// データ抽出ためレッスン．グループ．受講者情報を取得
		return $dao->getLessonGroupStudentCsvData($params);
	}
}

?>