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
require_once 'service/Manager_Subject_AreaService.php';
require_once 'service/Subject_AreaService.php';
require_once 'service/OrganizationService.php';
require_once 'dto/T_ManagerDto.php';
require_once 'dto/T_Manager_Subject_AreaDto.php';
require_once 'service/ExcelService.php';

//excell関係
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

/**
 * 担当者エクセル登録コントローラー
 */
class ExcelLessonManagerListController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login () == true ) {

			//ファイルの初期化（セッションに保持したファイル名をクリアする）
			unset($_SESSION ['File_Name']);

			// メニューが開くかどうかを確認する
			$this->setMenu();
			if ( isset($_SESSION ['regist_msg']) ) {

				if ( $_SESSION ['regist_msg'] != "" ) {

					$this->smarty->assign('err_msg',$_SESSION ['regist_msg']);
					$_SESSION ['regist_msg'] = "";
				}
			}

			$this->smarty->assign ( 'error', '' );
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->assign ( 'dataArray', null );
			$this->smarty->assign ( 'btn_flg', '' );
			$this->smarty->display ( 'excelLessonManagerList.html' );
		}else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * アップロード処理
	 */
	public function showAction() {

		if ( $this->check_login () == true ) {
			$this->setMenu();
			//ログインした運用管理者ログインID
			$admin_id = $_SESSION ['login_id'];
			$save_result = 0;
			if ( !empty($this->form->input_file) ) {
				$file_name = $this->form->file_name;
			}
			$excelService = new ExcelService($this->pdo);
			//ログインした運用管理者番号
			$admin_no = $_SESSION ['admin_no'];
			//サーバに保存するエクセルファイルパス・　運用管理者番号/運用管理者ログインID/日付
			$_SESSION ['Manager_File'] =  $admin_no . "_" . $admin_id. "_" . DateUtil::getDate ( 'YmdHis' ) . "_" . $file_name;
			$_SESSION ['File_Name'] = $file_name;
			$filedir = FILE_DIR.MANAGER_FOLDER_NAME. "/";
			//プロジェクト名/Files/LessonManager_temp/ファイル名
			$excelService->uploadFile($this->form->image_data, $filedir, $_SESSION ['Manager_File']);
			$this->dispatch('ExcelLessonManagerList/viewExcelList');
		}else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
		}

	}

	/**
	 * エクセル描画処理
	 */
	public function viewExcelListAction() {

		$imagedir = FILE_DIR. MANAGER_FOLDER_NAME. "/";
		//アップロードしたエクセルファイルをアクセスする
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir.$_SESSION ['Manager_File']);

		//エクセルファイルのアクティブシートを取る
		$sheet = $spreadsheet->getActiveSheet();

		//エクセルファイルにデータが有る最後のカラムと行を取る
		$hcol = $spreadsheet->setActiveSheetIndex(0)->getHighestColumn();
		$hrow = $spreadsheet->setActiveSheetIndex(0)->getHighestRow();

		//エクセルファイルにデータが有るかどうかチェックする
		if ( $hcol == 'A' || $hrow <= 1 ) {

			//エクセルファイルにデータが無いの場合、
			$error = sprintf('Error!!! Empty File.');
			$this->smarty->assign ( 'err_msg', $error );
			$this->smarty->assign('form', $this->form);
			$this->smarty->display ( 'excelLessonManagerList.html' );
			return;
		}else {

			// 領域を2次元配列として取得する
			$range = 'A1:'. 'S' . $hrow;
			$title_range = 'A1:'. 'S' . 1;

			// 日付けフォーマット設定
			$sheet->getStyle('G2:Q'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
			$sheet->getStyle('H2:R'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);

			$dataTitle = $sheet->rangeToArray($title_range);
			$dataArray = $this->changeDataArray($sheet->rangeToArray($range),$sheet,$hrow);

			$title_arr = unserialize (MANAGER_HEADER_LIST);
			$this->smarty->assign ( 'dataArray', $dataArray );

			$title_flg = 1;
			$col_flg = 1;

			// 列数を確認する
			if ( $hcol != 'S' && $hcol != 'T' ) {

				$col_flg = 0;
			}

			if ( $col_flg == 1 ) {
				// タイトルが間違いがどうか確認する
				for ( $i = 0; $i < 19; $i++ ) {

					if ( $dataTitle[0][$i] != $title_arr[$i] ) {

						$title_flg = 0;
					}
				}
			}

			// 担当者のフォーマットファイルが間違っている時エラーメッセージを表示する
			if ( $col_flg == 0 || $title_flg == 0 ) {

				$error = sprintf(E026,"担当者登録");
				$this->smarty->assign ( 'err_msg', $error );
				$this->smarty->assign ( 'dataArray', null );
			}else {

				$this->smarty->assign ( 'err_msg', '' );
				$this->smarty->assign ( 'dataArray', $dataArray );

				$org_service = new OrganizationService($this->pdo);
				$org_Data = $org_service->getOrgNoByOrgId(CommonUtil::htmlEntityDecode($dataArray[1][0]));
				$org_name_flg='0';
				$dataArray = array_filter($dataArray, 'array_filter');
				if ( $org_Data != null ){

					$this->form->org_name_flg ='1';
					$this->form->db_org_name = "組織名 - ".$org_Data->org_name;
					$db_org_id = $org_Data->org_id;
					$this->form->db_org_id = $db_org_id;
				}else {

					$this->form->org_name_flg ='0';
					$this->form->db_org_name = "組織名はありません。";
				}
			}

			$_SESSION['org_name_flg'] = $this->form->org_name_flg;
			$_SESSION['db_org_name'] = $this->form->db_org_name;
			$this->form->manager_max_count = MANAGER_MAX_COUNT;
			// メニュー情報を取得、セットする
			$this->setMenu();
			$this->form->file_name = $_SESSION ['File_Name'] ;
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->assign ( 'btn_flg', '1' );
			$this->smarty->display ( 'excelLessonManagerList.html' );
		}
	}

	/**
	 * 登録処理
	 */
	public function saveAction() {

		$manager_data = $this->form->manager_data;
		$manager = explode ( ',', $manager_data);
		$org_no = $this->form->org_no;
		$managerSub_service = new Manager_Subject_AreaService($this->pdo);
		$subArea_service = new Subject_AreaService($this->pdo);

		$manager_service = new ManagerService($this->pdo);

		//重複データが無い場合、
		for ( $i = 0; $i < count($manager); $i++ ) {
			$Arrsubject = array("");
			// 担当者データ情報登録
			$manager_dto = new T_ManagerDto();

			$manager_dto->org_no = $org_no;
			$next_manager_no= $manager_service->getNextId();
			$manager_no = $next_manager_no->id;
			$manager_dto->manager_no = $manager_no;
			$manager_dto->manager_name = CommonUtil::htmlEntityDecode($manager[$i+1]);
			$manager_dto->manager_name_kana = CommonUtil::htmlEntityDecode($manager[$i+2]);
			$manager_dto->login_id=CommonUtil::htmlEntityDecode($manager[$i+3]);

			$password = CommonUtil::htmlEntityDecode($manager[$i+4]);
			$manager_dto->password = CommonUtil::encryptPassword($password);
			$manager_dto->mail_address = CommonUtil::htmlEntityDecode($manager[$i+5]);
			$manager_dto->manager_kbn = SUB_TEACHER_KBN;
			$start_period=DateUtil::getYmd(CommonUtil::htmlEntityDecode($manager[$i+6]));//利用開始日
			$end_period=DateUtil::changeEndDateFormat(CommonUtil::htmlEntityDecode($manager[$i+7]));//利用開始日
			$manager_dto->start_period = $start_period;
			$manager_dto->end_period = $end_period;
			$manager_dto->remarks = CommonUtil::htmlEntityDecode($manager[$i+8]);
			$manager_dto->del_flg = 0;
			$manager_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
			$manager_dto->creater_id =  $_SESSION ['admin_no'];
			$manager_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
			$manager_dto->updater_id = $_SESSION ['admin_no'];

			if ( $manager[$i+9] != "" ){

				array_push($Arrsubject,"'".CommonUtil::htmlEntityDecode($manager[$i+9])."'");
			}

			if ( $manager[$i+10] != "" ){

				array_push($Arrsubject,"'".CommonUtil::htmlEntityDecode($manager[$i+10])."'");
			}
			if ( $manager[$i+11] != "" ){

				array_push($Arrsubject,"'".CommonUtil::htmlEntityDecode($manager[$i+11])."'");
			}
			if ( $manager[$i+12] != "" ){

				array_push($Arrsubject,"'".CommonUtil::htmlEntityDecode($manager[$i+12])."'");
			}
			if ( $manager[$i+13] != "" ){

				array_push($Arrsubject,"'".CommonUtil::htmlEntityDecode($manager[$i+13])."'");
			}
			if ( $manager[$i+14] != "" ){

				array_push($Arrsubject,"'".CommonUtil::htmlEntityDecode($manager[$i+14])."'");
			}
			if ( $manager[$i+15] != "" ){

				array_push($Arrsubject,"'".CommonUtil::htmlEntityDecode($manager[$i+15])."'");
			}
			if ( $manager[$i+16] != "" ){

				array_push($Arrsubject,"'".CommonUtil::htmlEntityDecode($manager[$i+16])."'");
			}
			if ( $manager[$i+17] != "" ){

				array_push($Arrsubject,"'".CommonUtil::htmlEntityDecode($manager[$i+17])."'");
			}
			if ( $manager[$i+18] != "" ){

				array_push($Arrsubject,"'".CommonUtil::htmlEntityDecode($manager[$i+18])."'");
			}

			$Arrsubject = array_filter($Arrsubject);
			$subNoArr = array();
			if ( !empty($Arrsubject) ){

				$subNoArr = $subArea_service->getSubjectNo($this->form->org_no, $Arrsubject);
			}

			$ms_arr = array();
			if ( !empty($subNoArr) ){

				for ( $j = 0; $j < count($subNoArr); $j++ ){
					// T教師教科データ情報登録
					$managerSubject_dto = new T_Manager_Subject_AreaDto();

					$managerSubject_dto->org_no = $org_no;
					$managerSubject_dto->manager_no = $manager_no;
					$managerSubject_dto->del_flg = 0;
					$managerSubject_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
					$managerSubject_dto->creater_id =  $_SESSION ['admin_no'];
					$managerSubject_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
					$managerSubject_dto->updater_id = $_SESSION ['admin_no'];

					$managerSubject_dto->subject_area_no = $subNoArr[$j]->subject_area_no;

					$ms_arr[] = $managerSubject_dto;
				}
			}
			// 管理者教師リスト情報を登録する
			$result1 = $managerSub_service->insertDataArr($manager_dto,$ms_arr);

			if ( $result1 == 1 ){
				//登録完了
				$count = $count + 1;
				$error = sprintf(I006, "担当者", $count);
				$_SESSION ['regist_msg'] = $error;
				$this->dispatch('ExcelLessonManagerList');
				// 登録出来ない場合,エーラーメーセジを表示する
			}else {
				$error = sprintf(E007,'登録');
				$this->smarty->assign ( 'error', $error );
				$_SESSION ['regist_msg'] = $error;
				$this->dispatch('ExcelLessonManagerList');
			}
			$i = $i + 18;
		}
	}

	/**
	 * エクセルダウンロード処理
	 */
	public function newExcelAction() {

		if ( $this->check_login () == true ) {

			$dir = FILE_DIR. EXCEL_FORMAT_FOLDER_NAME. "/";
			$file = $dir. MANAGER_FILE_NAME;
			if ( file_exists($file) ){

				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename($file));
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file));

				ob_clean();
				flush();
				readfile($file);
				exit;
			}else {

				$error = sprintf( E030 );
				$this->smarty->assign ( 'error', $error );
				$_SESSION ['regist_msg'] = $error;
				$this->dispatch('ExcelLessonManagerList');
			}
		}else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
		}

	}

	/**
	 * 管理者教師の項目重複チェック
	 */
	public function duplicateCheckWocAction() {

		if ( $this->check_login () == true ) {

			$temp = 0;

			$manager_data = $this->form->manager_data;

			$manager = explode ( ',', $manager_data);

			$org_id = $manager[0];

			$Orgservice = new OrganizationService($this->pdo);
			$org_result = $Orgservice->getOrgNoByOrgId($org_id);

			$service = new Subject_AreaService($this->pdo);
			$list = $service->getSubjectList($org_result->org_no);
			$this->form->org_no = $org_result->org_no;

			$name_list = array("");
			for ( $i = 0; $i<sizeof($list); $i++ ){

				array_push($name_list,$list[$i]->subject_area_name);
			}
			// 担当者名重複チェック

			$count = 0;

			$login_id = array("");
			$dup_arr = '';
			$sub_err_arr = '';
			$loop_count = 0;

			for ( $i = 0; $i < count($manager); $i++ ) {

				$Arrsubject = array("");
				//HTMLエンティティを文字に変換とエスケープコンマ
				$manager[$i] =CommonUtil::htmlEntityDecode($manager[$i]);

				if ( ($i % 19) == 0 ){

					$loop_count = $loop_count+1;
					$dup_arr_sub = 0;
					array_push($login_id,CommonUtil::htmlEntityDecode($manager[$i+3]));

					array_push($Arrsubject,CommonUtil::htmlEntityDecode($manager[$i+9]));
					array_push($Arrsubject,CommonUtil::htmlEntityDecode($manager[$i+10]));
					array_push($Arrsubject,CommonUtil::htmlEntityDecode($manager[$i+11]));
					array_push($Arrsubject,CommonUtil::htmlEntityDecode($manager[$i+12]));
					array_push($Arrsubject,CommonUtil::htmlEntityDecode($manager[$i+13]));
					array_push($Arrsubject,CommonUtil::htmlEntityDecode($manager[$i+14]));
					array_push($Arrsubject,CommonUtil::htmlEntityDecode($manager[$i+15]));
					array_push($Arrsubject,CommonUtil::htmlEntityDecode($manager[$i+16]));
					array_push($Arrsubject,CommonUtil::htmlEntityDecode($manager[$i+17]));
					array_push($Arrsubject,CommonUtil::htmlEntityDecode($manager[$i+18]));

					if ( !empty($Arrsubject) ){

						$err_sub = array_diff($Arrsubject, $name_list);
						if ( !empty($err_sub) ){

							if ( $sub_err_arr == '' ){

								$sub_err_arr= $loop_count;
							}else {

								$sub_err_arr= $sub_err_arr. ',' . $loop_count;
							}
						}
					}
				}
			}

			$manager_service = new ManagerService($this->pdo);
			for ( $i = 1; $i < count($login_id); $i++ ) {

				$org_no = "";
				$duplicate_result = $manager_service->checkedExistInfo($org_result->org_no, $login_id[$i] );

				if ( $duplicate_result > 0 ){

					if ( $dup_arr == '' ){

						$dup_arr = $i;
					}else {

						$dup_arr = $dup_arr . ',' . $i;
					}
					$temp = 1;
				}
			}

			$_SESSION ['file'] = $this->form->file;
			$this->form->org_name_flg = $_SESSION['org_name_flg'];
			$this->form->db_org_name = $_SESSION['db_org_name'];
			$this->smarty->assign( 'form', $this->form );

			if ( $temp > 0 ){

				$dup_msg = $dup_arr . '行目のログインID';
				$error = sprintf(E014,$dup_msg);
				$this->setFormData();
				$this->smarty->assign ( 'btn_flg', '1' );
				$this->smarty->assign( 'err_msg', $error );
				$this->smarty->display ( 'excelLessonManagerList.html' );
			}else if ( $sub_err_arr != '' ){

				$dup_msg = $sub_err_arr. '行目の教科';
				$error = sprintf(E029,$dup_msg);
				$this->setFormData();
				$this->smarty->assign ( 'btn_flg', '1' );
				$this->smarty->assign( 'err_msg', $error );
				$this->smarty->display ( 'excelLessonManagerList.html' );
			}else {

				$this->saveAction();
			}
		}else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * setFormData処理
	 */
	public function setFormData(){

		$file = $this->form->file;

		$imagedir = FILE_DIR. MANAGER_FOLDER_NAME. "/";
		//アップロードしたエクセルファイルをアクセスする
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir.$_SESSION ['Manager_File']);

		$sheet = $spreadsheet->getActiveSheet();

		$hcol = $spreadsheet->setActiveSheetIndex(0)->getHighestDataColumn();
		$hrow = $spreadsheet->setActiveSheetIndex(0)->getHighestDataRow();

		// 領域を2次元配列として取得する
		$range = 'A1:'. $hcol . $hrow;

		// 日付けフォーマット設定
		$sheet->getStyle('G2:Q'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$sheet->getStyle('H2:R'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);

		$dataArray = $this->changeDataArray($sheet->rangeToArray($range),$sheet,$hrow);
		$dataArray = array_filter($dataArray, 'array_filter');
		$this->smarty->assign ( 'dataArray', $dataArray );
	}

	/**
	 * 日付のフォーマット切り替え
	 * @param $sheet：エクセル
	 * @param $dataArray：エクセルのアレイ
	 * @param $hrow：最高のエクセル行
	 */
	public function changeDataArray($dataArray,$sheet,$hrow){
		//開いてるアレイを削除
		for ($row = 2; $row <= $hrow; $row++){
			$result=array_filter($dataArray[$row-1]);
			if(count($result)<=0){
				//ブランクのアレイを消す事
				unset($dataArray[$row-1]);
			}else{
				//日付交換
				$key1='G'.$row;
				$key2='H'.$row;
				// 利用開始
				if($sheet->getCell($key1)->getFormattedValue()!=""){
					if(!(DateUtil::isValidDateFormat($sheet->getCell($key1)->getFormattedValue()) || DateUtil::isValidDateFormat($sheet->getCell($key1)->getValue()))){
						$resVal=$sheet->getCell($key1)->getValue();
						$dataArray[$row-1][6]=(preg_match('/^[0-9]{8}$/i',$resVal))?(substr($resVal,0,4).'-'.substr($resVal,4,2).'-'.substr($resVal,6,2)):$resVal;
					}
				}
				//利用終了
				if($sheet->getCell($key2)->getFormattedValue()!=""){
					if(!(DateUtil::isValidDateFormat($sheet->getCell($key2)->getFormattedValue()) || DateUtil::isValidDateFormat($sheet->getCell($key2)->getValue()))){
						$resVal=$sheet->getCell($key2)->getValue();
						$dataArray[$row-1][7]=(preg_match('/^[0-9]{8}$/i',$resVal))?(substr($resVal,0,4).'-'.substr($resVal,4,2).'-'.substr($resVal,6,2)):$resVal;
					}
				}
			}
		}
		$dataArray=array_values($dataArray);
		return $dataArray;
	}
}
?>
