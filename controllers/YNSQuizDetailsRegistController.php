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
require_once 'service/TypeService.php';
require_once 'dto/T_Quiz_ItemDto.php';
require_once 'dto/T_Quiz_Item_OptionDto.php';
require_once 'service/QuizDetailsService.php';
require_once 'service/YNSQuizInfoService.php';
require_once 'service/YNSQuizDetailService.php';
require_once 'util/DateUtil.php';

/**
 * クイズアイテム登録コントローラー
 */
class YNSQuizDetailsRegistController extends BaseController
{

    /**
     * 初期処理
     */
    public function indexAction()
    {
        if ($this->check_login() == true) {
            $service = new YNSQuizDetailService($this->pdo);
            $id = $this->form->quiz_id;

            $err_msg = "";
            $type = $service->getQuizType();
            if (count($type) > 0) {
                $this->smarty->assign('quiz_type', $type);
                $this->smarty->assign('error_msg', "");
            } else {
                $this->smarty->assign('quiz_type', "");
                $this->smarty->assign('error_msg', "ドロップダウンリストのデータがありません。");
            }

            // 更新処理
            if ($id != null) {

                $list = $service->getQuizInfo($id);
                if ($list != null) {
                    foreach ($list as $value) {
                        $this->form->quiz_id = $value->quiz_id;
                        $this->form->quiz_name = $value->quiz_name;
                        // $this->form->word_lang_type = $value->word_lang_type;
                        // $this->form->trans_lang_type = $value->trans_lang_type;
                        // $this->form->screen_mode = "update";
                    }
                }
                // 登録処理
            }
            //  else {
            //     $word_services = new YNSWordService($this->pdo);
            //     // $next_word_id = $word_services->getNextId();
            //     // $this->form->id = $next_word_id->id;
            //     $this->form->word_book_name = "";
            //     $this->form->word_lang_type = "";
            //     $this->form->trans_lang_type = "";
            //     $this->form->screen_mode = "new";
            // }
            // メニュー情報を取得、セットする
            $this->setMenu();
            $this->smarty->assign('form', $this->form);
            $this->smarty->display('ynsquizDetailsRegist.html');
        } else {
            TransitionHelper::sendException(E002);
            return;
        }
    }











    /**
     * 画面データ取得・渡す処理
     */
    public function getQzDetailsData($form, $msg)
    {

        $org_no = $_SESSION['org_no'];
        $quiz_info_no = $this->form->quiz_info_no;

        $qzItemDtService = new QuizDetailsService($this->pdo);
        $qzOptDtService = new QuizDetailsService($this->pdo);

        //クイズ情報番号の存在チェック処理
        $count = $qzOptDtService->checkExistQInfoNo($org_no, $quiz_info_no);
        $this->smarty->assign('qzInfoCount', $count);

        $screen_mode = $this->form->screen_mode;

        // クイズタイプ取得
        $type_service = new TypeService($this->pdo);
        $qzType = $type_service->getQuizType($this->form);
        $date_flg  = 0;

        if ($screen_mode == "update") {

            if ($quiz_info_no != "") {

                // データベース接続
                $dataItem = $qzItemDtService->getQzItemInfo($this->form);
                $dataOpt = $qzOptDtService->getQzItemOptionInfo($this->form);

                if (sizeof($dataItem) > 0) {
                    $this->smarty->assign('qzList', $dataItem);
                    $this->smarty->assign('qzListOpt', $dataOpt);
                } else {
                    $this->smarty->assign('qzList', "");
                    $this->smarty->assign('qzListOpt', "");
                }

                $this->smarty->assign('qztypeNo', $qzType);
                $this->smarty->assign('error_msg', $msg);
            } else {
                TransitionHelper::sendException(E001);
                return;
            }
            $this->smarty->assign('date_flg', $date_flg);
            $this->smarty->assign('form', $this->form);
            $this->smarty->display('ynsquizDetailsRegist.html');
        } else {
            $this->form->qz_type = "001";
            $this->smarty->assign('qzList', "");
            $this->smarty->assign('qzListOpt', "");
            $this->smarty->assign('qztypeNo', $qzType);
            $this->smarty->assign('error_msg', $msg);
            $this->smarty->assign('form', $this->form);
            $this->smarty->display('ynsquizDetailsRegist.html');
        }
    }

    /**
     * 登録処理
     */
    public function saveAction()
    {

        if ($this->check_maintenance() == true) {

            if ($this->check_login() == true) {
                $form = $this->form;
                $qzDtService = new QuizDetailsService($this->pdo);


                $org_no = $_SESSION['org_no'];
                $uer_id = $_SESSION['manager_no'];
                $quiz_info_no = $this->form->quiz_info_no;

                //クイズが回答したチェック処理
                // 2021/07/14 チェリー修正
                /* $countTested = $qzDtService->checkTestedQuiz($org_no,$quiz_info_no);
				if($countTested > 0){
					return $this->registPage();
				} */

                $quiz_service = new QuizInfoService($this->pdo);
                $quizInfoDisable = $quiz_service->getQuizDataByQuizNoDisable($org_no, $quiz_info_no);

                if ($quizInfoDisable > 0) {
                    return $this->registPage();
                }
                $index = 1;
                LogHelper::logDebug("クイズアイテム");
                LogHelper::logDebug($this->form->arrTypeNameList);
                $error_msg = "";

                //クイズアイテム（Tクイズ情報テーブル）
                if (isset($this->form->arrTypeNameList)) {

                    $insertDataList = json_decode(stripslashes($form->arrTypeNameList));

                    //存在したアイテムの削除、更新するため
                    // クイズアイテム情報がない場合、エラー処理を追加
                    if ($insertDataList != null &&  count($insertDataList) > 0 && $insertDataList[0]->qz_content != "") {
                        $qzDtService->deleteQuizItemInfoDetails($org_no, $quiz_info_no);

                        // 削除後、登録処理をする
                        foreach ($insertDataList as $insertData) {

                            $qzDtlDto = new T_Quiz_ItemDto($this->pdo);

                            $qzDtlDto->quiz_info_no = $form->quiz_info_no;
                            $qzDtlDto->quiz_item_no = $index;
                            $qzDtlDto->quiz_type = $insertData->qz_type;
                            $qzDtlDto->description = $insertData->qz_content;
                            $qzDtlDto->marks = $insertData->qz_mark;

                            $qzDtlDto->del_flg = '0';
                            $qzDtlDto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
                            $qzDtlDto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
                            $qzDtlDto->creater_id = $uer_id;
                            $qzDtlDto->updater_id = $uer_id;
                            $result = $qzDtService->registQzDtlData($qzDtlDto);
                            if ($result > 0) {
                                $error_msg = "";
                            } else {

                                $error_msg = sprintf(E007, '登録');
                                LogHelper::logDebug("Tクイズ情報登録エラー");
                                break;
                            }
                            $index++;
                        }

                        //4選択アイテム（Tオプションテーブル）
                        LogHelper::logDebug("4選択アイテム");
                        LogHelper::logDebug($this->form->arrTypeNameList1);
                        $index = 1;

                        if (isset($this->form->arrTypeNameList1) && $error_msg == "") {

                            $insertDataList1 = json_decode(stripslashes($form->arrTypeNameList1));

                            foreach ($insertDataList1 as $insertData) {

                                $qzDtlDto = new T_Quiz_Item_OptionDto($this->pdo);
                                $qzDtlDto->quiz_info_no = $form->quiz_info_no;
                                $qzDtlDto->quiz_item_no = $insertData->qzItemNo;
                                $qzDtlDto->option_no = $index;
                                $qzDtlDto->description = $insertData->content;
                                $qzDtlDto->correct_flag = $insertData->cflag;

                                $qzDtlDto->del_flg = '0';
                                $qzDtlDto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
                                $qzDtlDto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
                                $qzDtlDto->creater_id = $uer_id;
                                $qzDtlDto->updater_id = $uer_id;
                                $result = $qzDtService->registQzOptDtlData($qzDtlDto);
                                if ($result > 0) {
                                    $error_msg = "";
                                } else {
                                    $error_msg = sprintf(E007, '登録');
                                    LogHelper::logDebug("4選択アイテム登録エラー");
                                    break;
                                }
                                $index++;
                            }
                        }

                        //穴埋めアイテム（Tオプションテーブル）
                        LogHelper::logDebug("穴埋めアイテム");
                        LogHelper::logDebug($this->form->arrTypeNameList2);

                        $index1 = $index;

                        if (isset($this->form->arrTypeNameList2) && $error_msg == "") {

                            $insertDataList2 = json_decode(stripslashes($form->arrTypeNameList2));

                            foreach ($insertDataList2 as $insertData) {

                                $qzDtlDto = new T_Quiz_Item_OptionDto($this->pdo);
                                $qzDtlDto->quiz_info_no = $form->quiz_info_no;
                                $qzDtlDto->quiz_item_no = $insertData->qzItemNo;
                                $qzDtlDto->option_no = $index1;
                                $qzDtlDto->description = $insertData->content;
                                $qzDtlDto->correct_flag = $insertData->cflag;

                                $qzDtlDto->del_flg = '0';
                                $qzDtlDto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
                                $qzDtlDto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
                                $qzDtlDto->creater_id = $uer_id;
                                $qzDtlDto->updater_id = $uer_id;
                                $result = $qzDtService->registQzOptDtlData($qzDtlDto);
                                if ($result > 0) {
                                    $error_msg = "";
                                } else {
                                    $error_msg = sprintf(E007, '登録');
                                    LogHelper::logDebug("穴埋めアイテム登録エラー");
                                    break;
                                }
                                $index1++;
                            }
                        }

                        //　メッセージ設定
                        if ($error_msg == "") {

                            $error_msg = I004;
                        } else {

                            $error_msg = sprintf(E007, '登録');
                        }
                    } else {

                        $error_msg = sprintf(E007, '登録');
                        // セッションからデータ取得
                        $this->form->org_no = $_SESSION['org_no'];

                        // メニュー情報を取得、セットする
                        $this->setMenu();
                        $this->form->screen_mode = "update";

                        // クイズアイテム設定
                        $this->getQzDetailsData($this->form, $error_msg);
                        return;
                    }
                }

                // セッションからデータ取得
                $this->form->org_no = $_SESSION['org_no'];

                // メニュー情報を取得、セットする
                $this->setMenu();
                $this->form->screen_mode = "update";

                // 2021/12/16 Cherry Edit Rollback処理追加
                $_SESSION['msg_qdr'] = $error_msg;
                $this->backAction();
                // クイズアイテム設定
                //	$this->getQzDetailsData($this->form , $error_msg);

            } else {
                TransitionHelper::sendException(E002);
                return;
            }
        } else {

            TransitionHelper::sendMaintenance($_SESSION['error_message']);
            return;
        }
    }

    //初期データ設定
    public function initDataSet()
    {

        $quiz_service = new YNSQuizInfoService($this->pdo);
        $quizInfoDisable = $quiz_service->getQuizDataByQuizNoDisable($this->form->quiz_id);
        LogHelper::logDebug("quizInfoDisable count:" . $quizInfoDisable);

        if ($quizInfoDisable > 0) {
            $this->form->disable_mode = "disable";
        } else {
            $this->form->disable_mode = "";
        }

        // メニュー情報を取得、セットする
        $this->setMenu();

        // クイズアイテム設定
        $this->getQzDetailsData($this->form, "");
    }

    /*
* 戻るボタンのAction
*/
    public function backAction()
    {
        if ($this->check_login() == true) {
            $this->setBackData();

            $this->smarty->assign('msg', "");
            $this->smarty->assign('error_msg', "");
            $this->smarty->assign('form', $this->form);

            // 2021/12/16 Cherry Add Rollback処理追加
            if ($_SESSION['msg_qdr'] != null && $_SESSION['msg_qdr'] != "") {
                $this->smarty->assign('msg', $_SESSION['msg_qdr']);
                unset($_SESSION['msg_qdr']);
            }

            $this->smarty->display('quizInfoRegist.html');
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

        $org_no = $this->form->org_no;
        $quiz_info_no = $this->form->quiz_info_no;
        $quiz_name = $this->form->quiz_name;
        $long_description = $this->form->long_description;
        $remarks = $this->form->remarks;
        $audio_file = $this->form->audio_file;
        $input_audio_file = $this->form->input_audio_file;
        $audio_del_flg = $this->form->audio_del_flg;
        $audio_chk_del = $this->form->audio_chk_del;


        $this->form->org_no = $org_no;
        $this->form->quiz_info_no = $quiz_info_no;
        $this->form->quiz_name = $quiz_name;
        $this->form->long_description = $long_description;
        $this->form->remarks = $remarks;
        $this->form->audio_file = $audio_file;
        $this->form->input_audio_file = $input_audio_file;
        $this->form->audio_del_flg = $audio_del_flg;
        $this->form->audio_chk_del = $audio_chk_del;

        $_SESSION['search_page_qil'] = $this->form->search_page_qil;
        $_SESSION['search_page_row_qil'] = $this->form->search_page_row_qil;
        $_SESSION['search_page_order_column_qil'] = $this->form->search_page_order_column_qil;
        $_SESSION['search_page_order_dir_qil'] = $this->form->search_page_order_dir_qil;
    }

    //クイズが回答したらクイズ登録画面に移動
    public function registPage()
    {

        $this->setBackData();

        $this->smarty->assign('info_msg', "");
        $this->smarty->assign('msg', "クイズアイテムを変更できません");
        $this->smarty->assign('form', $this->form);
        $this->smarty->display('quizInfoRegist.html');
    }
}
