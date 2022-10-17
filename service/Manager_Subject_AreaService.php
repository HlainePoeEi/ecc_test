<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワークgetSearchResultCount
 *
 *****************************************************/

require_once 'dao/T_Manager_Subject_AreaDao.php';
require_once 'dto/T_Manager_Subject_AreaDto.php';
require_once 'service/BaseService.php';

class Manager_Subject_AreaService extends BaseService{

	/* 登録処理 */
	public function insertData($param){
		// データベース接続
		$dao = new T_Manager_Subject_AreaDao();
		// 管理者教師データを登録する
		return $dao-> insertData($param);
	}

	/* 登録処理 */
	public function insertDataArr($manager_dto,$ms_arr) {
		// データベース接続
		$dao = new T_Manager_Subject_AreaDao($this->pdo);
		$res = $dao->insertDataArr($manager_dto,$ms_arr , $this->pdo);
		return $res;
	}

}
?>