<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/M_Lesson_ManagerDto.php';

/**
 * 管理者教師DAOクラス
 */
class M_Lesson_ManagerDao extends BaseDao {

	/***
	 * レッスン担当登録
	 * @param object $student_dto
	 * @param array $lm_dto_arr
	 * @return integer type
	 */
	public function insertLessMData($lm_dto_arr){
		//レッスン担当 登録
		for($lm=0;$lm<count($lm_dto_arr);$lm++){
			$result=parent::insert ($lm_dto_arr[$lm]);
			if($result !=1){
				break;
			}
		}
		return $result;
	}
}

?>