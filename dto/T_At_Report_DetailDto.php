<?php
/*****************************************************
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co.; Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * レポート詳細設定テーブルDTOクラス
 */
class T_AT_Report_DetailDto extends BaseDto {

	public $org_no;
	public $at_report_no;
	public $at_type;
	public $at_no;
	public $offer_no;
	public $disp_no;
}

?>