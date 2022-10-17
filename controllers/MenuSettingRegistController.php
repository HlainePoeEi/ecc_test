<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'service/OrganizationService.php';
require_once 'util/DateUtil.php';
require_once 'service/TypeService.php';
require_once 'service/CourseOrgService.php';

/**
 * 組織メニュー設定コントローラー
 */
class MenuSettingRegistController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			$this->setMenu();
			

			// 組織メニュー情報設定
			$this->getMenuSettingData($this->form);
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 画面データ取得・渡す処理
	 */
	public function getMenuSettingData($form) {

		$org_no = $form->org_no;
		$form->strHideMenu= "";

		// メニュー情報を取得、セットする
		$this->setMenuSetting($form);

		//画面上、組織情報設定
		$Orgservice = new OrganizationService($this->pdo);
		$orgInfo = $Orgservice->getOrgDataByOrgNo($org_no);

		$org_id = $orgInfo[0]->org_id;
		$org_name = $orgInfo[0]->org_name;
		$org_name_kana = $orgInfo[0]->org_name_kana;
		$org_name_official = $orgInfo[0]->org_name_official;
		
		$this->smarty->assign( 'org_id', $org_id );
		$this->smarty->assign( 'org_name', $org_name );
		$this->smarty->assign( 'org_name_kana', $org_name_kana );
		$this->smarty->assign( 'org_name_official', $org_name_official );
		
		$this->smarty->assign( 'form', $form );
		$this->smarty->display( 'menuSettingRegist.html' );
	}

	/**
	 * メニュー設定処理
	 */
	public function setMenuSetting($form) {
		
		$org_no = $form->org_no;
		$service = new CourseOrgService ($this->pdo);
		logHelper::logDebug( "here");

		//　非表示するメニューIDを取得
		$list = $service->getMenuSetting($org_no);
		logHelper::logDebug( $list);
		
		$this->smarty->assign ( 'list', $list );
		
	}
	
	/**
	 * 画面登録ボタン押下処理
	 */
	public function saveAction() {
		
		if ( $this->check_login() == true ){

			$org_no = $this->form->org_no;
			$strArr = $this->form->strHideMenu;
			$admin_id = $_SESSION ['admin_no'];
			
			$service = new CourseOrgService($this->pdo);
			
			if ( $org_no != "" ){
				
				$saveDataDto = new T_Menu_SettingDto();
				$saveDataDto->org_no = $org_no;
				$saveDataDto->show_flg = FLAG_1;
				
				$saveDataDto->creater_id = $admin_id;
				$saveDataDto->updater_id = $admin_id;

				// 保存処理
				$result = $service->insertCourseOrgConf($org_no , $strArr, $saveDataDto);
				
				// 登録処理成功の場合
				if ( $result > 0 ){

					$this->smarty->assign( 'info_msg', I004 );
					$this->smarty->assign( 'error_msg', "" );
					
				}else {

					$error_msg = sprintf( E007, '登録' );
					$this->smarty->assign( 'error_msg', $error_msg );
					$this->smarty->assign( 'info_msg', "" );
					
					return;
				}
				
				$this->getMenuSettingData($this->form);
				
			}else{
				
				TransitionHelper::sendException ( E002 );
				return;
			}
		
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}


	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {

		if ( $this->check_login() == true ){

			//組織登録画面の場合
			if ( $this->form->btn_flag == 1 ){

				$this->form->org_no = $this->form->organization_no;
				$this->form->org_id = $this->form->organization_id;
				$this->form->org_name = $this->form->organization_name;
				$this->form->org_name_kana = $this->form->organization_name_kana;
				$this->form->org_name_official = $this->form->organization_official;
				$this->form->org_kbn = $this->form->organization_kbn;
				$this->form->org_type = $this->form->organization_type;
				$this->form->function_type = $this->form->org_function_type;
				$this->form->org_start_date = $this->form->organization_start_date;
				$this->form->start_period = $this->form->org_start_period;
				$this->form->end_period = $this->form->org_end_period;
				$this->form->contract_start_dt = $this->form->contract_start_date;
				$this->form->contract_end_dt = $this->form->contract_end_date;
				$this->form->org_admin = $this->form->organization_admin;
				$this->form->phone_no = $this->form->org_phone_no;
				$this->form->mail_address = $this->form->organization_mail;
				$this->form->contract_no =$this->form->org_contract_no;
				$this->form->manager_name = $this->form->org_manager_nm;
				$this->form->remarks = $this->form->org_remarks;
				$this->form->screen_mode = $this->form->screen_value;

				$service = new OrganizationService($this->pdo);
				$org_type1 = $service->getCategoryInfo("001");
				$kbn = $service->getCategoryInfo("002");
				$fun_type = $service->getCategoryInfo("013");

				$this->smarty->assign( 'kbn', $kbn );
				$this->smarty->assign( 'type', $org_type1 );
				$this->smarty->assign( 'fun_type', $fun_type );
				$this->smarty->assign( 'form', $this->form );
				$this->smarty->display('organizationRegist.html');

				//組織一覧画面の場合
			}else {
				//登録完了
				$this->setBackData();
				// 受講者一覧画面へ遷移する
				$this->dispatch('OrganizationList/Search');
			}
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/*
	 * 戻る場合のデータセット
	 */
	public function setBackData() {

		$_SESSION ['back_flg'] = true;
		$_SESSION ['search_page'] = $this->form->search_page;
		$_SESSION ['search_start_period'] = $this->form->search_start_period;
		$_SESSION ['search_end_period'] = $this->form->search_end_period;
		$_SESSION ['search_org_name'] = $this->form->search_org_name;
		$_SESSION ['search_chk_status'] = $this->form->search_chk_status;
		$_SESSION ['search_chk_status1'] = $this->form->search_chk_status1;
		$_SESSION ['search_chk_status2'] = $this->form->search_chk_status2;
		$_SESSION ['search_chk_status3'] = $this->form->search_chk_status3;
	}
}

?>