<?php
/*****************************************************
 *	株式会社ECC 新商品開発プロジェクト
 *	PHPシステム構築フレームワーク
 *
 *	Copyright (c) 2018 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/M_OrganizationDao.php';
require_once 'dto/M_OrganizationDto.php';
require_once 'service/BaseService.php';

/**
 * 組織管理者サービス
 */
class OrganizationService extends BaseService{

	public function getUserData($user_id){
		// データベース接続
		$dao = new T_AdminDao();
		// ユーザ情報取得
		return $dao->getUserData($user_id);
	}

	public function getOrganizationList($form,$flg) {
		$orgDao = new M_OrganizationDao( $this->pdo );
		return  $orgDao->getOrganizationList($form,$flg);
	}

	public function getOrganizationCount($form) {
		$orgDao = new M_OrganizationDao( $this->pdo );
		return  $orgDao->getOrganizationCount($form);
	}

	public function getCategoryInfo($category) {
		$orgDao = new M_OrganizationDao( $this->pdo );
		return  $orgDao->getCategoryInfo($category);
	}

	public function getOrgDataByOrgNo($org_no) {
		$orgDao = new M_OrganizationDao( $this->pdo );
		return  $orgDao->getOrgDataByOrgNo($org_no);
	}

	public function updateOrgInfo($dto){
		// データベース接続
		$orgDao = new M_OrganizationDao();

		return $orgDao->updateOrgInfo($dto);
	}

	public function getNextId(){
		// データベース接続
		$orgDao = new M_OrganizationDao();
		// Tシーケンステーブルから次の管理者№を取得する
		return $orgDao-> getNextId();
	}

	public function saveOrg($dto){
		$orgDao = new M_OrganizationDao();
		return $orgDao->saveOrg($dto);
	}

	public function checkedExistInfo($org_no, $org_id){
		// データベース接続
		$orgDao = new M_OrganizationDao();
		// 組織管理者テーブルに組織管理№が存在しているかをチェックすること
		return $orgDao->checkedExistInfo($org_no, $org_id);
	}

	//組織IDを指定して組織情報を取得する
	public function getOrgNoByOrgId($org_id) {
		$orgDao = new M_OrganizationDao( $this->pdo );
		return  $orgDao->getOrgNoByOrgId($org_id);
	}
}
?>