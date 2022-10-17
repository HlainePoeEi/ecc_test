<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_StudentDao.php';
require_once 'dto/T_StudentDto.php';
require_once 'dao/M_OrganizationDao.php';
require_once 'service/BaseService.php';

/**
 * 受講者サービス
 */
class StudentService extends BaseService{

	/* 受講者情報を登録処理 */
	public function insertWithTran($param){
		// データベース接続
		$dao = new T_StudentDao($this->pdo);
		// 受講者データを登録すること
		return $dao-> insertWithTran($param , $this->pdo);
	}

	/* 次の受講者管理№を取得する */
	public function getNextId(){
		// データベース接続
		$dao = new T_StudentDao();
		// Tシーケンステーブルから次の受講者管理№を取得する
		return $dao-> getNext();
	}

	/* データベースに受講者の存在チェック処理 */
	public function checkedExistInfo($org_no, $login_id){
		// データベース接続
		$itemDao = new T_StudentDao();
		// 受講者テーブルに記入した受講者が存在しているかどうかをチェックすること
		return $itemDao->checkedExistInfo($org_no, $login_id);
	}

	/* ログインIDの重複チェックのためログインIDを取得する処理 */
	public function getSutdentByNameLoginId($org_no, $login_id, $student_name){
		// データベース接続
		$itemDao = new T_StudentDao();
		return $itemDao->getSutdentByNameLoginId($org_no, $login_id, $student_name);
	}

	/* 受講者の有効チェック */
	public function checkedValidStudent($org_no, $login_id, $student_name, $start_period, $end_period){
		// データベース接続
		$itemDao = new T_StudentDao();
		return $itemDao->checkedValidStudent($org_no, $login_id, $student_name, $start_period, $end_period);
	}

	/* アイテム情報更新処理 */
	public function updateItemInfo($org_no, $dto){
		// データベース接続
		$itemDao = new T_StudentDao($this->pdo);
		// Ｔ管理者教師データを更新すること
		return $itemDao->updateItemInfo($org_no, $dto , $this->pdo);
	}

	/**
	 * 受講者のデータを取得する
	 *
	 * @param count
	 */
	public function getStudentCsvData($params){
		$itemDao = new T_StudentDao();
		return $itemDao->getStudentCsvData($params);
	}
}
?>