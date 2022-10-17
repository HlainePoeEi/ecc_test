<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'dto/T_System_NoticeDto.php';
require_once 'service/SystemNoticeService.php';
require_once 'service/TypeService.php';
require_once 'util/DateUtil.php';

/**
 * お知らせ設定コントローラー
 */
class SystemNoticeRegistController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			$this->setMenu();
			// システムお知らせ情報設定
			$this->getSystemNotice($this->form);
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 画面データ取得・渡す処理
	 */
	public function searchAction() {

		$system_notice_no = $this->form->system_notice_no;
		// メニュー情報を取得、セットする
		$this->setMenu();
		if ( $this->form->page == "" ){

			$this->form->page = 1;
		}
		$service = new SystemNoticeService($this->pdo);

		// システムお知らせ情報取得
		$count = count($service->getSystemNoticeData($this->form, ""));

		if ( $count > 0 ){

			$this->form->max_page = ceil($count/ PAGE_ROW);
			$list = $service->getSystemNoticeData($this->form, "1");
			$this->smarty->assign( 'list', $list );
		}else {
			// エラーメッセージを設定「検索結果がありません」
			$err_msg = W001;
			$this->smarty->assign( 'list', Null );
			$this->smarty->assign( 'err_msg', $err_msg );
		}

		$target_kbn = TARGET_KBN;
		$service = new TypeService($this->pdo);
		$targetKbn = $service->getCategoryTypeAll($target_kbn);
		$this->smarty->assign( 'targetKbn', $targetKbn);

		if ( $this->form->screen_mode == "new" ){

			$this->form->system_kbn = $this->form->target_Kbn;
		}

		$this->smarty->assign( 'form', $this->form );
		$this->smarty->display( 'systemNoticeRegist.html' );
	}
	/**
	 * 画面データ取得・渡す処理
	 */
	public function getSystemNotice($myForm) {

		$system_notice_no = $myForm->system_notice_no;
		// メニュー情報を取得、セットする
		$this->setMenu();
		if ( $this->form->page == "" ){

			$this->form->page = 1;
		}
		$service = new SystemNoticeService($this->pdo);

		// システムお知らせ情報取得
		$count = count($service->getSystemNoticeData($myForm, ""));

		if ( $count > 0 ){

			$myForm->max_page = ceil($count/ PAGE_ROW);
			$list = $service->getSystemNoticeData($myForm, "1");
			$this->smarty->assign( 'list', $list );
		}else {
			// エラーメッセージを設定「検索結果がありません」
			$err_msg = W001;
			$this->smarty->assign( 'list', Null );
			$this->smarty->assign( 'err_msg', $err_msg );
		}

		// システムお知らせ№がある場合、編集情報取得
		if ( $system_notice_no != "" ){

			$target_kbn = TARGET_KBN;
			$service = new TypeService($this->pdo);
			$targetKbn = $service->getCategoryTypeAll($target_kbn);
			$this->smarty->assign( 'targetKbn', $targetKbn);

			$service = new SystemNoticeService($this->pdo);
			$systemNoticeInfo = $service->getSystemNoticeInfo($myForm);
			// テンプレートにデータ渡す
			$this->form->system_notice_no = $systemNoticeInfo->system_notice_no;
			$this->form->system_kbn = $systemNoticeInfo->system_kbn;
			$this->form->description = $systemNoticeInfo->description;
			$this->form->start_period = $systemNoticeInfo->start_period;
			$this->form->end_period = $systemNoticeInfo->end_period;
			$this->form->screen_mode = "update";
			$this->smarty->assign( 'form', $myForm );
		}else {

			// システムお知らせ№がない場合
			$target_kbn = TARGET_KBN;
			$service = new TypeService($this->pdo);
			$targetKbn = $service->getCategoryTypeAll($target_kbn);
			$this->smarty->assign( 'targetKbn', $targetKbn);

			$myForm->description = "";
			$start_period = DateUtil::getDate('Y/m/d');
			$end_period = DateUtil::getDateAddDay(7,'Y/m/d');
			$myForm->start_period = $start_period;
			$myForm->end_period = $end_period;
			$myForm->system_kbn = "";
			$myForm->target_Kbn = "";
			$myForm->system_kbn = $myForm->target_Kbn;
			$this->smarty->assign( 'form', $myForm );
			$myForm->screen_mode = 'new';
		}
		$this->smarty->display( 'systemNoticeRegist.html' );
	}

	/**
	 * 画面登録ボタン処理
	 */
	public function saveAction() {

		$admin_no = $_SESSION ['admin_no'];
		$system_notice_no = $this->form->system_notice_no;
		$service = new SystemNoticeService($this->pdo);

		// システムお知らせ№がない場合、新規追加
		if ( $system_notice_no == "" ){

			$systemNoticeDto = new T_System_NoticeDto();

			$systemNoticeDto->system_kbn = $this->form->target_Kbn;
			$systemNoticeDto->description = $this->form->description;
			$systemNoticeDto->start_period = $this->form->start_period;
			$systemNoticeDto->end_period = DateUtil::changeEndDateFormat($this->form->end_period);
			$systemNoticeDto->creater_id = $admin_no;
			$systemNoticeDto->updater_id = $admin_no;
			$systemNoticeDto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
			$systemNoticeDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );

			// システムお知らせ番号の設定
			$system_notice_data = $service->getNextSystemNoticeNo ();
			$system_notice_no = $system_notice_data->id;

			$this->form->system_notice_no = $system_notice_no;
			$systemNoticeDto->system_notice_no = $system_notice_no;

			$save_result = $service->registSystemNoticeData ( $systemNoticeDto);
			// 登録処理成功の場合
			if ( $save_result > 0 ){

				$this->smarty->assign( 'info_msg', I004 );
				$this->smarty->assign( 'error_msg', "" );
				$this->form->system_notice_no = "";
				$this->form->system_kbn = "";
				$this->getSystemNotice($this->form);
			}else {

				$error_msg = sprintf( E007, '登録' );
				$this->smarty->assign( 'error_msg', $error_msg );
				$this->smarty->assign( 'info_msg', "" );
				$this->getSystemNotice($this->form);
				return;
			}
		}else {

			$systemNoticeDto = new T_System_NoticeDto();
			$systemNoticeDto->system_notice_no = $system_notice_no;
			$systemNoticeDto->system_kbn = $this->form->target_Kbn;
			$systemNoticeDto->description = $this->form->description;
			$systemNoticeDto->start_period = $this->form->start_period;
			$systemNoticeDto->end_period = DateUtil::changeEndDateFormat($this->form->end_period);
			$systemNoticeDto->updater_id = $admin_no;
			$systemNoticeDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );

			$update_result = $service->updateSystemNoticeData ( $systemNoticeDto );

			// 更新処理成功の場合
			if ( $update_result > 0 ){

				$this->smarty->assign( 'info_msg', I004 );
				$this->smarty->assign( 'error_msg', "" );
				$this->form->system_notice_no = "";
				$this->form->system_kbn = "";
				$this->getSystemNotice($this->form);
			}else {

				$error_msg = sprintf( E007, '更新' );
				$this->smarty->assign( 'error_msg', $error_msg );
				$this->smarty->assign( 'info_msg', "" );
				$this->getSystemNotice($this->form);
				return;
			}
		}
	}
}

?>