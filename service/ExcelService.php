<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseService.php';
require_once 'helper/LogHelper.php';
require_once 'util/CommonUtil.php';


class ExcelService extends BaseService {

	public function uploadFile($file_data, $filedir, $name){

		// 保存先フォルダ存在チェック

		if (! is_dir ( $filedir )) {
			$res = mkdir ( $filedir, 0777 ,true);
		}

		$fileData = substr($file_data, strpos($file_data, ",") + 1);

		// デコード
		$decodedData = base64_decode ( $fileData );
		// 保存ファイル名
		$filename = $name ;
		$filePath = $filedir . $filename;
		// ファイル書き込み
		$fp = fopen ( $filePath, 'wb');
		fwrite ( $fp, $decodedData );
		fclose ( $fp );

	}
}

?>