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
require_once 'service/CourseDetailService.php';
require_once 'service/QuestionService.php';

/**
 * SW Practice 参照コントローラー
 */
class SWCourseDetailRefController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			$service = new CourseDetailService($this->pdo);
			$course_detail = $service->getCourseDetailListByCourseDetailNo($this->form);
			$audio_folder =  SYS_ROOT_STU.AUDIO_DIR;

			if(sizeof($course_detail) > 0){
				$this->smarty->assign('course_detail', $course_detail[0]);
			}else{
				$this->smarty->assign('course_detail', null);
			}

			$service = new QuestionService($this->pdo);
			$question_data= $service->getQuestionDetailListData($this->form);

			if(sizeof($question_data) > 0){

				$this->smarty->assign('question_data', $question_data);
			}else{
				$error = sprintf(E020);
				$this->smarty->assign( 'error_msg', $error );
				$this->smarty->assign('question_data', null);
			}

			$this->smarty->assign('audio_folder', $audio_folder);
			$this->smarty->assign('form', $this->form);
			$this->smarty->display ( 'swCourseDetailRef.html' );
		}else{
			TransitionHelper::sendException ( E002 );
			return;
		}
	}
}

?>