<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'dao/T_Group_StudentDao.php';
require_once 'conf/config.php';
require_once 'service/BaseService.php';

class GroupStudentService extends BaseService {

	/* グループデータ削除処理 */
	public function deleteGpStuData($org_no, $group_no) {
		// データベース接続
		$dao = new T_Group_StudentDao ();
		return $dao->deleteGpStuData ( $org_no, $group_no );
	}

	/* データチェック処理 */
	public function count($org_no, $group_no) {
		$dao = new T_Group_StudentDao ();
		return $dao->count ( $org_no, $group_no );
	}

	/* グループデータ登録処理 */
	public function insertData($param){
		// データベース接続
		$dao = new T_Group_StudentDao($this->pdo);
		// データを登録すること
		return $dao-> insertData($param , $this->pdo);
	}

	/**
	 * データ抽出ためグループと受講者情報を取得処理
	 * @param $org_no:組織№
	 * @param $param:画面からのデータ
	 * @return リスト
	 */
	public function getGroupStudentCsvData($org_no,$param) {
		// データベース接続
		$dao = new T_Group_StudentDao();
		// データ抽出ためグループと受講者情報を取得
		return $dao->getGroupStudentCsvData($org_no,$param);
	}

	/* グループと受講者テーブルで登録する前、重複チェック処理-20190425修正 */
	public function checkgpStudent($org_no, $group_no, $student_no) {
		$dao = new T_Group_StudentDao($this->pdo);
		return $dao->checkgpStudent($org_no, $group_no, $student_no);
	}
}
