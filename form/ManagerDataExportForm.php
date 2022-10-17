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
 * 担当者データ抽出Formクラス
 *
 */
class ManagerDataExportForm extends BaseForm{
	//組織ID
	public $org_id;
	//組織ID
	public $db_org_id;
	//組織名
	public $org_name;
}
?>