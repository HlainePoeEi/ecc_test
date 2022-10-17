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
 * レッスン対象テーブルDTOクラス
 */
class M_Lesson_TargetDto extends BaseDto {

	//組織管理№
	public $org_no;
	//レッスン管理№
	public $lesson_no;
	//グループ管理№
	public $group_no;

}

?>