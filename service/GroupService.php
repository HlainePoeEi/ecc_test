<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'dao/M_GradeDao.php';
require_once 'dao/T_GroupDao.php';
require_once 'service/BaseService.php';
require_once 'conf/config.php';

class GroupService extends BaseService {

	/* グループ複数件データを挿入する
	 *
	 * @param unknown $dto
	 */
	public function insertWithTran($param){
		// データベース接続
		$dao = new T_GroupDao($this->pdo);
		// 受講者データを登録すること
		return $dao-> insertWithTran($param , $this->pdo);
	}

	/* 次のグループ番号取得 */
	public function getNextGroupNo() {
		// データベース接続
		$dao = new T_GroupDao ($this->pdo);
		// ユーザ名とパスワード取得
		return $dao->getNextGroupNo();
	}

	/**
	 *  グループ名重複チェック処理
	 *
	 * @param count
	 */
	public function checkedExistGpName($org_no, $group_name){
		// データベース接続
		$dao = new T_GroupDao($this->pdo);
		return $dao->checkedExistGpName($org_no, $group_name);
	}

	/**
	 *  グループ名情報を取得処理
	 *
	 * @param count
	 */
	public function getInfoByGroupName($org_no, $group_name){
		// データベース接続
		$dao = new T_GroupDao($this->pdo);
		return $dao->getInfoByGroupName($org_no, $group_name);
	}

	/**
	 * グループデータを取得する
	 *
	 * @param count
	 */
	public function getGroupCsvData($params){
		$dao = new T_GroupDao();
		return $dao->getGroupCsvData($params);
	}

}

?>