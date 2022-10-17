<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

class T_CourseDto extends BaseDto{

	// コースID
	public $course_id;
	// コース名
	public $course_name;
	// コース名ふりがな
	public $course_name_romaji;
	//テスト区分
	public $test_kbn;
	// コースレベル
	public $course_level;
	// 状態
	public $status;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	//更新備考
	public $remarks;
	// マーク合計
	public $total_mark;
	// タイプ
	public $type;
	// cタイプ
	public $ctype;
	// 検査利用終了日
	public $search_start_period;
	// 検査利用終了日
	public $search_end_period;
	// 検査コース名
	public $search_course_name;
	// 検査ページ
	public $search_page;
	// リセット利用終了日
	public $reset_start_period;
	// リセット検査利用終了日
	public $reset_end_period;
	// 組織ID
	public $org_id;
	// 組織名
	public $org_name;
	// 組織番号
	public $org_no;
	// 申込管理番号
	public $offer_no;
	// 受講生数
	public $student_count;
	// 検索テスト区分
	public $search_test_kbn;
	// 検索コースレベル
	public $search_course_level;
}

?>