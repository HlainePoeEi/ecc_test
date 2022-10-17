//表示再現
$(document).ready(function() {
	// MSGのあるなし
	if ( $(".error_msg").html() != "" ) {
		$(".error_section").slideToggle('slow')
	}
	$(".post_btn1").on('click',function(){
		$('#main_form').submit();
	});
	$(".close_icon").on('click',function(){
		$(".error_section").slideToggle('slow');
	});
	$("#search").on('click',function(){
		// MSGのあるなし
		if ( $(".error_msg").html() != "" ) {
		   	$(".error_section").slideToggle('slow');
		}
		return true;
	});
	$('#testAss_lowertbl1 > tbody tr td:nth-child(5)').hide();
	// Up AND Down Image and Event
	$(".up,.down").click(function(){
		var row = $(this).parents("tr:first");
		if ($(this).is(".up")) {
			row.insertBefore(row.prev());
		}else {
			row.insertAfter(row.next());
		}
		rearrangeLowerRowNo();
	});
});
function get_previoussibling(n){
	x=n.previousSibling;
	while (x.nodeType!=1){
		x=x.previousSibling;
	}
	return x;
}
function get_nextsibling(n){
	x=n.nextSibling;
	while ( x != null && x.nodeType!=1){
		x=x.nextSibling;
	}
	return x;
}
function MoveUp(){
	var table,
	row = this.parentNode;
	while ( row != null ){
	    if ( row.nodeName == 'TR' ) {
	        break;
	    }
	    row = row.parentNode;
	}
	table = row.parentNode;
	table.insertBefore ( row, get_previoussibling( row ) );
	rearrangeLowerRowNo();
}
function MoveDown(){
	var table,
	row = this.parentNode;
	while ( row != null ) {
		if ( row.nodeName == 'TR' ) {
			break;
		}
	    row = row.parentNode;
	}
	table = row.parentNode;
	table.insertBefore ( row, get_nextsibling ( get_nextsibling( row ) ) );
	rearrangeLowerRowNo();
}
/*
 * テーブルを順番する
 */
function rearrangeLowerRowNo() {
	var newlower_tbl = document.getElementById("testAss_lowertbl1");
	var homeDir = $('#home_dir').val();
	if(newlower_tbl.rows.length <2){
		for (var j = 1; j <= newlower_tbl.rows.length; j++){
			newlower_tbl.rows[j].cells[0].innerHTML = 1;
				newlower_tbl.rows[j].cells[3].innerHTML = '<button style="background-color:#fff;border:0px;" disabled="disabled" onClick="MoveUp.call(this);return false;"'
						+ '><img src="'
						+ homeDir + 'image/up.svg'
						+ ' "style="width:25px;height:25px;"/></a><button style="background-color:#fff;border:0px;" disabled="disabled" onClick="MoveDown.call(this);return false;"'
						+ '><img src="'
						+ homeDir + 'image/down.svg'
						+ ' "style="width:25px;height:25px;" /></a>';
		}
	}else{
		for (var j = 1; j < newlower_tbl.rows.length; j++) {
			if(j == 1){
				newlower_tbl.rows[j].cells[0].innerHTML = j;
				newlower_tbl.rows[j].cells[3].innerHTML = '<button style="background-color:#fff;border:0px;" disabled="disabled" onClick="MoveUp.call(this);return false;"'
						+ '><img src="'
						+ homeDir + 'image/up.svg'
						+ ' "style="width:25px;height:25px;"/></a><button style="background-color:#fff;border:0px;" onClick="MoveDown.call(this);return false;"'
						+ '><img src="'
						+ homeDir + 'image/down.svg'
						+ ' "style="width:25px;height:25px;" /></a>';
			}else if(j == newlower_tbl.rows.length-1 ){

				newlower_tbl.rows[j].cells[0].innerHTML = j;
				newlower_tbl.rows[j].cells[3].innerHTML = '<button style="background-color:#fff;border:0px;" onClick="MoveUp.call(this);return false;"'
						+ '><img src="'
						+ homeDir + 'image/up.svg'
						+ ' "style="width:25px;height:25px;"/></a><button style="background-color:#fff;border:0px;" disabled="disabled" onClick="MoveDown.call(this);return false;"'
						+ '><img src="'
						+ homeDir + 'image/down.svg'
						+ ' "style="width:25px;height:25px;" /></a>';
			}else{
				newlower_tbl.rows[j].cells[0].innerHTML = j;
				newlower_tbl.rows[j].cells[3].innerHTML = '<button style="background-color:#fff;border:0px;" onClick="MoveUp.call(this);return false;"'
						+ '><img src="'
						+ homeDir + 'image/up.svg'
						+ ' "style="width:25px;height:25px;"/></a><button style="background-color:#fff;border:0px;" onClick="MoveDown.call(this);return false;"'
						+ '><img src="'
						+ homeDir + 'image/down.svg'
						+ ' "style="width:25px;height:25px;" /></a>';
			}
		}
	}
}
/*
 * 登録ボタンを押下とき、 formがsubmmitする前準備
 */
function insertQuizInfoAssignmentData() {
	// formのデータを取得する
	var homeDir = $('#home_dir').val();
	var wordbook_id = document.getElementById('wordbook_id').value;
	// 下テーブルのデータを取得する
	document.getElementById("entryList").value = readLowerTbl();
	console.log(document.getElementById("entryList").value);
	$("#main_form").submit();
}
/*
 * 登録する前、下テーブルのstudent_noデータを取得する
 *
 */
function readLowerTbl() {
	var lower_tbl = document.getElementById("testAss_lowertbl1");
	var tblDataArrStr = "";
	// テーブルに行が有るとき
	if (lower_tbl.rows.length > 1) {
		for (var j = 1; j < lower_tbl.rows.length; j++) {
			if (j == 1) {
				tblDataArrStr = lower_tbl.rows[j].cells[4].innerHTML;
			} else
				tblDataArrStr += "," + lower_tbl.rows[j].cells[4].innerHTML;
		}
	}
	return tblDataArrStr;
}
/*
 * resetボタンを押下とき、初期の条件に戻る
 */
function cancel(url) {
	window.location.href = url;
}
