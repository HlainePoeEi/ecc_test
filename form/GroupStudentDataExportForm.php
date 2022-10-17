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
 * グループ:受講者データ抽出FORMクラス
 *
 */
class GroupStudentDataExportForm extends BaseForm {
	//組織ID
	public $org_id;
	//組織ID
	public $db_org_id;
	//組織名
	public $org_name;
	//利用開始日・From
	public $start_period_start;
	//利用開始日・To
	public $start_period_end;
	//利用終了日・From
	public $end_period_start;
	//利用終了日・To
	public $end_period_end;
}

?>