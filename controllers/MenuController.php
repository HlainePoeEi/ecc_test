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
require_once 'dao/T_System_NoticeDao.php';
require_once 'service/MaintenanceService.php';

/**
 * 問い合わせ検索コントローラー
 */
class MenuController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			$service = new MaintenanceService($this->pdo);
			$statusList = $service->getMaintenanceStatus(TARGET_KBN);

			$arr = [];
			$status_msg = "";
			$j = 0;
			for ($i=0; $i < count($statusList); $i++){

				if ($statusList[$i]->system_status == 1){

					$arr[$j] = $statusList[$i]->name;
					$j++;
				}

			}

			// メニュー情報を取得、セットする
			$this->setMenu();

			$dao = new T_System_NoticeDao($this->pdo);

			$noticeList = $dao->getNoticeList();

			//uidセット
			$this->createUid();

			if (isset($_SESSION ['login_time']) && !StringUtil::isEmpty($_SESSION ['login_time'])){
				$this->smarty->assign( 'login_time', $_SESSION ['login_time'] );
			}

				/**
			 * セッションにあるメッセージを出す
			 */
			if ( isset($_SESSION ['regist_msg']) ){
				if ( $_SESSION ['regist_msg'] != "" ){
					$this->smarty->assign( 'info_msg',$_SESSION ['regist_msg'] );
					$_SESSION ['regist_msg'] = "";
				}
			}
			//menuOpen
			$this->smarty->assign( 'menuOpen', "open" );
			$this->smarty->assign( 'noticeList', $noticeList );
			$this->smarty->assign( 'statusArr', $arr);
			$this->smarty->assign('form',$this->form);
			$this->smarty->display( 'menu.html' );
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * menu
	 */
	public function menuAction() {

		// メニュー情報を取得、セットする
		$this->setMenu();

		$dao = new T_System_NoticeDao($this->pdo);

		$noticeList = $dao->getNoticeList();

		$this->smarty->assign( 'noticeList', $noticeList );
		$this->smarty->assign( 'error_msg', "" );
		$this->smarty->display( 'menu.html' );
	}

	/**
	 * ログアウト処理
	 */
	public function logoutAction() {

		session_unset ();
		$this->dispatch('Login');
	}
}

?>