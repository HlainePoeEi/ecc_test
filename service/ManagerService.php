<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_ManagerDao.php';
require_once 'service/BaseService.php';

class ManagerService extends BaseService {

	/* 管理者教師情報を取得処理 */
	public function getMangerInfo($org_no) {
		// データベース接続
		$dao = new T_ManagerDao();
		// Ｔ管理者教師データを取得
		return $dao->getMangerInfo($org_no);
	}

	/* データ抽出ため管理者教師情報を取得処理 */
	public function getMangerCsvData($org_no) {
		// データベース接続
		$dao = new T_ManagerDao();
		// データ抽出ためＴ管理者教師データを取得
		return $dao->getMangerCsvData($org_no);
	}

	/* 管理者教師情報を更新する処理 */
	public function updateItemInfo($dto){
		// データベース接続
		$itemDao = new T_ManagerDao();
		// Ｔ管理者教師データを更新すること
		return $itemDao->updateItemInfo($dto);
	}

	/* 管理者教師ログインIDの重複チェック */
	public function checkedExistInfo($org_no, $login_id){
		// データベース接続
		$itemDao = new T_ManagerDao();
		// 組織管理者テーブルに組織管理№が存在しているかをチェックすること
		return $itemDao->checkedExistInfo($org_no, $login_id);
	}

	/* 次の管理者№を取得する */
	public function getNextId(){
		// データベース接続
		$dao = new T_ManagerDao();
		// Tシーケンステーブルから次の管理者№を取得する
		return $dao-> getNextId();

	}

	/* 管理者教師データ登録処理 */
	public function insertData($param){
		// データベース接続
		$dao = new T_ManagerDao();
		// 管理者教師データを登録すること
		return $dao-> insertData($param);
	}
	/**
	 * データ抽出ため担当者．教科．レッスン情報を取得処理
	 * @param $org_no:組織№
	 * @param $param:画面からのデータ
	 * @return リスト
	 */
	public function getManagerSubjectLessonCsvData($org_no,$param) {
		// データベース接続
		$dao = new T_ManagerDao();
		// データ抽出ため担当者．教科．レッスン情報を取得
		return $dao->getManagerSubjectLessonCsvData($org_no,$param);
	}
}
?>