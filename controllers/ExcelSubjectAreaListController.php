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
require_once 'dao/M_OrganizationDao.php';
require_once 'service/OrganizationService.php';
require_once 'dao/M_Subject_AreaDao.php';
require_once 'service/Subject_AreaService.php';
require_once 'dto/M_Subject_AreaDto.php';
require_once 'service/ExcelService.php';

//excell関係
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

/**
 * 教科エクセル登録コントローラー
 */
class ExcelSubjectAreaListController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login () == true ) {

			//ファイルの初期化（セッションに保持したファイル名をクリアする）
			unset($_SESSION ['File_Name']);
			$user_id = $_SESSION ['admin_no'];
			// メニューが開くかどうかを確認する
			$this->setMenu();
			if ( isset($_SESSION ['regist_msg']) ) {

				if ( $_SESSION ['regist_msg'] != "" ) {
					$this->smarty->assign('err_msg',$_SESSION ['regist_msg']);
					$_SESSION ['regist_msg'] = "";
				}
			}else {
				$this->smarty->assign('err_msg','');
			}

			$this->smarty->assign ( 'error', '' );
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->assign ( 'dataArray', null );
			$this->smarty->assign ( 'db_org_name', '');
			$this->smarty->assign ( 'org_name_flg', '' );
			$this->smarty->assign ( 'btn_flg', '' );
			$this->smarty->display ( 'excelSubjectAreaList.html' );

		}else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 表示ボッタン処理
	 */
	public function showAction() {

		if ( $this->check_login () == true ) {

			$this->setMenu();
			$save_result = 0;
			//ログインした運用管理者ログインID
			$admin_id = $_SESSION ['login_id'];
			if ( !empty($this->form->input_file) ) {

				$file_name = $this->form->file_name;
			}
			$excelService = new ExcelService($this->pdo);
			//ログインした運用管理者番号
			$admin_no = $_SESSION ['admin_no'];
			//ファイル名をセッションに追加
			$_SESSION ['File_Name'] = $file_name;
			//サーバに保存するエクセルファイルパス・　運用管理者番号/運用管理者ログインID/日付
			$_SESSION ['Subject_Area_File'] = $admin_no . "_" . $admin_id. "_" .DateUtil::getDate ( 'YmdHis' ) . "_" . $file_name;
			//エクセルファイルディレクトリ
			$filedir = FILE_DIR. "/" . SUBJECT_AREA_FOLDER_NAME. "/";

			//プロジェクト名/Files/subject_area_temp/ファイル名
			$excelService->uploadFile($this->form->image_data, $filedir, $_SESSION ['Subject_Area_File']);
			$this->dispatch('ExcelSubjectAreaList/viewExcelList');

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

		$imagedir = FILE_DIR."/" . SUBJECT_AREA_FOLDER_NAME. "/";

		//アップロードしたエクセルファイルをアクセスする
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir.$_SESSION ['Subject_Area_File']);

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
			$this->smarty->assign( 'db_org_name', '' );
			$this->smarty->assign( 'org_name_flg', '' );
			$this->smarty->display ( 'excelSubjectAreaList.html' );
			return;

		}else {

			// 領域を2次元配列として取得する
			$range = 'A1:'. 'G' . $hrow;
			$title_range = 'A1:'. 'G' . 1;

			$sheet->getStyle('E2:E'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
			$sheet->getStyle('D2:D'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);

			$dataTitle = $sheet->rangeToArray($title_range);
			$dataArray = $this->changeDataArray($sheet->rangeToArray($range),$sheet,$hrow);

			$title_arr = unserialize (SUBJECT_AREA_HEADER_LIST);
			$this->smarty->assign ( 'dataArray', $dataArray );

			$title_flg = 1;
			$col_flg = 1;

			// 列数を確認する
			if ( $hcol != 'G' && $hcol != 'H' ) {

				$col_flg = 0;
			}

			if ( $col_flg == 1 ) {

				// タイトルが間違いがどうか確認する
				for ( $i = 0; $i < 7; $i++ ) {

					if ( $dataTitle[0][$i] != $title_arr[$i] ) {

						$title_flg = 0;
					}
				}
			}

			// 教科のフォーマットファイルが間違っている時エラーメッセージを表示する
			if ( $col_flg == 0 || $title_flg == 0 ) {

				$error = sprintf(E026,"教科");
				$this->smarty->assign ( 'err_msg', $error );
				$this->smarty->assign ( 'dataArray', null );
				$this->smarty->assign ( 'db_org_name', '' );
				$this->smarty->assign ( 'org_name_flg', '' );
			}else{

				$dataArray = array_filter($dataArray, 'array_filter');
				$this->smarty->assign ( 'err_msg', '' );
				$this->smarty->assign ( 'dataArray', $dataArray );
				$org_service = new OrganizationService($this->pdo);
				$org_Data = $org_service->getOrgNoByOrgId(CommonUtil::htmlEntityDecode($dataArray[1][0]));
				$org_name_flg='0';

				if($org_Data != null){

					$org_name_flg='1';
					$this->smarty->assign('db_org_name',"組織名 - ".$org_Data->org_name);
				}else {

					$org_name_flg='0';
					$this->smarty->assign ( 'db_org_name',"組織名はありません。");
				}

				$this->smarty->assign('org_name_flg',$org_name_flg);
			}

			// メニュー情報を取得、セットする

			$this->setMenu();
			$this->form->file_name1 = $_SESSION ['File_Name'] ;
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->assign ( 'btn_flg', '1' );
			$this->smarty->assign('sub_area_max_count', SUBJECT_AREA_MAX_COUNT);
			$this->smarty->display ( 'excelSubjectAreaList.html' );
		}
	}

	/**
	 * エクセルダウンロード処理
	 */
	public function newExcelAction() {

		if ( $this->check_login () == true ) {

			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			$dir = FILE_DIR. "/" . EXCEL_FORMAT_FOLDER_NAME. "/";
			$file = $dir. SUBJECT_AREA_FILE_NAME;
			if ( file_exists($file) ){
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
				$this->dispatch('ExcelSubjectAreaList');
			}
		}else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 登録処理
	 */
	public function saveAction() {

		$subject_area_data= $this->form->subject_area_data;
		$subject_area_data= explode ( ',', $subject_area_data);
		$service = new Subject_AreaService($this->pdo);
		$subject_area_dto_list = array();

		//重複データが無い場合、
		for ( $i = 0; $i < count($subject_area_data); $i++ ) {
			$subject_area_dto= new M_Subject_AreaDto();
			$subject_area_dto->org_no = $this->form->org_no;
			$next_subject_area_no= $service->getNextId();
			$subject_area_no= $next_subject_area_no->id;
			$subject_area_dto->subject_area_no= $subject_area_no;
			$subject_area_dto->subject_area_name= CommonUtil::htmlEntityDecode($subject_area_data[$i+1]);
			$subject_area_dto->subject_area_name_kana= CommonUtil::htmlEntityDecode($subject_area_data[$i+2]);
			$start_period = CommonUtil::htmlEntityDecode($subject_area_data[$i+3]);
			$subject_area_dto->start_period = DateUtil::getYmd($start_period);
			$end_period = CommonUtil::htmlEntityDecode($subject_area_data[$i+4]);
			$subject_area_dto->end_period= DateUtil::changeEndDateFormat($end_period);
			$disp_no=CommonUtil::htmlEntityDecode($subject_area_data[$i+5]);
			$subject_area_dto->disp_no = ($disp_no=="")?'0':$disp_no;
			$subject_area_dto->remarks = CommonUtil::htmlEntityDecode($subject_area_data[$i+6]);
			$subject_area_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
			$subject_area_dto->creater_id = $_SESSION['admin_no'];
			$subject_area_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
			$subject_area_dto->updater_id = $_SESSION['admin_no'];;
			$subject_area_dto->del_flg = 0;
			$i = $i + 6;
			array_push($subject_area_dto_list,$subject_area_dto);
		}
		$result1 = $service->insertWithTran($subject_area_dto_list);
		// 登録処理が正常の場合、成功メーセジを表示する
		if ( $result1 == 1 ) {
			//登録完了
			$error = sprintf(I006, "教科", sizeof($subject_area_dto_list));
			$_SESSION ['regist_msg'] = $error;
			$this->dispatch('ExcelSubjectAreaList');
		}else {
			$error = sprintf(E007,'登録');
			$_SESSION ['regist_msg'] = $error ;
			$this->dispatch('ExcelSubjectAreaList');
		}

	}

	/**
	 * 重複チェック
	 */
	public function isValidAction(){

		if ( $this->check_login () == true ) {
			$subject_area_data= $this->form->subject_area_data;
			$subject_area_data= explode ( ',', $subject_area_data);

			if($this->OrgValidationAction($subject_area_data) || $this->duplicateCheckWoc($subject_area_data)){

				$this->form->file_name1 = $_SESSION ['File_Name'] ;
				$this->smarty->assign( 'form', $this->form );
				$this->smarty->assign( 'db_org_name', $this->form->db_org_name );
				$this->smarty->assign( 'org_name_flg', $this->form->org_name_flg );
				$this->smarty->assign ( 'btn_flg', '1' );
				$this->setFormData();
				$this->smarty->display ( 'excelSubjectAreaList.html' );
			}else{

				$this->saveAction();
			}
		}else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 組織チェック
	 */
	public function OrgValidationAction($subject_area_data){

		$org_id=$subject_area_data[0];
		$subarea_service = new OrganizationService( $this->pdo);
		$result = $subarea_service->getOrgNoByOrgId($org_id);

		if($result != ""){
			$valid_org=$result->org_no;
			$this->form->org_no = $valid_org;
		}else{

			$this->smarty->assign ( 'err_msg', E028 );
		}

		return $result== "";
	}

	/**
	 * 教科重複チェック
	 */
	public function duplicateCheckWoc($subject_area_data) {

		if ( $this->check_login () == true ) {

			if ($this->form->org_no !=""){
				$temp = 0;

				// 教科名重複チェック
				$subject_area_service = new Subject_AreaService($this->pdo);
				$count = 0;
				$subject_area_name= array("");
				$dup_arr = '';

				for ( $i = 0; $i < count($subject_area_data); $i++ ) {
					//HTMLエンティティを文字に変換とエスケープコンマ
					$subject_area_data[$i] =CommonUtil::htmlEntityDecode($subject_area_data[$i]);

					if ( ($i % 7) == 0 ){

						array_push($subject_area_name,CommonUtil::htmlEntityDecode($subject_area_data[$i+1]));
					}
				}
				for ( $i = 1; $i < count($subject_area_name); $i++ ) {

					$duplicate_result = $subject_area_service->checkedExistSubjectAreaInfo( $this->form->org_no,$subject_area_name[$i] );
					if ( count($duplicate_result) > 0 ){

						if ( $dup_arr == '' ){

							$dup_arr = '<div>'. $i ;
						}else {

							$dup_arr = $dup_arr .',' .'</div><div>' . $i ;
						}
						$temp = 1;
					}
				}
				$dup_arr = $dup_arr . '</div>';

				$_SESSION ['file'] = $this->form->file;

				if ( $temp > 0 ){

					$dup_msg = $dup_arr . '行目の教科名';
					$error = sprintf(E014,$dup_msg);
					$this->smarty->assign('sub_area_max_count', SUBJECT_AREA_MAX_COUNT);
					$this->smarty->assign( 'err_msg', $error );
				}

				return $temp > 0;
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
		$imagedir = FILE_DIR . "/" . SUBJECT_AREA_FOLDER_NAME. "/";
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir.$_SESSION ['Subject_Area_File']);

		$sheet = $spreadsheet->getActiveSheet();

		$hcol = $spreadsheet->setActiveSheetIndex(0)->getHighestDataColumn();
		$hrow = $spreadsheet->setActiveSheetIndex(0)->getHighestDataRow();

		// 領域を2次元配列として取得する
		$sheet->getStyle('D2:D'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$sheet->getStyle('E2:E'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);

		$range = 'A1:'. 'G' . $hrow;
		$dataArray =  $this->changeDataArray($sheet->rangeToArray($range),$sheet,$hrow);
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
				$key1='D'.$row;
				$key2='E'.$row;
				// 利用開始
				if($sheet->getCell($key1)->getFormattedValue()!=""){
					if(!(DateUtil::isValidDateFormat($sheet->getCell($key1)->getFormattedValue()) || DateUtil::isValidDateFormat($sheet->getCell($key1)->getValue()))){
						$resVal=$sheet->getCell($key1)->getValue();
						$dataArray[$row-1][3]=(preg_match('/^[0-9]{8}$/i',$resVal))?(substr($resVal,0,4).'-'.substr($resVal,4,2).'-'.substr($resVal,6,2)):$resVal;
					}
				}
				//利用終了
				if($sheet->getCell($key2)->getFormattedValue()!=""){
					if(!(DateUtil::isValidDateFormat($sheet->getCell($key2)->getFormattedValue()) || DateUtil::isValidDateFormat($sheet->getCell($key2)->getValue()))){
						$resVal=$sheet->getCell($key2)->getValue();
						$dataArray[$row-1][4]=(preg_match('/^[0-9]{8}$/i',$resVal))?(substr($resVal,0,4).'-'.substr($resVal,4,2).'-'.substr($resVal,6,2)):$resVal;
					}
				}
			}
		}
		$dataArray=array_values($dataArray);
		return $dataArray;
	}

}