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
require_once 'service/ExcelService.php';
require_once 'service/OrganizationService.php';
require_once 'service/SubjectService.php';
require_once 'dto/M_SubjectDto.php';
//excell関係
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

/**
 * 科目エクセル読み込むコントローラー
 */
class ExcelSubjectListController extends BaseController {

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
				$this->smarty->display ( 'excelSubjectList.html' );
			} else {
				// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
				TransitionHelper::sendException ( E002 );
				return;
			}
	}

	/*
	 *
	 * 表示ボタンイベント
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
			//ファイル名をセッションに追加
			$_SESSION ['File_Name'] = $file_name;
			//サーバに保存するエクセルファイルパス・　運用管理者番号/運用管理者ログインID/日付
			$_SESSION ['Subj_File'] = $admin_no . "_" . $admin_id. "_". DateUtil::getDate ( 'YmdHis' ) . "_" . $file_name;
			//エクセルファイルディレクトリ
			$filedir = FILE_DIR. "/" . SUBJ_FOLDER_NAME. "/";
			//プロジェクト名/Files/subject_temp/ファイル名
			$excelService->uploadFile($this->form->file_data, $filedir, $_SESSION ['Subj_File']);
			$this->dispatch('ExcelSubjectList/viewExcelList');
		} else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * エクセル描画処理
	 */
	public function viewExcelListAction() {
		if ( $this->check_login () == true ) {

			$filedir = FILE_DIR. "/" . SUBJ_FOLDER_NAME . "/";

			//アップロードしたエクセルファイルをアクセスする
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filedir.$_SESSION ['Subj_File']);

			//エクセルファイルのアクティブシートを取る
			$sheet = $spreadsheet->getActiveSheet();
			//エクセルファイルにデータが有る最後のカラムと行を取る
			$hcol = $spreadsheet->setActiveSheetIndex(0)->getHighestDataColumn();
			$hrow = $spreadsheet->setActiveSheetIndex(0)->getHighestDataRow();
			$this->form->admin_no = $_SESSION ['admin_no'];
			//エクセルファイルにデータが有るかどうかチェックする
			if ( $hcol == 'A' || $hrow <= 1 ) {
				//エクセルファイルにデータが無いの場合、
				$error = sprintf('Error!!! Empty File.');
				$this->smarty->assign ( 'err_msg', $error );
				$this->smarty->assign('form', $this->form);
				$this->smarty->display ( 'excelSubjectList.html' );
				return;
			} else {
				// 領域を2次元配列として取得する
				$range = 'A1:'. $hcol . $hrow;
				$title_range = 'A1:'. $hcol . 1;
				$sheet->getStyle('E2:E'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
				$sheet->getStyle('F2:F'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
				$dataTitle = $sheet->rangeToArray($title_range);
				$dataArray = $this->changeDataArray($sheet->rangeToArray($range),$sheet,$hrow);
				$title_arr = unserialize (SUBJ_HEADER_LIST);
				$title_flg = 1;
				$col_flg = 1;
				//列数を確認する
				if ( $hcol != 'H' ) {
					$col_flg = 0;
				}
				if ( $col_flg == 1 ) {
					//タイトルが間違いがどうか確認する
					for ( $i = 0; $i < 8; $i++ ) {
						if ( $dataTitle[0][$i] != $title_arr[$i] ) {
							$title_flg = 0;
						}
					}
				}
				//科目のフォーマットファイルが間違っている時エラーメッセージを表示する
				if ( $col_flg == 0 || $title_flg == 0 ) {
					$msg=sprintf(E026,"科目登録");
					$this->smarty->assign ( 'err_msg',$msg);
					$this->smarty->assign ( 'dataArray', null );
				} else {
					$org_service = new OrganizationService($this->pdo);
					$org_Data = $org_service->getOrgNoByOrgId(CommonUtil::htmlEntityDecode($dataArray[1][0]));
					$db_org_id='';
					$db_org_name='';
					$dataArray = array_filter($dataArray, 'array_filter');
					if($org_Data != null){
						$db_org_id=$org_Data->org_id;
						$db_org_name=$org_Data->org_name;
						$this->form->org_no = $org_Data->org_no;
						$this->form->db_org_id= $db_org_id;
						$this->form->db_org_name= $db_org_name;
					}
					$this->smarty->assign ( 'db_org_id',$db_org_id);
					$this->smarty->assign ( 'db_org_name',$db_org_name);
					$this->smarty->assign ( 'err_msg', '' );
					$this->smarty->assign ( 'dataArray',$dataArray);
				}
				// メニューが開くかどうかを確認する
				$this->setMenu();
				$this->form->file = $_SESSION ['Subj_File'];
				$this->form->file_name = $_SESSION ['File_Name'];
				$this->smarty->assign ( 'btn_flg', '1' );
				$this->smarty->assign('subj_max_count', SUBJ_MAX_COUNT);
				$this->smarty->assign ( 'form', $this->form );
				$this->smarty->display ( 'excelSubjectList.html' );
			}
		} else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * ダウンロード処理
	 */
	public function newExcelWocAction() {
		if ( $this->check_login () == true ) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			$dir = FILE_DIR. "/" . EXCEL_FORMAT_FOLDER_NAME . "/";
			$file = $dir. SUBJ_FILE_NAME;
			if ( file_exists($file) ){
				header('Content-Disposition: attachment; filename='.basename($file));
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file));
				ob_clean();
				flush();
				readfile($file);
				$this->setMenu();
				exit;
			}else {
				$error = sprintf( E030 );
				$this->smarty->assign ( 'error', $error );
				$_SESSION ['regist_msg'] = $error;
				$this->dispatch('ExcelSubjectList');
			}
		} else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			LogHelper::logDebug('newExcel');
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 科目重複チェック
	 */
	public function duplicateCheckWocAction() {

		if ( $this->check_login () == true ) {
			$org_no =  $this->form->org_no;
			$temp = 0;
			$temp_msg="";
			$temp_msg_code='';
			$subj_service = new SubjectService($this->pdo);
			$count = 0;
			$subj_data = $this->form->subj_data;
			$subj = explode ( ',', $subj_data);
			$subjname =array();
			$subj_area_name = array();
			$subj_start = array();
			$subj_end = array();
			$dup_arr = '';
			for ( $i = 0; $i < count($subj); $i++ ) {
				//HTMLエンティティを文字に変換とエスケープコンマ
				$subj[$i] =CommonUtil::htmlEntityDecode($subj[$i]);
				//科目名の重複チェックを行う。
				if( ($i % 8) == 1){
					array_push($subjname,$subj[$i]);
				}
				//ファイルに教科がある場合、存在チェックを行う。
				if( ($i % 8) == 3){
					array_push($subj_area_name,$subj[$i]);
				}
				
				if( ($i % 8) == 4){
					array_push($subj_start,$subj[$i]);
				}
				
				if( ($i % 8) == 5){
					array_push($subj_end,$subj[$i]);
				}
			}
			//科目名の重複チェックを行う。
			for ( $i = 0; $i < count($subjname); $i++ ) {
				$duplicate_result = $subj_service->checkedExistInfo($this->form->org_no,$subjname[$i] );
				if($duplicate_result> 0) {
					if($dup_arr == ''){
						$dup_arr = $i+1;
					}else{
						$dup_arr = $dup_arr . ',' . ($i+1);
					}
					$temp = 1;
					$dup_msg=$dup_arr .'行目の科目名';
					$error = sprintf(E014,$dup_msg);
				}
			}
			if($temp === 0){
				$saArr=array();
				//教科の有効期間のチェックを行う。
				for ( $i = 0; $i < count($subj_area_name); $i++ ) {
					$start_dt = $subj_start[$i];
					$end_dt = $subj_end[$i];
					$duplicate_result = $subj_service->getSubjectAreaListForCheck( $this->form->org_no, $subj_area_name[$i] , $start_dt , $end_dt);
					if(count($duplicate_result) <= 0) {
						if($dup_arr == ''){
							$dup_arr = $i+1;
						}else{
							$dup_arr = $dup_arr . ',' . ($i+1);
						}
						$temp = 1;
						$dup_msg=$dup_arr .'行目の教科';
						$error = sprintf(E029,$dup_msg);
					}else{
						$getKey=$subjname[$i];
						$saArr[$getKey][]=$duplicate_result;
						$this->form->subj_area_data=$saArr;
					}
				}
			}
			$_SESSION ['file'] = $this->form->file;
			$org_no = $this->form->org_no;
			$this->smarty->assign( 'form', $this->form );
			if( $temp > 0){
				$this->setFormData();
				$this->smarty->assign( 'err_msg', $error );
				$this->smarty->assign ( 'btn_flg', '1' );
				$this->smarty->assign('subj_max_count', SUBJ_MAX_COUNT);
				$this->smarty->display( 'excelSubjectList.html' );
			}else{
				$this->saveAction();
			}
		}else{
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
		}

	}

	/**
	 * 登録処理
	 */
	public function saveAction() {

		if ( $this->check_login () == true) {
			$subj_data = $this->form->subj_data;
			$subj = explode ( ',', $subj_data);
			$org_no = $this->form->org_no;
			$subj_service = new SubjectService($this->pdo);
			$resultList=array();
			$rowcount=0;
			$saData=$this->form->subj_area_data;
			//重複データが無い場合、
			for ( $i = 0; $i < count($subj); $i++ ) {
				$rowcount=$rowcount+1;
				$start_period=DateUtil::getYmd(CommonUtil::htmlEntityDecode($subj[$i+4]));//利用開始日
				$end_period=DateUtil::changeEndDateFormat(CommonUtil::htmlEntityDecode($subj[$i+5]));//利用開始日
				$name=CommonUtil::htmlEntityDecode($subj[$i+1]);//科目名
				// 科目データ情報登録
				$subj_dto = new M_SubjectDto();
				$subj_dto->org_no=$this->form->org_no;//組織管理№
				$subj_dto->subject_area_no=$saData[$name][0][0]->subject_area_no;//教科管理№
				$next_subj_no = $subj_service->getNextSubjNo();
				$subj_dto->subject_no=$next_subj_no->id;//科目管理№
				$subj_dto->subject_name=$name;//科目名
				$subj_dto->subject_name_kana=CommonUtil::htmlEntityDecode($subj[$i+2]);//ふりがな
				$subj_dto->start_period=$start_period;//利用開始日
				$subj_dto->end_period=$end_period;//利用終了日
				$disp_no=CommonUtil::htmlEntityDecode($subj[$i+6]);
				$subj_dto->disp_no=($disp_no=="")?'0':$disp_no;//表示順
				$subj_dto->remarks=CommonUtil::htmlEntityDecode($subj[$i+7]);//備考
				$subj_dto->del_flg='0';//削除フラグ
				$subj_dto->create_dt=DateUtil::getDate('Y/m/d H:i:s');//登録日時
				$subj_dto->creater_id=$_SESSION['admin_no'];//登録者ＩＤ
				$subj_dto->update_dt=DateUtil::getDate('Y/m/d H:i:s');//更新日時
				$subj_dto->updater_id=$_SESSION['admin_no'];//更新者ＩＤ
				$i = $i +7;
				$resultList[]=$subj_dto;
			}
			// 科目リスト情報を登録する
			$result1 = $subj_service->insertData($resultList);
			// 登録処理が正常の場合、成功メーセジを表示する
			if ( $result1 == 1 ) {
				//登録完了
				$error = sprintf("%sデータ%s行を登録しました。", "科目", $rowcount);
				$_SESSION ['regist_msg'] = $error;
				$this->dispatch('ExcelSubjectList');
				// 登録出来ない場合,エーラーメーセジを表示する
			}else {
				$error = sprintf(E007,'登録');
				$_SESSION ['regist_msg'] = $error;
				$this->dispatch('ExcelSubjectList');
				return;
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
		$imagedir = FILE_DIR. "/" . SUBJ_FOLDER_NAME. "/";
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir . $file);

		$sheet = $spreadsheet->getActiveSheet();

		$hcol = $spreadsheet->setActiveSheetIndex(0)->getHighestDataColumn();
		$hrow = $spreadsheet->setActiveSheetIndex(0)->getHighestDataRow();
		$sheet->getStyle('E2:E'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$sheet->getStyle('F2:F'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);

		// 領域を2次元配列として取得する
		$range = 'A1:'. $hcol . $hrow;
		$dataArray = $this->changeDataArray($sheet->rangeToArray($range),$sheet,$hrow);
		$dataArray = array_filter($dataArray, 'array_filter');
		$this->smarty->assign ( 'dataArray', $dataArray );
		$this->smarty->assign ( 'db_org_name', $this->form->db_org_name );
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
				$key1='E'.$row;
				$key2='F'.$row;
				// 利用開始
				if($sheet->getCell($key1)->getFormattedValue()!=""){
					if(!(DateUtil::isValidDateFormat($sheet->getCell($key1)->getFormattedValue()) || DateUtil::isValidDateFormat($sheet->getCell($key1)->getValue()))){
						$resVal=$sheet->getCell($key1)->getValue();
						$dataArray[$row-1][4]=(preg_match('/^[0-9]{8}$/i',$resVal))?(substr($resVal,0,4).'-'.substr($resVal,4,2).'-'.substr($resVal,6,2)):$resVal;
					}
				}
				//利用終了
				if($sheet->getCell($key2)->getFormattedValue()!=""){
					if(!(DateUtil::isValidDateFormat($sheet->getCell($key2)->getFormattedValue()) || DateUtil::isValidDateFormat($sheet->getCell($key2)->getValue()))){
						$resVal=$sheet->getCell($key2)->getValue();
						$dataArray[$row-1][5]=(preg_match('/^[0-9]{8}$/i',$resVal))?(substr($resVal,0,4).'-'.substr($resVal,4,2).'-'.substr($resVal,6,2)):$resVal;
					}
				}
			}
		}
		$dataArray=array_values($dataArray);
		return $dataArray;
	}

}
?>