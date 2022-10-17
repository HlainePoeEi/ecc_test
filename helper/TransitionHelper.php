<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

/**
 * 遷移ヘルパークラス
 *
 */
class TransitionHelper {

	static $smarty;

	/**
	 * 初期化
	 */
	public static function getInstance() {
		require_once SMARTY_FILE;

		self::$smarty = new Smarty ();
		self::$smarty->template_dir = TEMPLATE_DIR;
		self::$smarty->compile_dir = TEMPLATE_C_DIR;
	}

	/**
	 * エラーページ表示
	 */
	public static function sendException($message) {
		$data = array (
				"message" => $message
		);
		$_SESSION [SESSION_KEY_DATA] = $data;

		header ( "Location: " . ERROR_PAGE );
	}
}

?>