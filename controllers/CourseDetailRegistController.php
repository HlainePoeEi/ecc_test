<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'dto/T_CourseDto.php';
require_once 'service/DetailService.php';
require_once 'service/TypeService.php';
require_once 'util/DateUtil.php';

/**
 * コース詳細登録コントローラー
 */
class CourseDetailRegistController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			$this->setMenu();

			// コース情報設定
			$this->getCourseData($this->form);
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 画面データ取得・渡す処理
	 */
	public function getCourseData($myForm) {

		$course_detail_no = $myForm->course_detail_no;

		// メニュー情報を取得、セットする
		$this->setMenu();

		// 学年情報取得
		$course_level = COURSE_LEVEL_KBN;
		$test_kbn = TEST_KBN;
		$typeService = new TypeService($this->pdo);
		$courseLevel = $typeService->getCategoryTypeAll($course_level);
		$testKbn = $typeService->getCategoryTypeAll($test_kbn);
		$this->smarty->assign( 'courseLevel', $courseLevel );
		$this->smarty->assign( 'testKbn', $testKbn );

		if ( $course_detail_no != "" ){

			$service = new DetailService($this->pdo);
			$CourseDetailInfo = $service->getCourseDetailInfo($myForm);
			$CourseDetailInfo->search_test_kbn = $this->form->search_test_kbn;
			$CourseDetailInfo->search_course_level= $this->form->search_course_level;

			// テンプレートにデータ渡す
			$course_detail_no = $CourseDetailInfo->course_detail_no;
			$course_detail_name = $CourseDetailInfo->course_detail_name;
			$course_detail_romaji = $CourseDetailInfo->course_detail_romaji;
			$ctype = $CourseDetailInfo->course_level;
			$type = $CourseDetailInfo->test_kbn;
			$status = $CourseDetailInfo->status;
			$start_period = $CourseDetailInfo->start_period;
			$end_period = $CourseDetailInfo->end_period;

			$this->setBackDataToDisplay();

			$this->form->course_detail_name = $CourseDetailInfo->course_detail_name;
			$this->form->course_detail_romaji = $CourseDetailInfo->course_detail_romaji;
			$this->form->start_period = $CourseDetailInfo->start_period;
			$this->form->end_period = $CourseDetailInfo->end_period;
			$this->smarty->assign( 'info_msg', "" );
			$this->smarty->assign( 'error_msg', "" );
			$this->smarty->assign( 'type', $type );
			$this->smarty->assign( 'ctype', $ctype );
			$this->smarty->assign( 'status', $status );
			$this->smarty->assign( 'screen_mode', "update" );
			$this->smarty->assign( 'course_detail_no', $course_detail_no );
			$this->smarty->assign('form',$this->form);
			$this->smarty->display ( 'courseDetailRegist.html' );
		}else {

			// テンプレートにデータ渡す
			$this->displayInit($myForm);
		}
	}

	//hiddenデータのセット
	public function setBackDataToDisplay(){

		$this->smarty->assign( 'search_page', $this->form->search_page );
		$this->smarty->assign( 'search_start_period', $this->form->search_start_period );
		$this->smarty->assign( 'search_end_period', $this->form->search_end_period );
		$this->smarty->assign( 'search_course_detail_name', $this->form->search_course_detail_name );
	}

	/**
	 * 初期表示処理
	 */
	public function displayInit($myForm) {

		$course_level = COURSE_LEVEL_KBN;
		$test_kbn = TEST_KBN;
		$service = new TypeService($this->pdo);
		$courseLevel = $service->getCategoryTypeAll($course_level);
		$testKbn = $service->getCategoryTypeAll($test_kbn);

		$this->form->course_detail_name = "";
		$this->form->course_detail_romaji = "";
		$this->form->course_detail_no = "";
		$this->form->start_period = "";
		$this->form->end_period = "";
		$this->form->reset_start_period = "";
		$this->form->reset_end_period = "";

		$this->setBackDataToDisplay();

		$this->smarty->assign( 'status', '1' );
		$this->smarty->assign( 'courseLevel', $courseLevel );
		$this->smarty->assign( 'testKbn', $testKbn );
		$this->smarty->assign( 'reset_start_period', $this->form->reset_start_period );
		$this->smarty->assign( 'reset_end_period', $this->form->reset_end_period );
		$this->smarty->assign( 'error_msg', "" );
		$this->smarty->assign( 'info_msg',"" );
		$this->smarty->assign( 'form', $myForm );
		$this->smarty->display( 'courseDetailRegist.html' );
	}

	/**
	 * 画面登録ボタン処理
	 */
	public function saveAction() {

		if ( $this->check_login() == true ){

			$admin_id = $_SESSION ['admin_no'];
			$course_detail_no = $this->form->course_detail_no;
			$service = new DetailService($this->pdo);

			// コース詳細番号がない場合、新規追加
			if ( $course_detail_no == "" ){

				$DetailDto = new T_DetailDto();

				$DetailDto->course_detail_name = $this->form->course_detail_name;
				$DetailDto->course_detail_romaji = $this->form->course_detail_romaji;
				$DetailDto->course_level = $this->form->course_level;
				$DetailDto->test_kbn = $this->form->test_kbn;
				$DetailDto->status = $this->form->status;
				$DetailDto->start_period = $this->form->start_period;
				$DetailDto->end_period = DateUtil::changeEndDateFormat($this->form->end_period);
				$DetailDto->creater_id = $admin_id;
				$DetailDto->updater_id = $admin_id;
				$DetailDto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
				$DetailDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );

				$course_detail_no_data = $service->getNextCourseDetailNo ();
				$course_detail_no = $course_detail_no_data->id;
				$this->form->course_detail_no = $course_detail_no;
				$DetailDto->course_detail_no = $course_detail_no;

				$save_result = $service->registCourseDetailData ( $DetailDto );

				// 登録処理成功の場合
				if ( $save_result > 0 ){

					$this->smarty->assign( 'info_msg', I004 );
					$this->smarty->assign( 'error_msg', "" );
					$this->smarty->assign( 'screen_mode', "update" );
					$this->displayValue($this->form);

				}else {

					$error_msg = sprintf(E007, '登録');
					$this->smarty->assign( 'error_msg', $error_msg );
					$this->smarty->assign( 'info_msg', "" );
					$this->displayValue($this->form);
					return;
				}
			}else {

				$DetailDto = new T_DetailDto();
				$DetailDto->course_detail_no = $course_detail_no;
				$DetailDto->course_detail_name = $this->form->course_detail_name;
				$DetailDto->course_detail_romaji = $this->form->course_detail_romaji;
				$DetailDto->course_level = $this->form->course_level;
				$DetailDto->test_kbn = $this->form->test_kbn;
				$DetailDto->status = $this->form->status;
				$DetailDto->start_period = $this->form->start_period;
				$DetailDto->end_period = DateUtil::changeEndDateFormat($this->form->end_period);
				$DetailDto->updater_id = $admin_id;
				$DetailDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );

				$update_result = $service->updateCourseDetailData ( $DetailDto );

				// 更新処理成功の場合
				if ( $update_result > 0 ){

					$this->smarty->assign( 'info_msg', "" );
					$this->smarty->assign( 'error_msg', I004 );
					$this->smarty->assign( 'screen_mode', "update" );
					$this->setBackDataToDisplay();
					$this->displayValue($this->form);
				}else {

					$error_msg = sprintf( E007, '更新' );
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
		$this->smarty->assign( 'search_course_detail_name', $this->form->search_course_detail_name );
		$this->smarty->assign( 'form', $myForm );
		$this->smarty->display( 'courseDetailRegist.html' );
	}
}
?>