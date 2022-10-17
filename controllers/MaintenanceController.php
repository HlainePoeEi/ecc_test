<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseController.php';
require_once 'service/MaintenanceService.php';
require_once 'service/TypeService.php';
require_once 'conf/config.php';
require_once 'util/DateUtil.php';

/**
 * システムメンテナンスコントローラー
 */
class MaintenanceController extends BaseController {

	/**
	 * アクションメソッド
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			$this->form->status = "";
			$this->form->select_kbn = "";
			$this->form->description = "";
			$this->form->page = 1;
			$this->searchAction();

		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	public function searchAction(){

		if ( $this->check_login() == true ){

			$type_service= new TypeService($this->pdo);
			$kbn =  $type_service->getCategoryTypeAll(TARGET_KBN);
			$this->smarty->assign( 'kbn', $kbn);

			if(empty($this->form->page)){
				$this->form->page = 1;
			}

			$service= new MaintenanceService($this->pdo);
			$list = $service->getSystemStatusHistory($this->form , "0");
			$count = count ($list);
			if ( $count > 0 ){

				$this->form->max_page = ceil($count/ PAGE_ROW);
				$history_list = $service->getSystemStatusHistory($this->form , "1");
				$this->smarty->assign( 'list', $history_list);
			}
			$this->smarty->assign('form',$this->form);
			$this->smarty->display ( 'maintenance.html' );
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	public function searchWocAction(){

		if ($this->check_login () == true) {

			$system_kbn = $this->form->system_kbn;
			$service = new MaintenanceService($this->pdo);
			$status = $service->getSystemStatus($system_kbn);
			echo json_encode ( $status);
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	public function saveAction() {

		if ( $this->check_login() == true ){

			$admin_no = $_SESSION['admin_no'];

			$service = new MaintenanceService($this->pdo);
			$status_dao = new M_StatusDao($this->pdo);
			$status_dto = new M_StatusDto();
			$status = $this->form->status;
			if ($status == "0"){
				$system_status = "1";
			}
			if ($status == "1"){
				$system_status = "0";
			}
			$status_dto->system_status = $system_status;
			$status_dto->system_kbn = $this->form->select_kbn;

			$update_result = $status_dao->updateSystemStatusInfo($status_dto);
			if ( $update_result == 1 ){

				$history_dao = new T_Status_HistoryDao($this->pdo);
				$history_dto = new T_Status_HistoryDto();

				$next_id = $service->getNextId();
				$history_dto->no = $next_id->id;
				$history_dto->system_status = $system_status;
				$history_dto->system_kbn = $this->form->select_kbn;
				$history_dto->description = $this->form->description;
				$history_dto->del_flg = "0";
				$history_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
				$history_dto->creater_id = $admin_no;
				$history_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
				$history_dto->updater_id = $admin_no;
				$save_result = $history_dao->saveStatusHistory($history_dto);
				if ( $save_result== 1 ){

					$this->smarty->assign( 'err_msg', I004 );
					$this->indexAction();
				}else {
					$error = sprintf( E007, '登録' );
					$this->smarty->assign( 'err_msg', $error );
					$this->smarty->assign( 'form', $this->form );
					$this->smarty->display( 'maintenance.html' );
					return;
				}
			}else {
				$error = sprintf( E007, '更新' );
				$this->smarty->assign( 'err_msg', $error );
				$this->smarty->assign( 'form', $this->form );
				$this->smarty->display( 'maintenance.html' );
				return;
			}

		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}

	}
}

?>