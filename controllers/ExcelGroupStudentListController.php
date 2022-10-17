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
require_once 'service/GroupService.php';
require_once 'service/GroupStudentService.php';
require_once 'dto/T_Group_StudentDto.php';
require_once 'service/ExcelService.php';

//excell関係
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

/**
 * グループ・受講者エクセル登録コントローラー
 */
class ExcelGroupStudentListController extends BaseController {

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
			$this->smarty->display ( 'excelGroupStudentList.html' );
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
			$_SESSION ['GroupStudent_File'] = $admin_no . "_" . $admin_id. "_" . DateUtil::getDate ( 'YmdHis' ) . "_" . $file_name;
			//エクセルファイルディレクトリ
			$filedir = FILE_DIR. "/" . GROUP_STUDENT_FOLDER_NAME. "/";
			//プロジェクト名/Files/Groupstudent_temp/ファイル名
			$excelService->uploadFile($this->form->image_data, $filedir, $_SESSION ['GroupStudent_File']);
			$this->dispatch('ExcelGroupStudentList/viewExcelList');

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

		$imagedir = FILE_DIR. GROUP_STUDENT_FOLDER_NAME. "/";
		//アップロードしたエクセルファイルをアクセスする
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir.$_SESSION ['GroupStudent_File']);

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
			$range = 'A1:'. 'D' . $hrow;
			$title_range = 'A1:'. 'D' . 1;

			$dataTitle = $sheet->rangeToArray($title_range);
			$dataArray = $sheet->rangeToArray($range);

			$array = array_filter($dataArray, 'array_filter');
			$title_arr = unserialize (GROUP_STUDENT_HEADER_LIST);

			$title_flg = 1;
			$col_flg = 1;

			// 列数を確認する
			if ( $hcol != 'D' && $hcol != 'E' ) {

				$col_flg = 0;
			}

			if ( $col_flg == 1 ) {
				// タイトルが間違いがどうか確認する
				for ( $i = 0; $i < 3; $i++ ) {

					if ( $dataTitle[0][$i] != $title_arr[$i] ) {

						$title_flg = 0;
					}
				}
			}

			// グループ・受講者のフォーマットファイルが間違っている時エラーメッセージを表示する
			if ( $col_flg == 0 || $title_flg == 0 ) {

				$error = sprintf(E026,"グループと受講");
				$this->smarty->assign ( 'err_msg', $error );
				$this->smarty->assign ( 'dataArray', null );
			}else {

				$this->smarty->assign ( 'err_msg', '' );
				$this->smarty->assign ( 'dataArray', $array);

				$org_service = new OrganizationService($this->pdo);
				$org_Data = $org_service->getOrgNoByOrgId($array[1][0]);
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
			$this->form->groupstu_max_count = GROUP_STUDENT_MAX_COUNT;
			$_SESSION['org_name_flg'] = $this->form->org_name_flg;
			$_SESSION['db_org_name'] = $this->form->db_org_name;
			// メニュー情報を取得、セットする
			$this->setMenu();
			$this->form->file_name = $_SESSION ['File_Name'] ;
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->assign ( 'btn_flg', '1' );
			$this->smarty->display ( 'excelGroupStudentList.html' );
		}
	}

	/**
	 * 登録処理
	 */
	public function saveAction() {
		if ( $this->check_login () == true ) {

			$org_no = $this->form->org_no;
			$group_no_data = $this->form->grpNoList;
			$group_data = explode ( ',', $group_no_data);
			$resultList = array();
			$stu_no_data = $this->form->stuNoList;
			$stu_data = explode ( ',', $stu_no_data);
			$rowcount = 0;

			$service = new GroupStudentService ( $this->pdo );

			//重複データが無い場合、
			for ( $i = 0; $i < count($group_data); $i++ ) {

				$rowcount = $rowcount + 1;
				// グループ・受講者データ情報登録
				$group_student_dto = new T_Group_StudentDto();

				$group_student_dto->org_no = $org_no;
				$group_student_dto->group_no = $group_data[$i];
				$group_student_dto->student_no = $stu_data[$i];
				$group_student_dto->del_flg = 0;
				$group_student_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
				$group_student_dto->creater_id =  $_SESSION ['admin_no'];
				$group_student_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
				$group_student_dto->updater_id = $_SESSION ['admin_no'];

				$resultList[] = $group_student_dto;
			}

			//グループ・受講者リスト情報を登録する
			$result = $service->insertData( $resultList );
			// 登録処理が正常の場合、成功メーセジを表示する
			if ( $result == 1 ) {

				//登録完了
				$error = sprintf("%sデータ%s行を登録しました。", " グループと受講者", $rowcount);
				$_SESSION ['regist_msg'] = $error;
				$this->dispatch('ExcelGroupStudentList');
			}else {
				$error = sprintf(E007,'登録');
				$_SESSION ['regist_msg'] = $error;
				$this->dispatch('ExcelGroupStudentList');
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
			$file = $dir. GROUP_STUDENT_FILE_NAME;
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
				$this->dispatch('ExcelGroupStudentList');
			}
		}else {
			// エラーメッセージを設定「ログイン情報がありません。トップ画面からログインしてください。」
			TransitionHelper::sendException ( E002 );
			return;
		}

	}

	/**
	 * グループ・受講者重複チェック
	 */
	public function duplicateCheckWocAction() {

		if ( $this->check_login () == true ) {

			$temp = 0;
			$errtemp = 0;
			$group_student_data = $this->form->group_student_data;

			$grp_stu = explode ( ',', $group_student_data);
			$org_id = CommonUtil::htmlEntityDecode($grp_stu[0]);
			$Orgservice = new OrganizationService($this->pdo);
			$org_result = $Orgservice->getOrgNoByOrgId($org_id);
			$this->form->org_no = $org_result->org_no;
			$count = 0;
			$stu_nameid = array("");
			$grp_name = array("");
			$sub_err_arr = '';
			$loop_count = 0;
			for ( $i = 0; $i < count($grp_stu); $i++ ) {
				//HTMLエンティティを文字に変換とエスケープコンマ
				$grp_stu[$i] = CommonUtil::htmlEntityDecode($grp_stu[$i]);
				if ( ($i % 4) == 0 ){

					$loop_count = $loop_count+1;
					$dup_arr_sub = 0;
					array_push($grp_name,CommonUtil::htmlEntityDecode($grp_stu[$i+1]));
					array_push($stu_nameid,CommonUtil::htmlEntityDecode($grp_stu[$i+2]));
					array_push($stu_nameid,CommonUtil::htmlEntityDecode($grp_stu[$i+3]));
				}
			}
			$student_service = new StudentService($this->pdo);
			$group_service = new GroupService($this->pdo);

			$Stu_List = array("");
			$grp_err_arr = '';
			$stu_err_arr = '';
			$grperrtemp = 0;
			$stuerrtemp = 0;
			$grpNoList = array("");
			$grp_no_arr = "";
			$j = 1;
			$stu_no_arr = "";
			for ( $i = 1; $i < count($grp_name); $i++ ) {

				$StuChk_List = array("");
				$group_list = $group_service->getInfoByGroupName($org_result->org_no, $grp_name[$i]);
				if ( empty($group_list) ){

					if ( $grp_err_arr == '' ){

						$grp_err_arr = $i;
					}else {

						$grp_err_arr = $grp_err_arr. ',' . $i;
					}
					$temp = 1;
					$dup_msg = $grp_err_arr . '行目のグループ名';
					$error = sprintf(E029,$dup_msg);
				}else {

					if ( $grp_no_arr == '' ){

						$grp_no_arr = $group_list[0]->group_no;
					}else {

						$grp_no_arr = $grp_no_arr. ',' . $group_list[0]->group_no;
					}

					$StuChk_List = $student_service->checkedValidStudent($org_result->org_no, $stu_nameid[$j], $stu_nameid[$j+1], $group_list[0]->start_period, $group_list[0]->end_period);
					$j = $j + 2;

					if ( count($StuChk_List) == 0 ){
						if ( $stu_err_arr == '' ){

							$stu_err_arr = $i;
						}else {

							$stu_err_arr = $stu_err_arr . ',' . $i;
						}
						$temp = 1;
						$dup_msg = $stu_err_arr . '行目の受講者';
						$error = sprintf(E029,$dup_msg);
					}else {
						if ( $stu_no_arr == '' ){

							$stu_no_arr = $StuChk_List[0]->student_no;
						}else {

							$stu_no_arr = $stu_no_arr. ',' . $StuChk_List[0]->student_no;
						}

						//グループと受講者テーブルで登録する前、重複チェック処理-20190425修正
						$service = new GroupStudentService ( $this->pdo );
						$gpStuCount = $service->checkgpStudent($org_result->org_no, $group_list[0]->group_no, $StuChk_List[0]->student_no);
						if (count($gpStuCount) > 0){
							if ( $gpStu_err_arr == '' ){

								$gpStu_err_arr = $i;
							}else {

								$gpStu_err_arr = $gpStu_err_arr . ',' . $i;
							}
							$temp = 1;
							$dup_msg = $gpStu_err_arr . '行目のグループと受講者が重複しています。';
							$error = $dup_msg;
						}
					}
				}
			}

			$this->form->stuNoList = $stu_no_arr;
			$this->form->grpNoList = $grp_no_arr;
			$_SESSION ['file'] = $this->form->file;
			$this->form->org_name_flg = $_SESSION['org_name_flg'];
			$this->form->db_org_name = $_SESSION['db_org_name'];
			$this->smarty->assign( 'form', $this->form );
			if ( $temp > 0 ){
				$this->setFormData();
				$this->smarty->assign ( 'btn_flg', '1' );
				$this->smarty->assign( 'err_msg', $error );
				$this->smarty->display ( 'excelGroupStudentList.html' );
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

		$imagedir = FILE_DIR. GROUP_STUDENT_FOLDER_NAME. "/";
		//アップロードしたエクセルファイルをアクセスする
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($imagedir.$_SESSION ['GroupStudent_File']);

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
