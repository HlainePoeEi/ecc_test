<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
header('content-type: text/html; charset=utf-8');

require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'dto/PageDto.php';
require_once 'util/DateUtil.php';
require_once 'util/StringUtil.php';
require_once 'helper/LogHelper.php';

/**
 * 課題模範解答送信コントローラー
 */
class ReportDetailViewController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		/* if ($this->check_maintenance() == true) {
			
			if ($this->check_login() == true){
				
				// ログインユーザのorg_no
				$org_no = $_SESSION['org_no'];
				$login_id = $_SESSION['login_id'];
				$this->form->org_no = $org_no;
                $this->form->login_id = $login_id;

                $report_no = $this->form->report_no ;
				
				if($report_no != ""){

					// メニュー情報を取得、セットする
					$this->setMenu();

					$this->smarty->assign('form',$this->form);
					$this->smarty->display ( 'reportDetailView.html' );
					
				} else {
					TransitionHelper::sendException ( E001 );
					return;
				}
			}else {
				TransitionHelper::sendException ( E002 );
				return;
			}
		}else {

			TransitionHelper::sendMaintenance ( $_SESSION ['error_message']);
			return;
		} */
	}


	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {
		if ($this->check_login() == true) {

			//登録完了
			$this->setBackData();

			// report一覧画面へ遷移する
			$this->dispatch('ReportList/Search');
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	//slpp
	public function setBackData() {

		LogHelper::logDebug("back action in Regist!");

		$_SESSION ['back_flg'] = true;
		$_SESSION ['search_page'] = $this->form->search_page;
		$_SESSION ['search_page_row'] = $this->form->search_page_row;
		$_SESSION ['search_page_order_column'] = $this->form->search_page_order_column;
		$_SESSION ['search_page_order_dir'] = $this->form->search_page_order_dir;
		$_SESSION ['search_test_info_name'] = $this->form->search_test_info_name;
		//slpp
		$_SESSION ['search_report_name'] = $this->form->search_report_name;
		$_SESSION ['search_org_id'] = $_SESSION['org_no'];;

		LogHelper::logDebug("--------back----".$_SESSION ['search_page'].'--'.$_SESSION ['search_page_row'].'--'.	$_SESSION ['search_page_order_column'].'--'.$_SESSION ['search_page_order_dir'].'--'.$_SESSION ['search_test_info_name'].'--'.$_SESSION ['search_chk_status2'].'--'.$_SESSION ['search_org_id']);
		LogHelper::logDebug('search_page: '.$_SESSION['search_page']);
		LogHelper::logDebug('report_name: '.$_SESSION['search_report_name']);
	}

}

?>