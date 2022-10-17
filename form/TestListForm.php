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
 * テスト一覧FORMクラス
 *
 */
class TestListForm extends BaseForm{
	// 組織管理№
	public $org_no;
	// テスト管理№
	public $test_no;
	// テスト名
	public $test_name;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// 更新備考
	public $remark;
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
	public $rd_status1;
	public $rd_status2;
	public $chk_status1;
	public $chk_status2;
	public $quiz_count;
	public $status;
	public $rdstatus;

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

	// Datatable用
	public $search_page_row;
	public $search_page_order_column;
	public $search_page_order_dir;
}

?>