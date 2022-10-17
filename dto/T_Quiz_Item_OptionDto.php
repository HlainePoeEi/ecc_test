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
 * クイズアイテムオプションテーブルDTOクラス
 */
class T_Quiz_Item_OptionDto extends BaseDto {

	public $quiz_info_no;
	public $quiz_item_no;
	public $option_no;
	public $description;
	public $correct_flag;

	public $del_flg;
	public $create_dt;
	public $creater_id;
	public $update_dt;
	public $updater_id;
}

?>
