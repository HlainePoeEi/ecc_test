<?php
require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'service/YNSExamService.php';
/**
 * テスト情報プレビューコントローラー
 */
class YNSTestInfoPreviewController extends BaseController
{
    /**
     * 初期処理
     */
    public function indexAction()
    {
        if ($this->check_login() == true) {
            $exam_id = $this->form->exam_id;
            if (!empty($exam_id)) {

                $this->search($this->form);

                // メニュー情報を取得、セットする
                $this->setMenu();

                $audio_file = sprintf(F001, AUDIO_FILE, 'YNSQuiz', 'YNSQuizInfo', 'ynSAudio');

                LogHelper::logDebug("audio File : " . $audio_file);

                $this->smarty->assign('folder_check',  $_SERVER["DOCUMENT_ROOT"] . ADMIN_HOME_DIR);
                $this->smarty->assign('audio_file', $audio_file);
                $this->smarty->assign('form', $this->form);
                $this->smarty->display('ynsTestInfoPreview.html');
            } else {
                TransitionHelper::sendException(E005);
                return;
            }
        } else {
            TransitionHelper::sendException(E002);
            return;
        }
    }
    private function search($form)
    {
        $exam_id = $this->form->exam_id;

        $service = new YNSExamService($this->pdo);

        $quiz_des = array();
        $itemList = array();
        $optionList = array();
        $items = array(array());
        $options = array(array(array()));

        // 検索結果を取得
        $quizList = $service->getListQuizForPreview($exam_id);

        LogHelper::logDebug($quizList);

        if (count($quizList) > 0) {

            LogHelper::logDebug("Quiz COUNt" . count($quizList));
            for ($i = 0; $i < count($quizList); $i++) {
                $quiz_des[] = $quizList[$i]->content;
                $itemList = $service->getItemList($quizList[$i]->quiz_id);
                LogHelper::logDebug("Item List" . count($itemList));
                if (!empty($itemList)) {
                    for ($j = 0; $j < count($itemList); $j++) {
                        $items[$i][$j] = $itemList[$j];
                        $optionList = $service->getOptionList($items[$i][$j]->quiz_item_no, $quizList[$i]->quiz_id);

                        if (!empty($optionList)) {
                            for ($k = 0; $k < count($optionList); $k++) {
                                $options[$i][$j][$k] = $optionList[$k];
                            }
                        }
                    }
                }
            }

            $this->smarty->assign('optionList', $optionList);
            $this->smarty->assign('options', $options);
            $this->smarty->assign('items', $items);
            $this->smarty->assign('itemList', $itemList);
            $this->smarty->assign('quiz_list', $quizList);
            $this->smarty->assign('quiz_description', $quiz_des);
            $this->smarty->assign('option_list', "");
            $this->smarty->assign('msg', '');
            $this->smarty->assign('item_list', '');
            $this->smarty->assign('form', $form);
            $this->smarty->assign('test_name', $quizList[0]->exam_name);
            $this->smarty->assign('time', $quizList[0]->time);
            $this->smarty->assign('description', $quizList[0]->content);
        } else {
            // エラーメッセージを設定 「検索結果がありません」
            $msg = sprintf(W005);
            $this->smarty->assign('quiz_list', '');
            $this->smarty->assign('item_list', '');
            $this->smarty->assign('option_list', '');
            $this->smarty->assign('form', '');
            $this->smarty->assign('msg', $msg);
        }
    }

    /*
     * 戻るボタンのAction
     */
    public function backAction()
    {
        // 登録完了
        $this->setBackData();

        if ($this->form->back_gamen == "at_report" && $this->form->at_report_no != "") {

            // AtReport画面へ遷移する
            $this->dispatch('AtReportList/index');
        } else {
            // 試験一覧画面へ遷移する
            $this->dispatch('TestInfoList/Search');
        }
    }

    /*
     * 戻る場合のデータセット
     */
    public function setBackData()
    {
        $_SESSION['back_flg'] = true;
        $_SESSION['search_page'] = $this->form->search_page;
        $_SESSION['search_start_period'] = $this->form->search_start_period;
        $_SESSION['search_end_period'] = $this->form->search_end_period;
        $_SESSION['search_test_info_name'] = $this->form->search_test_info_name;
        $_SESSION['search_remark'] = $this->form->search_remark;
        $_SESSION['search_rd_status1'] = $this->form->search_rd_status1;
        $_SESSION['search_rd_status2'] = $this->form->search_rd_status2;
        $_SESSION['search_rdstatus'] = $this->form->search_rdstatus;
        $_SESSION['search_chk_status1'] = $this->form->search_chk_status1;
        $_SESSION['search_chk_status2'] = $this->form->search_chk_status2;
        $_SESSION['search_status'] = $this->form->search_status;
        $_SESSION['search_org_id'] = $this->form->search_org_id;

        $_SESSION['search_page_til'] = $this->form->search_page_til;
        $_SESSION['search_page_row_til'] = $this->form->search_page_row_til;
        $_SESSION['search_page_order_column_til'] = $this->form->search_page_order_column_til;
        $_SESSION['search_page_order_dir_til'] = $this->form->search_page_order_dir_til;
    }
}
