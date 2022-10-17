<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2018 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'dto/M_OrganizationDto.php';
require_once 'service/OrganizationService.php';
require_once 'dto/M_Org_ConfDto.php';
require_once 'dto/T_Org_Push_ConfDto.php';
require_once 'service/Org_ConfService.php';
require_once 'service/Org_Push_ConfService.php';
require_once 'util/DateUtil.php';

/**
 * 組織登録コントローラー
 */
class OrganizationRegistController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			$service = new OrganizationService($this->pdo);
			$org_no = $this->form->org_no;
			$screen_mode = $this->form->screen_mode;
			if($screen_mode == "") {
				$this->form->screen_mode = "new";
			}

			if ( $screen_mode == "update" ){

				if ( $org_no != "" ){

					$orgInfo = $service->getOrgDataByOrgNo($org_no);

					if ( count($orgInfo) == 1 ){
						// formにデータをセットする
						$this->form->org_no = $org_no;
						$this->form->org_id = $orgInfo[0]->org_id;
						$this->form->org_name = $orgInfo[0]->org_name;
						$this->form->org_name_kana = $orgInfo[0]->org_name_kana;
						$this->form->org_name_official=  $orgInfo[0]->org_name_official;
						$this->form->org_kbn = $orgInfo[0]->org_kbn;
						$this->form->org_type = $orgInfo[0]->org_type;
						$this->form->function_type = $orgInfo[0]->function_type;
						$this->form->org_start_date = $orgInfo[0]->org_start_date;
						$this->form->start_period = $orgInfo[0]->start_period;
						$this->form->end_period = $orgInfo[0]->end_period;
						$this->form->contract_start_dt = $orgInfo[0]->contract_start_dt;
						$this->form->contract_end_dt = $orgInfo[0]->contract_end_dt;
						$this->form->org_admin = $orgInfo[0]->org_admin;
						$this->form->phone_no = $orgInfo[0]->phone_no;
						$this->form->mail_address = $orgInfo[0]->mail_address;
						$this->form->contract_no = $orgInfo[0]->contract_no;
						$this->form->manager_name = $orgInfo[0]->manager_name;
						$this->form->remarks = $orgInfo[0]->remarks;
                        // Start ADD 20211102 add query  by TienHM
                        //初期化
                        $this->form->push_flg = 0;
                        //設定
                        if($orgInfo[0]->push_flg) {
                            $this->form->push_flg = 1;
                        }
                        $this->form->count = $orgInfo[0]->count;
                        //  End  ADD 20211102
					}
				}
			}else {

				$this->setFormData();

			}

			$this->setCategoryData();
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'organizationRegist.html' );
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/*
	 * 登録ボタン、更新ボタンのAction
	 */
	public function saveAction() {

		if ( $this->check_login() == true ){

			$service = new OrganizationService($this->pdo);
			$dao = new M_OrganizationDao($this->pdo);

			$conf_service = new Org_ConfService($this->pdo);
			$conf_dao = new M_Org_ConfDao($this->pdo);
			$conf_dto = new M_Org_ConfDto();

            // Start ADD 20211102 add query  by TienHM
            $org_push_conf_service = new Org_Push_ConfService($this->pdo);
            $org_push_conf_dto = new T_Org_Push_ConfDto();
            //  End  ADD 20211102

			// メニュー情報を取得、セットする
			$this->setMenu();
			$admin_no = $_SESSION['admin_no'];
			$screen_mode = $this->form->screen_mode;

			$org_dto = new M_OrganizationDto();
			$org_id = $this->form->org_id;
			$org_dto->org_id = $org_id;
			$org_name = $this->form->org_name;
			$org_dto->org_name = $org_name;
			$org_dto->org_name_kana = $this->form->org_name_kana;
			$org_dto->org_name_official = $this->form->org_name_official;
			$org_dto->org_kbn = $this->form->org_kbn;
			$org_dto->org_type = $this->form->org_type;
			$org_dto->function_type = $this->form->function_type;
			$org_dto->org_start_date = $this->form->org_start_date;
			$org_dto->start_period = $this->form->start_period;
			$org_dto->end_period = DateUtil::changeEndDateFormat($this->form->end_period);
			$org_dto->contract_start_dt = $this->form->contract_start_dt;
			$org_dto->contract_end_dt = DateUtil::changeEndDateFormat($this->form->contract_end_dt);
			$org_dto->org_admin = $this->form->org_admin;
			$org_dto->phone_no = $this->form->phone_no;
			$org_dto->mail_address = $this->form->mail_address;
			$org_dto->contract_no = $this->form->contract_no;
			$org_dto->manager_name = $this->form->manager_name;
			$org_dto->remarks = $this->form->remarks;
			$org_dto->updater_id = $admin_no;
			$org_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');

			if ( $screen_mode == 'update' ){

				$org_no = $this->form->org_no;
				$org_dto->org_no = $org_no;

				$duplicate_result = $service->checkedExistInfo($org_no,$this->form->org_id);

				if ( $duplicate_result == 0 ){

					$result = $dao->updateOrgInfo($org_dto);

                    // Start ADD 20211102 add query  by TienHM
                    $org_push_conf_dto->org_no = $org_no;
                    $org_push_conf_dto->push_flg = $this->form->push_flg;
                    $org_push_conf_dto->count = intval($this->form->count);
                    $org_push_conf_dto->updater_id = $admin_no;
                    $org_push_conf_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
                    $check = $org_push_conf_service->updateOrgPushConf($org_push_conf_dto);
                    //  End  ADD 20211102

                    // 更新処理が正常の場合、
                    // Start UPDATE 20211103 add query  by TienHM
                    // if ( $result == 1){
                    if ($result == 1 && $check == 1) {
                        //  End  ADD 20211103
                        $conf_dto->org_no = $org_no;
						$conf_dto->updater_id = $admin_no;
						$conf_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
						$conf_dao->updateOrg_ConfInfo($conf_dto);
						//登録完了
						$error = sprintf(I004);
						$this->smarty->assign( 'err_msg', $error );
						$this->setCategoryData();
						$this->smarty->assign( 'form', $this->form );
						$this->smarty->display( 'organizationRegist.html' );

						// 更新出来ない場合、
					}else {

						$error = sprintf( E007, '更新' );
						$this->smarty->assign( 'err_msg', $error );
						$this->smarty->assign( 'form', $this->form );
						$this->smarty->display( 'organizationRegist.html' );
						return;
					}
				}else {

					$this->setCategoryData();
					$error = sprintf(E008);
					$this->smarty->assign( 'err_msg', $error );
					$this->smarty->assign( 'form', $this->form );
					$this->smarty->display( 'organizationRegist.html' );
					return;
				}
			}else {

				$result = $service->checkedExistInfo( "", $this->form->org_id );
				if ( $result== 0 ){

					$org_dto->creater_id = $admin_no;
					$org_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
					$next_id = $service->getNextId();
					$org_no = $next_id->id;
					$org_dto->org_no = $org_no;
					$result = $dao->saveOrg($org_dto);
                    // Start ADD 20211102 add query  by TienHM
                    $org_push_conf_dto->org_no = $org_no;
                    $org_push_conf_dto->push_flg = $this->form->push_flg;
                    $org_push_conf_dto->count = intval($this->form->count);
                    $org_push_conf_dto->creater_id = $admin_no;
                    $org_push_conf_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
                    $org_push_conf_dto->updater_id = $admin_no;
                    $org_push_conf_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
                    $check = $org_push_conf_service->saveOrgPushConf($org_push_conf_dto);
                    //  End  ADD 20211102

                    // Start UPDATE 20211103 add query  by TienHM
                    // if ( $result == 1){
                    if ($result == 1 && $check == 1) {
                        //  End  ADD 20211103

						//登録完了
						$conf_dto->org_no = $org_no;
						$conf_dto->attendance_flg = '1';
						$conf_dto->period_cnt = '0';
						$conf_dto->task_file_size = '151';
						$conf_dto->task_file_ext = 'png,jpg,pdf,mobi,docx,doc,docm,xlsx,xls,xlsm,csv,pptx,ppt,pptm,mp3,wma,wav,m4a,ogg,gif,mp4,flv,apk,zip,lzh';
						$conf_dto->quiz_audio_size = '2';
						$conf_dto->quiz_img_size = '2';
						$conf_dto->remarks = '';
						$conf_dto->del_flg = '0';
						$conf_dto->creater_id = $admin_no;
						$conf_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
						$conf_dto->updater_id = $admin_no;
						$conf_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
						$conf_result = $conf_dao->saveOrg_Conf($conf_dto);

						$error = sprintf(I004);
						$this->smarty->assign( 'err_msg', $error );
						$this->setCategoryData();
						$this->form->org_no= $org_no;
						$this->form->screen_mode = "update";
						$this->smarty->assign( 'form', $this->form );
						$this->smarty->display( 'organizationRegist.html' );

						// 登録出来ない場合、
					}else {

						$error = sprintf( E007, '登録' );
						$this->smarty->assign( 'err_msg', $error );
						$this->smarty->assign( 'form', $this->form );
						$this->smarty->display( 'organizationRegist.html' );
						return;
					}
				}else {

					$this->setCategoryData();
					$error = sprintf(E008);
					$this->smarty->assign( 'err_msg', $error );
					$this->smarty->assign( 'form', $this->form );
					$this->smarty->display( 'organizationRegist.html' );
					return;
				}
			}
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	public function setFormData() {

		$this->form->org_no = "";
		$this->form->org_id = "";
		$this->form->org_name = "";
		$this->form->org_name_kana = "";
		$this->form->org_name_official = "";
		$this->form->org_kbn = "";
		$this->form->org_type = "";
		$this->form->function_type = "";
		$this->form->org_start_date = "";
		$this->form->start_period = "";
		$this->form->end_period = "";
		$this->form->contract_start_dt = "";
		$this->form->contract_end_dt = "";
		$this->form->org_admin = "";
		$this->form->phone_no = "";
		$this->form->mail_address = "";
		$this->form->contract_no = "";
		$this->form->manager_name = "";
		$this->form->remarks = "";
        // Start ADD 20211102 add default value form by TienHM
		$this->form->push_flg = 1;
		$this->form->count = 0;
        //  End  ADD 20211102
	}

	public function setCategoryData() {

		$service = new OrganizationService($this->pdo);
		$org_type = $service->getCategoryInfo(CAT_ORG_TYPE);
		$kbn = $service->getCategoryInfo(CAT_ORG_KBN);
		$fun_type = $service->getCategoryInfo(CAT_FUN_TYPE);

		$this->smarty->assign( 'kbn', $kbn);
		$this->smarty->assign( 'type', $org_type);
		$this->smarty->assign( 'fun_type', $fun_type);

	}

	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {

		if ( $this->check_login() == true ){

			//登録完了
			$this->setBackData();

			// 組織一覧画面へ遷移する
			$this->dispatch('OrganizationList/search');
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