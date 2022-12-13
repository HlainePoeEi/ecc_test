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
class T_YNSQuiz_ItemDto extends BaseDto {

	public $quiz_id;
	public $quiz_item_id;
	public $quiz_type;
	public $description;
	public $marks;
}

?>
