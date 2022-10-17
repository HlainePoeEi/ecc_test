<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * T_TeacherCourseDetailDTOクラス
 */
class T_Teacher_Course_DetailDto extends BaseDto {

	// 講師管理№
	public $teacher_no;
	// コース詳細管理№
	public $course_detail_no;
	// 削除フラグ
	public $del_flg;
	// 登録者ＩＤ
	public $creater_id;
	// 登録日時
	public $create_dt;
	// 更新者ＩＤ
	public $updater_id;
	// 更新日時
	public $update_dt;
}

?>