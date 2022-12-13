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
require_once 'service/YMHTestInfoService.php';
require_once 'dto/PageDto.php';
require_once 'util/DateUtil.php';

/**
 * テスト情報一覧コントローラー
 */
class YMHTestInfoListController extends BaseController
{

    /**
     * 初期処理
     */
    public function indexAction()
    {

        if ($this->check_maintenance() == true) {
            if ($this->check_login() == true) {

                // $this->form->student_no = $_SESSION ['student_no'];
                // if(isset($_SESSION['org_no'])){
                //     $this->form->org_no = $_SESSION ['org_no'];
                // }
                $this->form->subject_no = '';
                $this->search($this->form);

                $this->form->page = 0;
                $this->form->page_row = 10;
                $this->form->page_order_column = 1;
                $this->form->page_order_dir = 'desc';

                // メニュー情報を取得、セットする
                $this->setMenu();

                $this->smarty->assign('err_msg', "");
                $this->smarty->assign('form', $this->form);
                $this->smarty->display('ymhTestInfoList.html');
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

        if ($this->check_login() == true) {

            $service = new YMHTestInfoService($this->pdo);
            $count = count($service->getExamList($form));
            //$count = count($service->getTestListData($form));

            if ($count > 0) {

                $list = $service->getExamList($form);
                $this->smarty->assign('list', $list);
            } else {

                $this->smarty->assign('list', NULL);
            }
            //$this->smarty->assign ( 'subjList', $subjList);
        } else {
            TransitionHelper::sendException(E002);
            return;
        }
    }

    public function searchAction()
    {

        if ($this->check_maintenance() == true) {

            if ($this->check_login() == true) {
                $this->form->student_no = $_SESSION['student_no'];
                if (isset($_SESSION['org_no'])) {
                    $this->form->org_no = $_SESSION['org_no'];
                }
                $this->form->page = $this->form->search_page;
                if ($this->form->subject_no == 0 || $this->form->subject_no == '') {
                    $this->form->subject_no = "";
                }

                $this->form->page = $this->form->search_page;
                $this->form->page_row = $this->form->search_page_row;
                $this->form->page_order_column = $this->form->search_page_order_column;
                $this->form->page_order_dir = $this->form->search_page_order_dir;

                $this->search($this->form);
                $this->smarty->assign('form', $this->form);
                $this->smarty->display('testInfoList.html');
            } else {

                TransitionHelper::sendException(E002);
                return;
            }
        } else {
            TransitionHelper::sendException(E002);
            return;
        }
    }

    public function checkDataAction()
    {

        if ($this->check_login() == true) {
            $service = new YMHTestInfoService($this->pdo);
            $this->form->page = $this->form->search_page;
            $this->form->page_row = $this->form->search_page_row;
            $this->form->page_order_column = $this->form->search_page_order_column;
            $this->form->page_order_dir = $this->form->search_page_order_dir;
            $result = $service->getListQuiz( $this->form->exam_id);
            LogHelper::logDebug("------------------------------" . count($result));
            LogHelper::logDebug("------------------------------" . count($result));
            if (count($result) < 1) {
                $err_msg = "テストのクイズがありません。";
                echo ($err_msg);
            }
        } else {

            TransitionHelper::sendException(E002);
            return;
        }
    }
}
?>