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
require_once 'service/LoginService.php';
require_once 'util/DateUtil.php';

/**
 * ログインコントローラー
 */
class LoginController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		session_unset ();
		$this->smarty->assign( 'error', '' );
		$this->smarty->assign( 'login_id', '' );
		$this->smarty->assign( 'password', '' );
		$this->smarty->display( 'login.html' );
	}

	/**
	 * ログイン処理
	 */
	public function loginAction() {

		// ログインボタン押下処理
		if ( isset ( $_POST ['submit'] ) ){

			$login_id = $this->form->login_id;
			$password = $this->form->password;

			if ( empty ( $login_id) && !empty ( $password ) ){

				$error = sprintf( I002, 'ログインID' );
				$this->smarty->assign( 'error', $error );

			}else if ( empty ( $login_id) && empty ( $password ) ){

				$error = sprintf(I002, 'ログインID');
				$this->smarty->assign( 'error', $error );

			}else if ( !empty ( $login_id) && empty ( $password ) ){

				$error = sprintf(I002, 'パスワード');
				$this->smarty->assign( 'error', $error );

			}else if ( !empty ( $login_id) && !empty ( $password ) ){

				// ユーザ名とパスワード
				$service = new LoginService ($this->pdo);
				$admin = $service->getUserData($login_id);

				if ( $admin ){

					if ( password_verify($password, $admin->password) ){

						$sysDate = DateUtil::getDate("Y/m/d");
						$start_period = $admin->start_period;
						$end_period = $admin->end_period;
						if ( $start_period <= $sysDate && $end_period >= $sysDate ){

							$_SESSION ['admin_no'] = $admin->admin_no;
							$_SESSION ['login_id'] = $admin->login_id;
							$_SESSION ['admin_name'] = $admin->admin_name;
							$_SESSION ['romaji_name'] = $admin->romaji_name;
							$_SESSION ['admin_kbn'] = $admin->admin_kbn;
							$_SESSION ['menuOpen'] = $this->form->menuOpen;
							$_SESSION ['login_time'] = DateUtil::getDate('Y/m/d H:i:s');

							//sessionCheckStart
							$this->createUid();

							$this->form->admin_kbn = $_SESSION ['admin_kbn'] ;
							// ログインボタン押下処理
							$this->dispatch('Menu');
					}else{

						$error = sprintf( E006, 'ログインID', 'パスワード' );
						$this->smarty->assign( 'error', $error );
					}
					}else {
						// データが取得できない場合、エラーメッセージ表示。
						$error = sprintf( E006, 'ログインID', 'パスワード' );
						$this->smarty->assign( 'error', $error );
					}
				}else {
					// データが取得できない場合、エラーメッセージ表示。
					$error = sprintf( E006, 'ログインID', 'パスワード' );
					$this->smarty->assign( 'error', $error );
				}

			}else {
				// データが取得できない場合、エラーメッセージ表示。
				$error = sprintf(E006, 'ログインID','パスワード');
				$this->smarty->assign( 'error', $error );
			}

			$this->smarty->assign( 'login_id', $login_id );
			$this->smarty->assign( 'password', $password );
			$this->smarty->display( 'login.html' );
		}else {
			session_unset ();
			$this->smarty->assign( 'error', '' );
			$this->smarty->assign( 'login_id', '');
			$this->smarty->assign( 'password', '' );
			$this->smarty->display( 'login.html' );
			return;
		}
	}
	/**
	 * ログアウト処理
	 */
	public function logoutAction() {
		session_unset ();
		$this->dispatch('Login');
	}
}

?>
