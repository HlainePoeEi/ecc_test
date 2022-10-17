<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

/**
 * コントローラー基底クラス
 *
 */
require_once 'util/StringUtil.php';
require_once 'helper/TransitionHelper.php';

class BaseController {
    public $sysRoot;
    public $smarty;
    public $form;
    public $pdo;

    // 初期化
    public function init($path,$pdo) {

        // smarty関連初期化
        $this->sysRoot = $path;

        require_once SMARTY_FILE;

        $this->smarty = new Smarty ();

        $this->smarty->force_compile = true;
        $this->smarty->template_dir = TEMPLATE_DIR;
        $this->smarty->compile_dir = TEMPLATE_C_DIR;
        $this->pdo = $pdo;

		//session check
		$this->checkSession();

        $this->setMenu();

        //ログイン管理者区分設定
        if ( isset($_SESSION ['admin_kbn']) && $_SESSION ['admin_kbn'] != "" ) {

        	$this->form->admin_kbn = $_SESSION ['admin_kbn'];
        	$this->smarty->assign ( 'admin_kbn', $this->form->admin_kbn );
        }


    }

    /**
	 * CheckSession
	 * 画面で保持しているuidとセッションで保持しているuidをチェックする
	 */
	public function checkSession(){

		LogHelper::logDebug ( "------------------------------".$_SERVER [REQUEST_URI] );

		//json取得はチェックしない
		if ((strpos($_SERVER [REQUEST_URI],"Woc") !== false)) {
			LogHelper::logDebug ( "------------------------------".$_SERVER [REQUEST_URI] );

			return;
		}
		
		//データ抽出のindex取得はチェックしない
		if ((strpos($_SERVER [REQUEST_URI],"DataExport") !== false)) {
			LogHelper::logDebug ( "------------------------------".$_SERVER [REQUEST_URI] );

			return;
		}

		//一覧のindex取得はチェックしない
		if ((strpos($_SERVER [REQUEST_URI],"List") !== false)) {
			//LogHelper::logDebug ( "------------------------------".$_SERVER [REQUEST_URI] );
			$this->createUid();
			return;
		}

		if ( get_class($this) != "LoginController"
			&& get_class($this) != "MenuController"
			&& get_class($this) != "ErrorController"){

			if ($this->form->uid != $_SESSION ['uid']){
				//error
				LogHelper::logDebug ( "------------------------------session_check_false:uid=".$this->form->uid."-----&-----".$_SESSION ['uid'] );
				$this->createUid();
				//$this->dispatch('Error');
				TransitionHelper::getInstance ();
				TransitionHelper::sendException ( E002 );
				return;

			} else {

				LogHelper::logDebug ( "------------------------------session_check_true" );

				//入替uid
				$this->createUid();
			}

		} else {

			LogHelper::logDebug ( "------------------------------login_start_check" );
			//初回uid
			$this->createUid();

		}

	}

    /**
	 * 画面セッションにuidをセットする
	 */
	public function createUid(){

		//初回呼び出しはログインから
		$this->form->uid = md5(uniqid(rand(), true));
		$_SESSION ['uid'] = $this->form->uid;
		$this->smarty->assign ( 'uid', $this->form->uid );

	}

	/**
	 * デフォルトアクション
	 * 指定がない場合はこれが実行される
	 */
    public function indexAction() {

    }

    /**
     * メニュー情報を取得、セットする
     */
    public function setMenu() {

    	// メニューが開くかどうかを確認する
    	if(isset($_SESSION['menuOpen'])) {

    		$this->form->menuOpen = $_SESSION['menuOpen'];
    		unset($_SESSION['menuOpen']);
    	}

		//メニューをMenu画面以外は常に閉じるように
	/*	if (get_class($this) != "MenuController"){
			$this->form->menuOpen = "";
			unset($_SESSION['menuOpen']);
		} */

    	if(isset($_SESSION['menuStatus'])) {
    		$this->form->menuStatus = $_SESSION['menuStatus'];
    		unset($_SESSION['menuStatus']);
    	}

    	$this->smarty->assign('menuOpen',$this->form->menuOpen);
    	$this->smarty->assign ( 'menuStatus', $this->form->menuStatus);

    	//ログインユーザ情報設定

    	//ログインユーザ名設定
    	if(isset($_SESSION ['admin_name']) && !StringUtil::isEmpty($_SESSION ['admin_name'])) {
    		$this->smarty->assign('admin_name',$_SESSION ['admin_name']);
    	}

    	if(isset($_SESSION ['romaji_name']) && !StringUtil::isEmpty($_SESSION ['romaji_name'])) {
    		$this->smarty->assign('romaji_name',$_SESSION ['romaji_name']);
    	}

    	if(isset($_SESSION ['login_time']) && !StringUtil::isEmpty($_SESSION ['login_time'])) {
    		$this->smarty->assign('login_time',$_SESSION ['login_time']);
    	}
    }


    /**
    *  ログイン時間設定
    */
    public function set_login_time() {
        if (! isset ( $_SESSION [SESSION_KEY_LOGIN_TIME] ) || empty ( $_SESSION [SESSION_KEY_LOGIN_TIME] )) {
            $_SESSION [SESSION_KEY_LOGIN_TIME] = time ();
        } else {
            if (time () - $_SESSION [SESSION_KEY_LOGIN_TIME] > TIMEOUT_PERIOD) {
                session_unset ();
                return false;
            }
        }
        return true;
    }

    /**
    *  セクション情報クリア処理
    */
    public function clear_session() {
        session_unset ();
    }

    /**
    * ログイン情報チェック
    */
    public function check_login() {

		LogHelper::logDebug("admin_no is " . $_SESSION ['admin_no']);

        if (! isset ( $_SESSION )) {
            return false;
        }
        if (! isset ( $_SESSION ['admin_no']) || ! isset ( $_SESSION ['admin_no'])) {
            return false;
        }
        if ($_SESSION ['admin_no'] == '' || $_SESSION ['admin_no'] == '') {
            return false;
        }

        return true;
    }

    /**
	 * ログアウト処理
	 */
	public function logoutAction() {
		session_unset ();
		$this->dispatch('Login');
	}

	/**
	 * 画面遷移
	 */
	public function dispatch($controllerName){

		//sessionにセットする
		$_SESSION['menuOpen'] = $this->form->menuOpen;
		$_SESSION['menuStatus'] = $this->form->menuStatus;

		header('Location:'.HOME_DIR.$controllerName);

	}


}

?>