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
require_once 'dto/T_Quiz_ItemDto.php';
require_once 'dto/T_Quiz_Item_OptionDto.php';
require_once 'dto/T_Quiz_InfoDto.php';
require_once 'service/QuizDetailsService.php';
require_once 'service/YNSQuizInfoService.php';
require_once 'util/DateUtil.php';
require_once 'service/TestInfoService.php';

/**
 * クイズアイテムプラビューコントローラー
 */
class YNSQuizDetailsPreviewController extends BaseController
{

    /**
     * 初期処理
     */
    public function indexAction()
    {

        if ($this->check_login() == true) {

            // メニュー情報を取得、セットする
            $this->setMenu();

            // クイズアイテム情報設定
            $this->getQuizPreviewData($this->form);
        } else {
            TransitionHelper::sendException(E002);
            return;
        }
    }

    /**
     * 画面データ取得・渡す処理
     */
    public function getQuizPreviewData($form)
    {

        $quiz_id = $this->form->quiz_id;

        if ($quiz_id != "") {

            // データベース接続
            $qzInfoService = new YNSQuizInfoService($this->pdo);
            $qzItemDtService = new QuizDetailsService($this->pdo);
            $qzOptDtService = new QuizDetailsService($this->pdo);

            //Tクイズ情報テーブルから取得
            $dataInfo = $qzInfoService->getQuizDataByQuizNo($quiz_id);

            //クイズア情報Noの存在チャック

            $quiz_des = array();
            $itemList = array();
            $optionList = array();
            $items = array(array());
            $options = array(array(array()));

            $service = new YNSExamService($this->pdo);
            $itemList = $service->getItemList($quiz_id);
            LogHelper::logDebug("Item List" . count($itemList));
            if (!empty($itemList)) {
                for ($j = 0; $j < count($itemList); $j++) {
                    $i=0;
                    $items[$i][$j] = $itemList[$j];
                    $optionList = $service->getOptionList($items[$i][$j]->quiz_item_no, $quiz_id);

                    if (!empty($optionList)) {
                        for ($k = 0; $k < count($optionList); $k++) {
                            $options[$i][$j][$k] = $optionList[$k];
                        }
                    }
                }
            }

            $audio_file = sprintf(F001, AUDIO_FILE, 'YNSQuiz', 'YNSQuizInfo', 'ynSAudio');

            LogHelper::logDebug("audio file name is " . $dataInfo->audio_name);
            LogHelper::logDebug("folder_check is " . $folder_check);
            LogHelper::logDebug("audio_file is " . $audio_file);

            $this->smarty->assign('folder_check', $_SERVER["DOCUMENT_ROOT"] . ADMIN_HOME_DIR);
            $this->smarty->assign('audio_file', $audio_file);
            $this->smarty->assign('optionList', $optionList);
            $this->smarty->assign('options', $options);
            $this->smarty->assign('items', $items);
            $this->smarty->assign('itemList', $itemList);
            // $this->smarty->assign('$audio_name', $dataInfo->audio_name);

            $this->smarty->assign('error_msg', "");
            $this->smarty->assign('form', $this->form);
            $this->smarty->display('quizDetailsPreview.html');
        }
    }

    /*
     * 戻るボタンのAction
     */
    public function backAction()
    {

        if ($this->check_login() == true) {
            $org_no = $this->form->org_no;
            $quiz_info_no = $this->form->quiz_info_no;
            $quiz_name = $this->form->quiz_name;
            $long_description = $this->form->long_description;
            $remarks = $this->form->remarks;
            $audio_file = $this->form->audio_file;
            $input_audio_file = $this->form->input_audio_file;
            $audio_del_flg = $this->form->audio_del_flg;
            $audio_chk_del = $this->form->audio_chk_del;
            $gamen_name = $this->form->gamen_name;

            $this->form->org_no = $org_no;
            $this->form->quiz_info_no = $quiz_info_no;
            $this->form->quiz_name = $quiz_name;
            $this->form->long_description = $long_description;
            $this->form->remarks = $remarks;
            $this->form->audio_file = $audio_file;
            $this->form->input_audio_file = $input_audio_file;
            $this->form->audio_del_flg = $audio_del_flg;
            $this->form->audio_chk_del = $audio_chk_del;
            $this->form->gamen_name = $gamen_name;
            $this->form->disable_mode = $this->form->disable_mode;
            $this->form->screen_mode = $this->form->screen_mode;

            $this->smarty->assign('info_msg', "");
            $this->smarty->assign('error_msg', "");
            $this->smarty->assign('form', $this->form);
            $this->setBackData();

            if ($gamen_name != "") {
                $this->smarty->display('quizInfoRegist.html');
            } else {
                $this->dispatch('QuizInfoList/Search');
            }
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
        $_SESSION['search_org_id'] = $this->form->search_org_id;

        $_SESSION['search_quiz_name'] = $this->form->search_quiz_name;
        $_SESSION['search_quiz_content'] = $this->form->search_long_description;
        $_SESSION['search_remark'] = $this->form->search_remark;
        $_SESSION['search_rd_status1'] = $this->form->search_rd_status1;

        $_SESSION['search_page_qil'] = $this->form->search_page_qil;
        $_SESSION['search_page_row_qil'] = $this->form->search_page_row_qil;
        $_SESSION['search_page_order_column_qil'] = $this->form->search_page_order_column_qil;
        $_SESSION['search_page_order_dir_qil'] = $this->form->search_page_order_dir_qil;
    }
}
