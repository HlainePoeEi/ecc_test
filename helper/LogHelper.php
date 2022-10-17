<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'conf/config.php';

/**
 * LogHelperクラス
 *
 */
class LogHelper{

	/** Loggerオブジェクト */
	static $log;

	/**
	 * コンストラクタ
	 */
	public static function getInstance() {

		// Loggerクラス読み込み
		include(LOGGER_CLASS);

		// 設定ファイル読み込み
		Logger::configure(LOG_CONFIG);

		// Loggerを取得
		self::$log = Logger::getLogger(basename($_SERVER['SCRIPT_NAME']));
	}

	/**
	 * Traceログ出力
	 */
	public static function logTrace($message){
		self::$log->trace($message);
	}

	/**
	 * Debugログ出力
	 */
	public static function logDebug($message){
		self::$log->debug($message);
	}

	/**
	 * Infoログ出力
	 */
	public static function logInfo($message){
		self::$log->info($message);
	}

	/**
	 * Warnログ出力
	 */
	public static function logWarn($message){
		self::$log->warn($message);
	}

	/**
	 * Errorログ出力
	 */
	public static function logError($message, $e){
		self::$log->error($message, $e);
	}

	/**
	 * Fatalログ出力
	 */
	public static function logFatal($message){
		self::$log->fatal($message);
	}

	/**
	 * ログに付加情報設定
	 */
	public static function setMDCData($key, $value){
		require_once LOG_MDC_CLASS;
		LoggerMDC::put($key, $value);
	}
}

?>