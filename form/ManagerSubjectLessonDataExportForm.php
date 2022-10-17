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
 * 担当者．教科．レッスンデータ抽出FORMクラス
 *
 */
class ManagerSubjectLessonDataExportForm extends BaseForm{
	// 組織ID
	public $org_id;
	//組織ID
	public $db_org_id;
	// 利用開始日
	public $start_period1;
	// 利用開始日
	public $start_period2;
	// 利用終了日
	public $end_period1;
	// 利用終了日
	public $end_period2;
}
?>