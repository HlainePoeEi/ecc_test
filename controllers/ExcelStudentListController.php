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
require_once 'service/StudentService.php';
require_once 'service/OrganizationService.php';
require_once 'service/ExcelService.php';

//excell関係
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
//excell関係

/**
 * 受講者エクセル登録コントローラー
 */
class ExcelStudentListController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login () == true ){

			//ファイルの初期化（セッションに保持したファイル名をクリアする）
			unset($_SESSION ['File_Name']);

			// メニューが開くかどうかを確認する
			$this->setMenu();
			if ( isset($_SESSION ['regist_msg']) ){

				if ( $_SESSION ['regist_msg'] != "" ){

					$this->smarty->assign('err_msg',$_SESSION ['regist_msg']);
					$_SESSION ['regist_msg'] = "";
				}
			}else {
				$this->smarty->assign('err_msg','');
			}

			$this->smarty->assign ( 'error', '' );
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->assign ( 'dataArray', null );
			$this->smarty->assign ( 'db_org_name', '' );
			$this->smarty->assign ( 'org_name_flg', '' );
			$this->smarty->assign ( 'btn_flg', '' );
			$this->smarty->display ( 'excelStudentList.html' );
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

		if ( $this->check_login () == true ){
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
			$_SESSION ['Student_File'] = $admin_no . "_" . $admin_id. "_" . DateUtil::getDate ( 'YmdHis' ) . "_" . $file_name;
			//エクセルファイルディレクトリ
			$filedir = FILE_DIR."/" . STUDENT_FOLDER_NAME. "/";

			//プロジェクト名/Files/student_temp/ファイル名
			$excelService->uploadFile($this->form->image_data, $filedir, $_SESSION ['Student_File']);
			$this->dispatch('ExcelStudentList/viewExcelList');
		}else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * エクセル描画処理
	 */
	public function viewExcelListAction(){

		$imagedir = FILE_DIR. "/" . STUDENT_FOLDER_NAME. "/";

		//アップロードしたエクセルファイルをアクセスする
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir.$_SESSION ['Student_File']);

		//エクセルファイルのアクティブシートを取る
		$sheet = $spreadsheet->getActiveSheet();

		//エクセルファイルにデータが有る最後のカラムと行を取る
		$hcol = $spreadsheet->setActiveSheetIndex(0)->getHighestColumn();
		$hrow = $spreadsheet->setActiveSheetIndex(0)->getHighestRow();

		//エクセルファイルにデータが有るかどうかチェックする
		if ( $hcol == 'A' || $hrow <= 1 ){

			//エクセルファイルにデータが無いの場合、
			$error = sprintf('Error!!! Empty File.');
			$this->smarty->assign ( 'err_msg', $error );
			$this->smarty->assign ( 'dataArray', null );
			$this->smarty->assign( 'db_org_name', '' );
			$this->smarty->assign( 'org_name_flg', '' );
			$this->smarty->assign('form', $this->form);
			$this->smarty->display ( 'excelStudentList.html' );
			return;
		}else {

			// 領域を2次元配列として取得する
			$title_range = 'A1:'. 'K' . 1;
			$range= 'A1:'. 'K' . $hrow;
			$sheet->getStyle('I2:I'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
			$sheet->getStyle('J2:J'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
			$dataTitle = $sheet->rangeToArray($title_range);
			$dataArray =  $this->changeDataArray($sheet->rangeToArray($range),$sheet,$hrow);
			$title_arr = unserialize (STUDENT_HEADER_LIST);

			$title_flg = 1;
			$col_flg = 1;

			// 列数を確認する
			if ( $hcol != 'K' && $hcol != 'L' ){

				$col_flg = 0;
			}
			if ( $col_flg == 1 ){
				// タイトルが間違いがどうか確認する
				for ( $i = 0; $i < 11; $i++ ){

					if ( $dataTitle[0][$i] != $title_arr[$i] ){

						$title_flg = 0;
					}
				}
			}

			// 受講者のフォーマットファイルが間違っている時エラーメッセージを表示する
			if ( $col_flg == 0 || $title_flg == 0 ){

				$error = sprintf(E026,"受講者");
				$this->smarty->assign ( 'err_msg', $error );
				$this->smarty->assign ( 'dataArray', null );
				$this->smarty->assign ( 'db_org_name', '' );
				$this->smarty->assign ( 'org_name_flg', '' );
			}else {
				$dataArray = array_filter($dataArray, 'array_filter');
				$this->smarty->assign ( 'err_msg', '' );
				$this->smarty->assign ( 'dataArray', $dataArray );

				$org_service = new OrganizationService($this->pdo);
				$org_Data = $org_service->getOrgNoByOrgId(CommonUtil::htmlEntityDecode($dataArray[1][0]));
				$org_name_flg='0';

				if ( $org_Data != null ){

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
			$this->smarty->assign('stu_max_count', STUDENT_MAX_COUNT);
			$this->smarty->display ( 'excelStudentList.html' );
		}
	}

	/**
	 * 登録処理
	 */
	public function saveAction(){
		$student_data = $this->form->student_data;
		$student = explode ( ',', $student_data);
		$student_service = new StudentService($this->pdo);
		$student_dto_list = array();
		//重複データが無い場合、
		for ( $i = 0; $i < count($student); $i++ ){
			// 受講者データ情報登録
			$student_dto = new T_StudentDto();
			$student_dto->org_no = $this->form->org_no;
			// 取得結果．Tシーケンス.現在シーケンス番号+1
			$next_student_no = $student_service->getNextId();
			$student_no = $next_student_no->id;
			$student_dto->student_no = $student_no;
			$student_dto->student_name = CommonUtil::htmlEntityDecode($student[$i+1]);
			$student_dto->no = CommonUtil::htmlEntityDecode($student[$i+2]);
			$student_dto->student_name_romaji = CommonUtil::htmlEntityDecode($student[$i+3]);
			$sex = CommonUtil::htmlEntityDecode($student[$i+4]);
			//性別設定
			if ( $sex == "男性" ){
				$student_dto->sex = '1';
			}else if ( $sex == "女性" ){
				$student_dto->sex = '2';
			}else {
				$student_dto->sex = '0';
			}
			$login_id = CommonUtil::htmlEntityDecode($student[$i+5]);
			$student_dto->login_id = $login_id;
			$password = CommonUtil::htmlEntityDecode($student[$i+6]);
			$student_dto->password = CommonUtil::encryptPassword($password);
			$student_dto->mail_address = CommonUtil::htmlEntityDecode($student[$i+7]);
			$start_period = CommonUtil::htmlEntityDecode($student[$i+8]);
			$student_dto->enroll_dt = DateUtil::getYmd($start_period);
			$end_period = CommonUtil::htmlEntityDecode($student[$i+9]);
			$student_dto->graduation_dt = DateUtil::changeEndDateFormat($end_period);
			$student_dto->remarks = CommonUtil::htmlEntityDecode($student[$i+10]);
			$student_dto->setting = null;
			$student_dto->valid_kbn = STU_CATEGORG_REGIT; // "003"
			$student_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
			$student_dto->creater_id = $_SESSION['admin_no'];
			$student_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
			$student_dto->updater_id = $_SESSION['admin_no'];
			$student_dto->del_flg = 0;
			$i = $i + 10;
			array_push($student_dto_list,$student_dto);
		}
		$result1 = $student_service->insertWithTran($student_dto_list);
		// 登録処理が正常の場合、成功メーセジを表示する
		if ( $result1 == 1 ){
			//登録完了
			$error = sprintf(I006, "受講者", sizeof($student_dto_list));
			$_SESSION ['regist_msg'] = $error;
			$this->dispatch('ExcelStudentList');
			// 登録出来ない場合,エーラーメーセジを表示する
		}else {
			$error = sprintf(E007,'登録');
			$_SESSION ['regist_msg'] = $error;
			$this->dispatch('ExcelStudentList');
		}
	}

	/**
	 * エクセルダウンロード処理
	 */
	public function newExcelAction(){
		if ( $this->check_login () == true ){
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			$dir = FILE_DIR. "/" . EXCEL_FORMAT_FOLDER_NAME. "/";
			$file = $dir. STUDENT_FILE_NAME;
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
				$this->dispatch('ExcelStudentList');
			}
		}else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 有効チェック処理
	 */
	public function isValidAction(){

		if ( $this->check_login () == true ) {
			$stu_data = $this->form->student_data;
			$student = explode ( ',', $stu_data);

			if ($this->orgCheck($student) || $this->duplicateCheckWoc($student)){

				$this->form->file_name1 = $_SESSION ['File_Name'] ;
				$this->smarty->assign( 'form', $this->form );
				$this->smarty->assign( 'db_org_name', $this->form->db_org_name );
				$this->smarty->assign( 'org_name_flg', $this->form->org_name_flg );
				$this->smarty->assign ( 'btn_flg', '1' );
				$this->setFormData();
				$this->smarty->display ( 'excelStudentList.html' );
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
	 * 組織IDの有効チェック処理
	 */
	public function orgCheck($student){

		if ( $this->check_login () == true ){

			$org_service = new OrganizationService($this->pdo);
			$org = $org_service->getOrgNoByOrgId($student[0]);

			if ( $org != "" ){
				$org_no= $org->org_no;
				$this->form->org_no = $org_no;
			}else {

				$this->smarty->assign( 'err_msg', E028);
			}

			return $org == "";
		}else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 受講者名重複チェック処理
	 */
	public function duplicateCheckWoc($student) {
		if ( $this->check_login () == true ){
			if ( $this->form->org_no !="" ){
				$temp = 0;
				// 受講者名重複チェック
				$student_service = new StudentService($this->pdo);
				$count = 0;
				$login_id = array("");
				$dup_arr = '';
				for ( $i = 0; $i < count($student); $i++ ) {
					//HTMLエンティティを文字に変換とエスケープコンマ
					$student[$i] =CommonUtil::htmlEntityDecode($student[$i]);
					if ( ($i % 11) == 0 ){
						array_push($login_id,CommonUtil::htmlEntityDecode($student[$i+5]));
					}
				}
				for ( $i = 1; $i < count($login_id); $i++ ){
					$duplicate_result = $student_service->checkedExistInfo( $this->form->org_no,$login_id[$i] );
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
					$dup_msg = $dup_arr . '行目のログインID';
					$error = sprintf(E014,$dup_msg);
					$this->smarty->assign('stu_max_count', STUDENT_MAX_COUNT);
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
		$imagedir = FILE_DIR . "/" . STUDENT_FOLDER_NAME. "/";
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir.$_SESSION ['Student_File']);
		$sheet = $spreadsheet->getActiveSheet();
		$hcol = $spreadsheet->setActiveSheetIndex(0)->getHighestDataColumn();
		$hrow = $spreadsheet->setActiveSheetIndex(0)->getHighestDataRow();

		// 領域を2次元配列として取得する
		$sheet->getStyle('I2:I'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$sheet->getStyle('J2:J'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$range= 'A1:'. 'K' . $hrow;
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
				$key1='I'.$row;
				$key2='J'.$row;
				// 利用開始
				if($sheet->getCell($key1)->getFormattedValue()!=""){
					if(!(DateUtil::isValidDateFormat($sheet->getCell($key1)->getFormattedValue()) || DateUtil::isValidDateFormat($sheet->getCell($key1)->getValue()))){
						$resVal=$sheet->getCell($key1)->getValue();
						$dataArray[$row-1][8]=(preg_match('/^[0-9]{8}$/i',$resVal))?(substr($resVal,0,4).'-'.substr($resVal,4,2).'-'.substr($resVal,6,2)):$resVal;
					}
				}
				//利用終了
				if($sheet->getCell($key2)->getFormattedValue()!=""){
					if(!(DateUtil::isValidDateFormat($sheet->getCell($key2)->getFormattedValue()) || DateUtil::isValidDateFormat($sheet->getCell($key2)->getValue()))){
						$resVal=$sheet->getCell($key2)->getValue();
						$dataArray[$row-1][9]=(preg_match('/^[0-9]{8}$/i',$resVal))?(substr($resVal,0,4).'-'.substr($resVal,4,2).'-'.substr($resVal,6,2)):$resVal;
					}
				}
			}
		}
		$dataArray=array_values($dataArray);
		return $dataArray;
	}
}
?>
