<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_TeacherDao.php';
require_once 'service/BaseService.php';

class TeacherService extends BaseService{

	public function getTeacherList($form , $flg) {
		// データベース接続
		$dao = new T_TeacherDao();
		// ユーザ名とパスワード取得
		return $dao->getTeacherList($form, $flg);
	}

	public function getTeacherInfo($teacher_no) {
		// データベース接続
		$dao = new T_TeacherDao();
		// ユーザ名とパスワード取得
		return $dao->getTeacherInfo($teacher_no);
	}

	public function checkedExistInfo($login_id) {
		// データベース接続
		$dao = new T_TeacherDao();
		// ユーザ名とパスワード取得
		return $dao->checkedExistInfo($login_id);
	}

	public function updateTeacherInfo($form) {
		// データベース接続
		$dao = new T_TeacherDao();
		// ユーザ名とパスワード取得
		return $dao->updateTeacherInfo($form);
	}

	public function insertData($dto) {
		// データベース接続
		$dao = new T_TeacherDao();
		// ユーザ名とパスワード取得
		return $dao->insertData($dto);
	}

	public function getNextId(){
		// データベース接続
		$dao = new T_TeacherDao();
		return $dao-> getNextId();
	}
}
?>