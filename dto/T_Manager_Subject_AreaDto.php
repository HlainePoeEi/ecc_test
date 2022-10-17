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
 * 管理者教師テーブルDTOクラス
 */
class T_Manager_Subject_AreaDto extends BaseDto{

	// 組織管理№
	public $org_no;
	// 管理者教師管理№
	public $manager_no;
	// 教科管理№
	public $subject_area_no;
}

?>