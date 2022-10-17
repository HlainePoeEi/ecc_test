<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseController.php';
require_once 'conf/config.php';

/**
 * エラーコントローラー
 */
class ErrorController extends BaseController {

    /**
    * アクションメソッド
    */
    public function dispAction() {

    	// セッションから連携データ取得
    	$data = $_SESSION[SESSION_KEY_DATA];

    	// エラー画面表示
        $this->smarty->assign ( 'data', $data );
        $this->smarty->display ( 'error.html' );
    }
}

?>