<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/M_GradeDao.php';
require_once 'service/BaseService.php';

class GradeService extends BaseService{

	// 学年設定データ取得
	public function getGradeOrgInfo($form) {

		// データベース接続
		$dao = new M_GradeDao();

		return $dao->getGradeOrgInfo($form);
	}


	// 学年設定データ取得
	public function getGradeInfo($form) {

		// データベース接続
		$dao = new M_GradeDao($this->pdo);

		return $dao->getGradeInfo($form);
	}

	public function getGradeOrgCount($form) {
		// データベース接続
		$dao = new M_GradeDao();

		return $dao->getGradeOrgCount($form);
	}

	// 学年設定番号の重複チェック処理
	public function checkExistGradeInfo($dto) {

		// データベース接続
		$dao = new M_GradeDao ($this->pdo);

		return $dao->checkExistGradeInfo($dto);
	}

	// 次の学年設定番号取得
	public function getNextGradeNo() {

		// データベース接続
		$dao = new M_GradeDao ($this->pdo);
		return $dao->getNextGradeNo();
	}

	// 学年設定データ登録
	public function registGradeData($dto) {

		// データベース接続
		$dao = new M_GradeDao ($this->pdo);

		return $dao->insert ( $dto );
	}

	// 学年設定データ更新
	public function updateGradeData($dto) {

		// データベース接続
		$dao = new M_GradeDao ($this->pdo);

		return $dao->updateGradeData( $dto );
	}

	// 学年設定データ更新
	public function delGradeData($dto) {

		// データベース接続
		$dao = new M_GradeDao($this->pdo);

		return $dao->delGradeData( $dto );
	}

	// 学年番号の設定
	public function getNextGradeNoByOrgNo($org_no){

		// データベース接続
		$dao = new M_GradeDao($org_no);

		return $dao->getNextGradeNoByOrgNo($org_no);
	}

	// エクセルファイルからグループ登録処理で学年の有効チェック
	public function getGradeByName($org_no,$grade_name){

		$dao = new M_GradeDao($this->pdo);
		return $dao->getGradeByName($org_no,$grade_name);
	}
}

?>