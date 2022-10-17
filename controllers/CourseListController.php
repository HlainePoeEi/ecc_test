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
require_once 'service/TypeService.php';
require_once 'util/DateUtil.php';

/**
 * コース一覧コントローラー
 */
class CourseListController extends BaseController {

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
			$this->form->admin_no = $_SESSION ["admin_no"];

			$search_test_kbn = explode(',',$this->form->search_test_kbn);
			$search_course_level = array_filter(explode(' ',str_replace(',',' ',$this->form->search_course_level)));

			$type_service = new TypeService($this->pdo);
			$test_kbn = $type_service->getCategoryTypeAll(TEST_KBN);
			$course_level_list = $type_service->getCategoryTypeAll(COURSE_LEVEL_KBN);

			$service = new CourseService($this->pdo);
			$list = $service->getCourseList($this->form , "0");
			$count = count($list);

			if ( $count > 0 ){

				$this->form->max_page = ceil($count/ PAGE_ROW);
				$list = $service->getCourseList($this->form , "1");
				// </'>を<'>に置き換える
				for ( $i = 0; $i < count($list); $i++ ) {
					if($list[$i]->course_name != ''){
						$list[$i]->course_name = str_replace("\'", "'", $list[$i]->course_name);
					}
				}

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

			$this->smarty->assign('search_test_kbn', $search_test_kbn);
			$this->smarty->assign('search_course_level', $search_course_level);
			$this->smarty->assign('test_kbn', $test_kbn);
			$this->smarty->assign('course_level_list', $course_level_list);
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'courseList.html' );
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
			$test_kbn = $type_service->getCategoryTypeAll(TEST_KBN);
			$course_level_list = $type_service->getCategoryTypeAll(COURSE_LEVEL_KBN);

			$status = explode(',',$this->form->search_status);
			foreach ($status as $value){
				if($value == 0){
					$this->form->chk_status2 = $value;
				}else{
					$this->form->chk_status1 = $value;
				}
			}

			//検索条件戻し
			if ( $this->form->back_flg ){

				$this->form->page = $this->form->search_page;
				$this->form->start_period = $this->form->search_start_period;
				$this->form->end_period = $this->form->search_end_period;
				$this->form->course_name = $this->form->search_course_name;
				$this->form->status = $this->form->search_status;

				if ( empty($this->form->start_period) ){

					$this->form->start_period = DateUtil::getDateAddMonth("-1","Y/m/d");
					$this->form->end_period = DateUtil::getDateAddMonth("1","Y/m/d");
				}

				//初期化
				$this->form->back_flg = false;
				$this->form->search_page = "";
				$this->form->search_start_period = "";
				$this->form->search_end_period = "";
				$this->form->search_course_name = "";
				$this->form->search_status = "";
			}

			if ( empty($this->form->page) ){

				$this->form->page = 1;
			}

			$err_msg = "";
			$search_test_kbn = explode(',',$this->form->search_test_kbn);
			$search_course_level = array_filter(explode(' ',str_replace(',',' ',$this->form->search_course_level)));

			$service = new CourseService($this->pdo);
			$list = $service->getCourseList($this->form , "0");
			$count = count($list);

			if ( $count > 0 ){

				$this->form->max_page = ceil($count/ PAGE_ROW);
				$this->smarty->assign( 'err_msg','' );
				$list = $service->getCourseList($this->form , "1");
				$this->smarty->assign( 'list', $list );

			}else {
				// エラーメッセージを設定「検索結果がありません」
				$this->smarty->assign( 'error_msg', W001 );
				$this->smarty->assign( 'list', Null );
			}

			$this->smarty->assign('search_test_kbn', $search_test_kbn);
			$this->smarty->assign('search_course_level', $search_course_level);
			$this->smarty->assign('test_kbn', $test_kbn);
			$this->smarty->assign('course_level_list', $course_level_list);
			$this->smarty->assign( 'err_msg', $err_msg );
			$this->smarty->assign( 'info_msg', "" );
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'courseList.html' );
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 削除処理
	 */
	public function deleteAction() {

		if ( $this->check_login() == true ){

			$user_id = $_SESSION ['admin_no'];
			$course_id = $this->form->course_id;
			$service = new CourseService($this->pdo);

			if ( $course_id != "" ){

				$CourseDto = new T_CourseDto();
				$CourseDto->course_id = $course_id;
				$CourseDto->updater_id = $user_id;
				$CourseDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );

				$result = $service->delCourseData($CourseDto);

				// 削除処理成功の場合
				if ( $result > 0 ){

					$this->smarty->assign( 'info_msg', "" );
					$this->smarty->assign( 'error_msg', I005 );
					$this->displayValue($this->form);

				}else {

					$error_msg = sprintf( E007, '削除' );
					$this->smarty->assign( 'error_msg', $error_msg );
					$this->smarty->assign( 'info_msg', "" );
					$this->displayValue($this->form);
					return;
				}
			}
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 画面上値設定処理
	 */
	public function displayValue($myForm) {

		$course_level = COURSE_LEVEL_KBN;
		$test_kbn = TEST_KBN;

		$service = new TypeService($this->pdo);
		$courseLevel = $service->getCategoryTypeAll($course_level);
		$testKbn = $service->getCategoryTypeAll($test_kbn);

		$this->smarty->assign( 'status', $myForm->status );
		$this->smarty->assign( 'courseLevel', $courseLevel );
		$this->smarty->assign( 'testKbn', $testKbn );
		$this->smarty->assign( 'type', $myForm->test_kbn );
		$this->smarty->assign( 'ctype', $myForm->course_level );
		$this->smarty->assign( 'search_start_period', $this->form->search_start_period );
		$this->smarty->assign( 'search_end_period', $this->form->search_end_period );
		$this->smarty->assign( 'search_course_name', $this->form->search_course_name );
		$this->smarty->assign( 'form', $myForm );
		$this->indexAction();
	}
}

?>