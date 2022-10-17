<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'service/AtReportService.php';
require_once 'dto/T_At_Report_DetailDto.php';
require_once 'util/DateUtil.php';

/**
 * Atレポート試験・コース並び順設定コントローラー
 */
class AtReportDisplayListController extends BaseController {
	/**
	 * 初期処理
	 */
	public function indexAction() {
		
		if ($this->check_login () == true) {

			$org_no = $this->form->org_no;
			$at_report_no = $this->form->at_report_no;
			
			LogHelper::logDebug($at_report_no);
			
			if (isset($_SESSION['save_msg'])){
				$org_no = $_SESSION['org_no'];
				$at_report_no = $_SESSION['at_report_no'];
				
				$this->form->org_no = $org_no;
				$this->form->at_report_no = $at_report_no;
			}
			
			if($at_report_no != ""){
				
				$this->search($org_no ,$at_report_no );

				// メニュー情報を取得、セットする
				$this->setMenu();

				$this->smarty->assign('form',$this->form);
				$this->smarty->display ( 'atReportDisplayList.html' );
				
			} else {
				TransitionHelper::sendException ( E001 );
				return;
			}

		} else {
			LogHelper::logDebug("login check no ");
			
			TransitionHelper::sendException ( E002 );
			return;
		}
		
	}
	
	/*
	 *
	 * 検索処理
	 */
	public function search($org_no , $at_report_no ){

		$service = new AtReportService($this->pdo);
		
		//検索結果を取得
		$list = $service->getAtReportDisplayList ($org_no, $at_report_no);
		$count = count($list);
		
		$reportData = $service->getReportData ($org_no, $at_report_no);
		$this->smarty->assign('at_report_name', $reportData[0]->at_report_name);

		LogHelper::logDebug ($list);
		if($count > 0){
			
			$this->smarty->assign('addlist', $list);
			$this->smarty->assign('list', NULL);

		} else {
			// エラーメッセージを設定　「検索結果がありません」
			$err_msg = W001;
			$this->smarty->assign('addlist',NULL);
			$this->smarty->assign('list',NULL);
			$this->smarty->assign('err_msg',$err_msg);
		}
		
		if (isset($_SESSION['save_msg'])){
			$msg = $_SESSION['save_msg'];
			$this->smarty->assign('err_msg', $msg);
			
			unset($_SESSION['save_msg']);
			unset($_SESSION['org_no']);
			unset($_SESSION['at_report_no']);
		}
		LogHelper::logDebug ($msg);
	}

	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {

		//登録完了
		$this->setBackData();

		// リポート一覧画面へ遷移する
		$this->dispatch('AtReportList/Search');

	}

	/*
	 * 戻る場合のデータセット
	 */
	public function setBackData() {
		$_SESSION ['back_flg'] = true;
		$_SESSION ['search_page'] = $this->form->search_page;
		$_SESSION ['search_page_row'] = $this->form->search_page_row;
		$_SESSION ['search_page_order_column'] = $this->form->search_page_order_column;
		$_SESSION ['search_page_order_dir'] = $this->form->search_page_order_dir;
		$_SESSION ['search_test_info_name'] = $this->form->search_test_info_name;
		$_SESSION ['search_at_report_name'] = $this->form->search_at_report_name;
		$_SESSION ['search_chk_status2'] = $this->form->search_chk_status2;
		$_SESSION ['search_org_id'] = $this->form->search_org_id;

	}

	/*
	 *
	 * 登録処理
	 */
	public function saveAction() {

		if ($this->check_login () == true) {

			$service = new AtReportService ( $this->pdo );

			$org_no = $this->form->org_no;

			$at_report_no = $this->form->at_report_no;

			// 削除処理
			
			$insertDataList = explode ( ',', $this->form->entryList );

			$display_no = 0;
			foreach ( $insertDataList as $insertData ) {
				
				if ($display_no == 0){
					
					$service-> deleteDataOnAtReport( $org_no, $at_report_no);
				}

				if ($insertData != null || $insertData != "") {
					
					$data = explode("-", $insertData);

					$dto = new T_At_Report_DetailDto();
					$dto->org_no = $org_no;
					$dto->at_report_no = $at_report_no;
					$dto->at_type = $data[0];
					$dto->at_no = $data[1];
					$dto->offer_no = $data[2];
					$dto->disp_no = ++$display_no;
					$dto->del_flg = '0';
					$dto->create_dt = DateUtil::getDate("Y/m/d H:i:s");;
					$dto->update_dt = DateUtil::getDate("Y/m/d H:i:s");;
					$dto->creater_id = $_SESSION['admin_no'];
					$dto->updater_id = $_SESSION['admin_no'];

					$result = $service->insertReportDetail ( $dto );
				}
			}

			if ( $result == 1 ){

				$_SESSION['org_no'] = $org_no ;
				$_SESSION['at_report_no'] = $at_report_no ;
				$_SESSION['save_msg'] = I004;
				$this->dispatch('AtReportDisplayList/index');
			} else {
				// 更新出来ない場合、
				$error = sprintf(E007,'登録');
				$this->smarty->assign ( 'msg', $error );
				$this->smarty->assign('form', $this->form);
				$this->smarty->display ( 'atReportDisplayList.html' );

			}

		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}
}

?>