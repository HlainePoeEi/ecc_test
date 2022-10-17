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
require_once 'util/DateUtil.php';
require_once 'util/CommonUtil.php';
require_once 'service/ManagerService.php';
require_once 'service/OrganizationService.php';

/**
 * 担当者データ抽出コントローラー
 */
class ManagerDataExportController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login () == true ) {

			// メニューが開くかどうかを確認する
			$this->setMenu();

			$this->form->org_id = null;
			$this->form->org_name = null;
			$this->smarty->assign ( 'error', '' );
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->display ( 'managerDataExport.html' );
		}else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * Csvダウンロードボタン押下処理
	 *
	 */
	public function csvAction () {

		if ( $this->check_login() == true ){

			// メニュー情報を取得、セットする
			$this->setMenu();

			$org_service = new OrganizationService($this->pdo);
			$org_Data = $org_service->getOrgNoByOrgId($this->form->org_id);

			if ( $org_Data != null ){

				$service = new ManagerService($this->pdo);

				// 検索結果を取得
				$list = $service->getMangerCsvData($org_Data->org_no);
				$this->form->org_name = $org_Data->org_name;
				$this->form->db_org_id = $org_Data->org_id;

				if ( count($list) > 0 ){

					$fileName = MANAGER_OUTPUT . "_" . date('YmdHis') . ".csv";
					$this->smarty->assign('form',$this->form);
					$list = $service->getMangerCsvData($org_Data->org_no);
					$this->array_to_csv_download($list,$fileName);
					$err_msg = "";
					$this->smarty->assign('error_msg',$err_msg);
				}else {
					// エラーメッセージを設定　「データがベースに存在しません」
					$err_msg = W001;
					$this->smarty->assign('err_msg',$err_msg);
					$this->smarty->assign('form',$this->form);
					$this->smarty->display ( 'managerDataExport.html' );
				}

				$this->smarty->assign ( 'error', '' );
				return;
			}else {

				$err_msg = sprintf( E029, "組織ID" );
				$this->smarty->assign ( 'err_msg', $err_msg );
			}
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
		$this->smarty->assign('form',$this->form);
		$this->smarty->display ( 'managerDataExport.html' );
	}

	/**
	 * csv ダウンロード処理
	 */
	private function array_to_csv_download($array, $filename) {

		ob_clean();
		header('Content-Encoding: UTF-8');
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename= ' . $filename);
		$output = fopen("php://output", "w");
		fprintf( $output, "\xEF\xBB\xBF");

		$export_date = DateUtil::getDate();
		$export_time = date("H:i:s");
		if ( isset($_SESSION['login_id']) ){

			$export_Id = $_SESSION['login_id'];
		}
		if ( isset($_SESSION['admin_no']) ){

			$exporter_name = $_SESSION ['admin_name'];
		}

		$manager_csvtitle = unserialize (MANAGER_LIST);
		fputcsv($output, $manager_csvtitle);

		foreach ( $array as $row ){

			fputcsv($output, array($export_date,$export_time,$this->form->db_org_id,$this->form->org_name,$row->manager_no,$row->manager_kbn,$row->manager_name,$row->manager_name_kana,$row->login_id,$row->mail_address,$row->subjectArea,$row->start_period,$row->end_period,$row->remarks,$row->create_dt,$row->update_dt,$export_Id,$exporter_name));
		}
		fclose($output);
	}
}
?>
