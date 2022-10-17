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
require_once 'service/CourseService.php';
require_once 'service/QuestionService.php';
require_once 'util/DateUtil.php';

/**
 * コース契約一覧コントローラー
 */
class CourseContractListController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			$this->form->page = 1;
			$service = new CourseService($this->pdo);
			$ques_service = new QuestionService($this->pdo);
			$start_period = DateUtil::getDateAddMonth(-1,'Y/m/d');
			$end_period = DateUtil::getDateAddMonth(1,'Y/m/d');
			$this->form->start_period = $start_period;
			$this->form->end_period = $end_period;
			$this->form->sc_org_id = "";
			$this->form->sc_org_name = "";
			$this->form->sc_course_level = "";
			$this->form->sc_test_kbn = "";
			$this->form->sc_course_name = "";
			// テスト区分リスト取得する
			$this->form->test_kbn_list = $ques_service->getCategoryTypeAll(TEST_KBN);
			// コースレベルリスト取得する
			$this->form->course_level_list = $ques_service->getCategoryTypeAll(COURSE_LEVEL_KBN);
			// チェックされたチェックボックスリストにnullを設定する
			$ck_cl_list = "";
			$ck_tk_list = "";
			$this->form->admin_no = $_SESSION["admin_no"];
			$err_msg = "";
			
			$this->form->page_ccl = 0;
			$this->form->page_row_ccl = 10;
			$this->form->page_order_column_ccl = 1;
			$this->form->page_order_dir_ccl = true;

			$list = $service->getCourseContractList($this->form , "");
			// コース契約カウント
			$count = count($list);
			// コース契約一覧がある場合、
			if ( $count > 0 ){
				$this->smarty->assign( 'info_msg', "" );
				$this->smarty->assign( 'err_msg', "" );
				$this->form->max_page = ceil($count / PAGE_ROW);
				$this->smarty->assign('list', $list);
			}
			// コース契約一覧がないの場合、
			else {
				// エラーメッセージを設定　「検索結果がありません」
				$err_msg = W001;
				$this->smarty->assign( 'list', Null );
				$this->smarty->assign( 'err_msg', $err_msg );
			}
			$this->setMenu();
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->assign( 'ck_cl_list', $ck_cl_list );
			$this->smarty->assign( 'ck_tk_list', $ck_tk_list );
			$this->smarty->display( 'courseContractList.html' );
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

			// 削除条件戻し
			if ( isset($_SESSION ['search_start_period']) ){
				if( $_SESSION["search_start_period"] != ''){
					$this->form->start_period = $_SESSION["search_start_period"];
				}
			}
			if ( isset($_SESSION ['search_end_period']) ){
				if( $_SESSION["search_end_period"] != ''){
					$this->form->end_period = $_SESSION["search_end_period"];
				}
			}
			if ( isset($_SESSION ['search_course_name']) ){
				if( $_SESSION["search_course_name"] != ''){
					$this->form->sc_course_name = $_SESSION["search_course_name"];
				}
			}
			if ( isset($_SESSION ['search_test_kbn']) ){
				if( $_SESSION["search_test_kbn"] != ''){
					$this->form->sc_test_kbn = $_SESSION["search_test_kbn"];
				}
			}
			if ( isset($_SESSION ['search_course_level']) ){
				if( $_SESSION["search_course_level"] != ''){
					$this->form->sc_course_level = $_SESSION["search_course_level"];
				}
			}
			if ( isset($_SESSION ['search_org_name']) ){
				if( $_SESSION["search_org_name"] != ''){
					$this->form->sc_org_name = $_SESSION["search_org_name"];
				}
			}
			if ( isset($_SESSION ['search_org_id']) ){
				if( $_SESSION["search_org_id"] != ''){
					$this->form->sc_org_id = $_SESSION["search_org_id"];
				}
			}
			if ( isset($_SESSION ['search_page']) ){
				if( $_SESSION["search_page"] != ''){
					$this->form->page = $_SESSION["search_page"];
				}
			}
			// 削除のメッセージをセットする
			if ( isset($_SESSION ['error_msg']) ){
				if( $_SESSION["error_msg"] != ''){
					$err_msg = $_SESSION["error_msg"];
				}else {
					$err_msg = "";
				}
			}else {
				$err_msg = "";
			}

			//検索条件戻し
			if ( $this->form->back_flg ){

				$this->form->page = $this->form->search_page;
				$this->form->start_period = $this->form->search_start_period;
				$this->form->end_period = $this->form->search_end_period;
				$this->form->sc_org_id = $this->form->search_org_id;
				$this->form->sc_org_name = $this->form->search_org_name;
				$this->form->sc_test_kbn = $this->form->search_test_kbn;
				$this->form->sc_course_level = $this->form->search_course_level;
				$this->form->sc_course_name = $this->form->search_course_name;

				if ( empty($this->form->start_period) ){

					$this->form->start_period = DateUtil::getDateAddMonth("-1","Y/m/d");
					$this->form->end_period = DateUtil::getDateAddMonth("1","Y/m/d");
				}

				$this->form->page_ccl = $_SESSION ['page_ccl'];
				$this->form->page_row_ccl = $_SESSION ['page_row_ccl'];
				$this->form->page_order_column_ccl = $_SESSION ['page_order_column_ccl'];
				$this->form->page_order_dir_ccl = $_SESSION ['page_order_dir_ccl'];
				
				//初期化
				$this->form->back_flg = false;
				$this->form->search_page = "";
				$this->form->org_no = "";
				$this->form->offer_no = "";
				$this->form->course_id = "";
				$this->form->search_start_period = "";
				$this->form->search_end_period = "";
				$this->form->search_org_id = "";
				$this->form->org_id = "";
				$this->form->search_org_name = "";
				$this->form->search_test_kbn = "";
				$this->form->search_course_level = "";
				$this->form->course_name = "";
				
				$_SESSION ['page_ccl'] = "";
				$_SESSION ['page_row_ccl'] = "";
				$_SESSION ['page_order_column_ccl'] = "";
				$_SESSION ['page_order_dir_ccl'] = "";
			}
			// ページを設定する
			if ( empty($this->form->page) ){

				$this->form->page = 0;
			}

			// チェックしたテスト区分リスト取得する
			$ck_tk_list = explode ( ',', $this->form->sc_test_kbn );
			// チェックしたコースレベルリスト取得する
			$ck_cl_list = explode ( ',', $this->form->sc_course_level );

			$service = new CourseService($this->pdo);
			$ques_service = new QuestionService($this->pdo);
			// テスト区分リスト取得する
			$this->form->test_kbn_list = $ques_service->getCategoryTypeAll(TEST_KBN);
			// コースレベルリスト取得する
			$this->form->course_level_list = $ques_service->getCategoryTypeAll(COURSE_LEVEL_KBN);
			// コース契約カウント
			$list = $service->getCourseContractList($this->form, "");
			$count = count($list);
			
			// コース契約一覧がある場合、
			if ( $count > 0 ){

				$this->form->max_page = ceil($count/ PAGE_ROW);
				$this->smarty->assign( 'err_msg',$err_msg );
				$this->smarty->assign('list', $list);

			}
			// コース契約一覧がないの場合、
			else {
				// エラーメッセージを設定　「検索結果がありません」
				$this->smarty->assign( 'err_msg', W001 );
				$this->smarty->assign( 'list', Null );
			}
			// セッションのエラーメッセージに""をセットする
			$_SESSION["error_msg"] = "";
			$_SESSION["search_start_period"] = "";
			$_SESSION["search_end_period"] = "";
			$_SESSION["search_course_name"] = "";
			$_SESSION["search_test_kbn"] = "";
			$_SESSION["search_course_level"] = "";
			$_SESSION["search_org_name"] = "";
			$_SESSION["search_org_id"] = "";
			$_SESSION["search_page"] = "";
			$this->smarty->assign( 'info_msg', "" );
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->assign( 'ck_cl_list', $ck_cl_list );
			$this->smarty->assign( 'ck_tk_list', $ck_tk_list );
			$this->smarty->display( 'courseContractList.html' );
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}
}
?>