<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_System_NoticeDao.php';
require_once 'service/BaseService.php';

class SystemNoticeService extends BaseService{

	// お知らせ設定画面のデータを取得
	public function getSystemNoticeData($form, $flg) {

		// データベース接続
		$dao = new T_System_NoticeDao();

		return $dao->getSystemNoticeData($form, $flg);
	}

	// お知らせ情報取得
	public function getSystemNoticeInfo($form) {

		// データベース接続
		$dao = new T_System_NoticeDao($this->pdo);

		return $dao->getSystemNoticeInfo($form);
	}

	// 次のシステムお知らせ番号取得
	public function getNextSystemNoticeNo() {

		// データベース接続
		$dao = new T_System_NoticeDao($this->pdo);

		return $dao->getNextSystemNoticeNo();
	}

	// お知らせ設定データ登録
	public function registSystemNoticeData($dto) {

		// データベース接続
		$dao = new T_System_NoticeDao($this->pdo);

		return $dao->insert ( $dto );
	}

	// お知らせ設定データ更新
	public function updateSystemNoticeData($dto) {

		// データベース接続
		$dao = new T_System_NoticeDao($this->pdo);

		return $dao->updateSystemNoticeData( $dto );
	}
}

?>