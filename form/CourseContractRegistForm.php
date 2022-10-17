<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseForm.php';

/**
 * コース詳細登録FORMクラス
 *
 */
class CourseContractRegistForm extends BaseForm {

	// 検査コースID
	public $se_course_id;
	// 検査コースID
	public $course_id1;
	// コース名
	public $course_name;
	// 組織名
	public $org_name;
	// 正式組織名
	public $org_name_official;
	// 組織コード
	public $org_id;
	// 申込管理№
	public $offer_no;
	// 組織管理№
	public $org_no;
	// コースID
	public $course_id;
	// コース期間開始日
	public $start_period;
	// コース期間終了日
	public $end_period;
	// 更新備考
	public $remarks;
	// 結果表示フラグ
	public $fb_show_flg;
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
	// 検索利用終了日
	public $search_start_period;
	// 検索利用終了日
	public $search_end_period;
	// 検査コース名
	public $search_course_name;
	// 検査テスト区分名
	public $search_test_kbn;
	// 検査レベル
	public $search_course_level;
	// 検査組織名
	public $search_org_name;
	// 検査組織コード
	public $search_org_id;
	// 受講生数
	public $search_page;
	public $btn_flg;
	public $contract_start_period;
	public $contract_end_period;
	public $contract_list_start_period;
	public $contract_list_end_period;
	
	public $page_ccl;
	public $page_row_ccl;
	public $page_order_column_ccl;
	public $page_order_dir_ccl;
}