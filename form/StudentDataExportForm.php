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
 *受講者データ抽出Formクラス
 *
 */
class StudentDataExportForm extends BaseForm{
	//組織ID
	public $org_id;
	//組織ID
	public $db_org_id;
	//組織名
	public $org_name;
	//利用開始日・From
	public $start_period_start;
	//利用終了日・To
	public $start_period_end;
	//利用終了日・From
	public $end_period_start;
	//利用終了日・To
	public $end_period_end;
}
?>