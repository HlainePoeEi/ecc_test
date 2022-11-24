<?php

/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

/**
 * 設定ファイル
 *
 */
// define ( "HOME_DIR", "/phpfw/" );
// define ( "SYS_ROOT", "C:/xampp/htdocs".HOME_DIR );
// define ( "SERVER_URL", "https://172.16.15.185".HOME_DIR );

define("HOME_DIR", "/ecc_test/");
define("STUDENT_HOME_DIR", "/student_dev/");
define("SYS_ROOT", __DIR__ . '/../');
define("SERVER_URL", 'https://' . $_SERVER['SERVER_NAME'] . HOME_DIR);
define("FILE_DIR", $_SERVER["DOCUMENT_ROOT"] . HOME_DIR . "files/");
define("FILE_DIR_TASK_CONFIRM", SERVER_URL . "files/");
define("EXCEL_FORMAT_FOLDER_NAME", "excel_format");
define("SYS_ROOT_STU",  $_SERVER["DOCUMENT_ROOT"] . STUDENT_HOME_DIR);
define("STUDENT_FILE_DIR", $_SERVER["DOCUMENT_ROOT"] . STUDENT_HOME_DIR . "files/");
define("AUDIO_DIR", "files/audio/");
define("ADMIN_HOME_DIR", "/admin_dev/");
define("ADMIN_FILE_DIR", $_SERVER["DOCUMENT_ROOT"] . ADMIN_HOME_DIR . "files/");

//エクセルファイルから登録
define("STUDENT_FILE_NAME", "student_file.xlsx");
define("CONTRACT_FILE_NAME", "contract_file.xlsx");
define("CONTRACT_2SKILL_FILE_NAME", "contract_2skill_file.xlsx");
define("SUBJECT_AREA_FILE_NAME", "subject_area_file.xlsx");
define("LESS_FILE_NAME", "lesson_file.xlsx");
define("LESSGP_FILE_NAME", "lessonGroup_file.xlsx");
define("MANAGER_FILE_NAME", "manager_file.xlsx");
define("GROUP_STUDENT_FILE_NAME", "groupStudent_file.xlsx");
define("GROUP_FILE_NAME", "group_file.xlsx");
define("SUBJ_FILE_NAME", "subject_file.xlsx");
define("STUDENT_NO_CHANGE_FILE_NAME", "studentNoChange_file.xlsx");

//エクセルTempファイル
define("STUDENT_FOLDER_NAME", "student_temp");
define("CONTRACT_FOLDER_NAME", "contract_temp");
define("CONTRACT_2SKILL_FOLDER_NAME", "contract_2skill_temp");
define("SUBJECT_AREA_FOLDER_NAME", "subject_area_temp");
define("LESS_FOLDER_NAME", "lesson_temp");
define("MANAGER_FOLDER_NAME", "manager_temp");
define("LESSGP_FOLDER_NAME", "lessonGroup_temp");
define("SUBJ_FOLDER_NAME", "subject_temp");
define("GROUP_STUDENT_FOLDER_NAME", "groupStudent_temp");
define("GROUP_FOLDER_NAME", "group_temp");
define("STUDENT_NO_CHANGE_FOLDER_NAME", "studentnochange_temp");

define("DB_CONNECT_STRING", "mysql:host=localhost;dbname=eccsaishin;charset=utf8");
define("DB_CONNECT_USER", "root");
define("DB_CONNECT_PASSWORD", "");

/* Image/Audio フィルチェック */
define("F001", "%s/%s/%s/%s");
define("AUDIO_FILE", "files");
define("QUIZ_AUDIO_DIR", "Quiz/audio/");
define("QUIZ_INFO_AUDIO_DIR", "QuizInfo/audio/");
define("FILE_DIR1", $_SERVER["DOCUMENT_ROOT"] . HOME_DIR);

define("ERROR_PAGE", HOME_DIR . "Error/disp");
define("MAINTENANCE_PAGE", HOME_DIR . "Maintenance/disp");
define("SMARTY_FILE", "libs/smarty/libs/Smarty.class.php");

define("LOGGER_CLASS", "libs/log4php/src/main/php/Logger.php");
define("LOG_CONFIG", "libs/log4php/src/main/php/config.xml");
define("LOG_MDC_CLASS", "libs/log4php/src/main/php/LoggerMDC.php");

define("SESSION_KEY_LOGIN_TIME", "login_time");
define("SESSION_KEY_DATA", "data");
define("SESSION_KEY_FORM", "form");

define("TIMEOUT_PERIOD", 3660);
define("NG", 0);
define("OK", 1);

define("TEMPLATE_DIR", "templates/");
define("TEMPLATE_C_DIR", "templates_c/");

define("I001", "%d件のデータが見つかりました。");

//入力チェック
define("I002", "%sを入力してください。");

//登録、更新メッセージ
define("I003", "%sが正常完了しました。");

//登録
define("I004", "登録が完了しました。");

define("I005", "削除が完了しました。");
define("I006", "%sデータ%s行を登録しました。");
define("I007", "更新が完了しました。");
define("W001", "検索条件に該当するデータが存在しません。");
define("W002", "登録内容が失われますがよろしいですいか？");

//パスワードチェック
define("W003", "新パスワードと新パスワード（確認用）を正しく入力ください。");
define("W004", "利用開始日 ≦ 利用終了日 を正しく入力ください。");
define("W005", "該当テストにクイズがありません。");
define("W006", "対象の受講生が存在しないか既に登録済みです。");
define("W007", "利用開始を正しく入力ください。");
define("W008", "利用終了を正しく入力ください。");

define("E001", "予期しない例外が発生しました。");
define("E002", "ログイン情報がありません。トップ画面からログインしてください。");
define("E003", "データベースにアクセスできません。管理者に問い合わせてください。");
define("E004", "指定されたページは存在しません。");
define("E005", "別プロセスによってデータが変更されています。");

//ログイン出来ない場合
define("E006", "%sまたは%sが正しくありません。");
define("E007", "%sが失敗しました。");
define("E008", "データが重複しています。");

//登録・更新が出来ない場合
define("E009", "登録は失敗しました。");
define("E010", "更新は失敗しました。");

//開始時間が完了時間以降になる場合
define("E011", "利用期間が不正です");

//対象データがない場合
define("E012", "取得結果がありません。");

//取得結果が複数データになっている場合
define("E013", "取得結果は1件以上になっています。");

define("E014", "%sが重複しています。");
define("E015", "検索結果がありません。");
define("E016", "検索結果が複数あります。");
define("E017", "組織ログインIDが正しくありません。");
define("E018", "コースIDが正しくありません。");
define("E019", "%sがないので%s出来ません。");
define("E020", "問題情報がありません。");
define("E021", "%sが公開していません。");
define("E022", "同じ契約は登録できません。");
define("E023", "コースの利用期間が有効ではない。");

//パスワードチェック
define("E024", "パスワードとパスワード（確認）が一致していません。");
define("E025", "新パスワードと新パスワード（確認）が一致していません。");

//ファイルから登録のチェック
define("E026", "%sのフォーマットファイルが間違っています。");
define("E027", "異なる組織IDがあります。");
define("E028", "組織IDが正しくありません。");
define("E029", "%sがデータベースに存在しません。");
define("E030", "フォーマットファイルがありません。");
define("E031", "コースにあるコース詳細が正しくありません。");
define("E032", "コース詳細と受講者データが重複しています");
define("E033", "行目の組織IDが正しくありません。<br/>");
define("E034", "行目の受講者情報が正しくありません。<br/>");
define("E035", "行目の契約情報が確認できません。<br/>");
define("E036", "行目のコース詳細受講者データ登録済みです。登録できません。<br/>");
define("E037", "行目のコース詳細受講開始日が契約期間内にありません。<br/>");
define("E038", "行目のコース詳細受講終了日が契約期間内にありません。<br/>");
define("E039", "行目のコース受講者データ登録済みです。登録できません。");
define("PHP_EXTENSION", ".php");

define("CONTROLLER_DIR", "controllers/");
define("FORM_DIR", "form/");
define("CONTROLLER_CLASS_SUFFIX", "Controller");
define("FORM_CLASS_SUFFIX", "Form");
define("ACTION_METHOD_SUFFIX", "Action");
define("DTO_CLASS_SUFFIX", "Dto");

define("REQUEST_URI", "REQUEST_URI");

define("DEFAULT_CONTROLLER_NAME", "Index");
define("DEFAULT_ACTION_NAME", "index");

define("PAGE_ROW", 10);
define("AUDIO_EXT", ".mp3");
define("Q_AUDIO_DIR", "audio/");

//運用管理者権限
define("T_ADMIN_KBN", "011");

//日付加算
const DATE_ADJUST = "0";
const MONTH_ADJUST = "0";
const SUB_ADMIN_KBN = "002";

// 組織の教師区分
const SUB_TEACHER_KBN = "003";

//テスト区分
const TEST_KBN = '016';

//コースレベル区分
const COURSE_LEVEL_KBN = "021";

//Speaking 問題パターン
const SQA_PATTERN = '017';

//Writing 問題パターン
const WQA_PATTERN = '018';

//採点パターン
const SCORE_PATTERN = '022';

//組織でのメイン管理者
const MAIN_ADMIN_KBN = "001";

//有償区分
const CAT_ORG_TYPE = "001";

//組織種類
const CAT_ORG_KBN = "002";

//機能区分
const CAT_FUN_TYPE = "013";

//管理者権限
const MANAGER_KBN = "003";

//スピーチテスト区分
const SPEAKING_TEST_KBN = "001";

//書き込みテスト区分
const WRITING_TEST_KBN = "002";
const TARGET_KBN = "015";
const SCHOOL_KBN = "012";

const STU_CATEGORG_REGIT = "001";

//運用管理者権限でメニュー表示
const ADMIN_KBN = "001";
const ADMIN_FOLLOW_KBN = "002";
const ADMIN_4SKILL_KBN = "003";
const CEBU_TEACHER_KBN = "004";
const BU_ADMIN_KBN = "005";

//エクセルファイルから登録出来る行
//教科登録行
const SUBJECT_AREA_MAX_COUNT = "100";
//受講者登録行　　　　　　 
const STUDENT_MAX_COUNT = "500";
//契約情報登録最大行数　　　　　　　　　　　 
const CONTRACT_MAX_COUNT = "100";
//レッスン登録行　　　　　　　　　　　 
const LESS_MAX_COUNT = "100";
//グループ・受講者登録行
const GROUP_STUDENT_MAX_COUNT = "1000";
//グループ登録行　 
const GROUP_MAX_COUNT = "100";
//担当者登録行　　　　　　　　　　　　 
const MANAGER_MAX_COUNT = "100";
//レッスン・グループ登録行　　　　　　　　　 
const LESSGP_MAX_COUNT = "300"; //20190606 100件を300件に変更
//科目登録行　
const SUBJ_MAX_COUNT = "100";
//受講者番号更新行
const STUDENT_NO_CHANGE_MAX_COUNT = "500";
//共通試験の組織
const COMMON_TEST_INFO_ORG = "99999";
//テストタイプカテゴリー（009）
const TEST_TYPE_KBN = "009";
//クイズカテゴリー（010）
const QUIZ_CATEG_KBN = '010';

define("COURSE_CONTRACT_CONFIRM_OUTPUT", "dev_CourseContractConfirm");

//抽出するエクセルファイルのタイトル
define("COURSE_CONTRACT_CONFIRM_LIST", serialize(array('組織ID', '組織表示名', '組織正式名', 'Offer No.', 'コースID', 'コース名', 'コースの利用開始日', 'コースの利用終了日', 'コースの申込番号', '受講生のログインID', '受講生名', 'コース詳細名', 'コース詳細の利用開始日', 'コース詳細の利用終了日', 'コース詳細の受講日', 'コース詳細の採点日', '講師コード', '氏名', '所属校舎', '結果')));

//エクセルファイルから登録
//教科エクセルタイトル名
define("SUBJECT_AREA_HEADER_LIST", serialize(array('組織ID', '教科名', '読み', '利用開始', '利用終了', '表示順', '備考')));
//受講者エクセルタイトル名
define("STUDENT_HEADER_LIST", serialize(array('組織ID', '受講者名', '番号', '読み', '性別', 'ログインID', 'パスワード', 'メールアドレス', '利用開始', '利用終了', '備考')));
//レッスンエクセルタイトル名
define("LESS_HEADER_LIST", serialize(array('組織ID', 'レッスン名', '読み', '学年', '利用開始', '利用終了', '科目', '公開', '備考', '担当1', '担当2', '担当3', '担当4', '担当5', '担当6', '担当7', '担当8', '担当9', '担当10', '担当11', '担当12')));
//レッスン・グループエクセルタイトル名
define("LESSGP_HEADER_LIST", serialize(array('組織ID', 'レッスン名', 'グループ名')));
//科目エクセルタイトル名
define("SUBJ_HEADER_LIST", serialize(array('組織ID', '科目名', '読み', '教科', '利用開始', '利用終了', '表示順', '備考')));
//担当者エクセルタイトル名
define("MANAGER_HEADER_LIST", serialize(array('組織ID', '担当者名', '読み', 'ログインID', 'パスワード', 'メールアドレス', '利用開始', '利用終了', '備考', '教科1', '教科2', '教科3', '教科4', '教科5', '教科6', '教科7', '教科8', '教科9', '教科10')));
//グループ・受講者エクセルタイトル名
define("GROUP_STUDENT_HEADER_LIST", serialize(array('組織ID', 'グループ名', '受講者ログインID', '受講者名')));
//グループエクセルタイトル名
define("GROUP_HEADER_LIST", serialize(array('組織ID', 'グループ名', '読み', '学年', '利用開始', '利用終了', '備考')));
// 受講者番号更新
define("STUDENT_NO_CHANGE_HEADER_LIST", serialize(array('組織ID', 'ログインID', '受講者名', '番号', '備考')));
//契約情報エクセルタイトル名
define("CONTRACT_HEADER_LIST", serialize(array('Offer No.', '組織ID', 'コースID', 'コース詳細番号', 'ログインID',  'コース詳細受講開始日', 'コース詳細受講終了日')));
//2技能契約受講者情報登録エクセルタイトル名
define("CONTRACT_2SKILL_HEADER_LIST", serialize(array('Offer No.', '組織ID', 'コースID', '受講者名', 'ログインID',  'コース詳細受講開始日', 'コース詳細受講終了日')));
// データ抽出
// 担当者データ抽出
define("MANAGER_OUTPUT", "dev_Manager");
define("MANAGER_LIST", serialize(array('抽出日', '抽出時刻', '組織ＩＤ', '組織名', '担当者管理番号', '管理者権限', '担当者名', '読み', 'ログインＩＤ', 'メールアドレス', '教科数', '利用開始', '利用終了', '備考', '登録日', '更新日', '抽出者ログインＩＤ', '抽出者名')));
// 教科：科目 データ抽出
define("SUBJECT_AREA_SUBJECT_OUTPUT", "dev_SubjectAreaSubject");
define("SUBJECT_AREA_SUBJECT_LIST", serialize(array('抽出日', '抽出時刻', '組織ＩＤ', '組織名', '教科管理番号', '教科名', '教科読み', '教科利用開始', '教科利用終了', '教科表示順', '教科備考', '教科登録日', '教科更新日', '科目管理番号', '科目名', '科目読み', '科目利用開始', '科目利用終了', '科目表示順', '科目備考', '科目登録日', '科目更新日', '抽出者ログインＩＤ', '抽出者名')));
//レッスンデータ抽出
define("LESSON_OUTPUT", "dev_Lesson");
define("LESSON_LIST", serialize(array('抽出日', '抽出時刻', '組織ＩＤ', '組織名', 'レッスン管理番号', 'レッスン名', '読み', '学年', '利用開始', '利用終了', '科目', '公開', '備考', '担当者数', 'グループ数', '受講者数', '登録日時', '更新日時', '抽出者ログインＩＤ', '抽出者名')));
// 受講者 データ抽出
define("STUDENT_OUTPUT", "dev_Student");
define("STUDENT_LIST", serialize(array('抽出日', '抽出時刻', '組織ＩＤ', '組織名', '受講者管理番号', '受講者名', '番号', '読み', '性別', 'ログインＩＤ', 'メールアドレス', '利用開始', '利用終了', '備考', '登録日', '更新日', '抽出者ログインＩＤ', '抽出者名')));
//グループ:受講者データ抽出
define("GROUP_STUDENT_OUTPUT", "dev_GroupStudent");
define("GROUP_STUDENT_LIST", serialize(array('抽出日', '抽出時刻', '組織ＩＤ', '組織名', 'グループ管理番号', 'グループ名', '学年', 'グループ利用開始', 'グループ利用終了', '受講者管理番号', 'ログインＩＤ', '受講者名', '受講者読み', '受講者番号', '性別', '受講者利用開始', '受講者利用終了', '抽出者ログインＩＤ', '抽出者名')));
// グループデータ抽出ータ抽出
define("GROUP_OUTPUT", "dev_Group");
define("GROUP_LIST", serialize(array('抽出日', '抽出時刻', '組織ＩＤ', '組織名', 'グループ管理番号', 'グループ名', '読み', '学年', '利用開始', '利用終了', '備考', '受講者数', '登録日', '更新日', '抽出者ログインＩＤ', '抽出者名')));
// レッスン グループ 受講者データ抽出ータ抽出
define("LESSON_GROUP_STUDENT_OUTPUT", "dev_LessonGroupStudent");
define("LESSON_GROUP_STUDENT_LIST", serialize(array('抽出日', '抽出時刻', '組織ＩＤ', '組織名', 'レッスン管理番号', 'レッスン名', 'レッスン学年', 'レッスン利用開始', 'レッスン利用終了', 'グループ管理番号', 'グループ名', 'グループ学年', 'グループ利用開始', 'グループ利用終了', '受講者管理番号', '受講者ログインＩＤ', '受講者名', '番号', '性別', '受講者利用開始', '受講者利用終了', '抽出者ログインＩＤ', '抽出者名')));
// 担当者．教科．レッスンデータ抽出
define("MANAGER_SUBJECTAREA_LESSON_OUTPUT", "dev_ManagerSubjectAreaLesson");
define("MANAGER_SUBJECTAREA_LESSON_LIST", serialize(array('抽出日', '抽出時刻', '組織ＩＤ', '組織名', '担当者管理番号', '担当者ログインＩＤ', '担当者名', '担当者利用開始', '担当者利用終了', '担当者教科名', 'レッスン管理番号', '科目名', 'レッスン名', 'レッスン利用開始', 'レッスン利用終了', '抽出者ログインＩＤ', '抽出者名')));
//パスワードの長さ
define("MIN_PASSWORDLENGTH", 8);
define("MAX_PASSWORDLENGTH", 20);

// 単語追加機能
// define("F001", "%s/%s/%s/%s");
// define("AUDIO_FILE", "files");
// define("FILE_DIR1", $_SERVER["DOCUMENT_ROOT"] . HOME_DIR);

const WORD_CATEG_KBN = '003';
const AT_TYPE_TEST = '001';
const AT_TYPE_COURSE = '002';

const FLAG_1 = '1';
