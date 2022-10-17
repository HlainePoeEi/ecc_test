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
class ExcelContract2SkillListController extends BaseController {

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
			$this->smarty->display ( 'excelContract2SkillList.html' );
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
			$_SESSION ['Contract_2Skill_File'] = $admin_no . "_" . $admin_id. "_" . DateUtil::getDate ( 'YmdHis' ) . "_" . $file_name;
			//エクセルファイルディレクトリ
			$filedir = FILE_DIR."/" . CONTRACT_2SKILL_FOLDER_NAME . "/";

			//プロジェクト名/Files/student_temp/ファイル名
			$excelService->uploadFile($this->form->file_data, $filedir, $_SESSION ['Contract_2Skill_File']);
			$this->dispatch('ExcelContract2SkillList/viewExcelList');
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

		$imagedir = FILE_DIR. "/" . CONTRACT_2SKILL_FOLDER_NAME . "/";

		//アップロードしたエクセルファイルをアクセスする
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir.$_SESSION ['Contract_2Skill_File']);

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
			$this->smarty->display ( 'excelContract2SkillList.html' );
			return;
		}else {

			// 領域を2次元配列として取得する
			$title_range = 'A1:'. 'G' . 1;
			$range= 'A1:'. 'G' . $hrow;
			
			$sheet->getStyle('F2:F'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
			$sheet->getStyle('G2:G'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
			
			$dataTitle = $sheet->rangeToArray($title_range);
			$dataArray =  $this->changeDataArray($sheet->rangeToArray($range),$sheet,$hrow);
			$title_arr = unserialize (CONTRACT_2SKILL_HEADER_LIST);
			
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
			$this->smarty->display ( 'excelContract2SkillList.html' );
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
		$cd_service = new CourseDetailService($this->pdo);
		$service = new CourseService($this->pdo);
		$student_service = new StudentService($this->pdo);
		$org_service = new OrganizationService($this->pdo);
		
		$admin_id = $_SESSION ['admin_no'];
		
		$total_cnt = 0;
		$line_no = 1;
		$offer_no = "";
		
		$savedStuList = array();
		LogHelper::logDebug($student);
		
		//重複データが無い場合、
		for ( $i = 0; $i < count($student); $i++ ){

			$offer_no = $student[$i];
			$org_id = $student[$i + 1];
			$course_id = $student[$i + 2];
			
			$org_dto = $org_service->getOrgNoByOrgId($org_id );
			
			if ($org_dto == ""){
				$errmsg .= $line_no . "目の組織IDが正しくありません。<br/>";
				logHelper::logDebug($errmsg . "組織ID: " . $org_id);
				break;
				return;

			}else{
				$org_no = $org_dto->org_no;
			}

			// 受講者ログインIDチェック
			$stuLoginId = $student[$i + 4];
			$stuList = $student_service->checkedExistInfo($org_no, $stuLoginId);
			
			if ( count($stuList) > 0 ){
				
				LogHelper::logDebug("受講者チェック　OK");
				$student_no = $stuList[0]->student_no;
				
				// T_COURSE_STUDENT に登録
				$course_student_dto =  new T_Course_StudentDto();
				$course_student_dto->offer_no = $offer_no;
				$course_student_dto->course_id = $course_id ;
				$course_student_dto->org_no = $org_no;
				$course_student_dto->student_no = $student_no;
				$course_student_dto->start_period = DateUtil::changeStartDateFormat($student[$i + 5]);
				$course_student_dto->end_period = DateUtil::changeEndDateFormat($student[$i + 6]);
				$course_student_dto->del_flg = '0';
				$course_student_dto->create_dt = DateUtil::getDate("Y/m/d H:i:s");
				$course_student_dto->update_dt = DateUtil::getDate("Y/m/d H:i:s");
				$course_student_dto->creater_id = $admin_id;
				$course_student_dto->updater_id = $admin_id;
				
//					LogHelper::logDebug($course_student_dto);

				$course_stuCheck = $cs_service->getCourseStudentData($course_student_dto);
				
				if ( count($course_stuCheck) > 0 ) {
					LogHelper::logDebug("コース受講者データ登録済み");
					$_SESSION ['regist_msg'] =  $line_no . E039;
					$result1 = 0;
					break;
				}

				$result = $cs_service->registerCourseStudentData($course_student_dto);
				
				// 登録済みの受講者データ
				array_push($savedStuList , $student_no );
				
				$dto = new T_CourseDto();
				$dto->course_id = $course_id;
				$course_dto = $service->getCourseInfo($dto);
				
				// コースにあるコース詳細番号を取得する
				$cdList = $cd_service->getDetailListOnCourse($course_dto);
				
				LogHelper::logDebug("cdList");
				LogHelper::logDebug($cdList);
				
				for ( $loop = 0 ; $loop < count($cdList); $loop++){
					
					// T_COURSE_DETAIL_STUDENT に登録
					$course_detail_student_dto = new T_Course_Detail_StudentDto();
					$course_detail_student_dto->offer_no =  $offer_no;
					$course_detail_student_dto->org_no = $org_no;
					$course_detail_student_dto->student_no = $student_no;
					$course_detail_student_dto->course_id = $course_id ;
					$course_detail_student_dto->course_detail_no = $cdList[$loop]->course_detail_no ;
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
						$_SESSION ['regist_msg'] = $line_no . E036;
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
					}
				}
			
			}else{
				//ERROR
				LogHelper::logDebug("受講者チェック　NG , Login ID : " . $stuLoginId);
				$_SESSION ['regist_msg'] = $line_no .　E034;
				$result1 = 0;
				break;
			}

			$i = $i + 6 ;
			$total_cnt++;
			$line_no++;
		}
		
		// 登録処理が正常の場合、成功メーセジを表示する
		if ( $result1 == 1 ){
			//登録完了
			$error = sprintf(I006, "契約情報", $total_cnt );
			$_SESSION ['regist_msg'] = $error;
			$this->dispatch('ExcelContract2SkillList');
			
			// 登録出来ない場合,エーラーメーセジを表示する
		}else {
			$error = sprintf(E007,'登録');
			$this->dispatch('ExcelContract2SkillList');
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
			$file = $dir . CONTRACT_2SKILL_FILE_NAME;
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
				$this->dispatch('ExcelContract2SkillList');
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
			if ($this->orgCheck($student) == "" || $this->contractCheck($student) == "" || $this->courseCheck($student) == "" ){

				$this->form->file_name1 = $_SESSION ['File_Name'] ;
				$this->smarty->assign( 'form', $this->form );
				$this->smarty->assign( 'db_org_name', $this->form->db_org_name );
				$this->smarty->assign( 'org_name_flg', $this->form->org_name_flg );
				$this->smarty->assign ( 'btn_flg', '1' );
				
				$this->setFormData();
				$this->smarty->display ( 'excelContract2SkillList.html' );
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
				$org_no = $org->org_no;
				$this->form->org_no = $org_no;
				
				return 1;
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
			
			// Excelファイルにある受講者データを計算
			$stuList = array();
			$cnt = 0 ;
			$line_no = 1;
			$student_service = new StudentService($this->pdo);
			$org_service = new OrganizationService($this->pdo);
			
			while( $cnt < count($student)){
				
				$org_id = $student[$cnt + 1];
				
				$org_dto = $org_service->getOrgNoByOrgId($org_id );
				
				if ($org_dto == ""){
					$errmsg .= $line_no . E033;
					logHelper::logDebug($errmsg . "組織ID: " . $org_id);

				}else{
					
					$org_no = $org_dto->org_no;
					$stu_name = $student[$cnt + 3];
					$login_id = $student[$cnt + 4];
					
					LogHelper::logDebug("　Org No : " . $org_no);
					LogHelper::logDebug("　Student Name : " . $stu_name);
					LogHelper::logDebug("　Login Id : " . $login_id);
					
					// 受講者存在チェック
					$stu_data = $student_service->getSutdentByNameLoginId($org_no , $login_id , $stu_name);
					if ( $stu_data == null ){
						$errmsg .= $line_no . E034;
						logHelper::logDebug($errmsg . "ログインID: " . $login_id);
					}

				}

				$cnt = $cnt + 7;
				$line_no++;

			}

			if ($errmsg != ""){
				$this->smarty->assign( 'err_msg', $errmsg);
				return "";
			}
		}
		
		return 1;
	}

	/**
	* setFormData処理
	*/
	public function setFormData(){
		$file = $this->form->file;
		$imagedir = FILE_DIR . "/" . CONTRACT_2SKILL_FOLDER_NAME. "/";
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir.$_SESSION ['Contract_2Skill_File']);
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
	
	/**
	 * 契約情報チェック処理
	 */
	public function contractCheck($student) {
		
		$err_msg = "";
		$line_no = 1;
		$co_service = new CourseOrgService($this->pdo);
		
		for ( $i = 0; $i < count($student); $i++ ){

			$courseOrgDto = new T_Course_OrgDto();
			$courseOrgDto->offer_no = $student[$i];
			$courseOrgDto->course_id = $student[$i + 2];

			$org_id = $student[$i + 1];
			$org_service = new OrganizationService($this->pdo);
			$org_dto = $org_service->getOrgNoByOrgId($org_id);
			
			if ($org_dto == ""){
				$errmsg .= $line_no . E033;
				logHelper::logDebug($errmsg . "組織ID: " . $org_id);

			}else{
				
				$courseOrgDto->org_no = $org_dto->org_no;
				LogHelper::logDebug($courseOrgDto);

				$course_org_result = $co_service->getCourseContractInfo ( $courseOrgDto );
				
				LogHelper::logDebug($course_org_result);
				
				if ( $course_org_result == "" || $course_org_result == null || empty($course_org_result)){
					$err_msg .= $line_no . E035 ;
				}else{
					$start_period = DateUtil::changeStartDateFormat($course_org_result->start_period);
					$end_period = DateUtil::changeEndDateFormat($course_org_result->end_period);
					
					$start_period_d = DateUtil::changeStartDateFormat($student[$i + 5]);
					$end_period_d = DateUtil::changeEndDateFormat($student[$i + 6]);

					if (  $start_period > $start_period_d || $start_period_d > $end_period ){
						$err_msg .= $line_no . E037 ;
					}

					if (  $start_period > $end_period_d || $end_period_d > $end_period ){
						$err_msg .= $line_no . E038 ;
					}
				}
			
			}

			$line_no++;
			$i = $i + 6;
		}
		
		if ($err_msg != "" ){
			$this->smarty->assign( 'err_msg', $err_msg);
			return "";
		}
		return 1;
	}
	
}
?>