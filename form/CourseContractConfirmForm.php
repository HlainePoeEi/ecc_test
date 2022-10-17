<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseForm.php';

/**
 * コース契約確認FORMクラス
 *
 */
class CourseContractConfirmForm extends BaseForm {

	// 組織コード
	public $org_id;
	// コースID開始
	public $course_id_to;
	// コースID終了
	public $course_id_from;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// ログインID開始
	public $login_id_from;
	// ログインID終了
	public $login_id_to;
	// 戻り用
	public $back_flg;
	// 最大ページ
	public $max_page;
	// 現ページ
	public $page;
	// 関索ページ
	public $search_page;
	// 関索利用開始日
	public $search_start_period;
	// 関索利用終了日
	public $search_end_period;
	// 関索組織コード
	public $search_org_id;
	// 関索コースID開始
	public $search_course_id_from;
	// 関索コースID終了
	public $search_course_id_to;
	// 関索ログインID開始
	public $search_login_id_from;
	// 関索ログインID終了
	public $search_login_id_to;
	
	public $page_cccl;
	public $page_row_cccl;
	public $page_order_column_cccl;
	public $page_order_dir_cccl;
}