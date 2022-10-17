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
 * 組織登録FORMクラス
 *
 */
class OrganizationRegistForm extends BaseForm {

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
	// 有償区分
	public $org_kbn;
	// 組織種類
	public $org_type;
	// 機能区分
	public $function_type;
	// 組織開始期の開始日
	public $org_start_date;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// 契約開始日
	public $contract_start_dt;
	// 契約終了日
	public $contract_end_dt;
	//組織担当者名
	public $org_admin;
	// 組織TEL
	public $phone_no;
	// メールアドレス
	public $mail_address;
	// 契約番号/申請番号
	public $contract_no;
	// 管理者名
	public $manager_name;
	// 更新備考
	public $remarks;
	// 削除フラグ
	public $del_flg;
	//登録日時
	public $create_dt;
	// 登録者ID
	public $creater_id;
	//更新日時
	public $update_dt;
	// 更新者ID
	public $updater_id;
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
	// 画面モード
	public $screen_mode;
    //Pushフラグ
    public $push_flg;
    //送信カウント
    public $count;
}

?>