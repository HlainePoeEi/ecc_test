<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * M組織DTOクラス
 */
class M_OrganizationDto extends BaseDto{

	//組織管理№
	public $org_no;
	//組織コード
	public $org_id;
	//組織名
	public $org_name;
	//組織名ふりがな
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
}

?>