<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDto.php';

/**
 *Tコース組織情報DTOクラス
 */
class T_Course_OrgDto extends BaseDto {

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
	// 組織コード
	public $org_id;
	// 組織名
	public $org_name;
	// 正式組織名
	public $org_name_official;
	// コース名
	public $course_name;
	// コース名ローマ字
	public $course_name_romaji;
	// コースレベル
	public $course_level;
	// テスト区分
	public $test_kbn;
	// 状態
	public $status;
}

?>