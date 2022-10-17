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
 * SequenceDTOクラス
 */
class SequenceDto extends BaseDto {

	public $current_sequence_num;
	public $increment;
}

?>