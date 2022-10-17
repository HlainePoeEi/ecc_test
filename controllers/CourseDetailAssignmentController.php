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
require_once 'service/CourseService.php';
require_once 'service/TypeService.php';
require_once 'service/CourseDetailService.php';
require_once 'util/DateUtil.php';

/**
 * コース詳細割当コントローラー
 */
class CourseDetailAssignmentController extends BaseController {
	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ) {

			$this->dataSearch();
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 登録した後、最新データを取得する処理
	 */
	public function dataSearch() {

		$course_id = $this->form->course_id;

		$course_level = COURSE_LEVEL_KBN;
		$test_kbn = TEST_KBN;
		$Typeservice = new TypeService($this->pdo);
		$courseLevel = $Typeservice->getCategoryTypeAll($course_level);
		$testKbn = $Typeservice->getCategoryTypeAll($test_kbn);
		$this->smarty->assign ( 'courseLevel', $courseLevel );
		$this->smarty->assign ( 'testKbn', $testKbn );

		if ( $course_id != "" ) {

			$service = new CourseService($this->pdo);
			$courseInfo = $service->getCourseInfo($this->form);
			// テンプレートにデータ渡す
			$this->form->course_id = $courseInfo->course_id;
			$this->form->course_name = $courseInfo->course_name;
			$this->form->course_name_romaji = $courseInfo->course_name_romaji;
			$this->smarty->assign ( 'clevel', $courseInfo->course_level);
			$this->smarty->assign ( 'ckbn', $courseInfo->test_kbn);
			$this->form->clevel = $courseInfo->course_level;
			$this->form->ckbn = $courseInfo->test_kbn;
			$this->form->status = $courseInfo->status;
			$this->form->start_period = $courseInfo->start_period;
			$this->form->end_period = $courseInfo->end_period;

			$this->search($this->form);

			// メニュー情報を取得、セットする
			$this->setMenu();

			$this->smarty->assign('form',$this->form);
			$this->setBackDataToDisplay();
			$this->smarty->display ( 'courseDetailAssignment.html' );
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	private function search($form){

		if ( empty($this->form->page) ) {
			$this->form->page = 1;
		}

		$service = new CourseDetailService($this->pdo);

		//検索結果を取得
		$count = count($service->getDetailListOnCourse($this->form));

		if ( $count > 0 ) {

			$addlist = $service->getDetailListOnCourse($this->form);
			$this->smarty->assign('addlist',$addlist);
			$this->smarty->assign('list',NULL);

		} else {
			// エラーメッセージを設定　「検索結果がありません」
			$this->smarty->assign('addlist',NULL);
			$this->smarty->assign('list',NULL);
		}
	}

	public function searchWocAction() {

		if ( $this->check_login() == true ) {

			$course_detail_name = $this->form->course_detail_name;
			$course_level = $this->form->course_level;
			$test_kbn = $this->form->test_kbn;
			$rd_status = $this->form->rd_status;
			// メニュー情報を取得、セットする
			$this->setMenu();

			if ( empty($this->form->page) ) {
				$this->form->page = 1;
			}

			$service = new CourseDetailService($this->pdo);
			$list = $service->getSearchDetailList($this->form, '1');
			$count = count($list);
			if ( $count > 0 ) {

				$this->form->msg = sprintf(I001,$count);
				$this->form->list = $list;
				$err_msg = "";
				echo json_encode ( $this->form->list );
			}
			else{

				$err_msg = W001;
				$this->smarty->assign ( 'error_msg', $err_msg );
				echo ( $err_msg );
			}
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 画面登録ボタン処理
	 */
	public function saveAction() {

		if ( $this->check_login () == true ) {

			$service = new CourseDetailService( $this->pdo );

			$course_id = $this->form->course_id;

			$count = $service->countExistingDetail ( $course_id);

			if ( $count > 0 ) {
				// 削除処理
				$service-> deleteDetailOnCourse($course_id);
			}
			$insertDataList = explode ( ',', $this->form->entryList );

			$display_no = 0;
			foreach ( $insertDataList as $insertData ) {

				if ( $insertData != null || $insertData != "" ) {

					$course_detailDto = new T_Course_DetailDto();

					$course_detailDto->course_id = $course_id;

					$course_detailDto->course_detail_no = $insertData;

					$course_detailDto->disp_no = ++$display_no;

					$course_detailDto->del_flg = '0';
					$course_detailDto->create_dt = DateUtil::getDate("Y/m/d H:i:s");
					$course_detailDto->update_dt = DateUtil::getDate("Y/m/d H:i:s");
					$course_detailDto->creater_id = $_SESSION ['admin_no'];
					$course_detailDto->updater_id = $_SESSION ['admin_no'];

					$result = $service->addDetailDataOnCourse ( $course_detailDto);

				}
			}
			$this->smarty->assign ( 'error_msg', I004);
			$this->dataSearch();
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	// hiddenデータのセット
	public function setBackDataToDisplay(){

		$this->smarty->assign ( 'search_page', $this->form->search_page );
		$this->smarty->assign ( 'search_start_period', $this->form->search_start_period );
		$this->smarty->assign ( 'search_end_period', $this->form->search_end_period );
		$this->smarty->assign ( 'search_course_name', $this->form->search_course_name );
		$this->smarty->assign( 'search_test_kbn', $this->form->search_test_kbn);
		$this->smarty->assign( 'search_course_level', $this->form->search_course_level);
	}
}