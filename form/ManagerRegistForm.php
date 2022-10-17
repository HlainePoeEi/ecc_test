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
 * 組織管理者登録Formクラス
 *
 */
class ManagerRegistForm extends BaseForm{

	// ログインID
	public $login_id;
	// 組織管理№
	public $org_no;
	// 組織コード
	public $org_id;
	// 組織名
	public $org_name;
	// 組織名ふりがな
	public $org_name_kana;
	// 正式組織名
	public $org_name_official;
	// 管理者№
	public $manager_no;
	// 管理者名
	public $manager_name;
	// 管理者名ふりがな
	public $manager_name_kana;
	// 管理者権限
	public $manager_kbn;
	// パスワード
	public $password;
	// 確認パスワード
	public $confirm_password;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// メールアドレス
	public $mail_address;
	// 備考
	public $remarks;
	//画面モード
	public $screen_mode;
	// 元のパスワード
	public $original_password;
	// 元のログインID
	public $original_login_id;
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
	// ボタンフラグ
	public $btn_flag;
	// 組織管理№
	public $organization_no;
	// 組織コード
	public $show_org_id;
	// 組織名
	public $show_org_name;
	// 組織名ふりがな
	public $show_org_kana;
	// 正式組織名
	public $show_org_official;
	// 組織開始日
	public $org_start_date;
	// 組織終了日
	public $org_end_date;
	// 戻る処理用データ
	public $organization_id;
	public $organization_name;
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
}

?>