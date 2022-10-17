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
require_once 'service/CourseDetailService.php';
require_once 'service/CourseStudentService.php';
require_once 'dto/T_Course_StudentDto.php';
require_once 'util/DateUtil.php';
require_once 'dto/T_4Skill_AnswerDto.php';

/**
 * 受講生コース詳細編集コントローラー
 */
class StudentCourseDetailEditController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){
			
			$this->setDatatableInfo($this->form);

			$this->displayInit($this->form , "");
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}


	/**
	 * 画面登録ボタン処理
	 */
	public function saveAction() {

		if ( $this->check_login() == true ){

			$this->form->admin_no = $_SESSION["admin_no"];
			$service = new CourseDetailService ($this->pdo) ;
			// 全てのパラメータがある場合、更新処理
			if ( $this->form->offer_no != "" && $this->form->org_no != "" && $this->form->student_no != "" && $this->form->course_id != "" && $this->form->course_detail_no != "" ){
				$courseStudentDto = new T_Course_StudentDto();
				$courseStudentDto->offer_no = $this->form->offer_no;
				$courseStudentDto->org_no = $this->form->org_no;
				$courseStudentDto->course_id = $this->form->course_id;
				$courseStudentDto->student_no = $this->form->student_no;
				$courseStudentDto->course_detail_no = $this->form->course_detail_no;
				$courseStudentDto->stu_course_start_period = $this->form->course_start_period;
				$courseStudentDto->stu_course_end_period = DateUtil::changeEndDateFormat($this->form->course_end_period);
				$courseStudentDto->updater_id = $this->form->admin_no;
				$courseStudentDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
				$update_result = $service->updateStudentCoursePeriod ( $courseStudentDto );

				// コース詳細カウント
				$count = count($service->getStudentCourseDetailList($this->form, ''));
				// コース詳細一覧がある場合、
				if ( $count > 0 ){

					$this->form->max_page = ceil($count / PAGE_ROW);
					$list = $service->getStudentCourseDetailList($this->form,'');
					$data = $service->getStudentCourseDetailList($this->form, $this->form->course_detail_no);
					$first_ele = array_values($data)[0];
					$this->form->org_id = $first_ele->org_id;
					$this->form->org_name = $first_ele->org_name;
					$this->form->org_name_official = $first_ele->org_name_official;
					$this->form->course_id = $first_ele->course_id;
					$this->form->course_name = $first_ele->course_name;
					$this->form->start_period = $first_ele->start_period;
					$this->form->end_period = $first_ele->end_period;
					$this->form->login_id = $first_ele->login_id;
					$this->form->student_name = $first_ele->student_name;
					$this->form->student_name_romaji = $first_ele->student_name_romaji;
					$this->form->disp_no = $first_ele->disp_no;
					$this->form->course_detail_name = $first_ele->course_detail_name;
					$this->form->stu_course_start_period = $first_ele->stu_course_start_period;
					$this->form->stu_course_end_period = $first_ele->stu_course_end_period;
					$this->smarty->assign('list', $list);
					$this->smarty->assign( 'info_msg', "" );
					$this->smarty->assign( 'error_msg', "" );
		
				}
				// コース詳細一覧がないの場合、
				else {
					$this->smarty->assign( 'list', Null );
				}

				// 更新処理成功の場合
				if ( $update_result > 0 ){

					$this->smarty->assign( 'info_msg', I004 );
					$this->smarty->assign( 'error_msg', "" );
					$this->smarty->assign( 'form', $this->form );
					$this->smarty->display( 'studentCourseDetailEdit.html' );
				}else {

					$error_msg = sprintf( E007, '更新' );
					$this->smarty->assign( 'error_msg', $error_msg );
					$this->smarty->assign( 'info_msg', "" );
					$this->smarty->assign( 'form', $this->form );
					$this->smarty->display( 'studentCourseDetailEdit.html' );
					return;
				}
			}else {

				TransitionHelper::sendException ( E002 );
				return;
			}
		}
	}


	/**
	 * 画面削除ボタン処理
	 */

	public function deleteAction() {

		if ( $this->check_login() == true ){

			$user_id = $_SESSION ['admin_no'];
			$offer_no = $this->form->offer_no;
			$course_id = $this->form->course_id;
			$org_no = $this->form->org_no;
			$stu_no = $this->form->student_no;
			$course_detailNo = $this->form->course_detail_no;

			if ( $offer_no != "" && $course_id != "" && $org_no != "" && $stu_no != ""){

				//　20190618-コース・コース詳細を削除処理の修正
				$CourseDetailStuDto = new T_Course_Detail_StudentDto();
				$detail_service = new CourseDetailService($this->pdo);
				$CourseDetailStuDto->offer_no = $offer_no;
				$CourseDetailStuDto->course_id = $course_id;
				$CourseDetailStuDto->org_no = $org_no;
				$CourseDetailStuDto->student_no = $stu_no;
				$CourseDetailStuDto->course_detail_no =$course_detailNo;
				$CourseDetailStuDto->updater_id = $user_id;
				$CourseDetailStuDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );

				$detail_result = $detail_service->delCourseDetailStudentData($CourseDetailStuDto);

				// 20190618-コース詳細削除処理成功の場合
				if ( $detail_result > 0 ){

					//　20190618-コースに紐つけたコース詳細のコース詳細数のチェック
					$service = new CourseDetailService($this->pdo);
					$list = $service->getStudentCourseDetailList($this->form,'');

					if ( count($list) == 0 ){

						// 20190618-コース詳細が1行の場合、コース・受講者の削除
						$CourseStuDto = new T_Course_StudentDto();
						$service = new CourseStudentService($this->pdo);
						$CourseStuDto->offer_no = $offer_no;
						$CourseStuDto->course_id = $course_id;
						$CourseStuDto->org_no = $org_no;
						$CourseStuDto->student_no = $stu_no;
						$CourseStuDto->updater_id = $user_id;
						$CourseStuDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );

						$result = $service->delCourseStudentData($CourseStuDto);
					}

					// 20190618-削除処理が成功の場合、必要なデータを格納してコース契約確認画面へ遷移する
					$_SESSION ['delete_msg'] = I005;
					$_SESSION ['page'] = $this->form->search_page;
					$_SESSION ['start_period'] = $this->form->search_start_period;
					$_SESSION ['end_period'] = $this->form->search_end_period;
					$_SESSION ['org_id'] = $this->form->search_org_id;
					$_SESSION ['course_id_from'] = $this->form->search_course_id_from;
					$_SESSION ['course_id_to']= $this->form->search_course_id_to;
					$_SESSION ['login_id_from'] = $this->form->search_login_id_from;
					$_SESSION ['login_id_to']= $this->form->search_login_id_to;
					
					$this->dispatch('CourseContractConfirmList/search');
				} else {

					$error_msg = sprintf( E007, '削除' );
					$this->smarty->assign( 'error_msg', $error_msg );
					$this->smarty->assign( 'form', $this->form );
					$this->smarty->display( 'studentCourseDetailEdit.html' );
					return;
				}
			}

		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 再受講ボタン処理
	 */

	public function retakeAction() {

		if ( $this->check_login() == true ){

		 	$user_id = $_SESSION ['admin_no'];
			$offer_no = $this->form->offer_no;
			$course_id = $this->form->course_id;
			$org_no = $this->form->org_no;
			$stu_no = $this->form->student_no;
			$course_detailNo = $this->form->course_detail_no;

			if ( $offer_no != "" && $course_id != "" && $org_no != "" && $stu_no != ""){

				//　20190618-コース・コース詳細を削除処理の修正
				$answerDto = new T_4Skill_AnswerDto();
				$detail_service = new CourseDetailService($this->pdo);
				$answerDto->offer_no = $offer_no;
				$answerDto->student_no = $stu_no;
				$answerDto->course_id = $course_id;
				$answerDto->course_detail_no =$course_detailNo;
				$answerDto->updater_id = $user_id;
				$answerDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );

				$result = $detail_service->delStudentAnswerData($answerDto);
				
				$msg = sprintf( I003, '再受講設定' );
				
				LogHelper::logDebug("再受講設定しました。");
				LogHelper::logDebug("ユーザーの組織 :" . $org_no);
				LogHelper::logDebug("受講者No :" . $stu_no);
				LogHelper::logDebug("Offer No :" . $offer_no);
				LogHelper::logDebug("コース名 :" . $course_detailNo);
				LogHelper::logDebug("コース詳細名 :" . $course_detailNo);

				// 受講回答情報と採点情報の削除が正常の場合
				if ( $result > 0 ){
					$this->displayInit($this->form , $msg);

				} else {

					$error_msg = sprintf( E007, '再受講設定' );
					$this->smarty->assign( 'error_msg', $error_msg );
					$this->smarty->assign( 'form', $this->form );
					$this->smarty->display( 'studentCourseDetailEdit.html' );
					return;
				}
			} 

		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	} 

	/**
	 * 初期表示処理
	 */
	private function displayInit($form, $msg){

		$form->page = 1;
		$service = new CourseDetailService($this->pdo);
		//前画面のパラメータをセットする
		$form->admin_no = $_SESSION["admin_no"];
		$err_msg = "";
		$form->retake_flg = "0";
		$today_date = DateUtil::getDate ( 'Y/m/d H:i:s' );

		// コース詳細カウント
		if ( $form->offer_no != "" && $form->org_no != "" && $form->student_no != "" && $form->course_id != "" && $form->course_detail_no != "" ){

			$count = count($service->getStudentCourseDetailList($form, $form->course_detail_no));
			// コース詳細一覧がある場合、
			if ( $count > 0 ){
				$list = $service->getStudentCourseDetailList($form,'');
				$data = $service->getStudentCourseDetailList($form, $form->course_detail_no);
				$first_ele = array_values($data)[0];
				// 画面の初期表示のため変数を設定する
				$form->org_id = $first_ele->org_id;
				$form->org_name = $first_ele->org_name;
				$form->org_name_official = $first_ele->org_name_official;
				$form->course_id = $first_ele->course_id;
				$form->course_name = $first_ele->course_name;
				$form->start_period = $first_ele->start_period;
				$form->end_period = $first_ele->end_period;
				$form->login_id = $first_ele->login_id;
				$form->student_name = $first_ele->student_name;
				$form->student_name_romaji = $first_ele->student_name_romaji;
				$form->disp_no = $first_ele->disp_no;
				$form->course_detail_name = $first_ele->course_detail_name;
				$form->stu_course_start_period = $first_ele->stu_course_start_period;
				$form->stu_course_end_period = $first_ele->stu_course_end_period;
				$form->answer_dt = $first_ele->answer_dt; //20190618-コース・コース詳細を削除処理で受講済みかどうかのチェック
				$form->score_dt = $first_ele->update_dt;
				$this->smarty->assign('list', $list);
				
				if ( ($form->end_period > $today_date)  && ($form->answer_dt != "") 
						&& (DateUtil::addMonthToDate(1, $form->stu_course_end_period ) > $today_date )
						&& ($form->stu_course_start_period < $today_date )){
					$form->retake_flg = "1";
				}

			}
			// コース詳細一覧がないの場合、
			else {
				$this->smarty->assign( 'list', Null );
			}

			$this->setMenu();
			$this->smarty->assign( 'info_msg', $msg);
			$this->smarty->assign( 'error_msg', "" );
			$this->smarty->assign( 'form', $form );
			$this->smarty->display( 'studentCourseDetailEdit.html' );
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}
	
	public function setDatatableInfo($form){
							
		$_SESSION ['page_cccl'] = $form->page_cccl;
		$_SESSION ['page_row_cccl'] = $form->page_row_cccl;
		$_SESSION ['page_order_column_cccl'] = $form->page_order_column_cccl;
		$_SESSION ['page_order_dir_cccl'] = $form->page_order_dir_cccl;
	}
	
}
?>