<?php
/*****************************************************
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * テスト問題テーブルDTOクラス
 */
class T_Quiz_InfoDto extends BaseDto {

	//組織管理№
	public $org_no;
	//クイズ管理№
	public $quiz_info_no;
	//クイズ名
	public $quiz_name;
	//クイズ内容
	public $long_description;
	//ファイル（音声）
	public $audio_name;
	//更新備考
	public $remarks;
}

?>