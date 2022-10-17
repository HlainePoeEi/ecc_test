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

		$(".error_section").slideToggle('slow')

	});

	$("#search").on('click',function(){

		// MSGのあるなし
		if ( $(".error_msg").html() != "" ) {

		   	$(".error_section").slideToggle('slow');
		}

		return true;
	});

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

	function get_previoussibling(n)
	{
		x=n.previousSibling;
		while (x.nodeType!=1)
			{
			   	x=x.previousSibling;
			}
			return x;
	}

	function get_nextsibling(n)
	{
		x=n.nextSibling;
		while ( x != null && x.nodeType!=1)
		{
			x=x.nextSibling;
		}
		return x;
	}

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

	function moveToLowerTable(upper_tblRowNo) {

		var upper_tbl = document.getElementById("testAss_uppertbl"); // 上テーブル

		var no = upper_tbl.rows[upper_tblRowNo].cells[0].innerHTML;

		var course_detail_name = upper_tbl.rows[upper_tblRowNo].cells[2].innerHTML;

		var course_detail_romaji = upper_tbl.rows[upper_tblRowNo].cells[3].innerHTML;

		var course_level = upper_tbl.rows[upper_tblRowNo].cells[4].innerHTML;

		var test_kbn = upper_tbl.rows[upper_tblRowNo].cells[5].innerHTML;

		var time = upper_tbl.rows[upper_tblRowNo].cells[6].innerHTML;

		var course_detail_no = upper_tbl.rows[upper_tblRowNo].cells[1].innerHTML;

		var lower_tbl = document.getElementById("testAss_lowertbl1");// 下テーブル
		var add_flg = true;// 新しい行が入れるため

		// テーブルに行が有るとき
		if (lower_tbl.rows.length >= 1) {
			for (var j = 1; j < lower_tbl.rows.length; j++) {

				// 上テーブルのデータと下テーブルのデータが同じ場合、追加しない
				if ( course_detail_no == lower_tbl.rows[j].cells[1].innerHTML)
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
					var row = createRowLowTbl(
							row_no,
							course_detail_no,
							course_detail_name,
							course_detail_romaji,
							course_level,
							test_kbn,
							time,
							'<button style="background-color:Transparent;border:0px;" onClick="MoveUp.call(this);return false;"'
							+ '><img src="' + '../image/up.svg ' + 'style="width:25px;height:25px;" /> '
							+ '</a><button style="background-color:Transparent;border:0px;" onClick="MoveDown.call(this);return false;"'
							+ '><img src="' + '../image/down.svg" style="width:25px;height:25px;" /></a>',
							'<a href="javascript:moveToUpperTable(' + upper_tblRowNo + ')"'
							+ '><img src="../image/minus.svg" style="width:25px;height:25px;" /></a>'
							);
			$("#testAss_lowertbl1 tbody").append(row);
			document.getElementById("testAss_uppertbl").deleteRow(upper_tblRowNo);

			// 順番する
			rearrangeRowNo();
		}
	}

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

		row.appendChild(col1);
		row.appendChild(col2);
		row.appendChild(col3);
		row.appendChild(col4);
		row.appendChild(col5);
		row.appendChild(col6);
		row.appendChild(col7);
		row.appendChild(col8);

		col1.innerHTML = val1;
		col2.innerHTML = val2;
		col3.innerHTML = val3;
		col4.innerHTML = val4;
		col5.innerHTML = val5;
		col6.innerHTML = val6;
		col7.innerHTML = val7 + " ~ " + val8;
		col8.innerHTML = val9;

		col1.setAttribute("style", "width:150px;");
		col2.setAttribute("style", "width:150px;");
		col3.setAttribute("style", "width:350px;");
		col4.setAttribute("style", "width:350px;");
		col5.setAttribute("style", "width:250px;");
		col6.setAttribute("style", "width:250px;");
		col7.setAttribute("style", "width:300px;");
		col8.setAttribute("style", "width:30px;text-align:center");
		return row;
	}

	function createRowLowTbl(val1, val2, val3, val4, val5, val6, val7, val8, val9) {
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
		col2.innerHTML = val2;// コース詳細番号
		col3.innerHTML = val3;// コース詳細名
		col4.innerHTML = val4;// コース詳細ローマ字
		col5.innerHTML = val5;// レベル
		col6.innerHTML = val6;// SW
		col7.innerHTML = val7;// 利用期間
		col8.innerHTML = val8;// 上下移動ボタン
		col9.innerHTML = val9;// 削除ボタン

		col1.setAttribute("style", "width:150px;");
		col2.setAttribute("style", "width:150px;");
		col3.setAttribute("style", "width:350px;");
		col4.setAttribute("style", "width:350px;");
		col5.setAttribute("style", "width:250px;");
		col6.setAttribute("style", "width:250px;");
		col7.setAttribute("style", "width:300px;");
		col8.setAttribute("style", "width:200px;text-align:center");
		col9.setAttribute("style", "width:20px;text-align:center");
		return row;
	}

	function rearrangeRowNo() {
		rearrangeUpperRowNo();
		rearrangeLowerRowNo();
		$('.btn_reset').show();
	}
	/*
	 * テーブルを順番する
	 */
	function rearrangeLowerRowNo() {
		var newlower_tbl = document.getElementById("testAss_lowertbl1");
		if(newlower_tbl.rows.length <3){
			for (var j = 1; j <= newlower_tbl.rows.length; j++){

				newlower_tbl.rows[j].cells[0].innerHTML = 1;
					newlower_tbl.rows[j].cells[7].innerHTML = '<button style="background-color:Transparent;border:0px;" disabled="disabled" onClick="MoveUp.call(this);return false;"'
							+ '><img src="'
							+ '../image/up.svg'
							+ ' "style="width:25px;height:25px;"/></a><button style="background-color:Transparent;border:0px;" disabled="disabled" onClick="MoveDown.call(this);return false;"'
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

		else{
			for (var j = 1; j < newlower_tbl.rows.length; j++) {
				if(j == 1){
					newlower_tbl.rows[j].cells[0].innerHTML = j;
					newlower_tbl.rows[j].cells[7].innerHTML = '<button style="background-color:Transparent;border:0px;" disabled="disabled" onClick="MoveUp.call(this);return false;"'
							+ '><img src="'
							+ '../image/up.svg'
							+ ' "style="width:25px;height:25px;"/></a><button style="background-color:Transparent;border:0px;" onClick="MoveDown.call(this);return false;"'
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
					newlower_tbl.rows[j].cells[7].innerHTML = '<button style="background-color:Transparent;border:0px;" onClick="MoveUp.call(this);return false;"'
							+ '><img src="'
							+ '../image/up.svg'
							+ ' "style="width:25px;height:25px;"/></a><button style="background-color:Transparent;border:0px;" disabled="disabled" onClick="MoveDown.call(this);return false;"'
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
					newlower_tbl.rows[j].cells[7].innerHTML = '<button style="background-color:Transparent;border:0px;" onClick="MoveUp.call(this);return false;"'
							+ '><img src="'
							+ '../image/up.svg'
							+ ' "style="width:25px;height:25px;"/></a><button style="background-color:Transparent;border:0px;" onClick="MoveDown.call(this);return false;"'
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
	}
	/*
	 * テーブルを順番する
	 */
	function rearrangeUpperRowNo() {

		var newupper_tbl = document.getElementById("testAss_uppertbl");
		for (var j = 1; j < newupper_tbl.rows.length; j++) {
			newupper_tbl.rows[j].cells[0].innerHTML = j;
			newupper_tbl.rows[j].cells[7].innerHTML = '<a href="javascript:moveToLowerTable('
					+ (j)
					+ ')"'
					+ '><img src="'
					+ '../image/add.svg'
					+ '" style="width:25px;height:25px;" /></a>';
		}
	}

	/*
	 * 登録ボタンを押下とき、 formがsubmmitする前準備
	 */
	function insertCourseDetailAssignmentData() {
		// formのデータを取得する

		var homeDir = $('#home_dir').val();
		var course_id = document.getElementById('course_id').value;

		// 下テーブルのデータを取得する
		document.getElementById("entryList").value = readLowerTbl();
		console.log(document.getElementById("entryList").value);

		$("#main_form").submit();
	}
	/*
	 * 登録する前、下テーブルのコース詳細番号データを取得する
	 *
	 */
	function readLowerTbl() {

		var lower_tbl = document.getElementById("testAss_lowertbl1");
		var tblDataArrStr = "";

		// テーブルに行が有るとき
		if (lower_tbl.rows.length > 1) {

			for (var j = 1; j < lower_tbl.rows.length; j++) {

				if (j == 1) {
					tblDataArrStr = lower_tbl.rows[j].cells[1].innerHTML;
				} else
					tblDataArrStr += "," + lower_tbl.rows[j].cells[1].innerHTML;
			}
		}
		return tblDataArrStr;
	}

	function detailSearch() {

		$(".error_section").hide();
		$('#err_dis').hide();
		$(".error_msg").html("");
		$('#err_msg').val("");
		$('#info_msg').val("");

		var upper_tbody=$('#testAss_uppertbl > tbody');
		var course_detail_name = document.getElementById('course_detail_name').value;
		var course_level = document.getElementById('clevel').value;
		var test_kbn = document.getElementById('ckbn').value;
		var homeDir = document.getElementById('home_dir').value;
		var status =$('input[name="rd_status1"]:checked', '#main_form').val();

		$('#rd_status').val(status);
		var rd_status = document.getElementById('rd_status').value;
		var fd = new FormData();
		fd.append('course_detail_name', course_detail_name);
		fd.append('course_level', course_level);
		fd.append('test_kbn', test_kbn);
		fd.append('rd_status', rd_status);
		$.ajax({
			type : 'POST',
			url : homeDir + 'CourseDetailAssignment/searchWoc',
			data : fd,
			datatype : 'JSON',
			processData : false,
			contentType : false
		}).done(

			function(data) {
				if(data=="検索条件に該当するデータが存在しません。"){

					$('#testAss_uppertbl > tbody tr').remove();
					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html(data);
					$('#err_msg').val(data);
					$(".divBody").scrollTop(0);
				}else{

					//tbodyを削除する
					$('#testAss_uppertbl > tbody tr').remove();
					//サーバーのデータをJSONを使って取得する
					var searchList = $.parseJSON(data);

					$.each(searchList, function(i, e) {

						var row =	createRow(e.rowno,
								 e.course_detail_no,
								 e.course_detail_name,
								 e.course_detail_romaji,
								 e.course_level,
								 e.test_kbn,
								 e.start_period,
								 e.end_period
								,'<a href="javascript:moveToLowerTable(' + e.rowno + ')"'
								+ '><img src="../image/add.svg" style="width:25px;height:25px;" /></a>'
								,"");

						upper_tbody.append(row);

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
		document.getElementById("testAss_lowertbl1").deleteRow(lower_tblRowNo);
		var newlower_tbl = document.getElementById("testAss_lowertbl1");
		rearrangeRowNo();
	}

	/*
	 * resetボタンを押下とき、初期の条件に戻る
	 */
	function cancel(url) {
		window.location.href = url;
	}
