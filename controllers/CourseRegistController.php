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
require_once 'service/CourseService.php';
require_once 'service/TypeService.php';
require_once 'util/DateUtil.php';

/**
 * コース登録コントローラー
 */
class CourseRegistController extends BaseController {

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

		$course_id = $myForm->course_id;

		// メニュー情報を取得、セットする
		$this->setMenu();

		$service = new CourseService($this->pdo);
		// コース情報取得
		$course_level = COURSE_LEVEL_KBN;
		$test_kbn = TEST_KBN;
		$Typeservice = new TypeService($this->pdo);
		$courseLevel = $Typeservice->getCategoryTypeAll($course_level);
		$testKbn = $Typeservice->getCategoryTypeAll($test_kbn);
		$this->smarty->assign( 'courseLevel', $courseLevel );
		$this->smarty->assign( 'testKbn', $testKbn );

		if ( $course_id != "" ){

			$courseInfo = $service->getCourseInfo($myForm);
			// </'>を<'>に置き換える
			$courseInfo->course_name = str_replace("\'", "'", $courseInfo->course_name);
			$courseInfo->search_status = $myForm->search_status;

			// テンプレートにデータ渡す
			$course_id = $courseInfo->course_id;
			$course_name = $courseInfo->course_name;
			$course_name_romaji = $courseInfo->course_name_romaji;
			$ctype = $courseInfo->course_level;
			$type = $courseInfo->test_kbn;
			$status = $courseInfo->status;
			$start_period = $courseInfo->start_period;
			$end_period = $courseInfo->end_period;
			$remarks = $courseInfo->remarks; //20190605編集モードの場合、備考の表示

			$this->form->course_name = $courseInfo->course_name;
			$this->form->course_name_romaji = $courseInfo->course_name_romaji;
			$this->form->start_period = $courseInfo->start_period;
			$this->form->end_period = $courseInfo->end_period;
			$this->form->remarks = $courseInfo->remarks; //20190605編集モードの場合、備考の表示
			$this->smarty->assign( 'info_msg', "" );
			$this->smarty->assign( 'error_msg', "" );
			$this->smarty->assign( 'type', $type );
			$this->smarty->assign( 'ctype', $ctype );
			$this->smarty->assign( 'status', $status );
			$this->smarty->assign( 'course_id', $course_id );
			$this->smarty->assign( 'screen_mode', 'update' );
			$this->setBackDataToDisplay();
			$this->smarty->assign('form',$this->form);
			$this->smarty->display ( 'courseRegist.html' );
		}else {

			// テンプレートにデータ渡す
			$this->displayInit($myForm);
			$this->smarty->assign( 'screen_mode', 'new' );
		}
	}

	//hiddenデータのセット
	public function setBackDataToDisplay(){

		$this->smarty->assign( 'search_page', $this->form->search_page );
		$this->smarty->assign( 'search_start_period', $this->form->search_start_period );
		$this->smarty->assign( 'search_end_period', $this->form->search_end_period );
		$this->smarty->assign( 'search_course_name', $this->form->search_course_name );
		$this->smarty->assign( 'search_test_kbn', $this->form->search_test_kbn);
		$this->smarty->assign( 'search_course_level', $this->form->search_course_level);
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

		$this->form->course_name = "";
		$this->form->course_name_romaji = "";
		$this->form->course_id = "";
		$this->form->start_period = "";
		$this->form->end_period = "";
		$this->form->reset_start_period = "";
		$this->form->reset_end_period = "";
		$this->form->remarks = "";

		$this->smarty->assign( 'courseLevel', $courseLevel );
		$this->smarty->assign( 'testKbn', $testKbn );
		$this->smarty->assign( 'reset_start_period', $this->form->reset_start_period );
		$this->smarty->assign( 'reset_end_period', $this->form->reset_end_period );
		$this->smarty->assign( 'status', '1' );
		$this->smarty->assign( 'error_msg', "" );
		$this->smarty->assign( 'info_msg', "" );
		$this->setBackDataToDisplay();
		$this->smarty->assign ( 'form', $myForm );
		$this->smarty->display ( 'courseRegist.html' );
	}

	/**
	 * 画面登録ボタン処理
	 */
	public function saveAction() {

		if ( $this->check_login() == true ){

			$admin_id = $_SESSION ['admin_no'];
			$course_id = $this->form->course_id;
			$service = new CourseService($this->pdo);
			// コース№がない場合、新規追加
			if ( $course_id == "" ){

				$courseDto = new T_CourseDto();

				$courseDto->course_name = $this->form->course_name;
				$courseDto->course_name_romaji = $this->form->course_name_romaji;
				$courseDto->course_level = $this->form->course_level;
				$courseDto->test_kbn = $this->form->test_kbn;
				$courseDto->status = $this->form->status;
				$courseDto->start_period = $this->form->start_period;
				$courseDto->end_period = DateUtil::changeEndDateFormat($this->form->end_period);
				$courseDto->remarks = $this->form->remarks;
				$courseDto->creater_id = $admin_id;
				$courseDto->updater_id = $admin_id;
				$courseDto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
				$courseDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );

				// 次のコース番号取得
				$course_id_data = $service->getNextCourseNo ();
				$course_id = $course_id_data->id;
				$this->form->course_id = $course_id;
				$courseDto->course_id = $course_id;

				$save_result = $service->registCourseData ( $courseDto );

				// 登録処理成功の場合
				if ( $save_result > 0 ){

					$this->smarty->assign( 'info_msg', I004 );
					$this->smarty->assign( 'screen_mode', "update" );
					$this->smarty->assign( 'error_msg', "" );
					$this->displayValue($this->form);

				}else {

					$error_msg = sprintf( E007, '登録' );
					$this->smarty->assign( 'error_msg', $error_msg );
					$this->smarty->assign( 'info_msg', "" );
					$this->displayValue($this->form);
					return;
				}
			}else {

				$courseDto = new T_CourseDto();
				$courseDto->course_id = $course_id;
				$courseDto->course_name = $this->form->course_name;
				$courseDto->course_name_romaji = $this->form->course_name_romaji;
				$courseDto->course_level = $this->form->course_level;
				$courseDto->test_kbn = $this->form->test_kbn;
				$courseDto->status = $this->form->status;
				$courseDto->start_period = $this->form->start_period;
				$courseDto->end_period = DateUtil::changeEndDateFormat($this->form->end_period);
				if ( $this->form->remarks== ""){
					$courseDto->remarks = " ";
				}else {
					$courseDto->remarks = $this->form->remarks;
				}
				$courseDto->updater_id = $admin_id;
				$courseDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );

				$update_result = $service->updateCourseData ( $courseDto );

				// 更新処理成功の場合
				if ( $update_result > 0 ){

					$this->smarty->assign( 'info_msg', I004 );
					$this->smarty->assign( 'error_msg', "" );
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
		$this->smarty->assign( 'search_course_name', $this->form->search_course_name );
		$this->smarty->assign( 'search_test_kbn', $this->form->search_test_kbn);
		$this->smarty->assign( 'search_course_level', $this->form->search_course_level);
		$this->smarty->assign( 'form', $myForm );
		$this->smarty->display( 'courseRegist.html' );
	}
}
?>