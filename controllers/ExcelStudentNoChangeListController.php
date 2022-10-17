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
require_once 'service/OrganizationService.php';
require_once 'service/StudentService.php';
require_once 'dto/T_StudentDto.php';
require_once 'service/ExcelService.php';

//excell関係
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

/**
 * 受講者番号更新コントローラー
 */
class ExcelStudentNoChangeListController extends BaseController {

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
			$this->smarty->display ( 'excelStudentNoChangeList.html' );
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
			$admin_no= $_SESSION ['admin_no'];
			//ファイル名をセッションに追加
			$_SESSION ['File_Name'] = $file_name;
			//サーバに保存するエクセルファイルパス・　運用管理者番号/運用管理者ログインID/日付
			$_SESSION ['StudentNoChange_File'] = $admin_no . "_" . $admin_id. "_" . DateUtil::getDate ( 'YmdHis' ) . "_" . $file_name;
			//エクセルファイルディレクトリ
			$filedir = FILE_DIR. "/" . STUDENT_NO_CHANGE_FOLDER_NAME. "/";
			//プロジェクト名/Files/Groupstudent_temp/ファイル名
			$excelService->uploadFile($this->form->image_data, $filedir, $_SESSION ['StudentNoChange_File']);
			$this->dispatch('ExcelStudentNoChangeList/viewExcelList');

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

		$imagedir = FILE_DIR. STUDENT_NO_CHANGE_FOLDER_NAME. "/";
		//アップロードしたエクセルファイルをアクセスする
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir.$_SESSION ['StudentNoChange_File']);

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
			$this->smarty->display ( 'excelStudentNoChangeList.html' );
			return;
		}else {

			// 領域を2次元配列として取得する
			$range = 'A1:'. 'E' . $hrow;
			$title_range = 'A1:'. 'E' . 1;

			$dataTitle = $sheet->rangeToArray($title_range);
			$dataArray = $sheet->rangeToArray($range);

			$dataArray = array_filter($dataArray, 'array_filter');
			$title_arr = unserialize (STUDENT_NO_CHANGE_HEADER_LIST);

			$title_flg = 1;
			$col_flg = 1;

			// 列数を確認する
			if ( $hcol != 'E' && $hcol != 'F' ) {

				$col_flg = 0;
			}

			if ( $col_flg == 1 ) {
				// タイトルが間違いがどうか確認する
				for ( $i = 0; $i < 4; $i++ ) {

					if ( $dataTitle[0][$i] != $title_arr[$i] ) {

						$title_flg = 0;
					}
				}
			}

			// 受講者番号更新のフォーマットファイルが間違っている時エラーメッセージを表示する
			if ( $col_flg == 0 || $title_flg == 0 ) {

				$error = sprintf(E026,"受講者番号更新");
				$this->smarty->assign ( 'err_msg', $error );
				$this->smarty->assign ( 'dataArray', null );
			}else {

				$this->smarty->assign ( 'err_msg', '' );
				$this->smarty->assign ( 'dataArray', $dataArray);

				$org_service = new OrganizationService($this->pdo);
				$org_Data = $org_service->getOrgNoByOrgId(CommonUtil::htmlEntityDecode($dataArray[1][0]));
				$org_name_flg = '0';

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
			// メニュー情報を取得、セットする
			$this->setMenu();
			$this->form->file_name = $_SESSION ['File_Name'] ;
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->assign ( 'btn_flg', '1' );
			$this->smarty->assign ('stunochg_max_count', STUDENT_NO_CHANGE_MAX_COUNT );
			$this->smarty->display ( 'excelStudentNoChangeList.html' );
		}
	}

	/**
	 * 登録処理
	 */
	public function saveAction() {

		if ( $this->check_login () == true ) {

			$org_no = $this->form->org_no;

			$student_no_change = $this->form->student_no_change;
			$stuno_data = explode ( ',', $student_no_change);

			$rowcount = 0;

			$student_service = new StudentService($this->pdo);
			$dto_list = array();

			// 重複データが無い場合、
			for ( $i = 0; $i < count($stuno_data); $i++ ) {

				$rowcount = $rowcount + 1;
				// 受講者番号更新
				$student_dto = new T_StudentDto();

				$student_dto->login_id = CommonUtil::htmlEntityDecode($stuno_data[$i+1]);
				$student_dto->no = CommonUtil::htmlEntityDecode($stuno_data[$i+3]);
				$student_dto->remarks = CommonUtil::htmlEntityDecode($stuno_data[$i+4]);
				$student_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
				$student_dto->updater_id = $_SESSION ['admin_no'];
				$dto_list[] = $student_dto;
				$i = $i + 4;
			}
			$result = $student_service->updateItemInfo($org_no, $dto_list);
			// 更新処理が正常の場合、成功メーセジを表示する
			if ( $result == 1 ) {
				// 登録完了
				$error = sprintf("%sデータ%s行を更新しました。", " 受講者番号", $rowcount);
				$_SESSION ['regist_msg'] = $error;
				$this->dispatch('ExcelStudentNoChangeList');
			}else {
				$error = sprintf(E007,'更新');
				$_SESSION ['regist_msg'] = $error;
				$this->dispatch('ExcelStudentNoChangeList');
				return;
			}
		}else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
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
			$file = $dir. STUDENT_NO_CHANGE_FILE_NAME;
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
				$this->dispatch('ExcelStudentNoChangeList');
			}
		}else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 受講者番号更新チェック
	 */
	public function duplicateCheckWocAction() {

		if ( $this->check_login () == true ) {

			$errtemp = 0;
			$student_no_change = $this->form->student_no_change;

			$stuno_data = explode ( ',', $student_no_change);

			$org_id = $stuno_data[0];
			$Orgservice = new OrganizationService($this->pdo);
			$org_result = $Orgservice->getOrgNoByOrgId($org_id);
			$this->form->org_no = $org_result->org_no;

			$stu_nameid = array("");

			for ( $i = 0; $i < count($stuno_data); $i++ ) {
				$stuno_data[$i] = CommonUtil::htmlEntityDecode($stuno_data[$i]);
				if ( ($i % 5) == 0 ){
					array_push($stu_nameid,CommonUtil::htmlEntityDecode($stuno_data[$i+1]));
					array_push($stu_nameid,CommonUtil::htmlEntityDecode($stuno_data[$i+2]));
				}
			}

			$student_service = new StudentService($this->pdo);

			$dup_arr_stu = '';
			$counter = 1;
			for ( $i = 1; $i < count($stu_nameid); $i++ ) {

				$Stu_List = array("");

				$Stu_List = $student_service->getSutdentByNameLoginId($org_result->org_no, $stu_nameid[$i], $stu_nameid[$i+1]);
				if ( empty($Stu_List) ){

					if ( $dup_arr_stu == '' ){

						$dup_arr_stu = $counter;
					}else {

						$dup_arr_stu = $dup_arr_stu. ',' . $counter;
					}
					$errtemp = 1;
				}

				$i = $i + 1;
				$counter = $counter + 1;
			}

			$_SESSION ['file'] = $this->form->file;
			$this->form->org_name_flg = $_SESSION['org_name_flg'];
			$this->form->db_org_name = $_SESSION['db_org_name'];
			$this->smarty->assign( 'form', $this->form );

			if ( $errtemp > 0 ){

				$dup_msg = $dup_arr_stu . '行目の受講者';
				$error = sprintf(E029,$dup_msg);
				$this->setFormData();
				$this->smarty->assign ( 'btn_flg', '1' );
				$this->smarty->assign( 'err_msg', $error );
				$this->smarty->assign ('stunochg_max_count', STUDENT_NO_CHANGE_MAX_COUNT );
				$this->smarty->display ( 'excelStudentNoChangeList.html' );
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

		$imagedir = FILE_DIR. STUDENT_NO_CHANGE_FOLDER_NAME. "/";
		//アップロードしたエクセルファイルをアクセスする
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir.$_SESSION ['StudentNoChange_File']);

		$sheet = $spreadsheet->getActiveSheet();

		$hcol = $spreadsheet->setActiveSheetIndex(0)->getHighestDataColumn();
		$hrow = $spreadsheet->setActiveSheetIndex(0)->getHighestDataRow();

		// 領域を2次元配列として取得する
		$range = 'A1:'. $hcol . $hrow;

		$dataArray = $sheet->rangeToArray($range);
		$dataArray = array_filter($dataArray, 'array_filter');
		$this->smarty->assign ( 'dataArray', $dataArray );
	}

}
?>
