<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

session_start();

// require_once '/virtual/111.89.135.157/ssl/home/sgc_test/fw/Dispatcher.php';
// require_once '/virtual/111.89.135.157/ssl/home/sgc_test/conf/config.php';

require_once __DIR__.'/fw/Dispatcher.php';
require_once __DIR__.'/conf/config.php';

/**
 * index
 * Dispatcherを呼び出し
 * 各コントローラーへdispatchする
 */

//Dispatcher
$dispatcher = new Dispatcher();

//Sysルート設定
$dispatcher->setSystemRoot(SYS_ROOT);

//Dispatch
$dispatcher->dispatch();

?>