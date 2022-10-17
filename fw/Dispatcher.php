<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'conf/config.php';
require_once 'helper/TransitionHelper.php';
require_once 'helper/LogHelper.php';
require_once 'util/CommonUtil.php';
require_once 'util/PDOUtil.php';

/**
 * ディスパッチャークラス
 */
class Dispatcher {

	/**
	 * システムルート
	 */
	public $sysRoot;

	/**
	 * システムルート設定
	 *
	 * @param unknown $path
	 */
	public function setSystemRoot($path) {
		$this->sysRoot = rtrim ( $path, '/' );
	}

	/**
	 * 画面遷移
	 */
	public function dispatch() {
		$pdo = null;
		try {
			// 出力準備
			LogHelper::getInstance ();
			LogHelper::logDebug ( "Request URI : " . $_SERVER [REQUEST_URI] );

			// 遷移ヘルパー準備
			TransitionHelper::getInstance ();

			// パラメーター取得（末尾の / は削除）
			$param = preg_replace ( '/\/?$/', '', $_SERVER [REQUEST_URI] );

			$params = array ();
			if ('' != $param) {
				// パラメーターを / で分割
				$params = explode ( '/', $param );
			}

			// 2番目のパラメーターをコントローラーとして取得
			$controller = DEFAULT_CONTROLLER_NAME;
			if (2 < count ( $params )) {
				// コントローラー名にGETパラメータを含めない。
				if (strpos($params[2], "?") != FALSE) {
					$controller = substr($params[2], 0, strpos($params[2], "?"));
				} else {
					$controller = $params [2];
				}
			}

			LogHelper::logDebug ( $controller . "Controller start" );
			// パラメータより取得したコントローラー名によりクラス振分け
			$controllerClassName = $controller . CONTROLLER_CLASS_SUFFIX;
			$controllerClassFile = CONTROLLER_DIR . $controllerClassName . PHP_EXTENSION;
			if (! file_exists ( $controllerClassFile )) {
				LogHelper::logDebug ( $controllerClassFile . ": is not exist" );
				TransitionHelper::sendException ( E004 );
				return;
			}

			LogHelper::logDebug ( $controllerClassFile . ": is exist" );

			// クラスファイル読込
			require_once $controllerClassFile;

			// クラスインスタンス生成
			$controllerInstance = new $controllerClassName ();

			// Formクラス
			$formClassName = $controller . FORM_CLASS_SUFFIX;
			
			LogHelper::logDebug ( $formClassName . ": is exist" );

			// クラスファイル読込
			require_once FORM_DIR . $formClassName . PHP_EXTENSION;

			// クラスインスタンス生成
			$formInstance = new $formClassName ();
//			LogHelper::logDebug("parameter : ". var_export($_POST, true));

			// formにPOSTデータをセット
			CommonUtil::fetchObject($formInstance, $_POST);

			// 作成したformをコントローラに渡す
			$controllerInstance->form = $formInstance;

			LogHelper::logDebug ( $formClassName.": form value set " );

			// 初期化（SysRoot設定）
			$pdo = PDOUtil::getPDO();
			$controllerInstance->init ( $this->sysRoot,$pdo );

			// 3番目のパラメーターをコントローラーとして取得
			$action = DEFAULT_ACTION_NAME;
			if (3 < count ( $params )) {
				$action = $params [3];
			}

			LogHelper::logDebug ( $action . "Action start" );
			// アクションメソッドを実行
			$pdo->beginTransaction();
			$actionMethod = $action . ACTION_METHOD_SUFFIX;
			if (! method_exists ( $controllerInstance, $actionMethod )) {
				if ($pdo && $pdo->inTransaction()){
					LogHelper::logDebug("rollback");
					$pdo->rollBack();
				}
				TransitionHelper::sendException ( E004 );
				return;
			}
			$controllerInstance->$actionMethod ();
			LogHelper::logDebug ( $action . "Action end" );

			LogHelper::logDebug ( $controller . "Controller end" );
			$pdo->commit();
		} catch ( Exception $e ) {

			if ($pdo && $pdo->inTransaction()){
				LogHelper::logDebug("rollback");
				$pdo->rollBack();
			}
			LogHelper::logError ( E001, $e );

			if(http_response_code() !== RESPONSE_CODE_INTERNAL_ERR){
				transitionHelper::sendException ( E001 );
			}
		} finally {
			LogHelper::logDebug("finally");
			$pdo = null;
		}
	}
}

?>