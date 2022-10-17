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
 * グループ・受講者テーブルDTOクラス
 */
class T_Group_StudentDto extends BaseDto {

	// 組織管理№
	public $org_no;
	// グループ管理№
	public $group_no;
	// 受講者管理№
	public $student_no;

}

?>