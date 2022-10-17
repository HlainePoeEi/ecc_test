<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  ECCー学校向け授業支援
 *
 *  Created by GICM 2017/11/20
 *
 *****************************************************/

require_once 'dto/BaseDto.php';

/**
 * M組織設定DTOクラス
 */
class M_Org_ConfDto extends BaseDto {

	/* 組織管理No */
	public $org_no;
	/* 出欠対象 */
	public $attendance_flg;
	/* 時限数 */
	public $period_cnt;
	/* 課題ファイルサイズ */
	public $task_file_size;
	/* 課題ファイルタイプ */
	public $task_file_ext;
	/* クイズ音声サイズ */
	public $quiz_audio_size;
	/* クイズ画像サイズ */
	public $quiz_img_size;
	/* 更新備考 */
	public $remarks;
	// 削除フラグ
	public $del_flg;
	//登録日時
	public $create_dt;
	// 登録者ID
	public $creater_id;
	//更新日時
	public $update_dt;
	// 更新者ID
	public $updater_id;
}

?>

