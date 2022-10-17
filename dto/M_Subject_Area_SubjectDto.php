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
 * 教科テーブルDTOクラス
 */
class M_Subject_Area_SubjectDto extends BaseDto{
	//教科管理番号
	public $subject_area_no;
	//教科名
	public $subject_area_name;
	//教科名ふりがな
	public $subject_area_name_kana;
	//教科利用開始日
	public $subArea_start_period;
	//教科利用終了日
	public $subArea_end_period;
	//教科表示順
	public $subArea_disp_no;
	//教科更新備考
	public $subArea_remarks;
	//教科登録日
	public $subArea_create_dt;
	//教科更新日
	public $subArea_update_dt;
	//科目管理番号
	public $subject_no;
	//科目名
	public $subject_name;
	//科目読み
	public $subject_name_kana;
	//科目利用開始
	public $sub_start_period;
	//科目利用終了
	public $sub_end_period;
	//科目表示順
	public $sub_disp_no;
	//科目備考
	public $sub_remarks;
	//科目登録日
	public $sub_create_dt;
	//科目更新日
	public $sub_update_dt;
}

?>