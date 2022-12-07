<?php
require_once 'BaseForm.php';

/**
 * テスト情報プレビューFORMクラス
 */
class YNSTestInfoPreviewForm extends BaseForm
{
    // 組織管理№
    public $org_no;
    // テスト名
    public $name;
    // テスト管理№
    public $exam_id;
    // 説明
    public $content;
    // 受講時間
    public $test_time;
    // クイズ管理№
    public $quiz_no;
    // クイズ内容
    public $quiz_content;
    // 音声ファイル名
    public $audio_name;
    // クイズタイプ
    public $quiz_type;

    // 戻る画面名
    public $back_gamen;

    // ATレポート番号
    public $at_report_no;

    // 戻り用
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
