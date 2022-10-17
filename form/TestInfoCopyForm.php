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
 * グループFORMクラス
 */
class TestInfoCopyForm extends BaseForm {
	
	// 組織No
	public $org_no;
	// テスト管理№
	public $test_info_no;
	// 複写元のとテスト管理№
	public $ori_test_info_no;
	// テスト名
	public $test_info_name;
	//受講時間
	public $test_time;
	// 状態
	public $status;
	//結果表示
	public $show_flg;
	// 反復ドリルフラグ
	public $drill_flg;
	// 説明
	public $long_description;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// 更新備考
	public $remarks;
	// ボタン
	public $btn_value;
	// スクリーンモード
	public $screen_mode;
	
	// 組織No
	public $new_org_no;
	// 組織ID
	public $org_id;
	// 組織名
	public $org_name;
	
	// 組織表示名
	public $org_name_official;
	
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
	/**
	 * 戻るの場合リストか登録かの画面を分けるため
	 * ないフィールドを追加
	 */
	public $btn_flg_type;
	public $test_info_start_period;
	public $test_info_end_period;
	public $test_info_remarks;
	public $test_info_btn_flg;
	public $test_info_date_flg;
	public $test_info_test_info_name;
	public $test_info_test_time;
	public $test_info_show_flg;
	
	public $search_page_til;
	public $search_page_row_til;
	public $search_page_order_column_til;
	public $search_page_order_dir_til;

}


?>