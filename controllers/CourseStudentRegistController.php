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
require_once 'service/CourseStudentService.php';
require_once 'util/DateUtil.php';
require_once 'dto/T_Course_StudentDto.php';
require_once 'dto/T_Course_Detail_StudentDto.php';

/**
 * コース詳細学生登録コントローラー
 */
class CourseStudentRegistController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction(){

		if ( $this->check_login() == true ){

			$_SESSION ['course_id'] = $this->form->course_id;
			$_SESSION ['org_no'] = $this->form->org_no;
			$_SESSION ['offer_no'] = $this->form->offer_no;

			$_SESSION['contract_start_period'] = $this->form->contract_start_period;
			$_SESSION['contract_end_period'] = $this->form->end_period;
			$_SESSION['contract_list_start_period'] = $this->form->contract_list_start_period;
			$_SESSION['contract_list_end_period'] = $this->form->contract_list_end_period;
			$_SESSION['btn_flag'] = 1;
			$_SESSION['search_org_id'] = $this->form->search_org_id;
			$_SESSION['search_org_name'] = $this->form->search_org_name;
			$_SESSION['search_test_kbn'] = $this->form->search_test_kbn;
			$_SESSION['search_course_level'] = $this->form->search_course_level;
			$_SESSION['search_course_name'] = $this->form->search_course_name;
			$_SESSION['remarks'] = $this->form->remarks;
			$_SESSION['search_page'] = $this->form->search_page;

			$this->form->contract_end_period = $this->form->end_period;
			$this->form->contract_list_start_period =  $this->form->search_start_period;
			$this->form->contract_list_end_period=  $this->form->search_end_period;
			$this->form->btn_flag ="1";

			$service = new CourseStudentService($this->pdo);
			// 必要な情報設定
			$this->getRequiredData($service, $this->form);
			
			// 一覧画面のデータテーブル情報セット
			$this->setDatatableInfo($this->form);

			$this->setMenu();
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'courseStudentRegist.html' );
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 画面データ取得・渡す処理
	 */
	private function getRequiredData($service, $myform){

		$results = $service->getOrganizationData($myform);

		if (count($results) > 0){
			$this->form->org_id = $results[0]->org_id;
			$this->form->org_name = $results[0]->org_name;
			$this->form->org_name_official = $results[0]->org_name_official;
			$this->form->start_period= $results[0]->start_period;
			$this->form->end_period= $results[0]->end_period;
			$this->form->course_name = $results[0]->course_name;
			$this->form->course_name_romaji = $results[0]->course_name_romaji;
		}

		$newCourseDetailList = $service->getCourseDetailByCourseId($this->form->course_id);

		if(count($newCourseDetailList) <= 0){

			$error_msg = sprintf(E019, '詳細情報','登録');
			$this->smarty->assign( 'error_msg', $error_msg);
		}else {

			$detailList = [];
			$oldCourseDtlList = explode ( '|', $this->form->course_dt_list);

			if( count($oldCourseDtlList) > 0 && $oldCourseDtlList[0] != ""){

				foreach ($oldCourseDtlList as $value){
					$oldCourseDtl = explode ( ',', $value);

					foreach ($newCourseDetailList as $newCourseDtl){

						if($newCourseDtl->course_detail_no == $oldCourseDtl[0]){

							$newCourseDtl->start_period = $oldCourseDtl[1];
							$newCourseDtl->end_period = $oldCourseDtl[2];
						}
					}
				}
			}else{

				foreach ($newCourseDetailList as $newCourseDtl){

					$newCourseDtl->start_period = "";
					$newCourseDtl->end_period = "";
				}
			}

			$this->smarty->assign('course_detail_list', $newCourseDetailList);
		}
	}

	/**
	 * 画面検索ボタン処理
	 */
	public function searchAction(){

		if ( $this->check_login() == true ){

			$this->form->course_id = $_SESSION ['course_id'];
			$this->form->org_no = $_SESSION ['org_no'];
			$this->form->offer_no = $_SESSION ['offer_no'];

			$this->form->start_period = $_SESSION['contract_start_period'];
			$this->form->end_period = $_SESSION['contract_end_period'];
			$this->form->contract_list_start_period = $_SESSION['contract_list_start_period'];
			$this->form->contract_list_end_period = $_SESSION['contract_list_end_period'];
			$this->form->btn_flag =  $_SESSION['btn_flag'];
			$this->form->search_org_id = $_SESSION['search_org_id'];
			$this->form->search_org_name = $_SESSION['search_org_name'];
			$this->form->search_test_kbn = $_SESSION['search_test_kbn'];
			$this->form->search_course_level = $_SESSION['search_course_level'];
			$this->form->search_course_name = $_SESSION['search_course_name'];
			$this->form->remarks = $_SESSION['remarks'];
			$this->form->search_page = $_SESSION['search_page'];

			$service = new CourseStudentService($this->pdo);
			$studentList = $service->getStudentListByGroupAndLoginId($this->form);
			if (count($studentList) < 1){
				$this->smarty->assign( 'info_msg', "" );
				$this->smarty->assign( 'error_msg', W006);
			}

			// 必要な情報設定
			$this->getRequiredData($service, $this->form);

			$this->smarty->assign('studentList', $studentList	);
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'courseStudentRegist.html' );
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 画面登録ボタン処理`
	 */
	public function saveAction(){

		if ( $this->check_login() == true ){

			$course_noString = $this->form->course_noString;
			$student_noString = $this->form->student_noString;
			$studentNoList = [];
			$courseDetailList = [];
			$courseDetailStudentList = [];

			if ($student_noString != ''){
				$studentNoList = array_filter(explode(' ',str_replace(',',' ',$student_noString)));
			}

			if ($course_noString != ''){
				$courseDetailList = array_filter(explode(' ',str_replace('}',' ',$course_noString)));
				foreach ($courseDetailList as $key=>$courseDetail){
					$result = explode ( ',', $courseDetail);
					$courseDetailStudentList[$key]['course_detail_no'] = $result[0];
					$courseDetailStudentList[$key]['start_period'] = $result[1];
					$courseDetailStudentList[$key]['end_period'] = $result[2];
				}
			}
			$this->form->course_id = $_SESSION ['course_id'];
			$this->form->org_no = $_SESSION ['org_no'];
			$this->form->offer_no = $_SESSION ['offer_no'];

			$service = new CourseStudentService($this->pdo);

 			foreach ($studentNoList as $studentNo){

				$course_student_dto =  new T_Course_StudentDto();
				$course_student_dto->offer_no = $this->form->offer_no;
				$course_student_dto->course_id = $this->form->course_id;
				$course_student_dto->org_no = $this->form->org_no;
				$course_student_dto->student_no = $studentNo;
				$course_student_dto->start_period = $this->form->course_dt_start_period;
				$course_student_dto->end_period = DateUtil::changeEndDateFormat($this->form->course_dt_end_period);
				$course_student_dto->del_flg = '0';
				$course_student_dto->create_dt = DateUtil::getDate("Y/m/d H:i:s");
				$course_student_dto->update_dt = DateUtil::getDate("Y/m/d H:i:s");
				$course_student_dto->creater_id = $_SESSION ['admin_no'];
				$course_student_dto->updater_id = $_SESSION ['admin_no'];

				$result = $service->registerCourseStudentData($course_student_dto);

				if ($result > 0){
					 foreach ($courseDetailStudentList as $courseDetail){

					 	$course_detail_student_dto = new T_Course_Detail_StudentDto();
						$course_detail_student_dto->offer_no = $this->form->offer_no;
						$course_detail_student_dto->org_no = $this->form->org_no;
						$course_detail_student_dto->student_no = $studentNo;
						$course_detail_student_dto->course_id = $this->form->course_id;
						$course_detail_student_dto->course_detail_no = $courseDetail['course_detail_no'];
						$course_detail_student_dto->start_period = $courseDetail['start_period'];
						$course_detail_student_dto->end_period = DateUtil::changeEndDateFormat($courseDetail['end_period']);
						$course_detail_student_dto->del_flg = '0';
						$course_detail_student_dto->create_dt = DateUtil::getDate("Y/m/d H:i:s");
						$course_detail_student_dto->update_dt = DateUtil::getDate("Y/m/d H:i:s");
						$course_detail_student_dto->creater_id = $_SESSION ['admin_no'];
						$course_detail_student_dto->updater_id = $_SESSION ['admin_no'];

						$save_result = $service->registerCoursDetailStudentData($course_detail_student_dto);

						if ($save_result< 1){
							$error_msg = sprintf( E007, '更新' );
							$this->smarty->assign( 'error_msg', $error_msg );
							$this->smarty->assign( 'info_msg', "" );
							$this->displayValue($service, $this->form);
							return;
						}
					}
				 }else {
					$error_msg= sprintf(E007, '更新');
					$this->smarty->assign ( 'error_msg', $error_msg);
					$this->smarty->assign ( 'info_msg', "");
					$this->displayValue($service, $this->form);
					return;
				}
			}
			$this->smarty->assign( 'info_msg', I004 );
			$this->smarty->assign( 'error_msg', "" );
			$this->form->course_dt_list = "";
			$this->displayValue($service, $this->form);
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	private function displayValue($service, $myForm) {
		$this->form->group_name = "";
		$this->form->login_id = "";
		$this->form->course_noString = "";
		$this->form->student_noString= "";

		// 必要な情報設定
		$this->getRequiredData($service, $myForm);

		$this->form->start_period = $_SESSION['contract_start_period'];
		$this->form->end_period = $_SESSION['contract_end_period'];
		$this->form->contract_list_start_period = $_SESSION['contract_list_start_period'];
		$this->form->contract_list_end_period = $_SESSION['contract_list_end_period'];
		$this->form->btn_flag =  $_SESSION['btn_flag'];
		$this->form->search_org_id = $_SESSION['search_org_id'];
		$this->form->search_org_name = $_SESSION['search_org_name'];
		$this->form->search_test_kbn = $_SESSION['search_test_kbn'];
		$this->form->search_course_level = $_SESSION['search_course_level'];
		$this->form->search_course_name = $_SESSION['search_course_name'];
		$this->form->remarks = $_SESSION['remarks'];
		$this->form->btn_flag = "1";
		$this->form->search_page = $_SESSION['search_page'];
		$this->form->course_detail_start_period= "";
		$this->form->course_detail_end_period= "";

		$this->smarty->assign( 'form', $myForm );
		$this->smarty->display( 'courseStudentRegist.html' );
	}
	
	public function setDatatableInfo($form){
							
		$_SESSION ['page_ccl'] = $form->page_ccl;
		$_SESSION ['page_row_ccl'] = $form->page_row_ccl;
		$_SESSION ['page_order_column_ccl'] = $form->page_order_column_ccl;
		$_SESSION ['page_order_dir_ccl'] = $form->page_order_dir_ccl;
	}
}
?>