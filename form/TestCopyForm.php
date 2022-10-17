<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseForm.php';

/**
 * テスト複写FORMクラス
 *
 */
class TestCopyForm extends BaseForm {

    // 組織No
    public $org_no;
    // テスト管理№
    public $test_no;
    // 複写元のとテスト管理№
    public $ori_test_no;
    // テスト名
    public $test_name;
    // テストタイプ
    public $test_type;
    // テスト問題数
    public $test_quiz_count;
   // 状態
    public $status;
    // 説明
    public $description;
    // 利用開始日
    public $start_period;
    // 利用終了日
    public $end_period;
    // 更新備考
    public $remarks;
     // ボタン
    public $btn_value;
    //スクリーンモード
    public $screen_mode;
     //隠されたフィールド
    public $hd_test_type;
	// 組織ログインID
	public $org_id;

    //戻り用
	public $back_flg;
	public $search_page;
	public $search_start_period;
	public $search_end_period;
	public $search_test_name;
	public $search_remark;
	public $search_rd_status1;
	public $search_rd_status2;
	public $search_rdstatus;
	public $search_chk_status1;
	public $search_chk_status2;
	public $search_status;
	public $search_org_id;
	/**
	 * 戻るの場合リストか登録かの画面を分けるため
	 * ないフィールドを追加
	 */
	public $btn_flg_type;
	public $test_start_period;
	public $test_end_period;
	public $test_remarks;
	public $test_btn_flg;
	public $test_date_flg;
	public $test_test_name;
	
	// テスト一覧Datatable用
	public $search_page_row;
	public $search_page_order_column;
	public $search_page_order_dir;

}

?>