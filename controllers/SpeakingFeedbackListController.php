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
require_once 'service/DetailService.php';
require_once 'util/DateUtil.php';

/**
 * Speaking受講結果確認コントローラー
 */
class SpeakingFeedbackListController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			$service = new DetailService($this->pdo);
			//前画面からパラメータ設定
			$course_detail_no = $this->form->course_detail_no;
			$offer_no = $this->form->offer_no;
			$course_id = $this->form->course_id;
			$student_no = $this->form->student_no;
			$org_no = $this->form->org_no;
			$audio_folder =  SYS_ROOT_STU.AUDIO_DIR;

			//コース詳細管理№, コースID, 申込管理№,受講番号がある場合
			if ( $course_detail_no != "" && $course_id != "" && $offer_no != "" && $student_no!= "" ){

				$this->form->test_kbn = '001';

				//教師がチェックしたコース
				$cfinish = $service->getCoursesFinishByStudent($this->form->student_no, $this->form->offer_no, $this->form->course_id, $this->form->test_kbn);
				$cnt = count($cfinish);

				//グラフのためデータを取得する
				$coursesData = $service->getWritingFeedbackAllData($this->form);

				//コース詳細管理№の通りデータを取得する
				$fbLists = $service->getWritingFeedbackData($this->form);
				
				$this->form->course_name = $fbLists[0]->course_name;
				$this->form->course_detail_name = $fbLists[0]->course_detail_name;
				$this->form->org_name= $fbLists[0]->org_name;//組織名
				$this->form->stu_login_in= $fbLists[0]->stu_login_in;//ログインID
				$this->form->student_name= $fbLists[0]->student_name;//氏名

				//コース別に質問リストを取得する
				//質問リストがある場合
				if ( count($fbLists) > 0 ){

					$quiz_data = array();
					$a = 0;
					$qno = $fbLists[$a]->question_no;
					$dec = array();
					$rule = array();
					$sub_rule = array();
					$m = 0;
					$n = 0;

					for ( $j = 0; $j < count($fbLists); $j++ ) {

						if ( $fbLists[$j]->question_no != $qno || $j == 0 ){

							$qno = $fbLists[$j]->question_no;
							for ( $i = 0; $i < count($fbLists); $i++ ) {

								if ( $fbLists[$i]->question_no == $qno ){

									$temp = new T_DetailDto();
									$m = $m + $fbLists[$i]->detail_result_marks;
									$n = $n + $fbLists[$i]->detail_total_marks;
									array_push($dec, $fbLists[$i]->reply_comment);
									array_push($rule, $fbLists[$i]->description);
									array_push($sub_rule, $fbLists[$i]->sub_description);
								}
							}
							$temp->question_no = $fbLists[$j]->question_no;
							$temp->total_marks = $m;
							$temp->full_marks = $n;
							$temp->reply_comment = $dec;
							$temp->description = $rule;
							$temp->sub_description = $sub_rule;
							$temp->sample_answer = nl2br($fbLists[$j]->sample_answer);
							$temp->offer_no = $fbLists[$j]->offer_no;
							$temp->org_no = $this->form->org_no;
							$temp->course_id = $fbLists[$j]->course_id;
							$temp->course_detail_no = $fbLists[$j]->course_detail_no;
							$temp->audio_name = $fbLists[$j]->audio_name;
							// YES/NO どちらを選んだか表示 2019/11/25
							$temp->answer_flg = $fbLists[$j]->answer_flg;
							array_push($quiz_data, $temp);
							$qno = $fbLists[$j]->question_no;
							$m = 0;
							$n = 0;
							unset($dec);
							unset($rule);
							unset($sub_rule);
							$dec = array();
							$rule = array();
							$sub_rule = array();
						}
					}

					$this->smarty->assign( 'quiz_data', $quiz_data );
				}else {
					//質問リストがないの場合
					$this->smarty->assign( 'quiz_data', null );
				}

				$this->smarty->assign( 'cfinish', $cfinish );
				$this->smarty->assign( 'cnt', $cnt );
				$this->smarty->assign( 'course_detail_no', $course_detail_no );
				$this->smarty->assign( 'course_id', $course_id );

				$this->smarty->assign( 'offer_no', $offer_no );
				$this->smarty->assign( 'student_no', $student_no );
				$this->smarty->assign( 'org_no', $org_no );
				$this->smarty->assign( 'coursesData', $coursesData );
				$this->smarty->assign( 'audio_folder', $audio_folder );
				$this->smarty->assign( 'form', $this->form );
				$this->smarty->display( 'speakingFeedbackList.html' );

			}else {
				//コース詳細管理№, コースID, 申込管理№,受講番号がない場合
				TransitionHelper::sendException ( E002 );
				return;
			}
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 戻るボタンのAction
	 */
	public function backAction() {

		if ( $this->check_login() == true ){
			//登録完了
			$this->setBackData();

			// コース一覧画面へ遷移する
			$this->dispatch('CourseStatusList/search');
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 戻る場合のデータセット
	 */
	public function setBackData() {

		$_SESSION ['back_flg'] = true;
		$_SESSION ['search_page'] = $this->form->search_page;
		$_SESSION ['search_start_period'] = $this->form->search_start_period;
		$_SESSION ['search_end_period'] = $this->form->search_end_period;
		$_SESSION ['search_detail_name'] = $this->form->search_detail_name;
		$_SESSION ['search_chk_status'] = $this->form->search_chk_status;
		$_SESSION ['org_id'] = $this->form->search_org_id;
		$_SESSION ['search_student_name'] = $this->form->search_student_name;
		$_SESSION ['search_login_id'] = $this->form->search_login_id;
	}
}

?>
