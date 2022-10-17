<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2018 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseForm.php';

/**
 * メニュー設定FORMクラス
 *
 */
class MenuSettingRegistForm extends BaseForm {

	// 組織管理№
	public $org_no;
	// 学年管理№
	public $grade_no;
	// 学年名
	public $grade_name;
	// 学年名ふりがな
	public $grade_name_kana;
	// 表示順
	public $disp_no;
	// 更新備考
	public $remarks;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// 検索ページ
	public $search_page;
	// 検索利用終了日
	public $search_start_period;
	// 検索利用終了日
	public $search_end_period;
	// 検索組織名
	public $search_org_name;
	// 検索チェック
	public $search_chk_status;
	// 検索チェック有償区分
	public $search_chk_status1;
	// 検索チェック利益移動
	public $search_chk_status2;
	// 検索チェック無償
	public $search_chk_status3;
	// 検索チェック
	public $status;
	// 有償チェック
	public $chk_status1;
	// 利益移動チェック
	public $chk_status2;
	// 無償チェック
	public $chk_status3;
	// 登録メッセージ
	public $regist_msg;
	// 現ページ
	public $page;
	// 最大ページ
	public $max_page;
	// ボタンフラグ
	public $btn_flag;
	// 組織管理№
	public $organization_no;
	// 組織コード
	public $organization_id;
	// 組織名
	public $organization_name;
	// 戻る処理用データ
	public $organization_name_kana;
	public $organization_official;
	public $organization_kbn;
	public $organization_type;
	public $org_function_type;
	public $organization_start_date;
	public $org_start_period;
	public $org_end_period;
	public $contract_start_date;
	public $contract_end_date;
	public $organization_admin;
	public $org_phone_no;
	public $organization_mail;
	public $org_contract_no;
	public $org_manager_nm;
	public $org_remarks;
	public $screen_value;
	
	public $strHideMenu;
}

?>