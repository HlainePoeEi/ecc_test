<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'dto/T_Course_OrgDto.php';
require_once 'service/CourseOrgService.php';
require_once 'util/DateUtil.php';
require_once 'dto/T_Course_Org_ConfDto.php';

/**
 * コース契約登録コントローラー
 */
class CourseContractRegistController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			// 一覧画面のデータテーブル情報セット
			$this->setDatatableInfo($this->form);
			$this->setMenu();
			// コース情報設定
			$this->getCourseData($this->form);
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 画面データ取得・渡す処理
	 */
	public function getCourseData($myForm) {

		$course_id = $myForm->se_course_id;
		$org_id = $myForm->org_id;
		$offer_no = $myForm->offer_no;

		// メニュー情報を取得、セットする
		$this->setMenu();

		// コース契約情報取得
		if ( $course_id != "" && $org_id != "" && $offer_no != "" ){

			$service = new CourseOrgService($this->pdo);
			$CourseContractInfo = $service->getCourseContractInfo($myForm);
			
			$org_id = $CourseContractInfo->org_id;
			$org_name = $CourseContractInfo->org_name;
			$org_name_official = $CourseContractInfo->org_name_official;
			$remarks = $CourseContractInfo->remarks;
			$start_period = $CourseContractInfo->start_period;
			$end_period = $CourseContractInfo->end_period;
			$CourseContractInfo->course_id = $course_id;
			$CourseContractInfo->se_course_id = $course_id;
			
			// 結果表示フラグ初期設定
			$confInfo = $service->getCourseOrgConfInfo($myForm);
			$this->form->fb_show_flg = 0;
			if ( count($confInfo) == 1 ){
				$this->form->fb_show_flg  =  $confInfo[0]->fb_show_flg;
			}
			$this->smarty->assign( 'fb_show_flg',	$this->form->fb_show_flg  );

			$this->smarty->assign( 'info_msg', "" );
			$this->smarty->assign( 'error_msg', "" );

			$CourseContractInfo->search_page = $this->form->search_page;
			$CourseContractInfo->search_start_period = $this->form->search_start_period;
			$CourseContractInfo->search_end_period = $this->form->search_end_period;
			$CourseContractInfo->search_org_id = $this->form->search_org_id;
			$CourseContractInfo->search_org_name = $this->form->search_org_name;
			$CourseContractInfo->search_test_kbn = $this->form->search_test_kbn;
			$CourseContractInfo->search_course_level = $this->form->search_course_level;
			$CourseContractInfo->search_course_name = $this->form->search_course_name;

			if ( $this->form->btn_flg == 1 ){

				$CourseContractInfo->remarks = $this->form->remarks;
				$CourseContractInfo->start_period = $this->form->contract_start_period;
				$CourseContractInfo->end_period = $this->form->contract_end_period;
				$CourseContractInfo->search_start_period = $this->form->contract_list_start_period;
				$CourseContractInfo->search_end_period = $this->form->contract_list_end_period;
			}
			$this->smarty->assign( 'form', $CourseContractInfo);
			$this->smarty->display ( 'courseContractRegist.html' );
		}else {

			// テンプレートにデータ渡す
			$this->displayInit($myForm);
		}
	}

	/**
	 * 初期表示処理
	 */
	public function displayInit($myForm) {

		$this->form->se_course_id = "";
		$this->form->org_id = "";
		$this->form->org_no = "";
		$this->form->course_id = "";
		$this->form->offer_no = "";
		$this->form->course_detail_no = "";
		$this->form->remarks = "";
		$this->smarty->assign( 'error_msg', "" );
		$this->smarty->assign( 'org_name', "" );
		$this->smarty->assign( 'org_name_official', "" );
		$this->smarty->assign( 'info_msg',"" );
		$this->setBackDataToDisplay();
		$this->form->start_period = "";
		$this->form->end_period = "";
		$this->smarty->assign( 'form', $myForm );

		$this->smarty->display( 'courseContractRegist.html' );
	}

	/**
	 * 組織情報表示ボタン処理
	 */
	public function orgShowAction(){

		if ( $this->check_login() == true ){

			$service = new CourseOrgService($this->pdo);
			$org_id = $this->form->org_id;
			$result = $service->getOrgName($org_id);
			if ( count($result) > 1 ){

				$this->smarty->assign( 'info_msg', "" );
				$this->smarty->assign( 'error_msg', E016 );
				$this->form->org_name = "";
				$this->form->org_name_official = "";
				$this->displayValue($this->form);
			}else if ( count($result) == 0 ){

				$this->smarty->assign( 'info_msg', "" );
				$this->smarty->assign( 'error_msg', E015 );
				$this->form->org_name = "";
				$this->form->org_name_official = "";
				$this->displayValue($this->form);
			}else {

				$courseOrgDto = new T_Course_OrgDto();
				$this->smarty->assign ( 'org_name', $result[0]->org_name);
				$this->form->org_name = $result[0]->org_name;
				$this->form->org_name_official = $result[0]->org_name_official;
				$this->displayValue($this->form);
			}
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * コース情報表示ボタン処理
	 */
	public function courseShowAction(){

		if ( $this->check_login() == true ){

			$service = new CourseOrgService($this->pdo);
			$course_id = $this->form->course_id;
			$result = $service->getCourseName($course_id);
			if ( count($result) > 1 ){

				$this->smarty->assign( 'info_msg', "" );
				$this->smarty->assign( 'error_msg', E016 );
				$this->form->course_name = "";
				$this->displayValue($this->form);
			}elseif ( count($result) == 0 ){

				$this->smarty->assign( 'info_msg', "" );
				$this->smarty->assign( 'error_msg', E015 );
				$this->form->course_name = "";
				$this->displayValue($this->form);
			}else {

				if ( $result[0]->status != 1 ){

					$error_msg = sprintf( E021, 'コース' );
					$this->smarty->assign( 'error_msg', $error_msg );
					$this->smarty->assign( 'info_msg', "" );
					$this->form->course_name = "";
					$this->displayValue($this->form);
				}else{

					$courseOrgDto = new T_Course_OrgDto();
					$this->smarty->assign ( 'course_name', $result[0]->course_name);
					$this->form->course_name = $result[0]->course_name;
					$this->displayValue($this->form);
				}
			}
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 画面登録ボタン処理
	 */
	public function saveAction() {

		if ( $this->check_login() == true ){

			$admin_id = $_SESSION ['admin_no'];
			$org_no = $this->form->org_no;
			$offer_no = $this->form->offer_no;
			$service = new CourseOrgService($this->pdo);
			// 申込管理№がない場合、新規追加
			if ( $offer_no == "" ){

				$org_id = $this->form->org_id;
				$service = new CourseOrgService ($this->pdo);
				$result = $service->getOrgName($org_id);
				if ( count($result) > 1 || count($result) == 0 ){

					$this->smarty->assign( 'info_msg', "" );
					$this->smarty->assign( 'error_msg', E017 );
					$this->displayValue($this->form);
				}else {

					$this->form->org_no = $result[0]->org_no;
					$course_id = $this->form->course_id;
					$result1 = $service->getCourseName($course_id);
					if ( count($result1) > 1 || count($result1) == 0 ){

						$this->smarty->assign( 'info_msg', "" );
						$this->smarty->assign( 'error_msg', E018 );
						$this->displayValue($this->form);
					}else {

						$currentdate = date('Y/m/d');
						if ( $result1[0]->end_period < $currentdate ){

							$this->smarty->assign( 'info_msg', "" );
							$this->smarty->assign( 'error_msg', E023 );
							$this->displayValue($this->form);
						}else {

							if ( $result1[0]->status != 1 ){

								$error_msg = sprintf( E021, 'コース' );
								$this->smarty->assign( 'error_msg', $error_msg );
								$this->smarty->assign( 'info_msg', "" );
								$this->displayValue($this->form);
							}else {

								$courseOrgDto = new T_Course_OrgDto();
								$courseOrgDto->course_id = $this->form->course_id;
								$courseOrgDto->org_no = $this->form->org_no;
								$courseOrgDto->remarks = $this->form->remarks;
								$courseOrgDto->start_period = $this->form->start_period;
								$courseOrgDto->end_period = DateUtil::changeEndDateFormat($this->form->end_period);
								$courseOrgDto->creater_id = $admin_id;
								$courseOrgDto->updater_id = $admin_id;
								$courseOrgDto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
								$courseOrgDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );

								$check_result = $service->checkCourseOrgData ( $courseOrgDto );
								if ( count($check_result) > 0 ){

									$this->smarty->assign( 'info_msg', "" );
									$this->smarty->assign( 'error_msg', E022 );
									$this->displayValue($this->form);
								}else {

									// 次の申込管理№取得
									$offer_no_data = $service->getNextOfferNo ();
									$offer_no = $offer_no_data->id;
									$this->form->offer_no = $offer_no;
									$courseOrgDto->offer_no = $offer_no;
									$this->form->org_no = $result[0]->org_no;
									$save_result = $service->registCourseOrgData ( $courseOrgDto );

									// 登録処理成功の場合
									if ( $save_result > 0 ){
										
										// コース組織契約設定情報を新規登録する
										$dto = new T_Course_Org_ConfDto();
										$dto->offer_no = $offer_no;
										$dto->course_id = $courseOrgDto->course_id ;
										$dto->org_no = $courseOrgDto->org_no;
										$dto->fb_show_flg = $this->form->fb_show_flg;
										$dto->creater_id = $admin_id;
										$dto->updater_id = $admin_id;
										$dto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
										$dto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
										
										$result = $service->setCourseOrgConfData($dto);
										LogHelper::logDebug($dto);

										$this->form->org_name = $result[0]->org_name;
										$this->form->org_name_official= $result[0]->org_name_official;
										$this->form->course_name = $result1[0]->course_name;
										$this->form->se_course_id = $this->form->course_id;
										$this->smarty->assign( 'info_msg', I004 );
										$this->smarty->assign( 'error_msg', "" );
										$this->displayValue($this->form);
									}else {

										$error_msg = sprintf( E007, '登録' );
										$this->smarty->assign( 'error_msg', $error_msg );
										$this->smarty->assign( 'info_msg', "" );
										$this->displayValue($this->form);
										return;
									}
								}
							}
						}
					}
				}
			}else {

				$courseOrgDto = new T_Course_OrgDto();
				$courseOrgDto->offer_no = $offer_no;
				$courseOrgDto->org_no = $org_no;
				$courseOrgDto->course_id = $this->form->course_id;
				$courseOrgDto->remarks = $this->form->remarks;
				$courseOrgDto->show_flg = $this->form->show_flg;
				$courseOrgDto->start_period = $this->form->start_period;
				$courseOrgDto->end_period = DateUtil::changeEndDateFormat($this->form->end_period);
				$courseOrgDto->updater_id = $admin_id;
				$courseOrgDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );

				$check_result = $service->checkCourseOrgData ( $courseOrgDto );
				if ( count($check_result) > 0 ){

					$this->smarty->assign( 'info_msg', "" );
					$this->smarty->assign( 'error_msg', E022 );
					$this->displayValue($this->form);
				}else {

					$update_result = $service->updateCourseOrgData ( $courseOrgDto );
					
					// コース組織契約設定情報を新規登録する
					$dto = new T_Course_Org_ConfDto();
					$dto->offer_no = $offer_no;
					$dto->course_id = $courseOrgDto->course_id ;
					$dto->org_no = $courseOrgDto->org_no;
					$dto->fb_show_flg = $this->form->fb_show_flg;
					$dto->creater_id = $admin_id;
					$dto->updater_id = $admin_id;
					$dto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
					$dto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
					
					$result = $service->setCourseOrgConfData($dto);
					LogHelper::logDebug($dto);

					// 更新処理成功の場合
					if ( $update_result > 0 && $result > 0 ){

						$this->smarty->assign( 'info_msg', I004 );
						$this->smarty->assign( 'error_msg', "" );
						$this->displayValue($this->form);
					}else {

						$error_msg = sprintf( E007, '更新' );
						$this->smarty->assign( 'error_msg', $error_msg );
						$this->smarty->assign( 'info_msg', "" );
						$this->displayValue($this->form);
						return;
					}
				}
			}
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 画面上値設定処理
	 */
	public function displayValue($myForm) {

		$this->smarty->assign( 'form', $myForm );
		$this->smarty->display( 'courseContractRegist.html' );
	}

	/**
	 * 削除処理
	 */
	public function deleteAction() {

		if ( $this->check_login() == true ){

			$user_id = $_SESSION ['admin_no'];
			$course_id = $this->form->se_course_id;
			$org_no = $this->form->org_no;
			$offer_no = $this->form->offer_no;
			$service = new CourseOrgService($this->pdo);

			$CourseOrgDto = new T_Course_OrgDto();
			$CourseOrgDto->course_id = $course_id;
			$CourseOrgDto->org_no = $org_no;
			$CourseOrgDto->offer_no = $offer_no;
			$CourseOrgDto->updater_id = $user_id;
			$CourseOrgDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
			$result = $service->delCourseOrgData($CourseOrgDto);

			// 削除処理成功の場合
			if ( $result > 0 ){

				$_SESSION ['error_msg'] = I005;
				$_SESSION ['search_start_period'] = $this->form->search_start_period;
				$_SESSION ['search_end_period'] = $this->form->search_end_period;
				$_SESSION ['search_course_name'] = $this->form->search_course_name;
				$_SESSION ['search_test_kbn'] = $this->form->search_test_kbn;
				$_SESSION ['search_course_level'] = $this->form->search_course_level;
				$_SESSION ['search_org_name'] = $this->form->search_org_name;
				$_SESSION ['search_org_id'] = $this->form->search_org_id;
				$_SESSION ['search_page'] = $this->form->search_page;
				$this->dispatch("CourseContractList/search");
			}else {

				$error_msg = sprintf( E007, '削除' );
				$this->smarty->assign( 'error_msg', $error_msg );
				$this->smarty->assign( 'info_msg', "" );
				$this->displayValue($this->form);
				return;
			}
		}else {

			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	public function setBackDataToDisplay(){

		$this->form->page = $this->form->search_page;
		$this->form->start_period = $this->form->search_start_period;
		$this->form->end_period = $this->form->search_end_period;
		$this->form->sc_org_name = $this->form->search_org_name;
		$this->form->sc_test_kbn = $this->form->search_test_kbn;
		$this->form->sc_course_level = $this->form->search_course_level;
		$this->form->sc_course_name = $this->form->search_course_name;
	}
	
	public function setDatatableInfo($form){
							
		$_SESSION ['page_ccl'] = $form->page_ccl;
		$_SESSION ['page_row_ccl'] = $form->page_row_ccl;
		$_SESSION ['page_order_column_ccl'] = $form->page_order_column_ccl;
		$_SESSION ['page_order_dir_ccl'] = $form->page_order_dir_ccl;
	}

}