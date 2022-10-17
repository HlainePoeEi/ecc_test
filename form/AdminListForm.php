<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseForm.php';

/**
 * 管理者一覧FORMクラス
 *
 */
class AdminListForm extends BaseForm{
	
	//運用管理者名
	public $admin_name;
	//日付(From)
	public $start_period;
	//日付(To)
	public $end_period;
	//件数
	public $count;
	// 現ページ
	public $page;
	//最大ページ
	public $max_page;
	// 検索ページ
	public $search_page;
	// 検索利用終了日
	public $search_start_period;
	// 検索利用終了日
	public $search_end_period;
	// 検索運用管理者名
	public $search_admin_name;
}

?>