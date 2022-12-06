<?php

/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'helper/LogHelper.php';
require_once 'util/CommonUtil.php';

class AudioService extends BaseService
{

	public function saveAudio($audio_data, $qno, $audio_folder, $name)
	{

		// 保存先フォルダ存在チェック
		$stu_audiodir = STUDENT_FILE_DIR . $audio_folder . "/" . 'qa_' . $qno . '/';

		if (!is_dir($stu_audiodir)) {
			$res = mkdir($stu_audiodir, 0777, true);
		}

		$audioData = substr($audio_data, strpos($audio_data, ",") + 1);

		// デコード
		$decodedData = base64_decode($audioData);
		// 保存ファイル名
		$filename = $name;
		$filePath = $stu_audiodir . $filename;

		// ファイル書き込み
		$fp = fopen($filePath, 'wb');
		fwrite($fp, $decodedData);
		fclose($fp);

		LogHelper::logDebug("audio name is " . $filename);
	}

	public function deleteAudio($qno, $audio_dir, $name)
	{

		// 保存先フォルダ存在チェック
		$stu_audiodir = STUDENT_FILE_DIR . $audio_dir . 'qa_' . $qno . '/';

		if (!is_dir($stu_audiodir)) {
			$flg = true;
		} else {
			$flg = false;
		}

		if ($flg == 'true') {
			return;
		}

		//Studentフォルダのファイルを削除する
		$file_stu = $stu_audiodir . $name;
		if (file_exists($file_stu)) {
			unlink($file_stu);
		}
	}

	public function saveAudioQuiz($audio_data, $org_id, $audio_folder, $name)
	{

		// 保存先フォルダ存在チェック
		$audiodir = ADMIN_FILE_DIR . $org_id . "/" . $audio_folder;

		LogHelper::logDebug("audio dir is " . $audiodir);

		if (!is_dir($audiodir)) {
			$res = mkdir($audiodir, 0777, true);
		}

		$audioData = substr($audio_data, strpos($audio_data, ",") + 1);

		// デコード
		$decodedData = base64_decode($audioData);
		// 保存ファイル名
		$filename = $name;
		$filePath = $audiodir . $filename;
		// ファイル書き込み
		$fp = fopen($filePath, 'wb');
		fwrite($fp, $decodedData);
		fclose($fp);

		LogHelper::logDebug("audio name is " . $filename);
	}
	public function saveAudioQuiz1($audio_data, $audio_folder, $name)
	{

		// 保存先フォルダ存在チェック
		$audiodir = ECCTEST_FILE_DIR . "YNSQuiz" . "/" . $audio_folder;

		LogHelper::logDebug("audio dir is " . $audiodir);

		if (!is_dir($audiodir)) {
			$res = mkdir($audiodir, 0777, true);
		}

		$audioData = substr($audio_data, strpos($audio_data, ",") + 1);

		// デコード
		$decodedData = base64_decode($audioData);
		// 保存ファイル名
		$filename = $name;
		$filePath = $audiodir . $filename;
		// ファイル書き込み
		$fp = fopen($filePath, 'wb');
		fwrite($fp, $decodedData);
		fclose($fp);

		LogHelper::logDebug("audio name is " . $filename);
	}

	public function deleteAudioQuiz($org_no, $audio_dir, $quiz_id)
	{
		// 保存先フォルダ存在チェック
		$audiodir = ADMIN_FILE_DIR . $org_no . "/" . $audio_dir;
		if (!is_dir($audiodir)) {
			return;
		}

		foreach (glob($audiodir . $quiz_id . ".*") as $file) {
			unlink($file);
		}
	}
	public function deleteAudioQuiz1($audio_dir, $quiz_id)
	{
		// 保存先フォルダ存在チェック
		$audiodir = ECCTEST_FILE_DIR . "YNSQuiz" . "/" . $audio_dir;
		if (!is_dir($audiodir)) {
			return;
		}

		foreach (glob($audiodir . $quiz_id . ".*") as $file) {
			unlink($file);
		}
	}
}
