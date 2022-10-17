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
require_once 'service/CourseService.php';
require_once 'service/CourseOrgService.php';
require_once 'service/CourseStudentService.php';
require_once 'service/CourseDetailService.php';
require_once 'dto/T_CourseDto.php';
require_once 'dto/T_Course_OrgDto.php';
require_once 'dto/T_Course_Org_ConfDto.php';
require_once 'dto/T_Course_StudentDto.php';
require_once 'dto/T_Course_Detail_StudentDto.php';

//excell関係
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
//excell関係

/**
 * 契約情報登録コントローラー
 */
class ExcelContractListController extends BaseController {

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
			$this->smarty->display ( 'excelContractList.html' );
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
			$_SESSION ['Contract_File'] = $admin_no . "_" . $admin_id. "_" . DateUtil::getDate ( 'YmdHis' ) . "_" . $file_name;
			//エクセルファイルディレクトリ
			$filedir = FILE_DIR."/" . CONTRACT_FOLDER_NAME . "/";

			//プロジェクト名/Files/student_temp/ファイル名
			$excelService->uploadFile($this->form->file_data, $filedir, $_SESSION ['Contract_File']);
			$this->dispatch('ExcelContractList/viewExcelList');
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

		$imagedir = FILE_DIR. "/" . CONTRACT_FOLDER_NAME . "/";

		//アップロードしたエクセルファイルをアクセスする
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir.$_SESSION ['Contract_File']);

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
			$this->smarty->display ( 'excelContractList.html' );
			return;
		}else {

			// 領域を2次元配列として取得する
			$title_range = 'A1:'. 'G' . 1;
			$range= 'A1:'. 'G' . $hrow;
			
			$sheet->getStyle('F2:F'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
			$sheet->getStyle('G2:G'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
			
			$dataTitle = $sheet->rangeToArray($title_range);
			$dataArray =  $this->changeDataArray($sheet->rangeToArray($range),$sheet,$hrow);
			$title_arr = unserialize (CONTRACT_HEADER_LIST);
			
			$title_flg = 1;
			$col_flg = 1;

			// 列数を確認する
			if ( $hcol != 'G' && $hcol != 'H' ){

				$col_flg = 0;
			}
			if ( $col_flg == 1 ){
				// タイトルが間違いがどうか確認する
				for ( $i = 0; $i < 7; $i++ ){

					if ( $dataTitle[0][$i] != $title_arr[$i] ){

						$title_flg = 0;
					}
				}
			}
	//		LogHelper::logDebug("hcol" . $hcol);
	//		LogHelper::logDebug($col_flg);
	//		LogHelper::logDebug($title_flg);

			// 受講者のフォーマットファイルが間違っている時エラーメッセージを表示する
			if ( $col_flg == 0 || $title_flg == 0 ){

				$error = sprintf(E026,"契約情報");
				$this->smarty->assign ( 'err_msg', $error );
				$this->smarty->assign ( 'dataArray', null );
				$this->smarty->assign ( 'db_org_name', '' );
				$this->smarty->assign ( 'org_name_flg', '' );
			}else {
				$dataArray = array_filter($dataArray, 'array_filter');
				$this->smarty->assign ( 'err_msg', '' );
				$this->smarty->assign ( 'dataArray', $dataArray );

				$org_service = new OrganizationService($this->pdo);
				$org_Data = $org_service->getOrgNoByOrgId(CommonUtil::htmlEntityDecode($dataArray[1][1]));
				$org_name_flg ='0';

				if ( $org_Data != null ){

					$org_name_flg ='1';
					$this->smarty->assign('db_org_name',"組織名 - ".$org_Data->org_name);
				}else {

					$org_name_flg ='0';
					$this->smarty->assign ( 'db_org_name',"組織名はありません。");
				}

				$this->smarty->assign('org_name_flg', $org_name_flg);
			}

			// メニュー情報を取得、セットする
			$this->setMenu();
			$this->form->file_name1 = $_SESSION ['File_Name'] ;
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->assign ( 'btn_flg', '1' );
			$this->smarty->assign('max_count', CONTRACT_MAX_COUNT);
			$this->smarty->display ( 'excelContractList.html' );
		}
	}

	/**
	 * 登録処理
	 */
	public function saveAction(){
		
		$student_data = $this->form->student_data;
		$student = explode ( ',', $student_data);
		
		$student_service = new StudentService($this->pdo);
		$co_service = new CourseOrgService($this->pdo);
		$cs_service = new CourseStudentService($this->pdo);
		$admin_id = $_SESSION ['admin_no'];
		$org_no = $this->form->org_no;
		
		$total_cnt = 0;
		$offer_no = "";
		
		$savedStuList = array();
		LogHelper::logDebug($student);
		
		//重複データが無い場合、
		for ( $i = 0; $i < count($student); $i++ ){

			$courseOrgDto = new T_Course_OrgDto();
			$courseOrgDto->offer_no = $student[$i];
			$courseOrgDto->org_no = $org_no;
			$courseOrgDto->course_id = $student[$i + 2];
			
			$offer_no = $courseOrgDto->offer_no;
			
			LogHelper::logDebug($courseOrgDto);

			$course_org_result = $co_service->getCourseContractInfo ( $courseOrgDto );
			
			LogHelper::logDebug($course_org_result);
			
			
			
			if ( count($course_org_result) != 1 ){
				$_SESSION ['regist_msg'] = "契約情報が確認できません。";
				$result1 = 0;
				break;
			}

			// 受講者ログインIDチェック
			$stuLoginId = $student[$i + 4];
			$stuList = $student_service->checkedExistInfo($courseOrgDto->org_no, $stuLoginId);
			
			if ( count($stuList) > 0 ){
				
				LogHelper::logDebug("受講者チェック　OK");
				$student_no = $stuList[0]->student_no;
				
				// コース受講者登録、受講者ごと登録する
//					LogHelper::logDebug($savedStuList);
				$chk_stu = false;
				foreach($savedStuList as $stu){
					if ($stu == $student_no){
						$chk_stu = true;
						break;
					}
				}
//					LogHelper::logDebug("Loop ID : " . $i);
//					LogHelper::logDebug("コース受講者登録チェック　Login ID : " . $stuLoginId);
//					LogHelper::logDebug("コース受講者登録チェック　" . $chk_stu);
				if ($chk_stu == false){
						
					// T_COURSE_STUDENT に登録
					$course_student_dto =  new T_Course_StudentDto();
					$course_student_dto->offer_no = $offer_no;
					$course_student_dto->course_id = $courseOrgDto->course_id ;
					$course_student_dto->org_no = $courseOrgDto->org_no;
					$course_student_dto->student_no = $student_no;
					$course_student_dto->start_period = $course_org_result->start_period;
					$course_student_dto->end_period = $course_org_result->end_period;
					$course_student_dto->del_flg = '0';
					$course_student_dto->create_dt = DateUtil::getDate("Y/m/d H:i:s");
					$course_student_dto->update_dt = DateUtil::getDate("Y/m/d H:i:s");
					$course_student_dto->creater_id = $admin_id;
					$course_student_dto->updater_id = $admin_id;
					
//					LogHelper::logDebug($course_student_dto);

					$course_stuCheck = $cs_service->getCourseStudentData($course_student_dto);
					
					if ( count($course_stuCheck) > 0 ) {
						LogHelper::logDebug("コース受講者データ登録済み");
						$_SESSION ['regist_msg'] = "コース受講者データ登録済みです。登録できません。";
						$result1 = 0;
						break;
					}

					$result = $cs_service->registerCourseStudentData($course_student_dto);
					
					// 登録済みの受講者データ
					array_push($savedStuList , $student_no );
				}
				
				// T_COURSE_DETAIL_STUDENT に登録
				$course_detail_student_dto = new T_Course_Detail_StudentDto();
				$course_detail_student_dto->offer_no =  $offer_no;
				$course_detail_student_dto->org_no = $courseOrgDto->org_no;
				$course_detail_student_dto->student_no = $student_no;
				$course_detail_student_dto->course_id = $courseOrgDto->course_id ;
				$course_detail_student_dto->course_detail_no = $student[$i + 3] ;
				$course_detail_student_dto->start_period = DateUtil::changeStartDateFormat($student[$i + 5]);
				$course_detail_student_dto->end_period = DateUtil::changeEndDateFormat($student[$i + 6]);
				$course_detail_student_dto->del_flg = '0';
				$course_detail_student_dto->create_dt = DateUtil::getDate("Y/m/d H:i:s");
				$course_detail_student_dto->update_dt = DateUtil::getDate("Y/m/d H:i:s");
				$course_detail_student_dto->creater_id = $admin_id;
				$course_detail_student_dto->updater_id = $admin_id;
				
//				LogHelper::logDebug($course_detail_student_dto);

				$course_detail_stuCheck = $cs_service->getCourseDetailStudentData($course_detail_student_dto);
				
				if ( count($course_stuCheck) > 0 ) {
					LogHelper::logDebug("コース詳細受講者データ登録済み");
					$_SESSION ['regist_msg'] = "コース詳細受講者データ登録済みです。登録できません。";
					$result1 = 0;
					break;
				}

				$save_result = $cs_service->registerCoursDetailStudentData($course_detail_student_dto);

				if ($save_result< 1){
					LogHelper::logDebug("T_COURSE_DETAIL_STUDENT に登録 NG");
					$_SESSION ['regist_msg'] = sprintf(E007,'登録');
					$result1 = 0;
					break;
				}else{
					$result1 = 1;
					LogHelper::logDebug("契約情報登録 すべてOK");
				}
			}else{
				//ERROR
				LogHelper::logDebug("受講者チェック　NG , Login ID : " . $stuLoginId);
				$_SESSION ['regist_msg'] = "受講者データが正しくありません。";
				$result1 = 0;
				break;
			}

			$i = $i + 6 ;
			$total_cnt++;
		}
		
		// 登録処理が正常の場合、成功メーセジを表示する
		if ( $result1 == 1 ){
			//登録完了
			$error = sprintf(I006, "契約情報", $total_cnt );
			$_SESSION ['regist_msg'] = $error;
			$this->dispatch('ExcelContractList');
			
			// 登録出来ない場合,エーラーメーセジを表示する
		}else {
			$error = sprintf(E007,'登録');
			$this->dispatch('ExcelContractList');
		}
	}

	/**
	 * エクセルダウンロード処理
	 */
	public function formatDlWocAction(){
		if ( $this->check_login () == true ){
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			$dir = FILE_DIR. "/" . EXCEL_FORMAT_FOLDER_NAME. "/";
			$file = $dir . CONTRACT_FILE_NAME;
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
				$this->dispatch('ExcelContractList');
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
			
			//組織IDチェックとコースとコース詳細チェック
			if ($this->orgCheck($student) || $this->courseCheck($student) == "" ){

				$this->form->file_name1 = $_SESSION ['File_Name'] ;
				$this->smarty->assign( 'form', $this->form );
				$this->smarty->assign( 'db_org_name', $this->form->db_org_name );
				$this->smarty->assign( 'org_name_flg', $this->form->org_name_flg );
				$this->smarty->assign ( 'btn_flg', '1' );
				
				$this->setFormData();
				$this->smarty->display ( 'excelContractList.html' );
				return;
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
			$org = $org_service->getOrgNoByOrgId($student[1]);

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
	public function courseCheck($student) {
		
		$course_id = $student[2];
		$rtn = "";
		
		$dto = new T_CourseDto();
		$dto->course_id = $course_id;
		$cd_service = new CourseDetailService($this->pdo);
		
		if ( $course_id !="" ){
			
			$service = new CourseService($this->pdo);
			$course_dto = $service->getCourseInfo($dto);
			
			if ($course_dto == ""){
				$this->smarty->assign( 'err_msg', E018);
				return "";
			}
			
			// DBにあるコースのコース詳細ID取得
			$cdList = $cd_service->getDetailListOnCourse($dto);
			
			LogHelper::logDebug("cdList");
			LogHelper::logDebug($cdList);
			
			// Excelファイルに記載されているコース詳細番号カウントを計算
			$list = array();
			$s = 0 ;
			while( $s < count($student)){
				
				$no = $student[$s + 3];
				array_push($list , $no);
				$s = $s + 7;
			}
			$uq_list = array_unique($list);
			logHelper::logDebug($uq_list);

			//コースにあるコース詳細数とExcelファイルからコース詳細番号数が違う場合、エラー
			if ( count($uq_list) != count($cdList)){
				$this->smarty->assign( 'err_msg', E031);
				return "";
			}
			
			$detailChkFlg = false;
			// 取得できたコース詳細番号がExcelファイルにない場合、エラー
			for ( $i= 0 ; $i < count($cdList) ; $i++ ){
				$cd_no = $cdList[$i]->course_detail_no;
				logHelper::logDebug("course_detail_no : " . $cd_no);
				foreach($uq_list as $no){
					if ($cd_no == $no){
						$detailChkFlg = true;
					}
				}
				if($detailChkFlg == false){
					$this->smarty->assign( 'err_msg', E031);
					return "";
				}
			}
			
			// Excelファイルにある受講者データを計算
			$stuList = array();
			$cnt = 0 ;
			while( $cnt < count($student)){
				
				$stu_no = $student[$cnt + 4];
				array_push($stuList , $stu_no);
				$cnt = $cnt + 7;
			}
			$uq_stuList = array_unique($stuList);
			logHelper::logDebug($uq_stuList);
			
			//受講者存在チェック
			$student_service = new StudentService($this->pdo);
			foreach($uq_stuList as $stu) {
				$stuList = $student_service->checkedExistInfo($this->form->org_no , $stu);
				if ( count($stuList) == 0 ){
					$errmsg = "受講者ログインIDが正しくありません。". "ログインID: " . $stu;
					logHelper::logDebug($errmsg . "ログインID: " . $stu);
					$this->smarty->assign( 'err_msg', $errmsg);
					return "";
				}
			}
			
			// コース詳細と受講者数が合わない場合、エラー
	//		LogHelper::logDebug( "total_cnt : " . count($student));
	//		LogHelper::logDebug( "ext_cnt : " . count($uq_stuList) * count($cdList) * 10 );
			if ( count($student) != count($uq_stuList) * count($cdList) * 7 ){
				$errmsg = "コース詳細・受講者数が合わない。";
				logHelper::logDebug($errmsg);
				$this->smarty->assign( 'err_msg', $errmsg);
				return "";
			}
			
			//コース詳細と受講者データ重複チェック
			$chkList = array();
			for ( $f= 0 ; $f < count($student) ; $f++ ){

				$data = $student[$f + 3] . "," . $student[$f + 4];
				array_push($chkList , $data);
				$f = $f + 9;
			}
		//	LogHelper::logDebug("chkList");
		//	LogHelper::logDebug($chkList);
			$uq_chList = array_unique($chkList);
		//	logHelper::logDebug($uq_chList);
			
			if ( count($chkList) != count($uq_chList)){
				logHelper::logDebug("コース詳細・受講者データ重複しています");
				$this->smarty->assign( 'err_msg', E032);
				return "";
			}else{
				$rtn = 1;
			}
		}
		
		return $rtn;
	}

	/**
	* setFormData処理
	*/
	public function setFormData(){
		$file = $this->form->file;
		$imagedir = FILE_DIR . "/" . CONTRACT_FOLDER_NAME. "/";
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir.$_SESSION ['Contract_File']);
		$sheet = $spreadsheet->getActiveSheet();
		$hcol = $spreadsheet->setActiveSheetIndex(0)->getHighestDataColumn();
		$hrow = $spreadsheet->setActiveSheetIndex(0)->getHighestDataRow();

		// 領域を2次元配列として取得する
		$sheet->getStyle('F2:F'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$sheet->getStyle('G2:G'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$range= 'A1:'. 'G' . $hrow;
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
				$key1='F'.$row;
				$key2='G'.$row;
				
				// コース詳細受講開始日
				if($sheet->getCell($key1)->getFormattedValue()!=""){
					if(!(DateUtil::isValidDateFormat($sheet->getCell($key1)->getFormattedValue()) || DateUtil::isValidDateFormat($sheet->getCell($key1)->getValue()))){
						$resVal=$sheet->getCell($key1)->getValue();
						$dataArray[$row-1][5]=(preg_match('/^[0-9]{8}$/i',$resVal))?(substr($resVal,0,4).'-'.substr($resVal,4,2).'-'.substr($resVal,6,2)):$resVal;
					}
				}
				
				// コース詳細受講終了日
				if($sheet->getCell($key2)->getFormattedValue()!=""){
					if(!(DateUtil::isValidDateFormat($sheet->getCell($key2)->getFormattedValue()) || DateUtil::isValidDateFormat($sheet->getCell($key2)->getValue()))){
						$resVal=$sheet->getCell($key2)->getValue();
						$dataArray[$row-1][6]=(preg_match('/^[0-9]{8}$/i',$resVal))?(substr($resVal,0,4).'-'.substr($resVal,4,2).'-'.substr($resVal,6,2)):$resVal;
					}
				}
			}
		}
		$dataArray=array_values($dataArray);
		return $dataArray;
	}
	
	public function checkContractData($data){
		
		$co_service = new CourseOrgService($this->pdo);
		$rtn = true;
		$org_no = $this->form->org_no ;
		
		//重複データが無い場合、
		for ( $i = 0; $i < count($data); $i++ ){
				
			$courseOrgDto = new T_Course_OrgDto();
			$courseOrgDto->offer_no = $data[$i];
			$courseOrgDto->org_no = $org_no;
			$courseOrgDto->course_id = $data[$i + 2];
			
			LogHelper::logDebug($courseOrgDto);
			
			$course_org_result = $co_service->checkCourseOrgData ( $courseOrgDto );
			
			if ( count($course_org_result) == 0 ){
				$rtn = false;
							
				LogHelper::logDebug("契約情報チェック NG");
				return $rtn;
			}
			$i = $i + 6;
		}
		
		return $rtn;
		
	}
}
?>