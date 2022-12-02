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
require_once 'util/DateUtil.php';
require_once 'service/YNSQuizInfoService.php';
require_once 'service/AudioService.php';

/**
 * クイズ情報登録コントローラー
 */
class YNSQuizInfoRegistController extends BaseController
{

    /**
     * 初期処理
     */
    public function indexAction()
    {

        if ($this->check_login() == true) {

            $screen_mode = $this->form->screen_mode;
            $this->smarty->assign('error_msg', "");
            $this->smarty->assign('info_msg', "");

            $quiz_service = new YNSQuizInfoService($this->pdo);

            // 更新
            if ($this->form->screen_mode == 'update') {
                // 課題管理№のチェック
                if (!empty($this->form->quiz_id)) {
                    // 課題データ取得
                    $quiz_id = $this->form->quiz_id;
                    $list = $quiz_service->getQuizDataByQuizNo($quiz_id);
                    // $quizInfoNo = $this->form->quiz_id;
                    if ($list != null) {
                        foreach ($list as $value) {
                            // formにデータをセットする
                            $this->form->quiz_id = $value->quiz_id;
                            $this->form->name = $value->name;
                            $this->form->content = $value->content;
                            $this->form->audio_file = $value->audio_name;
                            $this->form->remarks = $value->remarks;
                        }
                    }

                    $this->form->audio_del_flg = 1;
                    $this->form->screen_mode = "update";

                    $this->form->disable_mode = "";
                    // 管理者は利用しないのでコメントアウト
                    /* 
					$quizInfoDisable = $quiz_service->getQuizDataByQuizNoDisable($orgNo, $quizInfoNo);
					LogHelper::logDebug ( "quizInfoDisable count:".$quizInfoDisable);
					
					if ($quizInfoDisable > 0) {
						$this->form->disable_mode = "disable";
					}else{
						$this->form->disable_mode = "";
					} */
                } else {
                    TransitionHelper::sendException(E002);
                    return;
                }
            } else {

                // $this->form->org_no = COMMON_TEST_INFO_ORG;
                // $next_quiz_id = $quiz_service->getNextId();
                // $quiz_id = $next_quiz_id->id;

                // $this->form->quiz_id = $quiz_id;
                $this->form->name = "";
                $this->form->content = "";
                $this->form->audio_del_flg = 0;
                $this->form->screen_mode = "";
                $this->form->remarks = "";
                $this->smarty->assign('error_msg', "");
                $this->smarty->assign('info_msg', "");
            }

            // メニュー情報を取得、セットする
            $this->setMenu();

            $this->smarty->assign('form', $this->form);
            $this->smarty->display('ynsquizInfoRegist.html');
        } else {
            TransitionHelper::sendException(E002);
            return;
        }
    }

    /*
	 * 登録ボタン、更新ボタンのAction
	 */
    public function saveAction()
    {

        if ($this->check_login() == true) {

            $quiz_service = new YNSQuizInfoService($this->pdo);

            // 登録ボタン押下処理
            // メニュー情報を取得、セットする
            $this->setMenu();

            $screen_mode = $this->form->screen_mode;
            $audio_del_flg = $this->form->audio_del_flg;
            $name = $this->form->name;
            $content = $this->form->content;
            $remarks = $this->form->remarks;

            // テストデータ情報登録
            $quiz_dto = new T_YNSQuizDto();

            $quiz_dto->name = $name;
            $quiz_dto->content = $content;
            $quiz_dto->remarks = $remarks;

            $quiz_dto->quiz_id = $this->form->quiz_id;
            $this->form->quiz_id = $quiz_dto->quiz_id;

            if ($screen_mode == 'update') {

                $quiz_id = $this->form->quiz_id;
                $quiz_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');

                $audio_chk_del = $this->form->audio_chk_del;

                // 音声ファイルがある場合、音声ファイルのアップロード処理を実施
                if (!empty($quiz_id)) {

                    $audioService = new AudioService($this->pdo);

                    $audio_name = "YNSQuizInfoNo_" . $this->form->quiz_id . AUDIO_EXT;
                    if (!empty($this->form->audio_data)) {

                        $quiz_dto->audio_name = $audio_name;

                        $audioService->deleteAudioQuiz1(QUIZ_INFO_AUDIO_DIR, "YNSQuizInfoNo_" . $this->form->quiz_id);

                        // プロジェクト名/Files/組織管理№/Quiz/QuizInfoNo_クイズ管理№.選択されたファイルの拡張子
                        $this->SaveAudio($this->form);
                    } else {
                        if (!empty($this->form->audio_file)) {
                            $quiz_dto->audio_name =  "YNSQuizInfoNo_" . $this->form->quiz_id . AUDIO_EXT;
                        }
                    }
                    // 音声フィル削除チェックの場合、削除する
                    if ($this->form->audio_chk_del == "1") {
                        $quiz_dto->audio_name = "";
                        $audioService->deleteAudioQuiz1($quiz_dto->quiz_id, QUIZ_INFO_AUDIO_DIR, "YNSQuizInfoNo_" . $this->form->quiz_id);
                    }
                }

                $dao = new YNSQuizInfoService($this->pdo);
                $result = $dao->updateQuizInfo($quiz_dto);

                // 更新処理が正常の場合、
                if ($result == 1) {

                    //登録完了
                    $_SESSION['regist_msg'] = I007;

                    $this->setBackData();
                    $this->dispatch('YNSQuizInfoList');

                    // 更新出来ない場合、
                } else {

                    $error = sprintf(E007, '更新');
                    $this->smarty->assign('msg', $error);
                    $this->smarty->assign('form', $this->form);
                    $this->smarty->display('ynsquizInfoRegist.html');
                    return;
                }
                // 登録状況
            } else {

                $quiz_dto->org_no = COMMON_TEST_INFO_ORG;
                $next_quiz_id = $quiz_service->getNextId();
                $quiz_id = $next_quiz_id->id;

                $this->form->quiz_id = $quiz_id;

                if (!empty($this->form->audio_data)) {

                    $quiz_dto->audio_name =  "QuizInfoNo_" . $quiz_id . AUDIO_EXT;
                    $this->SaveAudio($this->form);
                }
                $quiz_dto->quiz_id = $quiz_id;
                $quiz_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
                $quiz_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');

                $dao = new YNSQuizInfoService($this->pdo);

                $result = $dao->saveQuiz($quiz_dto);

                // 登録処理が正常の場合、クイズ一覧画面に遷移する。
                if ($result == 1) {

                    $this->smarty->assign('info_msg', I004);
                    $this->smarty->assign('error_msg', "");

                    // メニュー情報を取得、セットする
                    $this->setMenu();
                    $this->smarty->assign('form', $this->form);
                    $this->smarty->display('ynsquizInfoRegist.html');

                    // 登録出来ない場合
                } else {

                    $error = sprintf(E007, '登録');
                    $this->smarty->assign('msg', $error);
                    $this->smarty->assign('form', $this->form);
                    $this->smarty->display('ynsquizInfoRegist.html');
                    return;
                }
            }
        } else {
            TransitionHelper::sendException(E002);
            return;
        }
    }
    /**
     *
     */
    private function SaveAudio($form)
    {

        $audioService = new AudioService($this->pdo);
        if ($form->audio_data != null && $form->audio_data != "") {
            $audio_name = "YNSQuizInfoNo_" . $form->quiz_id . AUDIO_EXT;
            $audioService->saveAudioQuiz1($form->audio_data, YNSQUIZ_INFO_AUDIO_DIR, $audio_name);
        }
    }

    /*
	 * 削除ボタンのAction
	 */
    public function deleteAction()
    {

        if ($this->check_login() == true) {

            $quiz_dto = new T_YNSQuizDto();

            // メニュー情報を取得、セットする
            $this->setMenu();
            $quiz_dto->quiz_id = $this->form->quiz_id;
            $quiz_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
            $dao = new YNSQuizInfoService($this->pdo);
            $result = $dao->deleteQuizInfo($quiz_dto);

            // 登録処理が正常の場合、クイズ一覧画面に遷移する。
            if ($result == 1) {
                //登録完了
                $this->setBackData();

                // 受講者一覧画面へ遷移する
                $this->dispatch('YNSQuizInfoList/Search');
                // 登録出来ない場合
            } else {
                $error = sprintf(E007, '削除');
                $this->smarty->assign('msg', $error);
                $this->smarty->assign('form', $this->form);
                $this->smarty->display('quizInfoRegist.html');
                return;
            }
        } else {
            TransitionHelper::sendException(E002);
            return;
        }
    }

    /*
	 * 戻るボタンのAction
	 */
    public function backAction()
    {
        if ($this->check_login() == true) {

            //登録完了
            $this->setBackData();

            // クイズ一覧画面へ遷移する
            $this->dispatch('YNSQuizInfoList/Search');
        } else {
            TransitionHelper::sendException(E002);
            return;
        }
    }

    /*
	 * 戻る場合のデータセット
	 */
    public function setBackData()
    {
        $_SESSION['back_flg'] = true;
        $_SESSION['search_page'] = $this->form->search_page;

        $_SESSION['search_quiz_name'] = $this->form->search_quiz_name;
        $_SESSION['search_quiz_content'] = $this->form->search_long_description;
        $_SESSION['search_remark'] = $this->form->search_remark;
        $_SESSION['search_rd_status1'] = $this->form->search_rd_status1;
        $_SESSION['search_org_id'] = $this->form->search_org_id;

        $_SESSION['search_page_qil'] = $this->form->search_page_qil;
        $_SESSION['search_page_row_qil'] = $this->form->search_page_row_qil;
        $_SESSION['search_page_order_column_qil'] = $this->form->search_page_order_column_qil;
        $_SESSION['search_page_order_dir_qil'] = $this->form->search_page_order_dir_qil;
    }
}
