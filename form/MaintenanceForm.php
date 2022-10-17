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
 * システムメンテナンスFORMクラス
 *
 */
class MaintenanceForm extends BaseForm{

	public $page;
	public $max_page;
	public $system_status;
	public $status;
	public $description;
	public $system_kbn;
	public $select_kbn;
}

?>