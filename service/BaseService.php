<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

class BaseService {
	protected $pdo;

	/**
	 * コンストラクタ
	 */
	function __construct($pdo) {
		$this->pdo = $pdo;
	}

}