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
require_once 'service/LessonService.php';
require_once 'service/OrganizationService.php';
require_once 'dto/M_LessonDto.php';
require_once 'dto/M_Lesson_ManagerDto.php';

//excell関係
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

/**
 * レッスンエクセル読み込むコントローラー
 */
class ExcelLessonListController extends BaseController {

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
			$this->smarty->display ( 'excelLessonList.html' );
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
			$_SESSION ['Less_File'] = $admin_no . "_" . $admin_id. "_" . DateUtil::getDate ( 'YmdHis' ) . "_" . $file_name;
            //エクセルファイルディレクトリ
			$filedir = FILE_DIR.LESS_FOLDER_NAME. "/";
			//プロジェクト名/files/lesson_tmp/ファイル名
			$excelService->uploadFile($this->form->file_data, $filedir, $_SESSION ['Less_File']);
			$this->dispatch('ExcelLessonList/viewExcelList');
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
			$filedir = FILE_DIR. LESS_FOLDER_NAME . "/";

			//アップロードしたエクセルファイルをアクセスする
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filedir.$_SESSION ['Less_File']);

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
				$this->smarty->display ( 'excelLessonList.html' );
				return;
			} else {
				// 領域を2次元配列として取得する
				$range = 'A1:'. $hcol . $hrow;
				$title_range = 'A1:'. $hcol . 1;
				$sheet->getStyle('E2:E'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
				$sheet->getStyle('F2:F'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
				$dataTitle = $sheet->rangeToArray($title_range);
				$dataArray = $this->changeDataArray($sheet->rangeToArray($range),$sheet,$hrow);
				$title_arr = unserialize (LESS_HEADER_LIST);
				$title_flg = 1;
				$col_flg = 1;
				//列数を確認する
				if ( $hcol != 'U' ) {
					$col_flg = 0;
				}
				if ( $col_flg == 1 ) {
					//タイトルが間違いがどうか確認する
					for ( $i = 0; $i < 21; $i++ ) {
						if ( $dataTitle[0][$i] != $title_arr[$i] ) {
							$title_flg = 0;
						}
					}
				}
				//レッスンのフォーマットファイルが間違っている時エラーメッセージを表示する
				if ( $col_flg == 0 || $title_flg == 0 ) {
					$msg=sprintf(E026,"レッスン");
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
				$this->form->file = $_SESSION ['Less_File'];
				$this->form->file_name = $_SESSION ['File_Name'];
				$this->smarty->assign ( 'btn_flg', '1' );
				$this->smarty->assign('less_max_count', LESS_MAX_COUNT);
				$this->smarty->assign ( 'form', $this->form );
				$this->smarty->display ( 'excelLessonList.html' );
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
			$dir = FILE_DIR. EXCEL_FORMAT_FOLDER_NAME . "/";
			$file = $dir. LESS_FILE_NAME;
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
				$this->dispatch('ExcelLessonList');
			}
		} else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			LogHelper::logDebug('newExcel');
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * レッスン項目重複チェック
	 */
	public function duplicateCheckWocAction() {

		if ( $this->check_login () == true) {
			$org_no =  $this->form->org_no;
			$temp = 0;
			$temp_msg="";
			$temp_msg_code='';
			//クイズ名重複チェック
			$less_service = new LessonService($this->pdo);
			$count = 0;
			$less_data = $this->form->less_data;
			$less = explode ( ',', $less_data);
			$name =array();
			$grade_no = array();
			$subject_no =array();
			$subject_no_manager = array();
			$dup_arr_lesson = '';
			$dup_arr_grade = '';
			$dup_arr_subj = '';
			$dup_arr_subj_admin = '';
			for ( $i = 0; $i < count($less); $i++ ) {
				//HTMLエンティティを文字に変換とエスケープコンマ
				$less[$i] =CommonUtil::htmlEntityDecode($less[$i]);
				//レッスン名の重複チェックを行う。
				if( ($i % 21) == 1){
					array_push($name,$less[$i]);
				}
				//ファイルに学年がある場合、存在チェックを行う。
				if( ($i % 21) == 3){
					array_push($grade_no,$less[$i]);
				}
				//ファイルの科目の存在チェックを行う。
				if( ($i % 21) == 6){
					array_push($subject_no,$less[$i]);
				}
				if( ($i % 21) ==9 || ($i % 21) ==10 || ($i % 21) ==11 || ($i % 21) ==12 || ($i % 21) ==13 || ($i % 21) ==14 ||
						($i % 21) ==15 || ($i % 21) ==16 || ($i % 21) ==17 || ($i % 21) ==18 || ($i % 21) ==19 || ($i % 21) == 20){
					if($less[$i] !== ""){
						$smkey=$name[count($name)-1].$subject_no[count($subject_no)-1];
						$subject_no_manager[$smkey][]=$less[$i];
					}
				}
			}
			//レッスン名の重複チェックを行う。
			for ( $i = 0; $i < count($name); $i++ ) {
				$duplicate_result = $less_service->checkedLessonExistInfo($this->form->org_no,$name[$i] );
				if($duplicate_result > 0) {
					if($dup_arr_lesson== ''){
						$dup_arr_lesson= $i+1;
					}else{
						$dup_arr_lesson= $dup_arr_lesson. ',' . ($i+1);
					}
					$temp = 1;
					$dup_msg=$dup_arr_lesson.'行目のレッスン名';
					$error = sprintf(E014,$dup_msg);
				}
			}
			if($temp === 0){
				$gArr=array();
				//ファイルに学年がある場合、存在チェックを行う。
				for ( $i = 0; $i < count($grade_no); $i++ ) {
					if($grade_no[$i]!==""){
						$duplicate_result = $less_service->getGradetListByName( $this->form->org_no,$grade_no[$i] );
						if(count($duplicate_result)<= 0) {
							if($dup_arr_grade== ''){
								$dup_arr_grade= $i+1;
							}else{
								$dup_arr_grade= $dup_arr_grade. ',' . ($i+1);
							}
							$temp = 1;
							$dup_msg=$dup_arr_grade.'行目の学年';
							$error = sprintf(E029,$dup_msg);
						}else{
							$getKey=$name[$i].$grade_no[$i];
							$gArr[$getKey][]=$duplicate_result;
							$this->form->grade_data=$gArr;
						}
					}
				}
			}
			if($temp === 0){
				//ファイルの科目の存在チェックを行う。
				$sArr=array();
				for ( $i = 0; $i < count($subject_no); $i++ ) {
					$duplicate_result = $less_service->getSubjectListByName( $this->form->org_no,$subject_no[$i] );
					if(count($duplicate_result) <= 0) {
						if($dup_arr_subj== ''){
							$dup_arr_subj= $i+1;
						}else{
							$dup_arr_subj= $dup_arr_subj. ',' . ($i+1);
						}
						$temp = 1;
						$dup_msg=$dup_arr_subj.'行目の科目';
						$error = sprintf(E029,$dup_msg);
					}else{
						$getKey=$name[$i].$subject_no[$i];
						$sArr[$getKey][]=$duplicate_result;
						$this->form->subject_data=$sArr;
					}
				}
			}
			if($temp === 0){
				//ファイルの科目の担当者の存在チェックを行う。
				$lsArr=array();
				for ( $i = 0; $i < count($subject_no); $i++ ) {
					$getKey=$name[$i].$subject_no[$i];
					if (array_key_exists($getKey,$subject_no_manager)){
						$mLoginIdArr=$subject_no_manager[$getKey];
						$subject=$this->form->subject_data[$getKey][0];
						$duplicate_result = $less_service->getManagerListBySubject( $this->form->org_no,$subject[0]->subject_no,$mLoginIdArr);
						if(count($duplicate_result)<=0) {
							if($dup_arr_subj_admin== ''){
								$dup_arr_subj_admin= $i+1;
							}else{
								$dup_arr_subj_admin= $dup_arr_subj_admin. ',' . ($i+1);
							}
							$temp = 1;
							$dup_msg=$dup_arr_subj_admin.'行目の担当者';
							$error = sprintf(E029,$dup_msg);
						}else{
							$lsArr[$getKey][]=$duplicate_result;
							$this->form->less_data_sm=$lsArr;
						}
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
				$this->smarty->assign('less_max_count', LESS_MAX_COUNT);
				$this->smarty->display( 'excelLessonList.html' );
			}elseif($this->form->org_no==""){
				$this->setFormData();
				$this->smarty->assign( 'err_msg', E028);
				$this->smarty->assign ( 'btn_flg', '1' );
				$this->smarty->assign('less_max_count', LESS_MAX_COUNT);
				$this->smarty->display( 'excelLessonList.html' );
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
			$less_data = $this->form->less_data;
			$lesson = explode ( ',', $less_data);
			$org_no = $this->form->org_no;
			$less_service = new LessonService($this->pdo);
			$grade_data=$this->form->grade_data;
			$subject_data=$this->form->subject_data;
			$less_data_sm=$this->form->less_data_sm;
			//重複データが無い場合、
			for ( $i = 0; $i < count($lesson); $i++ ) {
				$lessname=CommonUtil::htmlEntityDecode($lesson[$i+1]);
				$lessnamekana=CommonUtil::htmlEntityDecode($lesson[$i+2]);
				$lessgrade=CommonUtil::htmlEntityDecode($lesson[$i+3]);
				$lesssubject=CommonUtil::htmlEntityDecode($lesson[$i+6]);
				$gradeKey=$lessname.$lessgrade;
				$subjectKey=$lessname.$lesssubject;
				$status=CommonUtil::htmlEntityDecode($lesson[$i+7]);
				$start_period=DateUtil::getYmd(CommonUtil::htmlEntityDecode($lesson[$i+4]));
				$end_period=DateUtil::changeEndDateFormat(CommonUtil::htmlEntityDecode($lesson[$i+5]));
				// レッスンデータ情報登録
				$lesson_dto = new M_LessonDto();
				$lesson_dto->org_no=$this->form->org_no;//組織管理№
				$next_lesson_no = $less_service->getNextLessonNo();
				$lesson_no = $next_lesson_no->id;
				$lesson_dto->lesson_no= $lesson_no;//レッスン管理№
				$lesson_dto->lesson_name=$lessname;//レッスン名
				$lesson_dto->lesson_name_kana=$lessnamekana;//レッスン名ふりがな
				if(array_key_exists($gradeKey,$grade_data)){//学年管理№
					$lesson_dto->grade_no= $grade_data[$gradeKey][0][0]->grade_no;
				}
				$lesson_dto->subject_no= $subject_data[$subjectKey][0][0]->subject_no;//科目管理№
				$lesson_dto->attendance_flg='0';//出欠対象
				$lesson_dto->lesson_count='0';//レッスン回数
				$lesson_dto->status=($status=="する")?'1':'0';//状態
				$lesson_dto->start_period=$start_period;//利用開始日
				$lesson_dto->end_period=$end_period;//利用終了日
				$lesson_dto->remarks=CommonUtil::htmlEntityDecode($lesson[$i+8]);//更新備考
				$lesson_dto->del_flg='0';//削除フラグ
				$lesson_dto->create_dt=DateUtil::getDate('Y/m/d H:i:s');//登録日時
				$lesson_dto->creater_id=$_SESSION['admin_no'];//登録者ＩＤ
				$lesson_dto->update_dt=DateUtil::getDate('Y/m/d H:i:s');//更新日時
				$lesson_dto->updater_id=$_SESSION['admin_no'];//更新者ＩＤ
				//Ｍレッスン担当$manager_less_list
				$lm_arr_res=array();
				$lm_arr=array();
				if(array_key_exists($subjectKey,$less_data_sm)){
					$lm_arr=$less_data_sm[$subjectKey][0];
					for($j=0;$j<count($lm_arr);$j++){
						$lm_dto = new M_Lesson_ManagerDto();
						$lm_dto->org_no=$this->form->org_no;//組織管理№
						$lm_dto->lesson_no=$lesson_no;//レッスン管理№
						$lm_dto->manager_no=$lm_arr[$j][0]->manager_no;
						$lm_dto->del_flg='0';//削除フラグ
						$lm_dto->create_dt=DateUtil::getDate('Y/m/d H:i:s');//登録日時
						$lm_dto->creater_id=$_SESSION['admin_no'];//登録者ＩＤ
						$lm_dto->update_dt=DateUtil::getDate('Y/m/d H:i:s');//更新日時
						$lm_dto->updater_id=$_SESSION['admin_no'];//更新者ＩＤ
						$lm_arr_res[]=$lm_dto;
					}
				}
				$i = $i + 20;

				// レッスンリスト情報を登録する
				$result1 = $less_service->insertData($lesson_dto,$lm_arr_res);

				// 登録処理が正常の場合、成功メーセジを表示する
				if ( $result1 == 1 ) {
					//登録完了
					$count = $count + 1;
					$error = sprintf("%sデータ%s行を登録しました。", "レッスン", $count);
					$_SESSION ['regist_msg'] = $error;
					$this->dispatch('ExcelLessonList');
					// 登録出来ない場合,エーラーメーセジを表示する
				}else {
					$error = sprintf(E007,'登録');
					$this->smarty->assign ( 'error', $error );
					$_SESSION ['regist_msg'] = $error;
					$this->dispatch('ExcelLessonList');
				}
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
		$imagedir = FILE_DIR. LESS_FOLDER_NAME. "/";
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
		for ($row = 2; $row < $hrow; $row++){
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