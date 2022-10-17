<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  ECCー学校向け授業支援
 *
 *  Created by GICM 2017/11/20
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/M_Org_ConfDto.php';

/**
 * 組織設定DAOクラス
 */
class M_Org_ConfDao extends BaseDao {

    /**
     * 組織設定データを取得する
     */
    public function getDataListByData($org_no) {

        $query = " SELECT ";
        $query .= " conf.org_no ";
        $query .= " ,conf.attendance_flg ";
        $query .= " ,conf.period_cnt ";
        $query .= " ,conf.task_file_size ";
        $query .= " ,conf.task_file_ext ";
        $query .= " ,conf.quiz_audio_size ";
        $query .= " ,conf.quiz_img_size ";
        $query .= " ,conf.remarks ";
        $query .= " ,conf.del_flg ";
        $query .= " ,conf.create_dt ";
        $query .= " ,conf.creater_id ";
        $query .= " ,conf.update_dt ";
        $query .= " ,conf.updater_id ";
        $query .= " FROM ";
        $query .= " M_ORG_CONF conf";
        $query .= " WHERE 1=1";
        $query .= " AND conf.del_flg = '0' ";
        $query .= " AND conf.org_no = :org_no ";

        $stmt = $this->pdo->prepare ( $query );
        $stmt->bindParam(":org_no", $org_no,PDO::PARAM_STR);

        return parent::getDataList( $stmt, get_class(new M_OrgConfDto()) );
    }

    public function saveOrg_Conf($dto){

    	return parent::insert ( $dto );

    }

    public function updateOrg_ConfInfo($dto) {

    	$query = " UPDATE ";
    	$query .= " M_ORG_CONF ";
    	$query .= " SET";

    	if (!StringUtil::isEmpty($dto->updater_id)){
    		$query .= " updater_id  = :updater_id ";
    	}

    	if (!StringUtil::isEmpty($dto->update_dt)){
    		$query .= " ,update_dt  = :update_dt ";
    	}

    	$query .= " WHERE ";
    	$query .= " org_no = :org_no ";
    	$query .= " AND del_flg = '0' ";

    	$stmt = $this->pdo->prepare ( $query );
    	$stmt->bindParam ( ":org_no",  $dto->org_no, PDO::PARAM_STR );


    	if (!StringUtil::isEmpty($dto->updater_id)){
    		$stmt->bindParam ( ":updater_id",  $dto->updater_id, PDO::PARAM_STR );
    	}

    	if (!StringUtil::isEmpty($dto->update_dt)){
    		$stmt->bindParam ( ":update_dt",  $dto->update_dt, PDO::PARAM_STR );
    	}

    	return parent::update ( $stmt );
    }
}

?>
