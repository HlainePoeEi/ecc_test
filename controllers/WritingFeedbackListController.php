<?php
/*****************************************************
 *	株式会社ECC 新商品開発プロジェクト
 *	PHPシステム構築フレームワーク
 *
 *	Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'service/DetailService.php';

/**
 * WritingFeedback一覧コントローラー
 */
class WritingFeedbackListController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			$course_detail_no = $this->form->course_detail_no;
			$offer_no = $this->form->offer_no;
			$course_id = $this->form->course_id;
			$org_no = $this->form->org_no;
			$student_no = $this->form->student_no;

			if ( $course_detail_no != "" && $course_id != "" && $offer_no != "" && $student_no != "" ){
				
				$this->form->test_kbn = '002';

				$service = new DetailService($this->pdo);

				//教師がチェックしたコース
				$cfinish = $service->getCoursesFinishByStudent($this->form->student_no, $this->form->offer_no, $this->form->course_id, $this->form->test_kbn);
				$cnt = count($cfinish);
				
				$fbLists = $service->getWritingFeedbackData($this->form);
				$this->form->course_name = $fbLists[0]->course_name;
				$this->form->course_detail_name = $fbLists[0]->course_detail_name;
				$this->form->org_name= $fbLists[0]->org_name;//組織名
				$this->form->stu_login_in= $fbLists[0]->stu_login_in;//ログインID
				$this->form->student_name= $fbLists[0]->student_name;//氏名
				$courseData = $service->getWritingFeedbackAllData($this->form);

				for ( $j = 0; $j < count($courseData); $j++) {

					$courseData[$j]->answer_contents = str_replace(array("\r","\n"), "", nl2br($courseData[$j]->answer_contents));
				}

				if ( count($fbLists) > 0 ){

					$quiz_data = array();
					$a = 0;
					$result_kbn = $fbLists[$a]->result_kbn;
					$dec = array();
					$rule = array();
					$sub_rule = array();
					$m = 0;
					$count = 0;
					
					$current_q_no = $fbLists[$a]->question_no;
					
					for ( $j = 0; $j < count($fbLists); $j++ ) {

						if ( $fbLists[$j]->result_kbn != $result_kbn || $j == 0 ){

							$result_kbn = $fbLists[$j]->result_kbn;
							$current_q_no = $fbLists[$j]->question_no;
							for ( $i = 0; $i < count($fbLists); $i++ ) {

								if ( $fbLists[$i]->result_kbn == $result_kbn  && $fbLists[$i]->question_no == $current_q_no ){

									$temp = new T_DetailDto();
									$m = $m + $fbLists[$i]->detail_result_marks;
									array_push($dec, $fbLists[$i]->reply_comment);
									array_push($rule, $fbLists[$i]->description);
									array_push($sub_rule, $fbLists[$i]->sub_description);
								}
							}

							$temp->question_no = $fbLists[$j]->question_no;
							$temp->rule_result_marks = $fbLists[$j]->rule_result_marks;
							$temp->rule_total_marks = $fbLists[$j]->rule_total_marks;
							$temp->total_marks = $m;
							$temp->reply_comment = $dec;
							$temp->description = $rule;
							$temp->sub_description = $sub_rule;
							$temp->sample_answer = nl2br($fbLists[$j]->sample_answer);
							$temp->byosha_point = nl2br($fbLists[$j]->byosha_point);
							$temp->answer_contents=$fbLists[$j]->answer_contents;
							$temp->offer_no = $fbLists[$j]->offer_no;
							$temp->org_no = $this->form->org_no;
							$temp->course_id = $fbLists[$j]->course_id;
							$temp->course_detail_no = $fbLists[$j]->course_detail_no;
							$temp->audio_name = $fbLists[$j]->audio_name;
							array_push($quiz_data, $temp);
							$qno = $fbLists[$j]->question_no;
							$m = 0;
							unset($dec);
							unset($rule);
							unset($sub_rule);
							$dec = array();
							$rule = array();
							$sub_rule = array();
							$count = $count+1;

						}
						$fbLists[$j]->answer_contents = str_replace(array("\r","\n"), "", nl2br($fbLists[$j]->answer_contents));
					}

					$this->smarty->assign( 'quiz_data', $quiz_data );
				}else {

					$this->smarty->assign( 'quiz_data', null );
				}

				$this->form->answer_contents = str_replace("\\", "",$fbLists[0]->answer_contents);
				
				$this->form->kbn_count = $count;
				$this->smarty->assign( 'course_detail_no', $course_detail_no );
				$this->smarty->assign( 'course_id', $course_id );
				$this->smarty->assign( 'offer_no', $offer_no );
				$this->smarty->assign( 'org_no', $org_no );
				$this->smarty->assign( 'student_no', $student_no );
				$this->smarty->assign( 'courseData', $courseData);
				$this->smarty->assign( 'cnt', $cnt );
				$this->smarty->assign( 'cfinish', $cfinish );
				$this->smarty->assign( 'form', $this->form );
				$this->smarty->display( 'writingFeedbackList.html' );
			}else {

				TransitionHelper::sendException ( E002 );
				return;
			}
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}
}
?>