<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/M_TypeDto.php';
class TypeDao extends BaseDao {

	/**
	 * 指定したカテゴリのすべての区分を取得する
	 *
	 * @param unknown $categoryId
	 */
	public function getCategoryTypeAll($categoryId) {
		$query = "SELECT ";
		$query .= " category";
		$query .= ",type";
		$query .= ",name";
		$query .= ",sequence";
		$query .= ",del_flg ";
		$query .= "FROM M_TYPE ";
		$query .= " WHERE category = :category ";
		$query .= "  AND del_flg = '0' ";
		$query .= "ORDER BY sequence";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":category", $categoryId, PDO::PARAM_STR );

		return parent::getDataList ( $stmt, get_class ( new M_typeDto () ) );
	}
}