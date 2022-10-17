<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseForm.php';

/**
 * 問題登録FORMクラス
 *
 */

class QuestionRegistForm extends BaseForm {

	// 問題管理№
    public $question_no;
    // 問題名
    public $question_name;
    // 問題説明
    public $qa_description;
    // 内容
    public $description;
    // テスト区分
    public $test_kbn;
    // コースレベル
    public $course_level;
    // 問題パターン
    public $qa_pattern;
    // 採点パターン
    public $score_pattern;
    // 音声ファイル名
    public $audio_name;
    // 音声内容
    public $audio_description;
    // 準備時間
    public $prepare_time;
    // 回答時間
    public $answer_time;
    // yes音声ファイル
    public $audio_yes;
    // yes内容
    public $yes_description;
    // no音声ファイル
    public $audio_no;
    // 状態
    public $status;
    // no内容
    public $no_description;
    // 模範解答
    public $sample_answer;
    // 模範解答音声
    public $sample_answer_audio;
    // 描写ポイント
    public $byosha_point;
    /// 更新備考
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
    // 画面モード
    public $screen_mode;
    // テスト区分リスト
    public $test_kbn_list;
    // コースレベルリスト
    public $course_level_list;
    // 問題パターンリスト
    public $qa_pattern_list;
    // 採点パターンリスト
    public $score_pattern_list;
    // 検索ページ
    public $search_page;
    // 検索問題名
    public $search_question_name;
    // 検索テスト区分リスト
    public $search_test_kbn;
    // 検索コースレベル
    public $search_course_level;
    // 検索チェック状態1
    public $search_chk_status1;
    // 検索チェック状態2
    public $search_chk_status2;
    // 検索状態
    public $search_status;
    // 音声データ1
    public $audio_data1;
    // 音声データ2
    public $audio_data2;
    // 音声データ3
    public $audio_data3;
    // 音声データ4
    public $audio_data4;
    // 音声名ラベル
    public $audio_namelbl;
    // yes音声フラベル
    public $audio_yeslbl;
    // no音声フラベル
    public $audio_nolbl;
    // 模範解答フラベル
    public $sample_answerlbl;
    // 模範状態
    public $sample_status;
	
	// アップロードファイルの拡張子
	public $file_ext;
}

?>