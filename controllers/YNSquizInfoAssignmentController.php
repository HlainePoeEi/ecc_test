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
require_once 'dao/T_YNSQuizInfoAssignmentDao.php';
require_once 'service/YNSQuizInfoService.php';
require_once 'dto/T_Quiz_InfoDto.php';
require_once 'dto/T_YNS_Exam_QuizDto.php';
require_once 'dto/PageDto.php';
require_once 'util/DateUtil.php';


/**
 * テスト・クイズ情報割当コントローラー
 */
class YNSQuizInfoAssignmentController extends BaseController
{
    /**
     * 初期処理
     */
    public function indexAction()
    {

        if ($this->check_maintenance() == true) {

            if ($this->check_login() == true) {

                $this->dataSearch("");
            } else {
                TransitionHelper::sendException(E002);
                return;
            }
        } else {

            TransitionHelper::sendMaintenance($_SESSION['error_message']);
            return;
        }
    }

    private function search($form)
    {

        if (empty($this->form->page)) {
            $this->form->page = 1;
        }

        // if (isset($_SESS2ION['org_no'])) {
        //     $this->form->org_no = $_SESSION['org_no'];
        // }

        $service = new YNSQuizInfoService($this->pdo);

        //検索結果を取得
        $count = count($service->getQuizListOnTest($this->form));

        if ($count > 0) {

            $addlist = $service->getQuizListOnTest($this->form);
            $this->smarty->assign('addlist', $addlist);
            $this->smarty->assign('list', NULL);
        } else {
            // エラーメッセージを設定　「検索結果がありません」
            $err_msg = W001;
            $this->smarty->assign('addlist', NULL);
            $this->smarty->assign('list', NULL);
            $this->smarty->assign('err_msg', $err_msg);
        }
    }

    public function saveAction()
    {

        if ($this->check_login() == true) {

            $service = new YNSQuizInfoService($this->pdo);

            // if (isset($_SESSION['org_no'])) {
            //     $org_no = $_SESSION['org_no'];
            // }

            if (isset($_SESSION['login_id'])) {
                $login_id = $_SESSION['login_id'];
            }

            $exam_id = $this->form->exam_id;
            $count = $service->countExistingQuiz($exam_id);

            if ($count > 0) {
                // 削除処理
                $service->deleteQuizOnTest($exam_id);
            }
            $insertDataList = explode(',', $this->form->entryList);

            $display_no = 0;
            foreach ($insertDataList as $insertData) {

                if ($insertData != null || $insertData != "") {

                    $exam_quizDto = new T_YNS_Exam_QuizDto();

                    $exam_quizDto->exam_id = $exam_id;
                    $exam_quizDto->quiz_id = (int)$insertData;
                    $exam_quizDto->disp_no = ++$display_no;
                   
                    // $test_quizDto->create_dt = DateUtil::getDate("Y/m/d H:i:s");;
                    // $test_quizDto->update_dt = DateUtil::getDate("Y/m/d H:i:s");;
                    // $test_quizDto->creater_id = $_SESSION['manager_no'];
                    // $test_quizDto->updater_id = $_SESSION['manager_no'];

                    $result = $service->addQuizDataOnTest($exam_quizDto);
                }
            }

            $this->dataSearch(I004);
        } else {
            TransitionHelper::sendException(E002);
            return;
        }
    }

    /**
     * 登録した後、最新データを取得する処理
     */
    public function dataSearch($err_msg)
    {

        // $this->form = $this->form;

        $this->form->page = 1;

        $exam_id = $this->form->exam_id;
        if ($exam_id != Null) {

                $service = new YNSQuizInfoService($this->pdo);
                $list = $service->getTestData($exam_id);

                if ($list != null) {
                    foreach ($list as $value) {

                        $this->form->exam_name = $value->name;
                        $this->form->exam_id = $value->exam_id;
                        $this->form->start_date = $value->start_date;
                        $this->form->end_date = $value->end_date;
                    }
                }
            //clear assign value
            //clear_assign($addlist);
            $this->search($this->form);

            // メニュー情報を取得、セットする
            $this->setMenu();

            $this->smarty->assign('err_msg', $err_msg);
            $this->smarty->assign('form', $this->form);
            $this->smarty->display('ynsquizInfoAssignment.html');
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

        if ($this->check_maintenance() == true) {

            //登録完了
            $this->setBackData();

            // 受講者一覧画面へ遷移する
            $this->dispatch('YNSExamList/Search');
        } else {

            TransitionHelper::sendMaintenance($_SESSION['error_message']);
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
        $_SESSION['search_status'] = $this->form->search_status;

        $_SESSION['search_page_til'] = $this->form->search_page_til;
        $_SESSION['search_page_row_til'] = $this->form->search_page_row_til;
        $_SESSION['search_page_order_column_til'] = $this->form->search_page_order_column_til;
        $_SESSION['search_page_order_dir_til'] = $this->form->search_page_order_dir_til;
    }
}
