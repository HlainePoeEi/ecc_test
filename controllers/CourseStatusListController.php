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
require_once 'service/CourseStatusService.php';
require_once 'util/DateUtil.php';

/**
 * コース受講状況一覧コントローラー
 */
class CourseStatusListController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			$this->form->page = 1;
			/* 2019/09/05 初期値消す */
			/* $start_period = DateUtil::getDateAddMonth(-1,'Y/m/d');
			$end_period = DateUtil::getDateAddMonth(1,'Y/m/d');

			$this->form->start_period = $start_period;
			$this->form->end_period = $end_period; */
			$this->form->status = 2;
			$this->form->answer_flg = 2;
			
			
			/** 初期表示では検索しない 2019.07.12
			$service = new CourseStatusService($this->pdo);
			$list = $service->getCourseList($this->form , "0");
			$count = count($list);

			if ( $count > 0 ){

				$this->smarty->assign( 'info_msg', "" );
				$this->smarty->assign( 'err_msg', "" );
				$this->form->max_page = ceil($count/ PAGE_ROW);
				$list = $service->getCourseList($this->form , "1");
				$this->smarty->assign( 'list', $list );
			}else {
				// エラーメッセージを設定「検索結果がありません」
				$err_msg = W001;
				$this->smarty->assign( 'list', Null );
				$this->smarty->assign( 'err_msg', $err_msg );
			}
			*/

			$this->setMenu();
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'courseStatusList.html' );
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

				$this->form->page = $_SESSION ['search_page'];
				$this->form->start_period = $_SESSION ['search_start_period'];
				$this->form->end_period = $_SESSION ['search_end_period'];
				$this->form->detail_name = $_SESSION ['search_detail_name'];
				$this->form->student_name = $_SESSION ['search_student_name'];
				$this->form->login_id = $_SESSION ['search_login_id'];
				$this->form->org_id= $_SESSION ['org_id'];
				$this->form->status = $_SESSION ['search_chk_status'];
				$this->form->answer_flg= $_SESSION ['search_chk_status'];

				$_SESSION ['search_start_period'] = "";
				$_SESSION ['search_end_period'] = "";
				$_SESSION ['search_detail_name'] = "";
				$_SESSION ['org_id'] = "";
				$_SESSION ["search_chk_status"] = "";
				$_SESSION ['back_flg'] = false;
			}

			$service = new CourseStatusService($this->pdo);
			$list = $service->getCourseList($this->form , "0");
			$count = count($list);

			if ( $count > 0 ){

				$this->form->max_page = ceil($count/ PAGE_ROW);
				$this->smarty->assign( 'err_msg', '' );
				$list = $service->getCourseList($this->form , "1");
				$this->smarty->assign( 'list', $list );

			}else {
				// エラーメッセージを設定「検索結果がありません」
				$err_msg = W001;
				$this->smarty->assign( 'list', Null );
				$this->smarty->assign( 'err_msg', $err_msg );
			}

			$this->smarty->assign( 'err_msg', $err_msg );
			$this->smarty->assign( 'info_msg', "" );
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'courseStatusList.html' );
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}
}

?>