<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'service/ReportService.php';
require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'dto/PageDto.php';
/**
 * レポート一覧コントローラー
 */
class ReportListController extends BaseController {

	/**
	 * 初期処理
	 */
    public function indexAction() {

		if ($this->check_login () == true) {
			
			$this->form->report_name = "";
			$this->form->test_info_name = "";
			$this->form->org_id = "";

			$this->form->search_page = 0;
			$this->form->search_page_row = 10;
			$this->form->search_page_order_column =1;
			$this->form->search_page_order_dir= true;

			$this->search($this->form);
			// メニュー情報を取得、セットする
			$this->setMenu();

			$this->smarty->assign('form',$this->form);
			$this->smarty->display ('reportList.html' );
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
    }

    private function search($form){

		$service= new ReportService($this->pdo);

		// 検索結果を取得
		$list = $service->getReportList($this->form , "0");
		$count = count($list);

		if(count($list) > 0){

			$this->smarty->assign('err_msg','');
			$this->smarty->assign('list',$list);

			} else {
			// エラーメッセージを設定　「検索結果がありません」
				$err_msg = W001;
				$this->smarty->assign('list',"");
				$this->smarty->assign('err_msg',$err_msg);
			}
    }
	/**
	 * 検索処理
	*/
    public function searchAction() {
		
		$err_msg = "";
		
		if(isset($_SESSION['regist_msg'])){
			if ($_SESSION ['regist_msg'] != ""){
				$this->smarty->assign('err_msg',$_SESSION ['regist_msg']);
				$_SESSION ['regist_msg'] = "";
			}
		}
	
		if ( isset( $_SESSION ['back_flg']) &&  ($_SESSION ['back_flg'] != "") ){
			LogHelper::logDebug("--------back----".$_SESSION ['search_report_name'].'--'.$_SESSION ['search_test_info_name'].'--'.	$_SESSION ['search_org_id']);
		
			$this->form->search_page = $_SESSION ['search_page'];
			$this->form->search_page_row = $_SESSION ['search_page_row'];
			$this->form->search_page_order_column = $_SESSION ['search_page_order_column'];
			$this->form->search_page_order_dir = $_SESSION ['search_page_order_dir'];
			$this->form->report_name = $_SESSION ['search_report_name'];
			$this->form->test_info_name = $_SESSION ['search_test_info_name'];
			$this->form->org_id = $_SESSION ['search_org_id'];
         
			if(empty($this->form->search_page)) {
				$this->form->search_page = 0;
				$this->form->search_page_row = 10;
				$this->form->search_page_order_column = 1;
				$this->form->search_page_order_dir = true;
			}
			
			//クリア
			$_SESSION ['search_page'] = "";
			$_SESSION ['search_page_row'] = "";
			$_SESSION ['search_page_order_column'] = "";
			$_SESSION ['search_page_order_dir'] = "";
			$_SESSION ['search_report_name'] = "";
			$_SESSION ['search_test_info_name'] = "";
			$_SESSION ['back_flg'] = false;
			
		}

		if ($this->check_login() == true){

			if(empty($this->form->page)){
				$this->form->page = 0;
			}
            
			$service= new ReportService($this->pdo);

			// メニュー情報を取得、セットする
			$this->setMenu();

			// 検索結果を取得
			$list = $service->getReportList($this->form , "0");
			$count= count($list);

			if($count > 0){

				$this->smarty->assign('list',$list);
				$this->smarty->assign ( 'err_msg', '');

			} else {
				// エラーメッセージを設定　「検索結果がありません」
				$err_msg = sprintf(W001);
				$this->smarty->assign('list',"");
				$this->smarty->assign('err_msg',$err_msg);
			}

			$this->smarty->assign('form',$this->form);
			$this->smarty->display('reportList.html');
		

		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
		
	}
}
?>
