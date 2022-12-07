<?php

/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseForm.php';

/**
 * サブ管理者一覧FORMクラス
 *
 */
class YNSQuizInfoAssignmentForm extends BaseForm
{

    public $org_no;
    public $name;
    //組織管理№
    public $exam_id;
    //行数
    public $rowno;
    //日付(From)
    public $start_date;
    //日付(To)
    public $end_date;
    //件数
    public $count;
    // 現ページ
    public $page;
    //最大ページ
    public $max_page;
    //レッスン名
    public $exam_name;
    //テスト管理№
    public $quiz_id;
    //リスト
    public $entryList;

    //戻り用
    public $back_flg;
    public $search_page;
    public $search_start_period;
    public $search_end_period;
    public $search_test_info_name;
    public $search_remark;
    public $search_rd_status1;
    public $search_rd_status2;
    public $search_rdstatus;
    public $search_chk_status1;
    public $search_chk_status2;
    public $search_status;
    public $search_org_id;

    //　試験一覧　Datatable用
    public $search_page_til;
    public $search_page_row_til;
    public $search_page_order_column_til;
    public $search_page_order_dir_til;
}
