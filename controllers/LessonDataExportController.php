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
require_once 'service/LessonService.php';

/**
 * レッスンデータ抽出コントローラー
 */
class LessonDataExportController extends BaseController {

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
			$this->smarty->display( 'lessonDataExport.html' );
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
					$this->form->org_name=$org_data->org_name;
					$this->form->db_org_id=$org_data->org_id;
					$service = new LessonService($this->pdo);
					// 検索結果を取得
					$list = $service->getLessonCsvData($org_data->org_no,$this->form);
					if(count($list)>0){
						$this->smarty->assign('form',$this->form);
						$fileName = LESSON_OUTPUT. "_" . date('YmdHis') . ".csv";
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
			$this->smarty->display ( 'lessonDataExport.html' );

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
		$lesson_csvtitle = unserialize (LESSON_LIST);
		fputcsv($output, $lesson_csvtitle);
		foreach ( $array as $row ){
			fputcsv($output, array($export_date,$export_time,$this->form->db_org_id,$this->form->org_name,$row->lesson_no,$row->lesson_name,$row->lesson_name_kana,$row->grade_name,$row->start_period,$row->end_period,$row->subject_name,$row->lesson_status,$row->remarks,$row->managerCount,$row->groupCount,$row->studentCount,$row->create_dt,$row->update_dt,$export_Id,$exporter_name));
		}
		exit;
		fclose($output);
	}
}

?>