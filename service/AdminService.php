<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_AdminDao.php';
require_once 'dto/T_AdminDto.php';
require_once 'dao/M_TypeDao.php';
require_once 'service/BaseService.php';

/**
 * AdminServiceクラス
 *
 */
class AdminService extends BaseService{

	/* 一覧用の運用管理者情報を取得する */
	public function getAdminListData($form, $flg){
		// データベース接続
		$dao = new T_AdminDao();
		return $dao->getAdminListData($form, $flg);
	}
	
	/* 運用管理者情報を取得する */
	public function getAdminInfo($admin_no){
		// データベース接続
		$dao = new T_AdminDao();
		return $dao->getAdminInfo($admin_no);
	}

	/* 運用管理者情報新規登録 */
	public function insertData($param){
		// データベース接続
		$dao = new T_AdminDao();
		// 運用管理者データを新規登録すること
		return $dao->insertData($param);
	}

	/* 次の運用管理者№を取得する */
	public function getNextId(){
		// データベース接続
		$dao = new T_AdminDao();
		// Tシーケンステーブルから次の運用管理者№を取得する
		return $dao->getNextId();
	}

	/* 運用管理者情報更新処理 */
	public function updateAdminInfo($dto){
		// データベース接続
		$dao = new T_AdminDao();
		// 運用管理者データを更新すること
		return $dao->updateAdminInfo($dto);
	}

	/* ログインID存在チェック処理 */
	public function checkExists($login_id){
		// データベース接続
		$dao = new T_AdminDao();
		// ログインIDが既に存在しているかをチェックすること
		return $dao->checkExists($login_id);
	}
	
	/* 運用管理者権限取得処理 */
	public function getAdminKbn(){
		// データベース接続
		$dao = new M_TypeDao();
		// 運用管理者権限取得
		$t_admin_kbn=T_ADMIN_KBN;
		return $dao->getCategoryTypeAll($t_admin_kbn);
	}
	
	/* 運用管理者テーブルに運用管理者№が存在しているかをチェックする処理 */
	public function checkValid($login_id, $adm_no){
		// データベース接続
		$itemDao = new T_AdminDao();
		// 運用管理者テーブルに運用管理者№が存在しているかをチェックすること
		return $itemDao->checkValid($login_id, $adm_no);
	}
	
	/* 運用管理者のパスワードを変更する処理 */
	public function updatePassword($dto){
		// データベース接続
		$itemDao = new T_AdminDao();
		// Ｔ管理者教師データを更新すること
		return $itemDao->updatePassword($dto);
	}
}
?>