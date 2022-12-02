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
require_once 'service/YNSQuizInfoService.php';
require_once 'dto/T_Quiz_InfoDto.php';
/**
 * クイズ一覧コントローラー
 */
class YNSQuizInfoListController extends BaseController
{

    /**
     * 初期処理
     */
    public function indexAction()
    {

        if ($this->check_login() == true) {

            $this->form->name = "";
            $this->form->contet = "";
            $this->form->remarks = "";
            $this->form->search_page_qil = 0;
            $this->form->search_page_row_qil = 10;
            $this->form->search_page_order_column_qil = 1;
            $this->form->search_page_order_dir_qil = true;
            $this->form->search_org_id = COMMON_TEST_INFO_ORG;

            $this->search($this->form);
            $this->smarty->assign('err_msg', '');

            // メニュー情報を取得、セットする
            $this->setMenu();
            if (isset($_SESSION['regist_msg'])) {
                if ($_SESSION['regist_msg'] != "") {
                    $this->smarty->assign('err_msg', $_SESSION['regist_msg']);
                    $_SESSION['regist_msg'] = "";
                }
            }

            $this->smarty->assign('form', $this->form);
            $this->smarty->display('ynsquizInfoList.html');
        } else {
            TransitionHelper::sendException(E002);
            return;
        }
    }

    private function search($form)
    {

        if (empty($form->page)) {
            $form->page = 1;
        }

        $form->org_no = COMMON_TEST_INFO_ORG;
        $service = new YNSQuizInfoService($this->pdo);

        // 検索結果を取得
        $list = $service->getQuizListData($form, "0");
        $count = count($list);

        if ($count > 0) {
            $this->smarty->assign('err_msg', '');
            $this->smarty->assign('list', $list);
        } else {
            // エラーメッセージを設定　「検索結果がありません」
            $err_msg = W001;
            $this->smarty->assign('list', "");
            $this->smarty->assign('err_msg', $err_msg);
        }
    }

    public function searchAction()
    {

        $err_msg = "";

        if (isset($_SESSION['regist_msg']) && $_SESSION['regist_msg'] != "") {
            $this->smarty->assign('err_msg', $_SESSION['regist_msg']);
            $_SESSION['regist_msg'] = "";
        }

        if (isset($_SESSION['back_flg']) && ($_SESSION['back_flg'])) {
            $this->form->page = $_SESSION['search_page'];
            $this->form->search_page = $_SESSION['search_page'];
            // $this->form->name = $_SESSION['search_name'];
            // $this->form->content = $_SESSION['search_content'];
            // $this->form->remarks = $_SESSION['search_remarks'];
            // $this->form->search_quiz_id = $_SESSION['search_quiz_id'];

            $this->form->search_page_qil = $_SESSION['search_page_qil'];
            $this->form->search_page_row_qil = $_SESSION['search_page_row_qil'];
            $this->form->search_page_order_column_qil = $_SESSION['search_page_order_column_qil'];
            $this->form->search_page_order_dir_qil = $_SESSION['search_page_order_dir_qil'];

            if (empty($this->form->search_page_qil)) {
                $this->form->search_page_qil = 0;
                $this->form->search_page_row_qil = 10;
                $this->form->search_page_order_column_qil = 1;
                $this->form->search_page_order_dir_qil = true;
            }

            //クリア
            $_SESSION['back_flg'] = false;
            $_SESSION['search_page'] = "";
            $_SESSION['search_name'] = "";
            $_SESSION['search_content'] = "";
            $_SESSION['search_remarks'] = "";
            $_SESSION['search_rd_status1'] = "";
            $_SESSION['search_quiz_id'] = "";

            $_SESSION['search_page_qil'] = "";
            $_SESSION['search_page_row_qil'] = "";
            $_SESSION['search_page_order_column_qil'] = "";
            $_SESSION['search_page_order_dir_qil'] = "";
        }

        if ($this->check_login() == true) {

            $service = new YNSQuizInfoService($this->pdo);

            // メニュー情報を取得、セットする
            $this->setMenu();

            // 検索結果を取得
            $list = $service->getQuizSearchData($this->form, "0");
            $count = count($list);

            if ($count > 0) {

                $this->smarty->assign('list', $list);
            } else {
                // エラーメッセージを設定　「検索結果がありません」
                $err_msg = sprintf(W001);
                $this->smarty->assign('list', "");
                $this->smarty->assign('err_msg', $err_msg);
            }

            $this->smarty->assign('form', $this->form);
            $this->smarty->display('ynsquizInfoList.html');
            return;
        } else {
            TransitionHelper::sendException(E002);
            return;
        }
    }
}
