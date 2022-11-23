<?php

require_once 'BaseForm.php';
/**
 * テスト情報一覧FORMクラス
 *
 */
class YNSExamListForm extends BaseForm
{
    public $exam_id;

    public $name;

    public $description;

    public $status;

    public $time;

    public $start_date;

    public $end_date;

    public $remarks;



    // 削除フラグ
    public $del_flg;
    // 登録日時
    public $create_dt;
    // 登録者ＩＤ
    public $creater_id;
    // 更新日時
    public $update_dt;
    // 更新者ＩＤ
    public $updater_id;
    //件数
    public $count;
    // 現ページ
    public $page;
    //最大ページ
    public $max_page;
    public $rd_status1;
    public $rd_status2;
    public $chk_status1;
    public $chk_status2;
    public $quiz_count;
    public $rdstatus;

    //戻り用
    public $back_flg;
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

    public $search_page_til;
    public $search_page_row_til;
    public $search_page_order_column_til;
    public $search_page_order_dir_til;
}
