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
require_once 'service/LessonGroupService.php';
require_once 'service/OrganizationService.php';
require_once 'dto/M_Lesson_TargetDto.php';
//excell関係
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

/**
 * レッスン・グループエクセル読み込むコントローラー
 */
class ExcelLessonGroupListController extends BaseController {

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
				$this->smarty->display ( 'excelLessonGroupList.html' );
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
			$admin_no= $_SESSION ['admin_no'];
			//ファイル名をセッションに追加
			$_SESSION ['File_Name'] = $file_name;
			//サーバに保存するエクセルファイルパス・　運用管理者番号/運用管理者ログインID/日付
			$_SESSION ['LessGp_File'] = $admin_no . "_" . $admin_id. "_" . DateUtil::getDate ( 'YmdHis' ) . "_" . $file_name;
			//エクセルファイルディレクトリ
			$filedir = FILE_DIR. LESSGP_FOLDER_NAME. "/";
			//プロジェクト名/Files/ExcelSample/ファイル名
			$excelService->uploadFile($this->form->file_data, $filedir, $_SESSION ['LessGp_File']);
			$this->dispatch('ExcelLessonGroupList/viewExcelList');
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
			$filedir = FILE_DIR. LESSGP_FOLDER_NAME . "/";

			//アップロードしたエクセルファイルをアクセスする
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filedir.$_SESSION ['LessGp_File']);

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
				$this->smarty->display ( 'excelLessonGroupList.html' );
				return;
			} else {
				// 領域を2次元配列として取得する
				$range = 'A1:'. $hcol . $hrow;
				$title_range = 'A1:'. $hcol . 1;
				$dataTitle = $sheet->rangeToArray($title_range);
				$dataArray = $sheet->rangeToArray($range);
				$title_arr = unserialize (LESSGP_HEADER_LIST);
				$title_flg = 1;
				$col_flg = 1;
				//列数を確認する
				if ( $hcol != 'C' ) {
					$col_flg = 0;
				}
				if ( $col_flg == 1 ) {
					//タイトルが間違いがどうか確認する
					for ( $i = 0; $i < 3; $i++ ) {
						if ( $dataTitle[0][$i] != $title_arr[$i] ) {
							$title_flg = 0;
						}
					}
				}
				//レッスン・グループのフォーマットファイルが間違っている時エラーメッセージを表示する
				if ( $col_flg == 0 || $title_flg == 0 ) {
					$msg=sprintf(E026,"レッスンとグループ");
					$this->smarty->assign ( 'err_msg',$msg);
					$this->smarty->assign ( 'dataArray', null );
				} else {
					$org_service = new OrganizationService($this->pdo);
					$org_Data = $org_service->getOrgNoByOrgId(CommonUtil::htmlEntityDecode($dataArray[1][0]));
					$dataArray = array_filter($dataArray, 'array_filter');
					$db_org_id='';
					$db_org_name='';
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
				$this->form->file = $_SESSION ['LessGp_File'];
				$this->form->file_name = $_SESSION ['File_Name'];
				$this->smarty->assign ( 'btn_flg', '1' );
				$this->smarty->assign('lessgp_max_count', LESSGP_MAX_COUNT);
				$this->smarty->assign ( 'form', $this->form );
				$this->smarty->display ( 'excelLessonGroupList.html' );
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
			$file = $dir. LESSGP_FILE_NAME;
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
				$this->dispatch('ExcelLessonGroupList');
			}
		} else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			LogHelper::logDebug('newExcel');
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * レッスン・グループの重複チェック
	 */
	public function duplicateCheckWocAction() {

		if ( $this->check_login () == true ) {
			$org_no =  $this->form->org_no;
			$temp = 0;
			$temp_msg="";
			$temp_msg_code='';
			$lessgp_service = new LessonGroupService($this->pdo);
			$count = 0;
			$lessgp_data = $this->form->lessgp_data;
			$lessgp = explode ( ',', $lessgp_data);
			$lesssonname =array();
			$group_name = array();
			$dup_arr = '';
			$dup_arr_gp="";
			$dup_arr_grade="";
			for ( $i = 0; $i < count($lessgp); $i++ ) {
				//HTMLエンティティを文字に変換とエスケープコンマ
				$lessgp[$i] =CommonUtil::htmlEntityDecode($lessgp[$i]);
				//レッスン名の重複チェックを行う。
				if( ($i % 3) == 1){
					array_push($lesssonname,$lessgp[$i]);
				}
				//ファイルに学年がある場合、存在チェックを行う。
				if( ($i % 3) == 2){
					array_push($group_name,$lessgp[$i]);
				}
			}
			//レッスン名があるかどうかをチェック
			$lArr=array();
			for ( $i = 0; $i < count($lesssonname); $i++ ) {
				$duplicate_result = $lessgp_service->getLessonListByName($this->form->org_no,$lesssonname[$i] );
				if(count($duplicate_result) <= 0) {
					if($dup_arr == ''){
						$dup_arr = $i+1;
					}else{
						$dup_arr = $dup_arr . ',' . ($i+1);
					}
					$temp = 1;
					$dup_msg=$dup_arr .'行目のレッスン名';
					$error = sprintf(E029,$dup_msg);
				}else{
					$getKey=$lesssonname[$i].$group_name[$i];
					$lArr[$getKey][]=$duplicate_result;
					$this->form->less_data=$lArr;
				}
			}
			if($temp === 0){
				$gArr=array();
				//グループの有効期間のチェックを行う。
				for ( $i = 0; $i < count($group_name); $i++ ) {
					$getKey=$lesssonname[$i].$group_name[$i];
					$lessD=$this->form->less_data[$getKey][0];
					$duplicate_result = $lessgp_service->getLessonGpSearchList($this->form->org_no,$lessD[0]->lesson_no,$group_name[$i] );
					if(count($duplicate_result) <= 0) {
						if($dup_arr_gp== ''){
							$dup_arr_gp= $i+1;
						}else{
							$dup_arr_gp= $dup_arr_gp. ',' . ($i+1);
						}
						$temp = 1;
						$dup_msg=$dup_arr_gp.'行目のグループ名';
						$error = sprintf(E029,$dup_msg);
					}else{
						$gArr[$getKey][]=$duplicate_result;
						$this->form->group_data=$gArr;
						if($lessD[0]->grade_no!==0){
							if ($lessD[0]->grade_no !== $duplicate_result[0]->grade_no) {
								if($dup_arr_grade== ''){
									$dup_arr_grade= $i+1;
								}else{
									$dup_arr_grade= $dup_arr_grade. ',' . ($i+1);
								}
								$temp = 1;
								$dup_msg=$dup_arr_grade.'行目のレッスン名の学年とグループ名の学年が一致していません。';
								$error = $dup_msg;
							}
						}
						//レッスン・グループテーブルで登録する前、重複チェック処理-20190425修正
						$duplicate_lessGP = $lessgp_service->lessonTargetCount($this->form->org_no,$lessD[0]->lesson_no,$duplicate_result[0]->group_no);
						LogHelper::logDebug("lessonTarget Duplicate Count........." . count($duplicate_lessGP) );
						if(count($duplicate_lessGP) > 0 ){
							if($dup_arr_lessGP== ''){
							$dup_arr_lessGP= $i+1;
						}else{
							$dup_arr_lessGP= $dup_arr_lessGP. ',' . ($i+1);
						}
						$temp = 1;
						$dup_msg=$dup_arr_lessGP.'行目のレッスンとグループが重複しています。';
						$error = $dup_msg;
						}
					}
				}
			}
			$_SESSION ['file'] = $this->form->file;
			$org_no = $this->form->org_no;
			$this->smarty->assign( 'form', $this->form );
			if( $temp > 0){
				$this->setFormData();
				$this->smarty->assign ( 'btn_flg', '1' );
				$this->smarty->assign( 'err_msg', $error );
				$this->smarty->assign('lessgp_max_count', LESSGP_MAX_COUNT);
				$this->smarty->display( 'excelLessonGroupList.html' );
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
			$lessgp_data = $this->form->lessgp_data;
			$lessongp = explode ( ',', $lessgp_data);
			$org_no = $this->form->org_no;
			$lessgp_service = new LessonGroupService($this->pdo);
			$resultList=array();
			$rowcount=0;
			//重複データが無い場合、
			for ( $i = 0; $i < count($lessongp); $i++ ) {
				$rowcount=$rowcount+1;
				$getKey=CommonUtil::htmlEntityDecode($lessongp[$i+1]).CommonUtil::htmlEntityDecode($lessongp[$i+2]);
				$lessData=$this->form->less_data;
				$gpData=$this->form->group_data;
				$lesson_no=$lessData[$getKey][0][0]->lesson_no;//レッスン管理№
				$group_no=$gpData[$getKey][0][0]->group_no;
				// レッスンデータ情報登録
				$lessonT_dto = new M_Lesson_TargetDto();
				$lessonT_dto->org_no=$this->form->org_no;//組織管理№
				$lessonT_dto->lesson_no= $lesson_no;//レッスン管理№
				$lessonT_dto->group_no=$group_no;//グループ№
				$lessonT_dto->del_flg='0';//削除フラグ
				$lessonT_dto->create_dt=DateUtil::getDate('Y/m/d H:i:s');//登録日時
				$lessonT_dto->creater_id=$_SESSION['admin_no'];//登録者ＩＤ
				$lessonT_dto->update_dt=DateUtil::getDate('Y/m/d H:i:s');//更新日時
				$lessonT_dto->updater_id=$_SESSION['admin_no'];//更新者ＩＤ
				$i = $i +2;
				$resultList[]=$lessonT_dto;
			}
			//レッスン・グループリスト情報を登録する
			$result1 = $lessgp_service->insertData($resultList);
			// 登録処理が正常の場合、成功メーセジを表示する
			if ( $result1 == 1 ) {
				//登録完了
				$error = sprintf("%sデータ%s行を登録しました。", "レッスンとグループ", $rowcount);
				$_SESSION ['regist_msg'] = $error;
				$this->dispatch('ExcelLessonGroupList');
				// 登録出来ない場合,エーラーメーセジを表示する
			}else {
				$error = sprintf(E007,'登録');
				$_SESSION ['regist_msg'] = $error;
				$this->dispatch('ExcelLessonGroupList');
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
		$imagedir = FILE_DIR. LESSGP_FOLDER_NAME. "/";
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir . $file);

		$sheet = $spreadsheet->getActiveSheet();

		$hcol = $spreadsheet->setActiveSheetIndex(0)->getHighestDataColumn();
		$hrow = $spreadsheet->setActiveSheetIndex(0)->getHighestDataRow();

		// 領域を2次元配列として取得する
		$range = 'A1:'. $hcol . $hrow;
		$dataArray = $sheet->rangeToArray($range);
		$dataArray = array_filter($dataArray, 'array_filter');
		$this->smarty->assign ( 'dataArray', $dataArray );
		$this->smarty->assign ( 'db_org_name', $this->form->db_org_name );

	}

}
?>