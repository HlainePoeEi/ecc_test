<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_CourseStatusDao.php';
require_once 'service/BaseService.php';

class CourseStatusService extends BaseService{

	public function getCourseList($form , $flg){
		// データベース接続
		$dao = new T_CourseStatusDao();
		// ユーザ名とパスワード取得
		return $dao->getCourseList($form, $flg);
	}
}
?>