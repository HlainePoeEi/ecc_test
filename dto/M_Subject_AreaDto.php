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
class M_Subject_AreaDto extends BaseDto{
	//組織管理№
	public $org_no;
	//教科管理№
	public $subject_area_no;
	//教科名
	public $subject_area_name;
	//教科名ふりがな
	public $subject_area_name_kana;
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