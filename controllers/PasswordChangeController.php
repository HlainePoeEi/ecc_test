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
require_once 'service/AdminService.php';
require_once 'util/DateUtil.php';
require_once 'util/CommonUtil.php';

/**
 * パスワード変更コントローラー
 */
class PasswordChangeController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {
		if ($this->check_login() == true){
			$this->form->login_id = $_SESSION['login_id'];
			$this->form->admin_no = $_SESSION["admin_no"];
			$this->form->old_psw = "";
			$this->form->new_psw = "";
			$this->form->new_psw_confirm= "";
			$this->smarty->assign('form',$this->form);
			$this->smarty->display ( 'passwordChange.html' );
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}
	/**
	 *運用管理者のパスワードを変更する事
	 */
	public function updateAction() {
		if ($this->check_login() == true){
			$login_id = $this->form->login_id;
			$adm_no = $this->form->admin_no;
			$psw = $this->form->old_psw;
			$service = new AdminService ($this->pdo);
			$valid = $service->checkValid($login_id,$adm_no);
			if(password_verify($psw, $valid->password)) {
				$dto = new T_AdminDto();
				$dto->login_id = $login_id;
				$dto->admin_no = $adm_no;
				$dto->password = CommonUtil::encryptPassword($this->form->new_psw);
				$dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
				$dto->updater_id = $adm_no;
				$result = $service->updatePassword($dto);
				// 更新処理が正常の場合、
				if ( $result == 1 ){
					$this->form->old_psw = "";
					$this->form->new_psw = "";
					$this->form->new_psw_confirm= "";
					//メニューへ行く
					$_SESSION ['regist_msg'] =sprintf( I003, '更新' );
					$this->dispatch('Menu');
					/*$error = sprintf( I003, '更新' );
					 $this->smarty->assign( 'err_msg', $error );
					 $this->smarty->display( 'passwordChange.html' );
					 $this->smarty->assign( 'form', $this->form );
					 */
					// 更新出来ない場合、
				}else {
					TransitionHelper::sendException ( E002 );
					return;
				}
			}else {
				$error = "旧パスワードが正しくありません。";
				$this->smarty->assign( 'err_msg', $error );
				$this->smarty->assign( 'form', $this->form );
				$this->smarty->display( 'passwordChange.html' );
				return;
			}
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}
}

?>