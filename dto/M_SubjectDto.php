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
 * 科目テーブルDTOクラス
 */
class M_SubjectDto extends BaseDto{
	//組織管理№
	public $org_no;
	//教科管理№
	public $subject_area_no;
	//科目管理№
	public $subject_no;
	//科目名
	public $subject_name;
	//科目名ふりがな
	public $subject_name_kana;
	//表示順
	public $disp_no;
	//更新備考
	public $remarks;
	//利用開始日
	public $start_period;
	//利用終了日
	public $end_period;

}

?>