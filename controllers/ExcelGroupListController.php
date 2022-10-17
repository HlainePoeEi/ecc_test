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
require_once 'service/GroupService.php';
require_once 'service/GradeService.php';
require_once 'service/OrganizationService.php';
require_once 'service/ExcelService.php';

//excell関係
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

/**
 *グループエクセル登録コントローラー
 */
class ExcelGroupListController extends BaseController {

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
			}else {
				$this->smarty->assign('err_msg','');
			}
			$this->smarty->assign ( 'error', '' );
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->assign ( 'dataArray', null );
			$this->smarty->assign ( 'db_org_name', '' );
			$this->smarty->assign ( 'org_name_flg', '' );
			$this->smarty->assign ( 'btn_flg', '' );
			$this->smarty->display ( 'excelGroupList.html' );
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
			//ファイル名をセッションに追加
			$_SESSION ['File_Name'] = $file_name;
			//サーバに保存するエクセルファイルパス・　運用管理者番号/運用管理者ログインID/日付
			$_SESSION ['Group_File'] = $admin_no . "_" . $admin_id. "_" . DateUtil::getDate ( 'YmdHis' ) . "_" . $file_name;
			//エクセルファイルディレクトリ
			$filedir = FILE_DIR."/" . GROUP_FOLDER_NAME. "/";

			//プロジェクト名/Files/group_temp/ファイル名
			$excelService->uploadFile($this->form->image_data, $filedir, $_SESSION ['Group_File']);
			$this->dispatch('ExcelGroupList/viewExcelList');
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

		$imagedir = FILE_DIR. "/" . GROUP_FOLDER_NAME. "/";

		//アップロードしたエクセルファイルをアクセスする
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir.$_SESSION ['Group_File']);

		//エクセルファイルのアクティブシートを取る
		$sheet = $spreadsheet->getActiveSheet();

		//エクセルファイルにデータが有る最後のカラムと行を取る
		$hcol = $spreadsheet->setActiveSheetIndex(0)->getHighestDataColumn();
		$hrow = $spreadsheet->setActiveSheetIndex(0)->getHighestDataRow();
		//エクセルファイルにデータが有るかどうかチェックする
		if ( $hcol == 'A' || $hrow <= 1) {

			//エクセルファイルにデータが無いの場合、
			$error = sprintf('Error!!! Empty File.');
			$this->smarty->assign ( 'err_msg', $error );
			$this->smarty->assign( 'db_org_name', '' );
			$this->smarty->assign( 'org_name_flg', '' );
			$this->smarty->assign ( 'dataArray', null );
			$this->smarty->assign('form', $this->form);
			$this->smarty->display ( 'excelGroupList.html' );
			return;
		} else {

			// 領域を2次元配列として取得する
			$range = 'A1:'. $hcol . $hrow;
			$title_range = 'A1:'. $hcol . 1;
			$sheet->getStyle('E2:E'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
			$sheet->getStyle('F2:F'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
			$dataTitle = $sheet->rangeToArray($title_range);
			$dataArray =  $this->changeDataArray($sheet->rangeToArray($range),$sheet,$hrow);
			$title_arr = unserialize (GROUP_HEADER_LIST);
			$title_flg = 1;
			$col_flg = 1;
			// 列数を確認する
			if ( $hcol != 'G' ) {
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

			// グループのフォーマットファイルが間違っている時エラーメッセージを表示する
			if ( $col_flg == 0 || $title_flg == 0 ) {

				$error = sprintf(E026," グループ");
				$this->smarty->assign ( 'err_msg', $error );
				$this->smarty->assign ( 'dataArray', null );
				$this->smarty->assign ( 'db_org_name', '' );
				$this->smarty->assign ( 'org_name_flg', '' );
			} else {

				$org_service = new OrganizationService($this->pdo);
				$org_Data = $org_service->getOrgNoByOrgId($dataArray[1][0]);
				$org_name_flg='0';
				$dataArray = array_filter($dataArray, 'array_filter');
				if($org_Data != null){

					$org_name_flg='1';
					$this->smarty->assign('db_org_name',"組織名 - ".$org_Data->org_name);
				}else {

					$org_name_flg='0';
					$this->smarty->assign ( 'db_org_name',"組織名はありません。");
				}

				$this->smarty->assign('org_name_flg',$org_name_flg);
				$this->smarty->assign ( 'err_msg', '' );
				$this->smarty->assign ( 'dataArray', $dataArray );
			}

			// メニュー情報を取得、セットする
			$this->setMenu();
			$this->form->file_name1 = $_SESSION ['File_Name'] ;
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->assign ( 'btn_flg', '1' );
			$this->smarty->assign('gp_max_count', GROUP_MAX_COUNT);
			$this->smarty->display ( 'excelGroupList.html' );
		}
	}

	/**
	 * 登録処理
	 */
	public function saveAction() {

		$group_data= $this->form->group_data;
		$group = explode ( ',', $group_data);
		$group_service = new GroupService($this->pdo);
		$grade_service = new GradeService($this->pdo);

		$group_dto_list = array();
		//重複データが無い場合、
		for ( $i = 0; $i < count($group); $i++ ) {
			// グループデータ情報登録
			$group_dto = new T_GroupDto();
			$group_dto->org_no = $this->form->org_no;
			$next_gp_no = $group_service->getNextGroupNo();
			$gp_no = $next_gp_no->id;
			$group_dto->group_no= $gp_no;
			$group_dto->group_name= CommonUtil::htmlEntityDecode($group[$i+1]);
			$group_dto->group_name_kana= CommonUtil::htmlEntityDecode($group[$i+2]);
			$grade_result = $grade_service->getGradeByName( $this->form->org_no,CommonUtil::htmlEntityDecode($group[$i+3]));
			$group_dto->grade_no=(count($grade_result)>0)? $grade_result[0]->grade_no:0;
			$group_dto->start_period= DateUtil::getYmd(CommonUtil::htmlEntityDecode($group[$i+4]));
			$group_dto->end_period= DateUtil::changeEndDateFormat(CommonUtil::htmlEntityDecode($group[$i+5]));
			$group_dto->remarks = CommonUtil::htmlEntityDecode($group[$i+6]);
			$group_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
			$group_dto->creater_id = $_SESSION['admin_no'];
			$group_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
			$group_dto->updater_id = $_SESSION['admin_no'];
			$group_dto->del_flg = 0;
			$i = $i + 6;

			array_push($group_dto_list,$group_dto);
		}

		//グループリスト情報を登録する
		$result1 = $group_service->insertWithTran($group_dto_list);

		// 登録処理が正常の場合、成功メーセジを表示する
		if ( $result1 == 1 ) {
			//登録完了
			$error = sprintf(I006, "グループ", sizeof($group_dto_list));
			$_SESSION ['regist_msg'] = $error;
			$this->dispatch('ExcelGroupList');
			// 登録出来ない場合,エーラーメーセジを表示する
		}else {
			$error = sprintf(E007,'登録');
			$this->smarty->assign ( 'error', $error );
			$_SESSION ['regist_msg'] = $error;
			$this->dispatch('ExcelGroupList');
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
			$file = $dir. GROUP_FILE_NAME;
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
				$this->dispatch('ExcelGroupList');
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
			$gp_data = $this->form->group_data;
			$group = explode ( ',', $gp_data);

			if($this->orgCheck($group) || $this->checkField($group)){
				$this->form->file_name1 = $_SESSION ['File_Name'] ;
				$this->smarty->assign( 'form', $this->form );
				$this->smarty->assign( 'db_org_name', $this->form->db_org_name );
				$this->smarty->assign( 'org_name_flg', $this->form->org_name_flg );
				$this->smarty->assign ( 'btn_flg', '1' );
				$this->setFormData();
				$this->smarty->display ( 'excelGroupList.html' );
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
	 * 組織チェック処理
	 */
	public function orgCheck($group){

		if ( $this->check_login () == true ) {

			$org_service = new OrganizationService($this->pdo);
			$org_id = CommonUtil::htmlEntityDecode($group[0]);//組織ID
			$org = $org_service->getOrgNoByOrgId($org_id);

			if ($org != "")
			{
				$org_no= $org->org_no;
				$this->form->org_no = $org_no;
			}else{

				$this->smarty->assign( 'err_msg', E028);
			}

			return $org == "";
		}
		else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * グループの項目チェック
	 */
	public function checkField($group) {

		if ( $this->check_login () == true ) {

			if ($this->form->org_no !=""){
				$temp = 0;

				// グループ名重複チェック
				$group_service = new GroupService($this->pdo);
				$grade_service = new GradeService($this->pdo);

				$count = 0;
				$gp_name = array("");
				$grade_name = array("");
				$dup_arr = '';
				$grade_arr = '';

				for ( $i = 0; $i < count($group); $i++ ) {
					//HTMLエンティティを文字に変換とエスケープコンマ
					$group[$i] =CommonUtil::htmlEntityDecode($group[$i]);
					if ( ($i % 7) == 0 ){
						array_push($gp_name,CommonUtil::htmlEntityDecode($group[$i+1]));
						array_push($grade_name,CommonUtil::htmlEntityDecode($group[$i+3]));
					}
				}

				for ( $i = 1; $i < count($grade_name); $i++ ){
					if($grade_name[$i] !==""){
						$grade_result = $grade_service->getGradeByName( $this->form->org_no,$grade_name[$i] );
						if ( count($grade_result) == 0 ){
							if ( $grade_arr == '' ){
								$grade_arr= $i;
							}else {
								$grade_arr= $grade_arr. ',' . $i;
							}
							$temp = 1;
						}
					}
				}
				if ( $temp == 0 ){
					for ( $i = 1; $i < count($gp_name); $i++ ){
						$duplicate_result = $group_service->checkedExistGpName( $this->form->org_no,$gp_name[$i] );
						if ( count($duplicate_result) > 0 ){

							if ( $dup_arr == '' ){

								$dup_arr = '<div>'. $i ;
							}else {

								$dup_arr = $dup_arr .',' .'</div><div>' . $i ;
							}
							$temp = 2;
						}
					}
					$dup_arr = $dup_arr . '</div>';
				}
				$_SESSION ['file'] = $this->form->file;

				switch ($temp){
					case 1 :
						$error= $grade_arr. '行目の学年が正しくありません。';
						$this->smarty->assign('gp_max_count', GROUP_MAX_COUNT);
						$this->smarty->assign( 'err_msg', $error );
						break;
					case 2 :
						$dup_msg = $dup_arr . '行目のグループ名';
						$error = sprintf(E014,$dup_msg);
						$this->smarty->assign('gp_max_count', GROUP_MAX_COUNT);
						$this->smarty->assign( 'err_msg', $error );
						break;
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
		$imagedir = FILE_DIR . "/" . GROUP_FOLDER_NAME. "/";
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir.$_SESSION ['Group_File']);

		$sheet = $spreadsheet->getActiveSheet();

		$hcol = $spreadsheet->setActiveSheetIndex(0)->getHighestDataColumn();
		$hrow = $spreadsheet->setActiveSheetIndex(0)->getHighestDataRow();

		// 領域を2次元配列として取得する
		$sheet->getStyle('E2:E'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$sheet->getStyle('F2:F'.$hrow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);

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
