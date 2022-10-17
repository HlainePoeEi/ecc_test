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
 * レッスン管理者教師テーブルDTOクラス
 */
class M_Lesson_ManagerDto extends BaseDto{
	//組織管理№
	public $org_no;
	//レッソン管理№
	public $lesson_no;
	//管理者№
	public $manager_no;

}

?>