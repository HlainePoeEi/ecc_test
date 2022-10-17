<?php

/**
 * 日付ユーティリティクラス
 *
 */
require_once 'conf/config.php';
class DateUtil
{

	/**
	 * 日付を取得する
	 * デフォルトフォーマット："Y/m/d"
	 */
	public static function getDate($format = "Y/m/d") {

		return date($format, strtotime( DATE_ADJUST. "day " .MONTH_ADJUST."month" ));
	}

	/**
	 * 日付を取得する
	 * デフォルトフォーマット："Y/m/d H:i:s"
	 */
	public static function changeEndDateFormat($date) {

		$format = "Y/m/d H:i:s";
		$time = '23:59:59';

		return date($format, strtotime(self::getYmd($date) . $time));
	}
	
	/**
	 * 日付を取得する
	 * デフォルトフォーマット："Y/m/d H:i:s"
	 */
	public static function changeStartDateFormat($date) {

		$format = "Y/m/d H:i:s";
		$time = '00:00:00';

		return date($format, strtotime(self::getYmd($date) . $time));
	}

	/**
	 * 1ヶ月を加算した日付を取得する
	 * デフォルトフォーマット："Y/m/d"
	 */
	public static function getPreviousDate($format = "Y/m/d") {

		return date($format, strtotime(self::getDate($format) ." ". '-1'. "month "));
	}

	/**
	 * -1ヶ月減少を取得する
	 * デフォルトフォーマット："Y/m/d"
	 */
	public static function getNextDate($format = "Y/m/d") {

		return date($format, strtotime(self::getDate($format) ." ".  '1'. "month "));
	}


	/**
	 * 日を加算した日付を取得する
	 * デフォルトフォーマット："Y/m/d"
	 */
	public static function getDateAddDay($days,$format = "Y/m/d") {

		return date($format, strtotime(self::getDate($format) ." ".  $days. "day "));
	}

	/**
	 * 月を加算した日付を取得する
	 * デフォルトフォーマット："Y/m/d"
	 */
	public static function getDateAddMonth($month, $format = "Y/m/d") {

		return date($format, strtotime(self::getDate($format) ." ".  $month. "month "));
	}

	/* /**
	 * 月を加算した日付を取得する
	 * デフォルトフォーマット："Y/m/d"
	 */
	/*public static function getPrevYear($startDate, $format = "Y/m/d") {

		return date($format, strtotime(date("Y-m-d", strtotime($startDate)) . " - 365 day"));
	} */

	/**
	 * 月を加算した日付を取得する
	 * デフォルトフォーマット："Y/m/d"
	 */
	public static function getNextYear($endDate, $format = "Y/m/d") {

		return strtotime(date($format, strtotime($endDate.'+1 Year'.'-1 month')));

	}

	/**
	 * 月を加算した日付を取得する
	 * デフォルトフォーマット："Y/m/d"
	 */
	public static function getMonth($year, $format = "Y/m/d") {

		$month = date("m",strtotime($year));
		$day = date("d",strtotime($year));
		$this_year = self::getDate('Y-m-d');
		$year= date("Y",strtotime($this_year));

		return  date($format, strtotime($year. $month.  $day));
	}

	/**
	 * 年を加算した日付を取得する
	 * デフォルトフォーマット："Y/m/d"
	 */
	public static function getDateAddYear($year, $format = "Y/m/d") {

		return date($format, strtotime(self::getDate($format) ." ".  $year. "year "));
	}

	/**
	 * 月を加算した日付を取得する
	 * デフォルトフォーマット："Y/m/d"
	 */
	public static function getYmd($date) {

		$format = "Y/m/d";

		return date($format, strtotime($date));
	}

	/**
	 * エクセルのため日付のフォーマットチェック
	 * デフォルトフォーマット："Y-m-d"
	 */
	public static function isValidDateFormat($date, $format = 'Y-m-d'){
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	
	/**
	 * 月を加算した日付を取得する
	 * デフォルトフォーマット："Y/m/d"
	 */
	public static function addMonthToDate($month,$date, $format = "Y/m/d") {

		return date($format, strtotime(self::getYmd($date) ." ".  $month. "month "));
	}
}

?>