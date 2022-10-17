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

class M_TypeDao extends BaseDao {

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
		$query .= ",disp_no";
		$query .= ",del_flg ";
		$query .= "FROM M_TYPE ";
		$query .= " WHERE category = :category ";
		$query .= "  AND del_flg = '0' ";
		$query .= "ORDER BY disp_no";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":category", $categoryId, PDO::PARAM_STR );

		return parent::getDataList ( $stmt, get_class ( new M_typeDto () ) );
	}
	
	public function getQuizType($form){

    	$query = " SELECT ";
    	$query .= " distinct name ";
    	$query .= " ,type";
    	$query .= " FROM M_TYPE ";
    	$query .= " WHERE ";
    	$query .= " del_flg = '0'  ";
    	$query .= " AND category = '010'  ";

    	//ORDER BY
    	$query .= " ORDER BY "; // ORDER By
    	$query .= " type ASC ";
    	$stmt = $this->pdo->prepare ( $query );
    	LogHelper::logDebug($query);

    	return parent::getDataList($stmt, get_class ( new M_TypeDto () ));
    }
}

?>