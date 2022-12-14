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

            //Tクイズ情報テーブルから取得
            $dataInfo = $qzInfoService->getQuizDataByQuizNo($quiz_id);


            //クイズア情報Noの存在チャック

            $quiz_des = array();
            $itemList = array();
            $optionList = array();
            $items = array(array());
            $options = array(array(array()));


            $audio_file = sprintf(F001, AUDIO_FILE, 'YNSQuiz', 'YNSQuizInfo', 'ynsAudio');

            LogHelper::logDebug("audio File : " . $audio_file);

            $this->smarty->assign('folder_check', $_SERVER["DOCUMENT_ROOT"] . ADMIN_HOME_DIR);
            $this->smarty->assign('audio_file', $audio_file);
            $this->smarty->assign('optionList', $optionList);
            $this->smarty->assign('options', $options);
            $this->smarty->assign('items', $items);
            $this->smarty->assign('itemList', $itemList);
            // $this->smarty->assign('$audio_name', $dataInfo->audio_name);

            $this->smarty->assign('error_msg', "");
            $this->smarty->assign('dataInfo', $dataInfo);
            $this->smarty->display('ynsQuizDetailsPreview.html');
        }
    }

    /*
     * 戻るボタンのAction
     */
    public function backAction()
    {

        if ($this->check_login() == true) {
            $org_no = $this->form->org_no;
            $quiz_id = $this->form->quiz_id;
            $name = $this->form->name;
            $content = $this->form->content;
            $remarks = $this->form->remarks;
            $audio_file = $this->form->audio_file;
            $input_audio_file = $this->form->input_audio_file;
            $audio_del_flg = $this->form->audio_del_flg;
            $audio_chk_del = $this->form->audio_chk_del;
            $gamen_name = $this->form->gamen_name;

            $this->form->org_no = $org_no;
            $this->form->quiz_id = $quiz_id;
            $this->form->name = $name;
            $this->form->content = $content;
            $this->form->remarks = $remarks;
            $this->form->audio_file = $audio_file;
            $this->form->input_audio_file = $input_audio_file;
            $this->form->audio_del_flg = $audio_del_flg;
            $this->form->audio_chk_del = $audio_chk_del;
            $this->form->gamen_name = $gamen_name;
            $this->form->screen_mode = $this->form->screen_mode;

            $this->smarty->assign('info_msg', "");
            $this->smarty->assign('error_msg', "");
            $this->smarty->assign('form', $this->form);
            $this->setBackData();
            $this->smarty->display('ynsQuizInfoList.html');
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
