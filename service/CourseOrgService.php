<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_Course_OrgDao.php';
require_once 'service/BaseService.php';
require_once 'dto/T_Menu_SettingDto.php';
require_once 'util/DateUtil.php';

class CourseOrgService extends BaseService{

	public function getCourseContractInfo($form) {

		// データベース接続
		$dao = new T_Course_OrgDao();
		// コース契約情報取得
		return $dao->getCourseContractInfo($form);
	}

	public function getOrgName($org_id) {

		// データベース接続
		$dao = new T_Course_OrgDao();
		// ユーザ名とパスワード取得
		return $dao->getOrgName($org_id);
	}

	public function getCourseName($course_id) {

		// データベース接続
		$dao = new T_Course_OrgDao();
		// ユーザ名とパスワード取得
		return $dao->getCourseName($course_id);
	}

	// 次の申込管理番号取得
	public function getNextOfferNo() {

		// データベース接続
		$dao = new T_Course_OrgDao($this->pdo);
		return $dao->getNextOfferNo();
	}

	// コースデータ登録
	public function registCourseOrgData($dto) {

		// データベース接続
		$dao = new T_Course_OrgDao($this->pdo);
		return $dao->insertWithPdo ( $dto  , $this->pdo );
	}

	// コースデータ取得
	public function getCourseOrgInfo($form) {

		// データベース接続
		$dao = new T_Course_OrgDao($this->pdo);
		return $dao->getCourseOrgInfo($form);
	}

	// コースデータ更新
	public function updateCourseOrgData($dto) {

		// データベース接続
		$dao = new T_Course_OrgDao($this->pdo);
		return $dao->updateCourseOrgData( $dto );
	}

	public function delCourseOrgData($dto) {

		// データベース接続
		$dao = new T_Course_OrgDao($this->pdo);
		return $dao->delCourseOrgData( $dto );
	}

	// コースデータ更新
	public function checkCourseOrgData($dto) {

		// データベース接続
		$dao = new T_Course_OrgDao($this->pdo);
		return $dao->checkCourseOrgData( $dto );
	}
	
	//　コース組織契約設定取得
	public function getCourseOrgConfInfo($form) {

		// データベース接続
		$dao = new T_Course_OrgDao();
		// コース契約情報取得
		return $dao->getCourseOrgConfInfo($form);
	}
	
	// コース組織契約設定データ登録
	public function setCourseOrgConfData($dto) {

		// データベース接続
		$dao = new T_Course_OrgDao($this->pdo);
		$data = $dao->getCourseOrgConfInfo($dto);
		
		if ( count($data) == 1 ){
			$result = $dao->updateCourseOrgConfData( $dto );
		}else if(count($data) == 0){
			$result = $dao->insertWithPdo ( $dto , $this->pdo );
		}
		
		return $result;
	}
		
	//　非表示するメニューIDを取得
	public function getMenuSetting($org_no){
 		$dao = new T_Course_OrgDao();
		
		return $dao->getMenuSetting($org_no);
	}

	//　非表示するメニューIDを登録する
	public function insertCourseOrgConf($org_no , $str , $menuDto){
		
 		$dao = new T_Course_OrgDao();
		
		$result = $dao->delCourseOrgConf($org_no , $this->pdo);
		
		// 削除処理が正常で、非表示するメニューがある場合登録処理を続ける
		if ($result == 1 && $str != ""){
			
			$arr = explode (",", $str);
			 
			foreach ( $arr as $menu_id ){
				
				$dto = new T_Menu_SettingDto();
				
				$dto->org_no = $org_no;
				$dto->menu_id = $menu_id;
				$dto->show_flg = $menuDto->show_flg;
				
				$dto->creater_id = $menuDto->creater_id;
				$dto->updater_id = $menuDto->updater_id;
				$dto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
				$dto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
				
				$result = $dao->insertWithPdo($dto , $this->pdo );
			}

		}
		
		return $result;
	}
}