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
class T_YNSQuiz_Item_OptionDto extends BaseDto {

    public $quiz_id;
	public $quiz_item_option_id;
	public $quiz_item_id;
	public $option_no;
	public $description;
	public $correct_flag;
}

?>
