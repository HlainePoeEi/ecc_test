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
require_once 'service/OrganizationService.php';
require_once 'util/DateUtil.php';

/**
 * 組織一覧コントローラー
 */
class OrganizationListController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			$this->form->page = 1;
			$start_period = DateUtil::getDateAddMonth(-1,'Y/m/d');
			$end_period = DateUtil::getDateAddMonth(1,'Y/m/d');

			$this->form->start_period = $start_period;
			$this->form->end_period = $end_period;
			$this->form->chk_status1 = "";
			$this->form->chk_status2 = "";
			$this->form->chk_status3 = "";
			$this->form->admin_no = $_SESSION ['admin_no'];
			$service = new OrganizationService($this->pdo);

			$list = $service->getOrganizationList($this->form , "0");
			$count = count ($list);

			if ( $count > 0 ){

				$this->smarty->assign( 'err_msg', "" );
				$this->form->max_page = ceil($count/ PAGE_ROW);
				$org_list = $service->getOrganizationList($this->form , "1");
				$this->smarty->assign( 'list', $org_list);
			}else {
				// エラーメッセージを設定「検索結果がありません」
				$err_msg = W001;
				$this->smarty->assign( 'list', Null );
				$this->smarty->assign( 'err_msg', $err_msg );
			}
			$this->setMenu();
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'organizationList.html' );
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 画面検索ボタン処理
	 */
	public function searchAction() {

		if ( $this->check_login() == true ){

			if ( empty($this->form->page) ){

				$this->form->page = 1;
			}
			$err_msg = "";
			if ( isset( $_SESSION ['back_flg']) &&  ($_SESSION ['back_flg'] != "") ){

				if ( $_SESSION ['search_page'] != "" ){
					$this->form->page = $_SESSION ['search_page'];
				}else {
					$this->form->page = 1;
				}

				if ( $_SESSION ['search_start_period'] != "" ){
					$this->form->start_period= $_SESSION ['search_start_period'];
				}else {
					$this->form->start_period= DateUtil::getDateAddMonth(-1,'Y/m/d');
				}

				if ( $_SESSION ['search_end_period'] != "" ){
					$this->form->end_period = $_SESSION ['search_end_period'];
				}else {
					$this->form->end_period= DateUtil::getDateAddMonth(1,'Y/m/d');
				}

				$this->form->org_name = $_SESSION ['search_org_name'];
				$this->form->chk_status1 = $_SESSION ['search_chk_status1'];
				$this->form->chk_status2 = $_SESSION ['search_chk_status2'];
				$this->form->chk_status3 = $_SESSION ['search_chk_status3'];
				$this->form->status = $_SESSION ['search_chk_status'];

				$_SESSION ['search_start_period'] = "";
				$_SESSION ['search_end_period'] = "";
				$_SESSION ['search_org_name'] = "";
				$_SESSION ["search_chk_status"] = "";
				$_SESSION ["search_chk_status1"] = "";
				$_SESSION ["search_chk_status2"] = "";
				$_SESSION ["search_chk_status3"] = "";
				$_SESSION ['back_flg'] = false;
			}

			$service = new OrganizationService($this->pdo);
			$list= $service->getOrganizationList($this->form, "0");
			$count = count ($list);

			if ( $count > 0 ){

				$this->form->max_page = ceil($count/ PAGE_ROW);
				$this->smarty->assign( 'err_msg', '' );
				$org_list = $service->getOrganizationList($this->form , "1");
				$this->smarty->assign( 'list', $org_list);

			}else {
				// エラーメッセージを設定「検索結果がありません」
				$err_msg = W001;
				$this->smarty->assign( 'list', Null );
				$this->smarty->assign( 'err_msg', $err_msg );
			}
			if ( isset($_SESSION ['regist_msg_org']) && $_SESSION ['regist_msg_org'] != "" ){
				$this->smarty->assign('err_msg',$_SESSION ['regist_msg_org']);
				$_SESSION ['regist_msg_org'] = "";
			}
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'organizationList.html' );
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}
}

?>