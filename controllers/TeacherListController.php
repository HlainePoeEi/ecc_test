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
require_once 'service/TeacherService.php';
require_once 'service/TypeService.php';
require_once 'util/DateUtil.php';

/**
 * 講師一覧コントローラー
 */
class TeacherListController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			$start_period = DateUtil::getDateAddMonth(-1,'Y/m/d');
			$end_period = DateUtil::getDateAddMonth(1,'Y/m/d');
			$this->form->page = 1;
			$this->form->start_period = $start_period;
			$this->form->end_period = $end_period;
			$search_school_kbn = explode(',',$this->form->search_school_kbn);

			$type_service = new TypeService($this->pdo);
			$school_kbn = $type_service->getCategoryTypeAll(SCHOOL_KBN);

			$service = new TeacherService($this->pdo);
			$list = $service->getTeacherList($this->form , "0");
			$count = count($list);

			if ( $count > 0 ){

				$this->form->max_page = ceil($count/ PAGE_ROW);
				$list = $service->getTeacherList($this->form , "1");

				$this->smarty->assign( 'list', $list );
				$this->smarty->assign( 'info_msg', "" );
				$this->smarty->assign( 'err_msg', "" );
			}else {
				// エラーメッセージを設定「検索結果がありません」
				$err_msg = W001;
				$this->smarty->assign( 'list', Null );
				$this->smarty->assign( 'err_msg', $err_msg );
			}

			$this->setMenu();
			$this->smarty->assign( 'search_school_kbn', $search_school_kbn );
			$this->smarty->assign( 'school_kbn', $school_kbn );
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'teacherList.html' );
		}else {

			TransitionHelper::sendException( E002 );
			return;
		}
	}

	/**
	 * 画面検索ボタン処理
	 */
	public function searchAction() {

		if ( $this->check_login() == true ){

			$type_service = new TypeService($this->pdo);
			$school_kbn = $type_service->getCategoryTypeAll(SCHOOL_KBN);

			//検索条件戻し
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

				if ( isset($_SESSION ['regist_msg_tchr']) ){

					if ( $_SESSION ['regist_msg_tchr'] != "" ){

						$this->smarty->assign( 'error_msg',$_SESSION ['regist_msg_tchr'] );
						$_SESSION ['regist_msg_tchr'] = "";
					}
				}

				$this->form->teacher_name = $_SESSION ['search_name'];
				$this->form->search_school_kbn = $_SESSION ['search_school_kbn'];

				$_SESSION ['search_start_period'] = "";
				$_SESSION ['search_end_period'] = "";
				$_SESSION ['search_name'] = "";
				$_SESSION ['back_flg'] = false;
			}

			$err_msg = "";

			$service = new TeacherService($this->pdo);
			$list = $service->getTeacherList($this->form , "0");
			$count = count($list);

			if ( $count > 0 ){

				$this->form->max_page = ceil($count/ PAGE_ROW);
				if ( $this->form->page > $this->form->max_page ){

					$this->form->page = 1;
				}
				$this->smarty->assign( 'err_msg','' );
				$list = $service->getTeacherList($this->form , "1");
				$this->smarty->assign( 'list', $list );
			}else {
				// エラーメッセージを設定「検索結果がありません」
				$this->smarty->assign( 'error_msg', W001 );
				$this->smarty->assign( 'list', Null );
			}
			$search_school_kbn = explode(',',$this->form->search_school_kbn);
			$this->smarty->assign( 'search_school_kbn', $search_school_kbn);
			$this->smarty->assign( 'school_kbn', $school_kbn );
			$this->smarty->assign( 'err_msg', $err_msg );
			$this->smarty->assign( 'info_msg', "" );
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'teacherList.html' );
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}
}
?>