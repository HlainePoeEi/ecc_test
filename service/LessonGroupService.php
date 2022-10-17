<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/
require_once 'dao/M_Lesson_TargetDao.php';
require_once 'conf/config.php';
require_once 'service/BaseService.php';

class LessonGroupService extends BaseService {

	/*　ファイルのためレッソンがあるかどうかをチェック　*/
	public function getLessonListByName($org_no,$lesson_name){
		// データベース接続
		$lessDao = new M_Lesson_TargetDao( $this->pdo );
		return  $lessDao->getLessonListByName($org_no,$lesson_name);
	}

	/* 入力するデータの条件によるＴグループのリストを取得する */
	public function getLessonGpSearchList( $org_no,$lesson_no,$group_name ) {
		$dao = new M_Lesson_TargetDao ();
		return $dao->getLessonGpSearchList ($org_no,$lesson_no,$group_name);
	}

	/* レッスン・グループデータ登録 */
	public function insertData($resultList) {
		// データベース接続
		$dao = new M_Lesson_TargetDao($this->pdo);
		return $dao->insertData($resultList , $this->pdo);
	}

	/* レッスン・グループテーブルで登録する前、重複チェック処理-20190425修正 */
	public function lessonTargetCount($org_no, $lesson_no, $group_no) {
		$dao = new M_Lesson_TargetDao($this->pdo);
		return $dao->lessonTargetCount( $org_no, $lesson_no, $group_no);
	}

}
