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
require_once 'util/DateUtil.php';
require_once 'service/TypeService.php';
require_once 'service/TeacherCourseDetailAssignmentService.php';
require_once 'dto/T_Teacher_Course_DetailDto.php';

/**
 * 講師コース詳細割当コントローラー
 */
class TeacherCourseDetailAssignmentController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction(){

		if ( $this->check_login() == true ){

			$this->search();

			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'teacherCourseDetailAssignment.html' );
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	private function search(){

		$courseDetailList = [];
		$registerList = [];
		$registerCourseDtlList = [];
		$exist_course_dt_list = [];
		$nonexist_course_dt_list= [];
		$resultList = [];
		$err_msg = "";
		$entryList = "";

		$type_service = new TypeService($this->pdo);
		$test_kbn = $type_service->getCategoryTypeAll(TEST_KBN);
		$course_level = $type_service->getCategoryTypeAll(COURSE_LEVEL_KBN);
		

		$search_test_kbn = explode(',',$this->form->search_test_kbn);
		$search_course_level = array_filter(explode(' ',str_replace(',',' ',$this->form->search_course_level)));

		

		$service = new TeacherCourseDetailAssignmentService($this->pdo);
		$courseDetailList = $service->getCourseDetailData($this->form);

		if ( count($courseDetailList) > 0 ){

			$registerList= $service->getCourseDetailRegisterData($this->form->teacher_no);

			if(count($registerList) > 0){

				foreach ($registerList as $value){
					array_push($registerCourseDtlList, $value->course_detail_no);
				}

				foreach ($courseDetailList as $value){

					if(in_array($value->course_detail_no,$registerCourseDtlList)){
						array_push($exist_course_dt_list, $value);
					}else {
						array_push($nonexist_course_dt_list, $value);
					}
				}

				$resultList = array_merge($exist_course_dt_list, $nonexist_course_dt_list);

				if($this->form->entryList == ""){
					foreach ($exist_course_dt_list as $value){
						$entryList .= $value->course_detail_no. ",";
					}
					$this->form->entryList = $entryList;
				}else{

					$registerCourseDtlList = explode ( ',', $this->form->entryList );
				}
			}else{

				$resultList = $courseDetailList;
				$registerCourseDtlList = explode ( ',', $this->form->entryList );
			}

		}else{
			$err_msg = W001;
		}
		$this->smarty->assign('error_msg', $err_msg );
		$this->smarty->assign('courseDetailList', $resultList);
		$this->smarty->assign('test_kbn', $test_kbn);
		$this->smarty->assign('course_level', $course_level);
		$this->smarty->assign('search_test_kbn', $search_test_kbn);
		$this->smarty->assign('search_course_level', $search_course_level);
		$this->smarty->assign('data_list', $registerCourseDtlList);
	}

	/**
	 * 画面検索ボタン処理
	 */
	public function searchAction(){

		if ( $this->check_login() == true ){

			$this->search();

			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'teacherCourseDetailAssignment.html' );
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

			$teacher_no = $this->form->teacher_no;
			$error_msg= "";

			$service = new TeacherCourseDetailAssignmentService($this->pdo);
			$courseDetailList = $service->getCourseDetailRegisterData($teacher_no);

			if ( count($courseDetailList) > 0 ){
				$service->deleteCourseDetailData($teacher_no);
			}

			$courseDetailNoList = array_filter(explode ( ',', $this->form->entryList ));

			foreach ( $courseDetailNoList as $courseDetailNo ) {

				$teacherCourseDetailDto = new T_Teacher_Course_DetailDto();
				$teacherCourseDetailDto->teacher_no = $teacher_no;
				$teacherCourseDetailDto->course_detail_no= $courseDetailNo;
				$teacherCourseDetailDto->del_flg = '0';
				$teacherCourseDetailDto->create_dt = DateUtil::getDate("Y/m/d H:i:s");;
				$teacherCourseDetailDto->update_dt = DateUtil::getDate("Y/m/d H:i:s");;
				$teacherCourseDetailDto->creater_id = $_SESSION ['admin_no'];
				$teacherCourseDetailDto->updater_id = $_SESSION ['admin_no'];

				$result = $service->registerTeacherCourseDetailData($teacherCourseDetailDto);

				if ($result == 0){

					$error_msg = sprintf( E007, '更新' );
					$this->smarty->assign ( 'error_msg', $error_msg);
					return;
				}
			}

			if($error_msg == ""){
				$error_msg = sprintf( I004, '更新' );
			}

			$this->search();

			$this->smarty->assign ( 'error_msg', $error_msg);
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'teacherCourseDetailAssignment.html' );
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}
	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {

		if ( $this->check_login() == true ){

			//登録完了
			$this->setBackData();

			// 受講者一覧画面へ遷移する
			$this->dispatch('TeacherList/Search');
		}else {
			TransitionHelper::sendException( E002 );
			return;
		}
	}

	/*
	 * 戻る場合のデータセット
	 */
	public function setBackData() {
		$_SESSION ['back_flg'] = true;
		$_SESSION ['search_page'] = $this->form->search_page;
		$_SESSION ['search_start_period'] = $this->form->search_start_period;
		$_SESSION ['search_end_period'] = $this->form->search_end_period;
		$_SESSION ['search_name'] = $this->form->search_name;
		$_SESSION ['search_school_kbn'] = $this->form->search_school_kbn;
	}
}
?>