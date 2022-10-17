<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/T_Manager_Subject_AreaDto.php';

/**
 * 管理者教師・教科DAOクラス
 */
class T_Manager_Subject_AreaDao extends BaseDao {

	/**
	 * 入出庫ヘッダー情報新規登録
	 *
	 * @param unknown $dto
	 */
	public function insertData($dto){

		return parent::insert ( $dto );
	}

	/**
	 * 複数データ登録処理
	 *
	 * @param unknown $dto
	 */
	public function insertDataArr($manager_dto,$ms_arr , $pdo){

		$rs = 1;
		try {
			
			// レッソンの登録実行
			$rs = parent::insertWithPdo ($manager_dto , $pdo);
			if ( $rs == 1 ){
				if ( !empty($ms_arr) ){
					// レッソン担当者の登録実行
					$this->bulkInsert ($ms_arr);
				}
			
			}
		}catch ( Exception $e ) {

			$rs = 0;
		}
		return $rs;
	}
}

?>