<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseForm.php';

/**
 * 問題一覧FORMクラス
 *
 */

class QuestionListForm extends BaseForm{

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
    // no内容
    public $no_description;
    // 状態
    public $status;
    // 模範解答
    public $sample_answer;
    // 描写ポイント
    public $byosha_point;
    // 更新備考
    public $remarks;
    // チェック状態1
    public $chk_status1;
    // チェック状態2
    public $chk_status2;
    // 現ページ
    public $page;
    // 最大ページ
    public $max_page;
    // テスト区分リスト
    public $test_kbn_list;
    // コースレベルリスト
    public $course_level_list;
    // 検索ページ
    public $search_page;
    // 検索問題名
    public $search_question_name;
    // 検索テスト区分
    public $search_test_kbn;
    // 検索コースレベル
    public $search_course_level;
    // 検索チェック状態1
    public $search_chk_status1;
    // 検索チェック状態2
    public $search_chk_status2;
    // 検索状態
    public $search_status;
}

?>