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
require_once 'service/StudentService.php';
require_once 'util/DateUtil.php';

class StudentDataExportController extends BaseController {
	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login () == true ) {

			$this->setMenu();
			$this->smarty->assign('org_id',"");
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->display ( 'studentDataExport.html' );
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	public function csvWocAction() {

		if ( $this->check_login () == true ) {

			// メニュー情報を取得、セットする
			$this->setMenu();

			$org_service = new OrganizationService($this->pdo);
			$org_id = $this->form->org_id;

			if($org_id != "" ){

				$this->smarty->assign('org_id',$org_id);
				$org = $org_service->getOrgNoByOrgId($org_id);

				if ( $org != "" ){

					$this->form->org_no = $org->org_no;
					$this->form->db_org_id = $org->org_id;
					$this->form->org_name = $org->org_name;
					$service = new StudentService($this->pdo);
					$list = $service->getStudentCsvData($this->form);
					$count = count($list);

					if ( $count > 0 ) {

						$fileName = STUDENT_OUTPUT. "_" . date('YmdHis') . ".csv";
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

				$this->smarty->assign('org_id',"" );
				$err_msg = sprintf( I002, "組織ID" );
				$this->smarty->assign( 'error_msg',$err_msg);
			}

		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}

		$this->smarty->assign('form', $this->form);
		$this->smarty->display ( 'studentDataExport.html' );
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

		$csvtitle = unserialize (STUDENT_LIST);
		fputcsv($output, $csvtitle);

		$org_id = $this->form->db_org_id;
		$org_name = $this->form->org_name;
		foreach ( $array as $row ) {

			if ( $row->sex == '0' ){

				$gender = "-";
			}else if ( $row->sex == '1' ){

				$gender = "男性";
			}else {

				$gender = "女性";
			}

			fputcsv($output, array(DateUtil::getDate('Y/m/d'), DateUtil::getDate('H:m:s'), $org_id, $org_name, $row->student_no, $row->student_name,
					$row->no, $row->student_name_romaji, $gender , $row->login_id, $row->mail_address,$row->enroll_dt, $row->graduation_dt,
					$row->remarks, $row->create_dt, $row->update_dt, $_SESSION ['login_id'], $_SESSION ['admin_name'] ));
		}
		exit();
		fclose($output);

	}
}
?>