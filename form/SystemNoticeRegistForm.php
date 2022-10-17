<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseForm.php';

/**
 * お知らせ設定FORMクラス
 *
 */
class SystemNoticeRegistForm extends BaseForm {

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
	// ページ
	public $page;
	// 最大ページ
	public $max_page;
	// 区分
	public $target_Kbn;
	// 名前
	public $name;
	// 管理者名
	public $admin_name;
	// 画面モード
	public $screen_mode;
}

?>