<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

class GradeInfoDto extends BaseDto{

	// 組織管理№
	public $org_no;
	public $org_name;
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
}

?>