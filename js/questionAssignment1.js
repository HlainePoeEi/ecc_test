//表示再現
$(document).ready(function() {
	// MSGのあるなし
	if ( $(".error_msg").html() != "" ) {

		$(".error_section").slideToggle('slow');

	}

	$(".post_btn1").on('click',function(){

		$('#main_form').submit();

	});

	$(".close_icon").on('click',function(){

		$(".error_section").slideToggle('slow')

	});

	$("#search").on('click',function(){

		// MSGのあるなし
		if ( $(".error_msg").html() != "" ) {

			$(".error_section").slideToggle('slow');
		}

		return true;
	});

	// question_no の列を非表示にする
	$('#questionAss_uppertbl > tbody tr td:nth-child(9)').hide();
	$('#questionAss_lowertbl > tbody tr td:nth-child(10)').hide();

	// 画像のイベントのアップ/ダウン
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

	//上の行を取得する
	function get_previoussibling(n)
	{
		x=n.previousSibling;
		while (x.nodeType!=1)
			{
				x=x.previousSibling;
			}
			return x;
	}
	//下の行を取得する
	function get_nextsibling(n)
	{
		x=n.nextSibling;
		while ( x != null && x.nodeType!=1)
		{
			x=x.nextSibling;
		}
		return x;
	}

	// 上に移動する
	function MoveUp()
		{
			var table,
			row = this.parentNode;

			while ( row != null ) {
				if ( row.nodeName == 'TR' ) {
					break;
				}
				row = row.parentNode;
			}
			table = row.parentNode;
			table.insertBefore ( row, get_previoussibling( row ) );
			rearrangeLowerRowNo();
		}

	// 下に移動する
	function MoveDown()
	{
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

	// 上のテーブルの行が下のテーブルに移動する
	function moveToLowerTable(upper_tblRowNo) {

		var upper_tbl = document.getElementById("questionAss_uppertbl"); // 上テーブル

		var rowno = upper_tbl.rows[upper_tblRowNo].cells[0].innerHTML;

		var question_name = upper_tbl.rows[upper_tblRowNo].cells[1].innerHTML;

		var qa_description = upper_tbl.rows[upper_tblRowNo].cells[2].innerHTML;

		var test_kbn = upper_tbl.rows[upper_tblRowNo].cells[3].innerHTML;

		var course_level = upper_tbl.rows[upper_tblRowNo].cells[4].innerHTML;

		var qa_pattern = upper_tbl.rows[upper_tblRowNo].cells[5].innerHTML;

		var score_pattern = upper_tbl.rows[upper_tblRowNo].cells[6].innerHTML;

		var question_no = upper_tbl.rows[upper_tblRowNo].cells[8].innerHTML;
		// 下テーブル
		var lower_tbl = document.getElementById("questionAss_lowertbl");
		// 新しい行が入れるため
		var add_flg = true;

		// テーブルに行が有るとき
		if (lower_tbl.rows.length >= 1) {
			for (var j = 1; j < lower_tbl.rows.length; j++) {

				// 上テーブルのデータと下テーブルのデータが同じ場合、追加しない
				if ( question_no == lower_tbl.rows[j].cells[9].innerHTML)
				{
					add_flg = false;
					break;
				}
			}
		}
		// 上テーブルのデータが下テーブルのデータにない場合、追加する
		if (add_flg == true) {

			var tbody = document.createElement('tbody');
			var row_no =upper_tbl.rows[upper_tblRowNo].cells[0].innerHTML;
					var row = createRowLowTbl('1', question_name
						,qa_description, test_kbn, course_level, qa_pattern, score_pattern,'<button style="background-color:transparent;border:0px;" onClick="MoveUp.call(this);return false;"'
							+ '><img src="' + '../image/up.svg ' + 'style="width:25px;height:25px;" /> '
							+ '</a><button style="background-color:transparent;border:0px;" onClick="MoveDown.call(this);return false;"'
							+ '><img src="' + '../image/down.svg" style="width:25px;height:25px;" /></a>',
					'<a href="javascript:moveToUpperTable(' + upper_tblRowNo + ')"'
							+ '><img src="../image/minus.svg" style="width:25px;height:25px;" /></a>',question_no);
			$("#questionAss_lowertbl tbody").append(row);
			$('#questionAss_lowertbl > tbody tr td:nth-child(10)').hide();
			document.getElementById("questionAss_uppertbl").deleteRow(upper_tblRowNo);

			// 順番する
			rearrangeRowNo();
		}
	}

	// 上のテーブルの新しい行を作成する
	function createRow(val1, val2, val3, val4, val5, val6, val7, val8, val9) {
		var row = document.createElement('tr');
		var col1 = document.createElement('td');
		var col2 = document.createElement('td');
		var col3 = document.createElement('td');
		var col4 = document.createElement('td');
		var col5 = document.createElement('td');
		var col6 = document.createElement('td');
		var col7 = document.createElement('td');
		var col8 = document.createElement('td');
		var col9 = document.createElement('td');
		var length = 20;

		row.appendChild(col1);
		row.appendChild(col2);
		row.appendChild(col3);
		row.appendChild(col4);
		row.appendChild(col5);
		row.appendChild(col6);
		row.appendChild(col7);
		row.appendChild(col8);
		row.appendChild(col9);

		col1.innerHTML = val1;// rowno
		col2.innerHTML = val2;// question_name
		col3.innerHTML = (val3 === null || val3 === '') ? '' :val3.substring(0,length) + '...';// qa_description
		col4.innerHTML = val4;// test_kbn
		col5.innerHTML = val5;// course_Level
		col6.innerHTML = val6;// qa_pattern
		col7.innerHTML = val7;// score_pattern
		col8.innerHTML = val8;// image
		col9.innerHTML = val9;// question_no

		col1.setAttribute("style", "width:50px;");
		col2.setAttribute("style", "width:230px;");
		col3.setAttribute("style", "width:300px;");
		col4.setAttribute("style", "width:160px;");
		col5.setAttribute("style", "width:160px;");
		col6.setAttribute("style", "width:160px;");
		col7.setAttribute("style", "width:130px;");
		col8.setAttribute("style", "width:90px;text-align:center");
		col9.setAttribute("style", "width:50px;text-align:center;");
		return row;
	}

	// 下のテーブルの新しい行を作成する
	function createRowLowTbl(val1, val2, val3, val4, val5, val6, val7, val8, val9, val10) {

		var row = document.createElement('tr');
		var col1 = document.createElement('td');
		var col2 = document.createElement('td');
		var col3 = document.createElement('td');
		var col4 = document.createElement('td');
		var col5 = document.createElement('td');
		var col6 = document.createElement('td');
		var col7 = document.createElement('td');
		var col8 = document.createElement('td');
		var col9 = document.createElement('td');
		var col10 = document.createElement('td');

		row.appendChild(col1);
		row.appendChild(col2);
		row.appendChild(col3);
		row.appendChild(col4);
		row.appendChild(col5);
		row.appendChild(col6);
		row.appendChild(col7);
		row.appendChild(col8);
		row.appendChild(col9);
		row.appendChild(col10);

		col1.innerHTML = val1;// rowno
		col2.innerHTML = val2;// question_name
		col3.innerHTML = val3;// qa_description
		col4.innerHTML = val4;// test_kbn
		col5.innerHTML = val5;// course_level
		col6.innerHTML = val6;// qa_pattern
		col7.innerHTML = val7;// score_pattern
		col8.innerHTML = val8;// up and down images
		col9.innerHTML = val9;// minus image
		col10.innerHTML = val10;// question_no

		col1.setAttribute("style", "width:50px;");
		col2.setAttribute("style", "width:200px;");
		col3.setAttribute("style", "width:300px;");
		col4.setAttribute("style", "width:160px;");
		col5.setAttribute("style", "width:160px;");
		col6.setAttribute("style", "width:160px;");
		col7.setAttribute("style", "width:180px;");
		col8.setAttribute("style", "width:90px;text-align:center");
		col9.setAttribute("style", "width:50px;text-align:center;");
		col10.setAttribute("style", "width:50px;");
		return row;
	}

	// テーブルを順番する
	function rearrangeRowNo() {
		rearrangeUpperRowNo();
		rearrangeLowerRowNo();
		$('.btn_reset').show();
	}

	/*
	 * テーブルを順番する
	 */
	function rearrangeLowerRowNo() {
		var newlower_tbl = document.getElementById("questionAss_lowertbl");

		if(newlower_tbl.rows.length <3){
			for (var j = 1; j <= newlower_tbl.rows.length; j++){

					newlower_tbl.rows[j].cells[7].innerHTML = '<button style="background-color:transparent;border:0px;" disabled="disabled" onClick="MoveUp.call(this);return false;"'
							+ '><img src="'
							+ '../image/up.svg'
							+ ' "style="width:25px;height:25px;"/></a><button style="background-color:transparent;border:0px;" disabled="disabled" onClick="MoveDown.call(this);return false;"'
							+ '><img src="'
							+ '../image/down.svg'
							+ ' "style="width:25px;height:25px;" /></a>';
					newlower_tbl.rows[j].cells[8].innerHTML = '<a href="javascript:moveToUpperTable('
							+ (j)
							+ ')"'
							+ '><img src="'
							+ '../image/minus.svg'
							+ '" style="background-color:transparent;width:25px;height:25px;" /></a>';
			}
		}
		else{
			for (var j = 1; j < newlower_tbl.rows.length; j++) {
				if(j == 1){
					newlower_tbl.rows[j].cells[0].innerHTML = j;
					newlower_tbl.rows[j].cells[7].innerHTML = '<button style="background-color:transparent;border:0px;" disabled="disabled" onClick="MoveUp.call(this);return false;"'
							+ '><img src="'
							+ '../image/up.svg'
							+ ' "style="width:25px;height:25px;"/></a><button style="background-color:transparent;border:0px;" onClick="MoveDown.call(this);return false;"'
							+ '><img src="'
							+ '../image/down.svg'
							+ ' "style="width:25px;height:25px;" /></a>';
					newlower_tbl.rows[j].cells[8].innerHTML = '<a href="javascript:moveToUpperTable('
							+ (j)
							+ ')"'
							+ '><img src="'
							+ '../image/minus.svg'
							+ '" style="width:25px;height:25px;" /></a>';
				}else if(j == newlower_tbl.rows.length-1 ){

					newlower_tbl.rows[j].cells[0].innerHTML = j;
					newlower_tbl.rows[j].cells[7].innerHTML = '<button style="background-color:transparent;border:0px;" onClick="MoveUp.call(this);return false;"'
							+ '><img src="'
							+ '../image/up.svg'
							+ ' "style="width:25px;height:25px;"/></a><button style="background-color:transparent;border:0px;" disabled="disabled" onClick="MoveDown.call(this);return false;"'
							+ '><img src="'
							+ '../image/down.svg'
							+ ' "style="width:25px;height:25px;" /></a>';
					newlower_tbl.rows[j].cells[8].innerHTML = '<a href="javascript:moveToUpperTable('
							+ (j)
							+ ')"'
							+ '><img src="'
							+ '../image/minus.svg'
							+ '" style="width:25px;height:25px;" /></a>';
				}else{
					newlower_tbl.rows[j].cells[0].innerHTML = j;
					newlower_tbl.rows[j].cells[7].innerHTML = '<button style="background-color:transparent;border:0px;" onClick="MoveUp.call(this);return false;"'
							+ '><img src="'
							+ '../image/up.svg'
							+ ' "style="width:25px;height:25px;"/></a><button style="background-color:transparent;border:0px;" onClick="MoveDown.call(this);return false;"'
							+ '><img src="'
							+ '../image/down.svg'
							+ ' "style="width:25px;height:25px;" /></a>';
					newlower_tbl.rows[j].cells[8].innerHTML = '<a href="javascript:moveToUpperTable('
							+ (j)
							+ ')"'
							+ '><img src="'
							+ '../image/minus.svg'
							+ '" style="width:25px;height:25px;" /></a>';
				}
			}
		}
		$('#questionAss_lowertbl > tbody tr td:nth-child(10)').hide();
	}

	/*
	 * テーブルを順番する
	 */
	function rearrangeUpperRowNo() {
		var newupper_tbl = document.getElementById("questionAss_uppertbl");
		for (var j = 1; j < newupper_tbl.rows.length; j++) {

			newupper_tbl.rows[j].cells[0].innerHTML = j;
			newupper_tbl.rows[j].cells[7].innerHTML = '<a href="javascript:moveToLowerTable('
					+ (j)
					+ ')"'
					+ '><img src="'
					+ '../image/add.svg'
					+ '" style="width:25px;height:25px;" /></a>';
		}
			$('#questionAss_uppertbl > tbody tr td:nth-child(9)').hide();
	}

	/*
	 * 登録ボタンを押下とき、 formがsubmmitする前準備
	 */
	function insertQuestionAssignmentData() {
		// formのデータを取得する

		var homeDir = $('#home_dir').val();
		var course_detail_no = document.getElementById('course_detail_no').value;
		// 下テーブルのデータを取得する
		document.getElementById("entryList").value = readLowerTbl();
		console.log(document.getElementById("entryList").value);

		$("#main_form").submit();
	}

	/*
	 * 登録する前、下テーブルのcourse_detail_noデータを取得する
	 *
	 */
	function readLowerTbl() {

		var lower_tbl = document.getElementById("questionAss_lowertbl");
		var tblDataArrStr = "";

		// テーブルに行が有るとき
		if (lower_tbl.rows.length > 1) {

			for (var j = 1; j < lower_tbl.rows.length; j++) {
				if (j == 1) {
					tblDataArrStr = lower_tbl.rows[j].cells[9].innerHTML;

				} else
					tblDataArrStr += "," + lower_tbl.rows[j].cells[9].innerHTML;
			}
		}
		return tblDataArrStr;
	}

	//上テーブルのため検索する
	function questionSearch() {

		$(".error_section").hide();
		$('#err_dis').hide();
		$(".error_msg").html("");
		$('#err_msg').val("");
		$('#info_msg').val("");
		var upper_tbody=$('#questionAss_uppertbl > tbody');
		var course_detail_no = document.getElementById('course_detail_no').value;
		var question_name = document.getElementById('question_name').value;
		var course_level = document.getElementById('course_level').value;
		var test_kbn = document.getElementById('test_kbn').value;
		var status = "";
		if($('#chk_status1').prop('checked') === true){
			if(status == "")
				status = $('#chk_status1').attr('value');
			else
				status += $('#chk_status1').attr('value');
		}

		if($('#chk_status2').prop('checked') === true){

			if(status == "")
				status = $('#chk_status2').attr('value');
			else
				status += ',' + $('#chk_status2').attr('value');
		}

		$('#status').val(status);

		var status = document.getElementById('status').value;
		var homeDir = document.getElementById('home_dir').value;

		var fd = new FormData();
		fd.append('course_detail_no', course_detail_no);
		fd.append('question_name', question_name);
		fd.append('course_level', course_level);
		fd.append('test_kbn', test_kbn);
		fd.append('status', status);
		$.ajax({
			type : 'POST',
			url : homeDir + 'QuestionAssignmentList/searchAllWoc',
			data : fd,
			datatype : 'JSON',
			processData : false,
			contentType : false
		}).done(

			function(data) {
				if(data=="検索条件に該当するデータが存在しません。"){
					$('#questionAss_uppertbl > tbody tr').remove();
					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html(data);
					$('#err_msg').val(data);
					$(".divBody").scrollTop(0);
				}else{
					//tbodyを削除する
					$('#questionAss_uppertbl > tbody tr').remove();

					//サーバーのデータをJSONを使って取得する
					var searchList = $.parseJSON(data);
					console.log(searchList);
					$.each(searchList, function(i, e) {
						var row = createRow(e.rowno,
								 e.question_name, e.qa_description, e.test_kbn, e.course_level, e.qa_pattern, e.score_pattern
								,'<a href="javascript:moveToLowerTable(' + e.rowno + ')"'
								+ '><img src="../image/add.svg" style="width:25px;height:25px;" /></a>',e.question_no,"");
						upper_tbody.append(row);
						$('#questionAss_uppertbl > tbody tr td:nth-child(9)').hide();
					});

					rearrangeUpperRowNo();
				}
			}).fail(function(data) {
			console.log("error");
		});
		$('.btn_reset').show();
	}

	/*
	 * 下のテブルのデータを上に移動する
	 */
	function moveToUpperTable(lower_tblRowNo) {
		// 下テーブルの行を削除する
		document.getElementById("questionAss_lowertbl").deleteRow(lower_tblRowNo);
		var newlower_tbl = document.getElementById("questionAss_lowertbl");
		rearrangeRowNo();
	}

	/*
	 * resetボタンを押下とき、初期の条件に戻る
	 */
	function cancel(url) {
		window.location.href = url;
	}
