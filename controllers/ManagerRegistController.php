<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'service/ManagerService.php';
require_once 'service/OrganizationService.php';
require_once 'util/CommonUtil.php';
require_once 'util/DateUtil.php';

/**
 * 組織管理者登録コントローラー
 */
class ManagerRegistController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){
			// 前画面のパラメーター設定
			$org_no = $this->form->organization_no;
			$org_id = $this->form->show_org_id;
			$org_name = $this->form->show_org_name;
			$org_name_kana = $this->form->show_org_kana;
			$org_name_official = $this->form->show_org_official;
			$start_period = $this->form->org_start_date;
			$end_period = $this->form->org_end_date;

			$service = new ManagerService($this->pdo);

			$list = $service->getMangerInfo($org_no);

			// DBの取得結果が０件の場合、登録処理
			if ( count ($list) == 0 ){

				$this->form->screen_mode = 1;
				$this->form->manager_name = "";
				$this->form->start_period = $start_period;
				$this->form->end_period = $end_period;
				$this->form->remarks = "";
				$this->form->org_id = $org_id;
				$this->form->org_name = $org_name;
				$this->form->org_name_kana = $org_name_kana;
				$this->form->org_name_official = $org_name_official;

			// DBの取得結果が１件ある場合、更新処理
			}else if ( count($list) == 1 ){

					$this->form->screen_mode = 2;
					$this->form->org_no = $org_no;

					foreach ( $list as $value ) {

						$this->form->org_no = $value->org_no;
						$this->form->org_id = $value->org_id;
						$this->form->org_name = $value->org_name;
						$this->form->org_name_kana = $value->org_name_kana;
						$this->form->org_name_official = $value->org_name_official;
						$this->form->manager_no = $value->manager_no;
						$this->form->manager_name = $value->manager_name;
						$this->form->manager_name_kana = $value->manager_name_kana;
						$this->form->login_id = $value->login_id;
						$this->form->original_login_id = $value->login_id;
						$this->form->original_password = $value->password;
						$this->form->start_period = $value->start_period;
						$this->form->end_period = $value->end_period;
						$this->form->remarks = $value->remarks;
					}

			// DBの取得結果が複数データの場合、エラー
			}else if ( count ($list) > 1 ){

				$error = sprintf(E013);
				$this->smarty->assign( 'error', $error );
			}

			$this->setMenu();
			$this->smarty->assign( 'form', $this->form);
			$this->smarty->display( 'managerRegist.html' );

		}else {
			TransitionHelper::sendException( E002 );
			return;
		}

	}

	/*
	 * 登録ボタン、更新ボタンのAction
	 */
	public function saveAction() {

		if ( $this->check_login() == true ){

			// メニュー情報を取得、セットする
			$this->setMenu();
			$manager_service = new ManagerService($this->pdo);

			$org_no = $this->form->organization_no;
			$org_id = $this->form->organization_id;
			$org_name = $this->form->organization_name;
			$login_id = $this->form->login_id;
			$manager_name = $this->form->manager_name;
			$manager_name_kana = $this->form->manager_name_kana;
			$original_password = $this->form->original_password;
			$original_login_id = $this->form->original_login_id;
			$remarks = $this->form->remarks;
			$start_period = $this->form->start_period;
			$end_period = $this->form->end_period;

			if ( empty($this->form->password) ){

				$original_password = $this->form->original_password;
			}else {

				$password = $this->form->password;
			}

			// 管理者教師データ情報登録
			$manager_dto = new T_ManagerDto();
			$manager_dto->org_no = $org_no;
			$manager_dto->login_id = $login_id;
			$manager_dto->manager_name = $manager_name;
			$manager_dto->manager_name_kana = $manager_name_kana;
			$manager_dto->manager_kbn = MAIN_ADMIN_KBN;
			$manager_dto->start_period = $start_period;
			$manager_dto->end_period = DateUtil::changeEndDateFormat($end_period);
			$manager_dto->remarks = $remarks;
			$manager_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
			$manager_dto->updater_id = $_SESSION['admin_no'];
			$manager_dto->del_flg = 0;

			// パスワード暗号化
			if ( empty($this->form->password) ){

				$manager_dto->password = $original_password;
			}else {

				$manager_dto->password = CommonUtil::encryptPassword($password);
			}

			// 更新状況
			if ( $this->form->screen_mode == 2 ){

				$manager_dto->manager_no = $this->form->manager_no;

				if ( !empty($this->form->password) ){

					$manager_dto->pw_update_dt = DateUtil::getDate('Y/m/d H:i:s');
				}

				$check_result = 0;
				if ( $login_id != $original_login_id ){
					// データベースに存在することをチェックする
					$check_result = $manager_service->checkedExistInfo($org_no,$login_id);
				}

				// データベースに存在していない場合、
				if ( $check_result == 0 ){

					$result = $manager_service->updateItemInfo($manager_dto);

					// 更新処理が正常の場合、組織管理者一覧（参照）画面に遷移する。
					if ( $result == 1 ){

						// 組織管理者一覧（参照）画面に遷移する
						//登録完了
						$_SESSION ['regist_msg_org'] = I004;
						$this->setBackData();
						$this->dispatch('OrganizationList/Search');
						// 更新出来ない場合、
					}else {
						$error = sprintf( E007, '更新' );
						$this->smarty->assign( 'error', $error );
					}
				}else {

					$error = sprintf( E014, 'ログインID' );
					$this->smarty->assign( 'error', $error );
				}
				// 登録状況
			}else {

				$manager_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
				$manager_dto->creater_id = $_SESSION ['admin_no'];

				// データベースに存在することをチェックする
				$result = $manager_service->checkedExistInfo($org_no, $login_id);

				// データベースに存在していない場合、
				if ( $result == 0 ){

					// 取得結果．Tシーケンス.現在シーケンス番号+1
					$next_manager_no = $manager_service->getNextId();
					$manager_dto->manager_no = $next_manager_no->id;

					$result = $manager_service->insertData($manager_dto);

					// 登録処理が正常の場合、組織管理者一覧画面に遷移する。
					if ( $result == 1 ){

						// 組織管理者一覧画面に遷移する
						//登録完了
						$_SESSION ['regist_msg_org'] = I004;
						$this->setBackData();
						$this->dispatch('OrganizationList/Search');
						// 登録出来ない場合
					}else {

						$error = sprintf( E007, '登録' );
						$this->smarty->assign( 'error', $error );
					}

					// データベースに存在している場合、
				}else {

					$error = sprintf( E014, 'ログインID' );
					$this->smarty->assign( 'error', $error );
				}
			}
			$this->form->organization_no = $org_no;
			$this->form->organization_id = $org_id;
			$this->form->organization_name = $org_name;
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'managerRegist.html' );
		}else {
			TransitionHelper::sendException( E002 );
			return;
		}
	}

	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {

		if ( $this->check_login() == true ){

			$btn_flag = $this->form->btn_flag;
			$screen_value = $this->form->screen_value;
			$org_no = $this->form->organization_no;
			$org_id = $this->form->organization_id;
			$org_name = $this->form->organization_name;
			$org_name_kana = $this->form->organization_name_kana;
			$org_name_offical = $this->form->organization_official;
			$org_kbn = $this->form->organization_kbn;
			$org_type = $this->form->organization_type;
			$org_function_type = $this->form->org_function_type;
			$org_start_date = $this->form->organization_start_date;
			$org_start_period = $this->form->org_start_period;
			$org_end_period = $this->form->org_end_period;
			$contract_start_date = $this->form->contract_start_date;
			$contract_end_date = $this->form->contract_end_date;
			$org_admin = $this->form->organization_admin;
			$org_phone_no = $this->form->org_phone_no;
			$org_mail = $this->form->organization_mail;
			$org_contract_no = $this->form->org_contract_no;
			$org_manager_name = $this->form->org_manager_nm;
			$org_remark = $this->form->org_remarks;

			$service = new OrganizationService($this->pdo);
			$org_type1 = $service->getCategoryInfo("001");
			$kbn = $service->getCategoryInfo("002");
			$fun_type = $service->getCategoryInfo("013");

			$this->smarty->assign( 'kbn', $kbn );
			$this->smarty->assign( 'type', $org_type1 );
			$this->smarty->assign( 'fun_type', $fun_type );

			if ($btn_flag == 1){
				//登録完了
				$this->setBackData();

				// 受講者一覧画面へ遷移する
				$this->dispatch('OrganizationList/Search');

			}else {

				$this->form->org_no = $org_no;
				$this->form->org_id = $org_id;
				$this->form->org_name = $org_name;
				$this->form->org_name_kana = $org_name_kana;
				$this->form->org_name_official = $org_name_offical;
				$this->form->org_kbn = $org_kbn;
				$this->form->org_type = $org_type;
				$this->form->function_type = $org_function_type;
				$this->form->org_start_date = $org_start_date;
				$this->form->start_period = $org_start_period;
				$this->form->end_period = $org_end_period;
				$this->form->contract_start_dt = $contract_start_date;
				$this->form->contract_end_dt = $contract_end_date;
				$this->form->org_admin = $org_admin;
				$this->form->phone_no = $org_phone_no;
				$this->form->contract_no = $org_contract_no;
				$this->form->manager_name = $org_manager_name;
				$this->form->remarks = $org_remark;
				$this->form->screen_mode = $screen_value;

				$this->smarty->assign( 'form', $this->form );
				$this->smarty->display('organizationRegist.html');
			}
		}else {
			TransitionHelper::sendException( E002 );
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