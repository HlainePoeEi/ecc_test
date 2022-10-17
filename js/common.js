/*
*
* フォーカスアウトの場合、日付形式変換
* 正常：return true; 異常：return false;
*
*/
function changeDateFormat(elem) {

	var date = elem.value;
	var date_ft = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/; // YYYY/MM/DD

	if (date_ft.test(date)) { // 正しい日付形式の場合、日付チェック処理
		selectedArray = date.split('/'),
		dtYear = selectedArray [0];
		dtMonth = selectedArray [1];
		dtDay = selectedArray [2];

		if (dtMonth < 1 || dtMonth > 12) {
			if ( window.location.href.indexOf("DataExport") == -1 ){

				elem.value = '';
			}
			return false;
		}else {
			if (dtMonth.length < 2) {
				dtMonth = '0' + dtMonth;
			}
		}

		if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) {
			if ( window.location.href.indexOf("DataExport") == -1 ){

				elem.value = '';
			}
			return false;
		}

		if (dtMonth == 2){
			var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
			if (dtDay> 29 || (dtDay ==29 && !isleap)) {
				if ( window.location.href.indexOf("DataExport") == -1 ){

					elem.value = '';
				}
				return false;
		   }
		}

		if (dtDay < 1 || dtDay> 31) {
			if ( window.location.href.indexOf("DataExport") == -1 ){

				elem.value = '';
			}
			return false;
		} else {
			if (dtDay.length < 2) {
				dtDay = '0' + dtDay;
			}
		}

		elem.value = dtYear+"/"+dtMonth+"/"+dtDay;
		return true;

	} else if (!isNaN(date) && (date.length == 8) ) { //数字のとき、数値の制御が"8"の場合、チェック処理

		var dtYear = date.substring(0,4);
		var dtMonth = date.substring(4, 6);
		var dtDay = date.substring(6,8);

		if (dtMonth < 1 || dtMonth > 12) {
			if ( window.location.href.indexOf("DataExport") == -1 ){

				elem.value = '';
			}
				return false;
			}

			if ((dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31) {
				if ( window.location.href.indexOf("DataExport") == -1 ){

					elem.value = '';
				}
				return false;
			}

			if (dtMonth == 2) {
				var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
				if (dtDay> 29 || (dtDay ==29 && !isleap)) {
					if ( window.location.href.indexOf("DataExport") == -1 ){

						elem.value = '';
					}
					return false;
				}
			}

			if (dtDay < 1 || dtDay > 31) {
				if ( window.location.href.indexOf("DataExport") == -1 ){

					elem.value = '';
				}
				return false;
			}

			elem.value = dtYear+"/"+dtMonth+"/"+dtDay;
			return true;

	} else {

		if ( window.location.href.indexOf("DataExport") == -1 ){

			elem.value = '';
		}
		return false;

	}
}

//戻るボタン処理
function doBack(action){

	$("#main_form").attr("action", action);
	$("#main_form").submit();
}

/**
*
*/
function jsonParse(s) {
	// remove non-printable and other non-valid JSON chars
	s = s.replace(/[\u0000-\u0019]+/g,"");
	console.log(s);
	return JSON.parse(s);
}

/**
 *メールアドレスのフォーマットチェック
 **/
function isEmail(email){
	return typeof email === 'string' && /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email);
}

//ファイルから登録する日付フォーマットチェック
function dateFormat(date) {
	var date_ft = /^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$/;  // YYYY-MM-DD

	// 正しい日付形式の場合、日付チェック処理
	if (date_ft.test(date)) {
		selectedArray = date.split('-'),
		dtYear = selectedArray [0];
		dtMonth = selectedArray [1];
		dtDay = selectedArray [2];

		if ( dtMonth < 1 || dtMonth > 12 ) {

			return false;
		}else {
			if ( dtMonth.length < 2 ) {

				dtMonth = '0' + dtMonth;
			}
		}
		if ( (dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31 ) {

			return false;
		}
		if ( dtMonth == 2 ) {

			var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
			if ( dtDay> 29 || (dtDay ==29 && !isleap) ) {

				return false;
			}
		}
		if ( dtDay < 1 || dtDay> 31 ) {

			return false;
		}else {
			if ( dtDay.length < 2 ) {

				dtDay = '0' + dtDay;
			}
		}
		return true;

	} else if ( !isNaN(date) && (date.length == 8) ) {
	//数字のとき、数値の制御が"8"の場合、チェック処理
	var dtYear = date.substring(0,4);
	var dtMonth = date.substring(4, 6);
	var dtDay = date.substring(6,8);

		if ( dtMonth < 1 || dtMonth > 12 ) {

			return false;
		}
		if ( (dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31 ) {

			return false;
		}
		if ( dtMonth == 2 ) {

			var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
			if ( dtDay> 29 || (dtDay ==29 && !isleap) ) {

				return false;
			}
		}
		if ( dtDay < 1 || dtDay > 31 ) {

			return false;
		}
		return true;
	}else {
		return false;
	}
}

//重複チェック
function dupCheck(temp){

	var dup_err = [];
	var notSort = "";
	var arr = [];

	Array.prototype.indicesOf = function(x){
		return this.reduce((p,c,i) => c === x ? p.concat(i) : p ,[]);
	};
	for ( j = 0; j < temp.length ; j++ ) {
		var indices = temp.indicesOf(temp[j]);
		if ( indices.length > 1 ){
			if ( notSort == "" ){
				notSort = indices;
			}else {
				notSort = notSort +','+indices;
			}
		}
	}

	// 配列タイプに変える
	var notSort_arr = notSort.split(",");
	// 正しい順序にする
	var sorted_arr = notSort_arr.slice().sort();
	var results = [];
	for ( var i = 0; i < sorted_arr.length - 1; i++ ) {
		results.push(parseInt(sorted_arr[i]) + 1);
		for ( var j = i+1; j < sorted_arr.length - 1; j++ ){
			if ( sorted_arr[i] == sorted_arr[j] ){
				i++;
			}
		}
	}

	function sortNumber(a,b) {
		return a - b;
	}

	dup_err = results.sort(sortNumber);
	return dup_err;
}
//名、読む、備考のチェック
function characterCheck(checkVal){
	var errStrs = ["&lt;","&gt;",":","*","?","\'","\"","/","\\","|","<",">"];
	var error_msg;
	for ( var j = 0, len = errStrs.length; j < len; ++j ) {
		if ( checkVal.indexOf(errStrs[j]) != -1 ) {
			error_msg ="に「"+errStrs[j] +"」は使用できません。";
			return error_msg;
		}
	}
}