<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'util/DateUtil.php';
require_once 'util/CommonUtil.php';
require_once 'service/OrganizationService.php';
require_once 'service/GroupStudentService.php';

/**
 *グループ:受講者データ抽出コントローラー
 */
class GroupStudentDataExportController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {
		if ( $this->check_login() == true ){
			$this->setMenu();
			$this->form->org_id = null;
			$this->form->org_name = null;
			$this->smarty->assign ( 'error', '' );
			$this->smarty->assign ( 'err_msg', '' );
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'groupStudentDataExport.html' );
		}else {
			TransitionHelper::sendException( E002 );
			return;
		}
	}
	/**
	 * Csvダウンロードボタン押下処理
	 *
	 */
	public function csvWocAction() {
			if ( $this->check_login() == true ){
				$org_service = new OrganizationService($this->pdo);
				$org_data = $org_service->getOrgNoByOrgId($this->form->org_id);
				if($org_data != null){
					$this->form->db_org_id=$org_data->org_id;
					$this->form->org_name=$org_data->org_name;
					$service = new GroupStudentService($this->pdo);
					// 検索結果を取得
					$list = $service->getGroupStudentCsvData($org_data->org_no,$this->form);
					if(count($list)>0){
						$this->smarty->assign('form',$this->form);
						$fileName = GROUP_STUDENT_OUTPUT. "_" . date('YmdHis') . ".csv";
						$this->array_to_csv_download($list,$fileName);
						$this->smarty->assign('err_msg',"");
					}else{
						$this->smarty->assign('err_msg',W001);
					}
				}else{
					//組織IDは存在しない場合のエラーメッセージ
					$err_msg = sprintf( E029, "組織ID" );
					$this->smarty->assign('err_msg',$err_msg);
				}
			}else {
				TransitionHelper::sendException ( E002 );
				return;
			}
			$this->smarty->assign('form',$this->form);
			$this->smarty->display ( 'groupStudentDataExport.html' );
	}

	/**
	 * csv ダウンロード処理
	 */
	private function array_to_csv_download($array, $filename) {
		ob_clean();
		ob_end_clean();
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
		$gpStu_csvtitle = unserialize (GROUP_STUDENT_LIST);
		fputcsv($output, $gpStu_csvtitle);
		foreach ( $array as $row ){
			fputcsv($output, array(
					$export_date,$export_time,$this->form->db_org_id,$this->form->org_name,$row->group_no,$row->group_name,$row->grade_name,
					$row->start_period,$row->end_period,$row->student_no,$row->login_id,$row->student_name,$row->student_name_romaji,$row->no,
					$row->sex,$row->enroll_dt,$row->graduation_dt,$export_Id,$exporter_name));
		}
		exit;
		fclose($output);
	}
}

?>