<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

class T_System_NoticeDto extends BaseDto {

	// システムお知らせ№
	public $system_notice_no;
	// システム区分
	public $system_kbn;
	// 内容
	public $description;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// 名前
	public $name;
	// 管理者名
	public $admin_name;
}

?>