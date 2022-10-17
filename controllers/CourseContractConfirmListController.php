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
require_once 'util/DateUtil.php';

/**
 * コース契約確認コントローラー
 */
class CourseContractConfirmListController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ) {

			$this->setMenu();
			$start_period = DateUtil::getDateAddMonth(-1,'Y/m/d');
			$end_period = DateUtil::getDateAddMonth(1,'Y/m/d');
			$this->form->start_period = $start_period;
			$this->form->end_period = $end_period;
			$this->form->org_id = "";
			$this->form->course_id_from = "";
			$this->form->course_id_to = "";
			$this->form->login_id_from = "";
			$this->form->login_id_to = "";

			$err_msg = "";
			if ( empty($this->form->page) ) {

				$this->form->page = 0;
			}
			
			/** 初期処理では検索しない 2019.07.12
			$service = new CourseService($this->pdo);
			$list = $service->getCourseContractConfirmList($this->form , "0");
			$count = count($list);

			if ( $count > 0 ) {

				$this->form->max_page = ceil($count/ PAGE_ROW);
				$this->smarty->assign( 'err_msg','' );
				$list = $service->getCourseContractConfirmList($this->form , "1");
				$this->smarty->assign( 'list', $list );

			}else {
				// エラーメッセージを設定「検索結果がありません」
				$this->smarty->assign( 'error_msg', "" );
				$this->smarty->assign( 'list', Null );
			}*/
			
			$this->form->page_cccl = 0;
			$this->form->page_row_cccl = 10;
			$this->form->page_order_column_cccl = 1;
			$this->form->page_order_dir_cccl = true;

			$this->smarty->assign( 'err_msg', $err_msg );
			$this->smarty->assign( 'info_msg', "" );
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'courseContractConfirmList.html' );

		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 画面検索ボタン処理
	 */
	public function searchAction() {

		if ( $this->check_login() == true ) {

			//検索条件戻し
			if ( $this->form->back_flg ) {

				$this->form->page = $this->form->search_page;
				$this->form->start_period = $this->form->search_start_period;
				$this->form->end_period = $this->form->search_end_period;
				$this->form->org_id = $this->form->search_org_id;
				$this->form->course_id_from = $this->form->search_course_id_from;
				$this->form->course_id_to = $this->form->search_course_id_to;
				$this->form->login_id_from = $this->form->search_login_id_from;
				$this->form->login_id_to = $this->form->search_login_id_to;
				
				$this->form->page_cccl = $_SESSION ['page_cccl'];
				$this->form->page_row_cccl = $_SESSION ['page_row_cccl'];
				$this->form->page_order_column_cccl = $_SESSION ['page_order_column_cccl'];
				$this->form->page_order_dir_cccl = $_SESSION ['page_order_dir_cccl'];
			
				//初期化
				$this->form->back_flg = false;
				$this->form->search_page = "";
				$this->form->search_start_period = "";
				$this->form->search_end_period = "";
				$this->form->search_org_id = "";
				$this->form->search_course_id_from = "";
				$this->form->search_course_id_to = "";
				$this->form->search_login_id_from = "";
				$this->form->search_login_id_to = "";
				
				$_SESSION ['page_cccl'] = "";
				$_SESSION ['page_row_cccl'] = "";
				$_SESSION ['page_order_column_cccl'] = "";
				$_SESSION ['page_order_dir_cccl'] = "";

			}if ( isset($_SESSION ['delete_msg']) && $_SESSION ['delete_msg'] !="" ){

				$this->smarty->assign( 'info_msg', $_SESSION ['delete_msg']);
				$this->form->page = $_SESSION ['page'];
				$this->form->start_period = $_SESSION ['start_period'];
				$this->form->end_period = $_SESSION ['end_period'];
				$this->form->org_id = $_SESSION ['org_id'];
				$this->form->course_id_from = $_SESSION ['course_id_from'];
				$this->form->course_id_to = $_SESSION ['course_id_to'];
				$this->form->login_id_from = $_SESSION ['login_id_from'];
				$this->form->login_id_to = $_SESSION ['login_id_to'];
				
				$this->form->page_cccl = $_SESSION ['page_cccl'];
				$this->form->page_row_cccl = $_SESSION ['page_row_cccl'];
				$this->form->page_order_column_cccl = $_SESSION ['page_order_column_cccl'];
				$this->form->page_order_dir_cccl = $_SESSION ['page_order_dir_cccl'];

				$_SESSION ['delete_msg'] = "";
				$_SESSION ['page'] = "";
				$_SESSION ['start_period'] = "";
				$_SESSION ['end_period'] = "";
				$_SESSION ['org_id'] = "";
				$_SESSION ['course_id_from'] = "";
				$_SESSION ['course_id_to']= "";
				$_SESSION ['login_id_from'] = "";
				$_SESSION ['login_id_to']= "";
				
				$_SESSION ['page_cccl'] = "";
				$_SESSION ['page_row_cccl'] = "";
				$_SESSION ['page_order_column_cccl'] = "";
				$_SESSION ['page_order_dir_cccl'] = "";
			}

			if ( empty($this->form->page) ) {

				$this->form->page = 0;
			}

			$err_msg = "";
			$service = new CourseService($this->pdo);
			$list = $service->getCourseContractConfirmList($this->form , "0");
			$count = count($list);

			if ( $count > 0 ) {

				$this->smarty->assign( 'err_msg','' );
				$this->smarty->assign( 'list', $list );

			}else {
				// エラーメッセージを設定「検索結果がありません」
				$this->smarty->assign( 'error_msg', W001 );
				$this->smarty->assign( 'list', Null );
			}

			$this->smarty->assign( 'err_msg', $err_msg );
			$this->smarty->assign( 'info_msg', "" );
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'courseContractConfirmList.html' );
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * Csvダウンロードボタン押下処理
	 *
	 */
	public function csvWocAction () {

		if ( $this->check_login() == true ) {

			// メニュー情報を取得、セットする
			$this->setMenu();

			if ( empty($this->form->page) ) {
				$this->form->page = 1;
			}

			$service = new CourseService($this->pdo);
			$list = $service->getCourseContractConfirmList($this->form , "0");

			$fileName = COURSE_CONTRACT_CONFIRM_OUTPUT. "_" . date('YmdHis') . ".csv";

			$this->array_to_csv_download($list,$fileName);
			$this->smarty->assign ( 'list', $list);
			$err_msg="";

			$this->smarty->assign ( 'error', '' );
			return;

		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
		$this->smarty->display ( 'courseContractConfirmList.html' );
	}

	/**
	 * csv ダウンロード処理
	 */
	private function array_to_csv_download($array, $filename) {

		header('Content-Encoding: UTF-8');
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename= ' . $filename);
		$output = fopen("php://output", "w");
		fprintf( $output, "\xEF\xBB\xBF");

		$test_status_csvtitle = unserialize (COURSE_CONTRACT_CONFIRM_LIST);
		if ( count($array) > 0){
			fputcsv($output, $test_status_csvtitle);
		}else{
			$msg = array(W001);
			fputcsv($output, $msg);
		}

		foreach ( $array as $row ) {

			fputcsv($output, array($row->org_id, $row->org_name, $row->org_name_official,$row->offer_no, $row->course_id, $row->course_name,$row->co_start_period, $row->co_end_period, $row->remarks, $row->login_id, $row->student_name,$row->course_detail_name, $row->cds_start_period, $row->cds_end_period, $row->a_answer_dt, $row->u_update_dt,$row->teacher_code, $row->teacher_name, $row->teacher_school, $row->result));

		}
		fclose($output);
	}
}