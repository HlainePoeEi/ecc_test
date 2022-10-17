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
require_once 'service/OrganizationService.php';
require_once 'service/Subject_AreaService.php';
require_once 'util/DateUtil.php';

/**
 *教科：科目データ抽出コントローラー
 */
class SubjectAreaSubjectDataExportController extends BaseController {
	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login () == true ){

			$this->setMenu();
			$this->smarty->assign('org_id',"");
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->display ( 'subjectAreaSubjectDataExport.html' );
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	public function csvWocAction() {

		if ( $this->check_login () == true ){

			// メニュー情報を取得、セットする
			$this->setMenu();

			$org_service = new OrganizationService($this->pdo);
			$org_id = $this->form->org_id;
			$this->smarty->assign('org_id',$org_id);
			$org = $org_service->getOrgNoByOrgId($org_id);

			if ( $org != "" ){
				$this->form->db_org_id=$org->org_id;
				$this->form->org_name = $org->org_name;
				$service = new Subject_AreaService($this->pdo);
				$list = $service->getSubjectAreaSubjectCsvData($org->org_no);
				$count = count($list);

				if ( $count > 0 ){

					$fileName = SUBJECT_AREA_SUBJECT_OUTPUT. "_" . date('YmdHis') . ".csv";
					$this->array_to_csv_download($list,$fileName);
					$this->smarty->assign('error_msg',"");
				}else {
					// エラーメッセージを設定　「データがベースに存在しません」
					$this->smarty->assign('error_msg',W001);
				}
			}else {

				$err_msg = sprintf( E029, "組織ID" );
				$this->smarty->assign( 'error_msg',$err_msg);
			}

		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}

		$this->smarty->assign('form', $this->form);
		$this->smarty->display ( 'subjectAreaSubjectDataExport.html' );
	}

	/**
	 * csv ダウンロード処理
	 */
	private function array_to_csv_download($array, $filename) {

		header('Content-Encoding: UTF-8');
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename= ' . $filename);
		ob_end_clean();

		$output = fopen("php://output", "w");
		fprintf( $output, "\xEF\xBB\xBF");

		$csvtitle = unserialize (SUBJECT_AREA_SUBJECT_LIST);
		fputcsv($output, $csvtitle);

		$db_org_id = $this->form->db_org_id;
		$org_name = $this->form->org_name;
		LogHelper::logDebug("Admin Name      " . $_SESSION ['admin_name'] );
		foreach ( $array as $row ) {

			fputcsv($output, array(DateUtil::getDate('Y/m/d'), DateUtil::getDate('H:m:s'), $db_org_id, $org_name, $row->subject_area_no, $row->subject_area_name,
					$row->subject_area_name_kana, $row->subArea_start_period, $row->subArea_end_period, $row->subArea_disp_no, $row->subArea_remarks,
					$row->subArea_create_dt, $row->subArea_update_dt, $row->subject_no, $row->subject_name, $row->subject_name_kana, $row->sub_start_period,
					$row->sub_end_period, $row->sub_disp_no, $row->sub_remarks, $row->sub_create_dt, $row->sub_update_dt, $_SESSION ['login_id'],
					$_SESSION ['admin_name'] ));
		}
		exit();
		fclose($output);

	}
}
?>