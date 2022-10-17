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
require_once 'dto/M_GradeDto.php';
require_once 'service/GradeService.php';
require_once 'service/OrganizationService.php';
require_once 'util/DateUtil.php';

/**
 * 組織学年設定コントローラー
 */
class GradeRegistController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			$this->setMenu();

			// 組織学年情報設定
			$this->getGradeData($this->form);
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 画面データ取得・渡す処理
	 */
	public function getGradeData($myForm) {

		$org_no = $myForm->org_no;
		$grade_no = $myForm->grade_no;
		$_SESSION ['org_no'] = $org_no;
		// メニュー情報を取得、セットする
		$this->setMenu();
		$service = new GradeService($this->pdo);

		// 学年情報取得
		$count = count($service->getGradeOrgCount($myForm));

		if ( $count > 0 ){

			$this->form->max_page = ceil($count/ PAGE_ROW);
			$list = $service->getGradeOrgInfo($myForm, "1");
			$this->smarty->assign('grade_cnt', $count);
			$this->smarty->assign( 'list', $list );
		}else {
			// エラーメッセージを設定「検索結果がありません」
			$err_msg = W001;
			$this->smarty->assign( 'list', Null );
			$this->smarty->assign( 'err_msg', $err_msg );
		}
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

		if ( $grade_no != "" ){

			$service = new GradeService($this->pdo);
			$gradeInfo = $service->getGradeInfo($myForm);

			// テンプレートにデータ渡す
			$this->form->grade_no = $gradeInfo->grade_no;
			$this->form->grade_name = $gradeInfo->grade_name;
			$this->form->grade_name_kana = $gradeInfo->grade_name_kana;
			$this->form->disp_no = $gradeInfo->disp_no;
			$this->form->remarks = $gradeInfo->remarks;
			$this->form->start_period = $gradeInfo->start_period;
			$this->form->end_period = $gradeInfo->end_period;

			$this->smarty->assign( 'form', $myForm );
		}else {

			$myForm->start_period = "";
			$myForm->end_period = "";
			$myForm->grade_name = "";
			$myForm->grade_name_kana = "";
			$myForm->disp_no = "";
			$myForm->remarks = "";
			$this->smarty->assign( 'form', $myForm );
		}
		$this->smarty->display( 'gradeRegist.html' );
	}

	/**
	 * 画面登録ボタン処理
	 */
	public function saveAction() {

		$admin_id = $_SESSION ['admin_no'];
		$grade_no = $this->form->grade_no;
		$service = new GradeService($this->pdo);

		// 学年設定管理№がない場合、新規追加
		if ( $grade_no == "" ){

			$gradeDto = new M_GradeDto();

			$gradeDto->org_no = $_SESSION ['org_no'];
			$gradeDto->grade_name = $this->form->grade_name;
			$gradeDto->grade_name_kana = $this->form->grade_name_kana;
			$gradeDto->disp_no = $this->form->disp_no;
			$gradeDto->remarks = $this->form->remarks;
			$gradeDto->start_period = $this->form->start_period;
			$gradeDto->end_period = DateUtil::changeEndDateFormat($this->form->end_period);
			$gradeDto->creater_id = $admin_id;
			$gradeDto->updater_id = $admin_id;
			$gradeDto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
			$gradeDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );

			// 学年番号の設定
 			$grade_no_data = $service->getNextGradeNoByOrgNo($_SESSION ['org_no']);

			if ( $grade_no_data->grade_no == "" ){

				$grade_no = 1;
			}else{

				$grade_no = $grade_no_data->grade_no + 1;
			}

			$this->form->grade_no = $grade_no;
			$gradeDto->grade_no = $grade_no;

			$save_result = $service->registGradeData ( $gradeDto);
			// 登録処理成功の場合
			if ( $save_result > 0 ){

				$this->smarty->assign( 'info_msg', I004 );
				$this->smarty->assign( 'error_msg', "" );
				$this->form->grade_no = "";
				$this->getGradeData($this->form);
			}else {

				$error_msg = sprintf( E007, '登録' );
				$this->smarty->assign( 'error_msg', $error_msg );
				$this->smarty->assign( 'info_msg', "" );
				$this->getGradeData($this->form);
				return;
			}
		}else {

			$gradeDto = new M_GradeDto();
			$gradeDto->org_no = $_SESSION ['org_no'];
			$gradeDto->grade_no = $grade_no;
			$gradeDto->grade_name = $this->form->grade_name;
			$gradeDto->grade_name_kana = $this->form->grade_name_kana;
			$gradeDto->disp_no = $this->form->disp_no;
			$gradeDto->remarks = $this->form->remarks;
			$gradeDto->start_period = $this->form->start_period;
			$gradeDto->end_period = DateUtil::changeEndDateFormat($this->form->end_period);
			$gradeDto->updater_id = $admin_id;
			$gradeDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );

			$update_result = $service->updateGradeData ( $gradeDto );

			// 更新処理成功の場合
			if ( $update_result > 0 ){

				$this->smarty->assign( 'info_msg', I004 );
				$this->smarty->assign( 'error_msg', "" );
				$this->form->grade_no = "";
				$this->getGradeData($this->form);
			}else {

				$error_msg = sprintf( E007, '更新' );
				$this->smarty->assign( 'error_msg', $error_msg );
				$this->smarty->assign( 'info_msg', "" );
				$this->getGradeData ($this->form);
				return;
			}
		}
	}

	/**
	 * 削除処理
	 */
	public function deleteAction() {

		$org_no = $_SESSION ['org_no'];
		$admin_id = $_SESSION ['admin_no'];
		$grade_no = $this->form->grade_no;
		$service = new GradeService($this->pdo);

		if ( $grade_no != "" ){

			$gradeDto = new M_GradeDto();
			$gradeDto->org_no = $org_no;
			$gradeDto->grade_no = $grade_no;
			$gradeDto->updater_id = $admin_id;
			$gradeDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );

			$result = $service->delGradeData($gradeDto);

			// 削除処理成功の場合
			if ( $result > 0 ){

				$list = $service->getGradeOrgInfo($this->form, "1");
				$this->smarty->assign('list', $list);

				$Orgservice = new OrganizationService($this->pdo);
				$orgInfo = $Orgservice->getOrgDataByOrgNo($org_no);

				$org_id = $orgInfo[0]->org_id;
				$org_name = $orgInfo[0]->org_name;
				$org_name_kana = $orgInfo[0]->org_name_kana;
				$org_name_official = $orgInfo[0]->org_name_official;

				$this->form->grade_no = "";
				$this->smarty->assign( 'org_id', $org_id );
				$this->smarty->assign( 'org_name', $org_name );
				$this->smarty->assign( 'org_name_kana', $org_name_kana );
				$this->smarty->assign( 'org_name_official', $org_name_official );
				$this->smarty->assign( 'info_msg', "" );
				$this->smarty->assign( 'error_msg', I005 );
				$this->smarty->assign( 'form', $this->form );
				$this->smarty->display( 'gradeRegist.html' );
			}else {

				$error_msg = sprintf( E007, '削除' );
				$this->smarty->assign ( 'error_msg', $error_msg );
				$this->smarty->assign ( 'info_msg', "" );
				$this->getGradeData ($this->form);
				return;
			}
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