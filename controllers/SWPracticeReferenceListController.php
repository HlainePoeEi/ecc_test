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
require_once 'util/DateUtil.php';
require_once 'service/TypeService.php';
require_once 'service/CourseService.php';

/**
 * SW Practice 参照コントローラー
 */
class SWPracticeReferenceListController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			if ( $this->form->search_page == null ){

				$this->form->page = 1;
			}else {

				$this->form->page = $this->form->search_page;
			}

			$this->getSWPracticeCourseList($this->form);
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	private function getSWPracticeCourseList($myForm){

		$type_service = new TypeService($this->pdo);
		$test_kbn = $type_service->getCategoryTypeAll(TEST_KBN);
		$course_level_list = $type_service->getCategoryTypeAll(COURSE_LEVEL_KBN);

		$course_service = new CourseService($this->pdo);

		$list = $course_service->getSWPracticeCourseList($this->form, 0);

		if ( count($list) > 0 ){

			$this->form->max_page = ceil(count($list)/ PAGE_ROW);
			$list = $course_service->getSWPracticeCourseList($this->form , "1");

			$this->smarty->assign('list', $list);
			$this->smarty->assign( 'info_msg', "" );
			$this->smarty->assign( 'err_msg', "" );
		}else {
			// エラーメッセージを設定　「検索結果がありません」
			$err_msg = W001;
			$this->smarty->assign( 'list', Null );
			$this->smarty->assign( 'error_msg', $err_msg );
		}

		$search_test_kbn = explode(',',$this->form->search_test_kbn);
		$search_course_level = array_filter(explode(' ',str_replace(',',' ',$this->form->search_course_level)));

		$status = explode(',',$this->form->status);
		foreach ( $status as $value ){

			if ( $value == 0 ){

				$this->form->chk_status2 = $value;
			}else {

				$this->form->chk_status1 = $value;
			}
		}

		$this->smarty->assign('search_test_kbn', $search_test_kbn);
		$this->smarty->assign('search_course_level', $search_course_level);
		$this->smarty->assign('test_kbn', $test_kbn);
		$this->smarty->assign('course_level_list', $course_level_list);
		$this->smarty->assign('form', $this->form);
		$this->smarty->display ( 'swPracticeReferenceList.html' );
	}

	/**
	 * 画面検索ボタン処理
	 */
	public function searchAction() {
		if ( $this->check_login() == true ){

			if ( $this->form->back_flg ){

				$this->form->page = $this->form->search_page;
				$this->form->test_kbn = $this->form->search_test_kbn;
				$this->form->course_level = $this->form->search_course_level;
				$this->form->name = $this->form->search_name;
				$this->form->remarks = $this->form->search_remarks;
				//初期化
				$this->form->back_flg = false;
			}
			$this->getSWPracticeCourseList($this->form);
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}
}

?>