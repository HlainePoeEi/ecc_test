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
require_once 'service/GroupService.php';
require_once 'util/DateUtil.php';

class GroupDataExportController extends BaseController {
	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login () == true ) {

			$this->setMenu();
			$this->smarty->assign('org_id',"");
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->display ( 'groupDataExport.html' );
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	public function csvDownloadAction() {

		if ( $this->check_login() == true ){
			// メニュー情報を取得、セットする
			$this->setMenu();

			$org_service = new OrganizationService($this->pdo);
			$org_id = $this->form->org_id;

			if($org_id != ""){
				$this->smarty->assign('org_id',$org_id);
				$result = $org_service->getOrgNoByOrgId($org_id);
			if($result != ""){
				$this->form->org_no = $result->org_no;
				$this->form->org_name = $result->org_name;
				$this->form->db_org_id = $result->org_id;
				$group_service=new GroupService($this->pdo);
				$list=$group_service->getGroupCsvData($this->form);
				$count = count($list);
				if ( $count > 0 ) {

					$fileName = GROUP_OUTPUT. "_" . date('YmdHis') . ".csv";
					$this->array_to_csv_download($list,$fileName);
					$this->smarty->assign('err_msg',"");
				}else {
					// エラーメッセージを設定　「データがベースに存在しません」
					$this->smarty->assign('err_msg',W001);
				}

			}else {
				$err_msg = sprintf( E029, "組織ID" );
				$this->smarty->assign( 'err_msg',$err_msg);
			}
		}else{
			$this->smarty->assign('org_id',"" );
			$err_msg = sprintf( I002, "組織ID" );
			$this->smarty->assign( 'err_msg',$err_msg);
			}
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}

		$this->smarty->assign('form', $this->form);
		$this->smarty->display ( 'groupDataExport.html' );
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

		$csvtitle = unserialize (GROUP_LIST);
		fputcsv($output, $csvtitle);

		$db_org_id = $this->form->db_org_id;
		$org_name = $this->form->org_name;
		foreach ( $array as $row ) {

			fputcsv($output, array(DateUtil::getDate('Y/m/d'), DateUtil::getDate('H:m:s'), $db_org_id, $org_name, $row->group_no, $row->group_name,
					$row->group_name_kana, $row->grade_name, $row->start_period, $row->end_period, $row->remarks,
					$row->stuCount, $row->create_dt, $row->update_dt,$_SESSION ['login_id'],
					$_SESSION ['admin_name'] ));
		}
		exit();
		fclose($output);

	}
}