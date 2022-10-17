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
 * クイズアイテム情報テーブルDTOクラス
 */
class T_Quiz_ItemDto extends BaseDto {

	public $quiz_info_no;
	public $quiz_item_no;
	public $quiz_type;
	public $description;
	public $marks;
	public $explanation;
	public $remarks;
	public $del_flg;
	public $create_dt;
	public $creater_id;
	public $update_dt;
	public $updater_id;
}

?>
