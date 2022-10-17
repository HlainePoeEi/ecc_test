<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/T_WordBookListDto.php';
/**
 * T_WordBookListDAOクラス
 *
 */
class T_WordBookListDao extends BaseDao {
		/*
		* 単語帳一覧画面のデータを取得する
		*/
		public function getWordBookListData($param, $flg) {
			$query = $this->createQuery();
			$query .= $this->createSearchWhere($param);
			$stmt = $this->pdo->prepare ( $query );
			$this->setSearchParam($stmt, $param);
			return parent::getDataList($stmt, get_class(new T_WordBookListDto()) );
		}

		public function createQuery(){
			$query = " SELECT ";
        	$query .= " t_wordbook.wordbook_id wordbook_id ";
			$query .= " ,t_wordbook.name name ";
        	$query .= " ,org.org_name org_name ";
			$query .= " ,org.org_id org_id ";
			$query .= " ,org.org_no org_no ";
        	$query .= " FROM ";
			$query .= " T_WORDBOOK t_wordbook ";
        	$query .= " LEFT JOIN M_ORGANIZATION as org ";
        	$query .= "	ON t_wordbook.org_no = org.org_no ";
			return $query;
		}

		public function createSearchWhere( $param ){
			$query = " WHERE ";
			$query .= " t_wordbook.word_system_kbn != '003' ";
			$query .= " AND t_wordbook.del_flg = '0' ";
				if ( ! StringUtil::isEmpty($param->search_name) ){
					$query .= " AND (t_wordbook.name LIKE :name ) ";
				}
				if ( ! StringUtil::isEmpty($param->search_org_id) ){
					$query .= " AND (org.org_id LIKE :org_id ) ";
				}
			$query .= " ORDER BY ";
			$query .= " t_wordbook.wordbook_id DESC";
			return $query;
		}

		/**
		* パラメータバインド
		*
		*/
		public function setSearchParam($stmt, $param){
			if ( ! StringUtil::isEmpty($param->search_name) ){
				$name =  '%'.$param->search_name.'%';
				$stmt->bindParam(":name", $name, PDO::PARAM_STR);
			}
			if ( ! StringUtil::isEmpty($param->search_org_id) ){
				$org_id =  '%'.$param->search_org_id.'%';
				$stmt->bindParam(":org_id", $org_id, PDO::PARAM_STR);
			}
		}
}
?>