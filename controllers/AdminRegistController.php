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
require_once 'service/AdminService.php';
require_once 'dto/PageDto.php';
require_once 'util/DateUtil.php';

/**
 * 運用管理者登録コントローラー
 */
class AdminRegistController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			// 画面初期データ設定
			$admin_no = $this->form->admin_no;
			$this->form->date_flg = 0;
			$original_password = null;

			$service = new AdminService($this->pdo);

			// 運用権利者権限取得
			$adminKbn = $service->getAdminKbn();

			// 運用管理者№がある場合、更新処理
			if ( $admin_no != "" ){

				// 更新
				$this->form->btn_value = 1;
				$today_date = DateUtil::getDate('Y/m/d');

				// 検索結果を取得
				$list = $service->getAdminInfo($admin_no);

				if ( $list ){

					$this->form->admin_no = $list->admin_no;
					$this->form->admin_name = $list->admin_name;
					$this->form->romaji_name = $list->romaji_name;
					$this->form->login_id = $list->login_id;
					$this->form->admin_kbn = $list->admin_kbn;
					$this->form->password = "";
					$this->form->start_period = $list->start_period;

					$diff = date_diff(date_create($list->start_period), date_create($today_date));

					if ( $diff->format("%R%a") > 0 ){

						$this->form->date_flg = 1;
					}

					$this->form->end_period = $list->end_period;
					$this->form->remarks = $list->remarks;
					$this->form->mail_address = $list->mail_address;
					$this->form->admin_no = $admin_no;
				}
				// 運用管理者№が""の場合、新規処理
			}else {

				$this->form->admin_name = "";
				$this->form->start_period = "";
				$this->form->end_period = "";
				$this->form->btn_value = 2;
			}

			// メニュー情報を取得、セットする
			$this->setMenu();

			$this->smarty->assign('adminKbn', $adminKbn);
			$this->smarty->assign('form', $this->form);
			$this->smarty->display ( 'adminRegist.html' );
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

			// メニュー情報を取得、セットする
			$this->setMenu();

			$admin_service = new AdminService($this->pdo);

			// 運用管理者データ情報登録
			$adminDto = new T_AdminDto();
			$adminDto->login_id = $this->form->login_id;
			$adminDto->admin_name = $this->form->admin_name;
			$adminDto->romaji_name = $this->form->romaji_name;
			$adminDto->admin_kbn = $this->form->txt_admin_kbn;

			// パスワード暗号化
			$password = $this->form->password;
			if ( !StringUtil::isEmpty($this->form->password) ){

				$adminDto->password = CommonUtil::encryptPassword($password);
			}
			$adminDto->mail_address = $this->form->mail_address;
			$adminDto->start_period = $this->form->start_period;
			$adminDto->end_period = DateUtil::changeEndDateFormat($this->form->end_period);
			$adminDto->remarks = $this->form->remarks;
			$adminDto->updater_id = $_SESSION['admin_no'];
			$adminDto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
			$adminDto->del_flg = 0;

			// 更新状況
			if ( $this->form->admin_no != "" ){

				$adminDto->admin_no = $this->form->admin_no;
				// データベースに存在することをチェックする
				$check = $admin_service->checkExists($adminDto->login_id);
				// データベースに存在していない場合、
				if ( count($check) == 0 || $check[0]->admin_no == $adminDto->admin_no ){

					$result = $admin_service->updateAdminInfo($adminDto);

					// 更新処理が正常の場合、運用管理者一覧画面に遷移する。
					if ( $result == 1 ){
						//登録完了
						$_SESSION ['regist_msg_admin'] = I004;
						$this->dispatch('AdminList');
						// 更新出来ない場合、
					}else {

						$error = sprintf(E007,'更新');
						$this->smarty->assign ( 'msg', $error );
					}
				}else {

					$service = new AdminService($this->pdo);
					$adminKbn = $service->getAdminKbn();
					$this->smarty->assign('adminKbn', $adminKbn);
					$this->form->admin_kbn = $this->form->txt_admin_kbn;;
					$error = sprintf(E008);
					$this->smarty->assign ( 'msg', $error );
				}
			}else {

				$adminDto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
				$adminDto->creater_id =  $_SESSION['admin_no'];

				// データベースに存在することをチェックする
				$check = $admin_service->checkExists($adminDto->login_id);

				// データベースに存在していない場合、
				if ( count($check) == 0 ){

					// 取得結果．Tシーケンス.現在シーケンス番号+1
					$next_admin_no = $admin_service->getNextId();
					$adminDto->admin_no = $next_admin_no->id;

					$result = $admin_service->insertData($adminDto);

					// 登録処理が正常の場合、運用管理者一覧画面に遷移する。
					if ( $result == 1 ){

						// 運用管理者一覧画面に遷移する
						//登録完了
						$_SESSION ['regist_msg_admin'] = I004;
						$this->dispatch('AdminList');
						// 登録出来ない場合
					}else {

						$error = sprintf(E007,'登録');
						$this->smarty->assign ( 'msg', $error );
					}
					// データベースに存在している場合、
				}else {

					$service = new AdminService($this->pdo);
					$adminKbn = $service->getAdminKbn();
					$this->smarty->assign('adminKbn', $adminKbn);
					$this->form->admin_kbn = $this->form->txt_admin_kbn;;
					$error = sprintf(E008);
					$this->smarty->assign ( 'msg', $error );
				}
			}
			$this->smarty->assign('form', $this->form);
			$this->smarty->display ( 'adminRegist.html' );
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	public function backAction(){

		$this->setBackData();
		// 運用管理者一覧画面へ遷移する
		$this->dispatch('AdminList/search');
	}

	/*
	 * 戻る場合のデータセット
	 */
	public function setBackData() {

		$_SESSION ['back_flg'] = true;
		$_SESSION ['search_page'] = $this->form->search_page;
		$_SESSION ['search_start_period'] = $this->form->search_start_period;
		$_SESSION ['search_end_period'] = $this->form->search_end_period;
		$_SESSION ['search_admin_name'] = $this->form->search_admin_name;
	}
}

?>