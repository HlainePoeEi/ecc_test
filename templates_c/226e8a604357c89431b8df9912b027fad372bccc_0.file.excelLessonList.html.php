<?php
/* Smarty version 3.1.29, created on 2022-10-13 11:47:09
  from "/var/www/html/eccadmin_dev/templates/excelLessonList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_63477c2db336d0_10547910',
  'file_dependency' => 
  array (
    '226e8a604357c89431b8df9912b027fad372bccc' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/excelLessonList.html',
      1 => 1553234938,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:leftMenu.html' => 1,
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_63477c2db336d0_10547910 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>レッスンエクセル登録</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta name="robots" content="noindex, nofollow">
		<meta name="googlebot" content="noindex, nofollow">
		
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/jquery.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/jquery-ui.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/common.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/moment.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/datatables.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/datatables.min.js"><?php echo '</script'; ?>
>
		
		<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/style.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/datatables.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/datatables.min.css" rel="stylesheet">
		<?php echo '<script'; ?>
>
			$(document).ready(function() {
				// MSGのあるなし
				if ( $(".error_msg").html() != "" ) {

					$(".error_section").slideDown('slow')
				}

				$(".close_icon").on('click',function(){

					$(".error_section").slideUp('slow')

				});

				//アップロードボタン処理
				$("#btn_upload").on('click',function(e) {

					var input_file = $("#input_file").val();

					//インプットファイル必須チェック
					if ( input_file == "" ) {

						error_msg = "ファイルを選択してください。";
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html(error_msg);
						$('#err_dis')[0].focus();
						return false;
					}
				});
				// イベントを隠しボタンに変更する
				document.getElementById('img_btn').addEventListener('click',function(){
					document.getElementById('input_file').click();
				});

				// ------------------------------------------------------------
				// Base64化する
				// ------------------------------------------------------------
				File.prototype.convertToBase64 = function(callback){
					var reader = new FileReader();
					reader.onload = function(e) {
						callback(e.target.result)
					};
					reader.onerror = function(e) {
						callback(null);
					};
					reader.readAsDataURL(this);
				};

				// ------------------------------------------------------------
				// ファイルを選択した時に実行されるイベント
				// ------------------------------------------------------------
				$("input[type=file]#input_file").on("change", function () {
					// ファイルのタイプチェック
					var fileExtension = ['xlsx','xls','csv'];//'xlsm'
					//クレア組織名
					if($('.tsk_regist_tbl2 tr:eq(1)').length>0){
						$('.tsk_regist_tbl2 tr:eq(1)').remove();
					}
					if ( $.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1 ) {
						$('#input_file').val('');
						$("#file_name").val('');
						$("#img_flg").val(0);
						error_msg = "正しいファイルを選択してください。";
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html(error_msg);
						return false;
					} else {

						var file_data = "";
						var selectedFile = this.files[0];
						// 画像ファイルデータ設定
						if ( selectedFile != null ){

							selectedFile.convertToBase64(function(base64){
								file_data = base64;
								$("#file_data").val(base64);
							});
						} else{

							file_data = "";
							$("#file_data").val("");
						}

						var fileName = $('input[type=file]').val();
						var clean = fileName.split('\\').pop();
						$("#file_name").val(clean);
						$("#img_flg").val(1);
						$('#copy_image_file').val('');

						 // 画像ファイル拡張子設定
						if ( input_file.value != "" ){
							image_ext = "." + input_file.value.split('.').pop();
							$("#image_ext").val(image_ext);
						}
					}

					$('.excelDiv').hide();
					$('#hide1').show();
					$('#hide2').show();
					return true;
				});

				//データテーブルを表示する
				var dataArray = $("#dataArray").val();
				if ( dataArray != "" ) {
					var t = $('#less_tbl').DataTable({
						"scrollY": 300,
						"scrollX": true,
						"ordering": false,
						"pageLength": 100,//デフォルトの件表示
						"columnDefs": [ {
							"searchable": false,
							"orderable": false,
							"targets": 0
						} ],
						"oLanguage": {
							"sUrl": "<?php echo @constant('HOME_DIR');?>
files/japanese.json"
						}
					});

					t.on( 'draw.dt', function () {
						var PageInfo = $('#less_tbl').DataTable().page.info();
						t.column(0, { page: 'current' }).nodes().each( function (cell, i) {
							cell.innerHTML = i+1+ PageInfo.start;
						});
					});
				}
				var rowCount = $('#less_tbl tr').length - 1;
				var colCount = $('#less_tbl th').length - 1;
				var org_id;
				var lesson_name;
				var lesson_name_kana;
                var start_period;
				var end_period;
				var grade_no;
				var subject_no;
				var status;
				var remarks;
				var manager_no1;
				var manager_no2;
				var manager_no3;
				var manager_no4;
				var manager_no5;
				var manager_no6;
				var manager_no7;
				var manager_no8;
				var manager_no9;
				var manager_no10;
				var manager_no11;
				var manager_no12;
				var less_data = [];
				var arr = [];
				for ( var h = 0; h <= colCount-1; h++ ) {
					var header = document.getElementById("0r"+ h + "c").innerHTML;
					if ( header == "組織ID" ) {
						org_id = h + "c";
					} else if ( header == "レッスン名" ) {
						lesson_name = h + "c";
					} else if ( header == "読み" ) {
						lesson_name_kana = h + "c";
					} else if ( header == "学年" ) {
						grade_no = h + "c";
					} else if ( header == "利用開始" ) {
						start_period = h + "c";
					} else if ( header == "利用終了" ) {
						end_period = h + "c";
					} else if ( header == "科目" ) {
						subject_no = h + "c";
					} else if ( header == "公開" ) {
						status = h + "c";
					} else if ( header == "備考" ) {
						remarks = h + "c";
					} else if ( header == "担当1" ) {
						manager_no1 = h + "c";
					} else if ( header == "担当2" ) {
						manager_no2 = h + "c";
					} else if ( header == "担当3" ) {
						manager_no3 = h + "c";
					} else if ( header == "担当4" ) {
						manager_no4 = h + "c";
					} else if ( header == "担当5" ) {
						manager_no5 = h + "c";
					} else if ( header == "担当6" ) {
						manager_no6 = h + "c";
					} else if ( header == "担当7" ) {
						manager_no7 = h + "c";
					} else if ( header == "担当8" ) {
						manager_no8 = h + "c";
					} else if ( header == "担当9" ) {
						manager_no9 = h + "c";
					} else if ( header == "担当10" ) {
						manager_no10 = h + "c";
					} else if ( header == "担当11" ) {
						manager_no11 = h + "c";
					} else if ( header == "担当12" ) {
						manager_no12 = h + "c";
					}
				}
				document.getElementById("org_id").setAttribute('value',org_id);
				document.getElementById("lesson_name").setAttribute('value',lesson_name);
				document.getElementById("lesson_name_kana").setAttribute('value',lesson_name_kana);
				document.getElementById("start_period").setAttribute('value',start_period);
				document.getElementById("end_period").setAttribute('value',end_period);
				document.getElementById("grade_no").setAttribute('value',grade_no);
				document.getElementById("subject_no").setAttribute('value',subject_no);
				document.getElementById("status").setAttribute('value',status);
				document.getElementById("remarks").setAttribute('value',remarks);
				document.getElementById("manager_no1").setAttribute('value',manager_no1);
				document.getElementById("manager_no2").setAttribute('value',manager_no2);
				document.getElementById("manager_no3").setAttribute('value',manager_no3);
				document.getElementById("manager_no4").setAttribute('value',manager_no4);
				document.getElementById("manager_no5").setAttribute('value',manager_no5);
				document.getElementById("manager_no6").setAttribute('value',manager_no6);
				document.getElementById("manager_no7").setAttribute('value',manager_no7);
				document.getElementById("manager_no8").setAttribute('value',manager_no8);
				document.getElementById("manager_no9").setAttribute('value',manager_no9);
				document.getElementById("manager_no10").setAttribute('value',manager_no10);
				document.getElementById("manager_no11").setAttribute('value',manager_no11);
				document.getElementById("manager_no12").setAttribute('value',manager_no12);

				for ( var k = 1; k <= rowCount; k++ ) {
					var table = $('#less_tbl').dataTable();
					var rowOrg_id = document.getElementById(""+k+"r"+org_id).innerHTML;
					var rowLesson_name = document.getElementById(""+k+"r"+lesson_name).innerHTML;
					var rowLesson_name_kana = document.getElementById(""+k+"r"+lesson_name_kana).innerHTML;
					var rowGrade_no = document.getElementById(""+k+"r"+grade_no).innerHTML;
					var rowStart_period = document.getElementById(""+k+"r"+start_period).innerHTML;
					var rowEnd_period = document.getElementById(""+k+"r"+end_period).innerHTML;
					var rowSubject_no = document.getElementById(""+k+"r"+subject_no).innerHTML;
					var rowStatus = document.getElementById(""+k+"r"+status).innerHTML;
					var rowRemarks = document.getElementById(""+k+"r"+remarks).innerHTML;
					var rowManager_no1 = document.getElementById(""+k+"r"+manager_no1).innerHTML;
					var rowManager_no2 = document.getElementById(""+k+"r"+manager_no2).innerHTML;
					var rowManager_no3 = document.getElementById(""+k+"r"+manager_no3).innerHTML;
					var rowManager_no4 = document.getElementById(""+k+"r"+manager_no4).innerHTML;
					var rowManager_no5 = document.getElementById(""+k+"r"+manager_no5).innerHTML;
					var rowManager_no6 = document.getElementById(""+k+"r"+manager_no6).innerHTML;
					var rowManager_no7 = document.getElementById(""+k+"r"+manager_no7).innerHTML;
					var rowManager_no8 = document.getElementById(""+k+"r"+manager_no8).innerHTML;
					var rowManager_no9 = document.getElementById(""+k+"r"+manager_no9).innerHTML;
					var rowManager_no10 = document.getElementById(""+k+"r"+manager_no10).innerHTML;
					var rowManager_no11 = document.getElementById(""+k+"r"+manager_no11).innerHTML;
					var rowManager_no12 = document.getElementById(""+k+"r"+manager_no12).innerHTML;
					if ( rowOrg_id == "" && rowLesson_name == "" && rowLesson_name_kana == "" && rowGrade_no=="" && rowStart_period == ""
						&& rowEnd_period == "" && rowSubject_no == "" && rowStatus == "" && rowRemarks=="" && rowManager_no1=="" && rowManager_no2==""
						&& rowManager_no2== "" && rowManager_no3 == "" && rowManager_no4== "" && rowManager_no5 == "" && rowManager_no6 == ""
						&& rowManager_no7 == "" && rowManager_no8 == "" && rowManager_no9 == "" && rowManager_no10 == "" && rowManager_no11 == "" && rowManager_no12 == "") {
						table.fnDeleteRow( table.$('#'+k)[0], null, false );
					}else{
						array = [rowOrg_id,rowLesson_name,rowLesson_name_kana,rowGrade_no,
							rowStart_period,rowEnd_period,rowSubject_no,rowStatus,rowRemarks,rowManager_no1,
							rowManager_no2,rowManager_no3,rowManager_no4,rowManager_no5,rowManager_no6,
							rowManager_no7,rowManager_no8,rowManager_no9,rowManager_no10,rowManager_no11,rowManager_no12];
						less_data.push(array);
					}
					console.log("array");
					console.log(less_data);
					console.log("count array :" + less_data.length);
					$('.display').show();
				}
				$('.excelDiv').show();
				if ( $("#btn_flg").val() == 1) {
					$('#hide1').hide();
					$('#hide2').hide();
				}

				//登録ボタンを押すと、画面での項目チェック
				$("#btn_insert").on('click',function(e) {
					console.log("check arry count " + less_data.length);
					var err_array = [];
					var org_id_array = [];
					var validate_flg = 1;
					var err_content;
					if ( $(".error_msg").html() != "" ) {
						$(".error_section").slideDown('slow')
					}
					var table = $('#less_tbl').DataTable();
					var rowCount = table.rows().data();
					if ( rowCount.length == 0 ){
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html(" エクセルファイルにデータを記入してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					//　最大登録できる件数より多い場合、エラー
					var less_max_count = $("#less_max_count").val();
					if ( less_data.length > less_max_count ){
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html("登録件数は"+less_max_count+"件以内です。");
						$(".divBody").scrollTop(0);
						return false;
					}
					// レッスン情報チェック
					var allOrg_Id;
					for ( i = 0; i < less_data.length ; i++ ) {
						var managerArr = [];
						var managerArrTst = [];
						validate_flg = 1;
						//組織ID
						var org_id = less_data[i][0] ;
						//レッスン名
						var less_name = less_data[i][1] ;
						//読み
						var lesson_name_kana =less_data[i][2] ;
						//利用開始日
						var l_start_period = less_data[i][4] ;
						//利用終了日
						var l_end_period = less_data[i][5] ;
						//科目
						var subject_no = less_data[i][6] ;
						//公開
						var status = less_data[i][7] ;
						//備考
						var remarks = less_data[i][8] ;
						//担当者アレイ
						managerArr.push(less_data[i][9],less_data[i][10],less_data[i][11],less_data[i][12],less_data[i][13],less_data[i][14],less_data[i][15],less_data[i][16],less_data[i][17],less_data[i][18],less_data[i][19],less_data[i][20]);
						//担当者アレイのブランクを消す
						managerArr = jQuery.grep(managerArr, function(n){ return (n); });
						var managerArrO=managerArr.length;
						//担当者アレイの重複でデータを消す
						managerArr = managerArr.filter(function(elem, index, self) {
							return index == self.indexOf(elem);
						});
						var st_dt = new Date(l_start_period);
						var ed_dt = new Date(l_end_period);

						var d = new Date();
						var todayDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate();

						// 組織IDチェック
						if ( org_id == "" || org_id.length > 10 ){
							validate_flg = 0;
							err_content = "組織IDが正しくありません。";
						}else if ( less_name == "" || less_name.length > 32 ){
							// レッスン名チェック
							validate_flg = 0;
							err_content = "レッスン名が正しくありません。";
						}else if ((chk = characterCheck(less_name)) != null){
							validate_flg = 0;
							err_content = "レッスン名" + chk;
						// 受講者ログインIDチェック
						}else if (lesson_name_kana.length > 32 ){
							// 読みチェック
							validate_flg = 0;
							err_content = "読みが正しくありません。";
						}else if ((chk = characterCheck(lesson_name_kana)) != null){
							validate_flg = 0;
							err_content = "読み" + chk;
						// 受講者ログインIDチェック
						}else if ( l_start_period == "" || l_start_period.length > 10 || !dateFormat(moment(st_dt).format('Y-MM-DD')) || Date.parse(l_start_period) < Date.parse(todayDate) ){
							//利用開始日チェック
							validate_flg = 0;
							err_content = "利用開始が正しくありません。";
						}else if ( l_end_period == "" || l_end_period.length > 10 || !dateFormat(moment(ed_dt).format('Y-MM-DD')) || Date.parse(l_end_period) < Date.parse(todayDate) || Date.parse(l_start_period) > Date.parse(l_end_period) ){
							// 利用終了チェック
							validate_flg = 0;
							err_content = "利用終了が正しくありません。";
						}else if (subject_no == ""){
							// 科目チェック
							validate_flg = 0;
							err_content = "科目が正しくありません。";
						}else if(managerArrO !== managerArr.length){
							// 担当者チェック
							err_content = "同じ担当になっています。";
							err_array.push('登録ファイルの'+(i+1)," 行目が ", err_content , "<br/>");
						}else if(status == "" || (status != "" &&  status != "する" &&  status != "しない")){
							// 公開チェック
							validate_flg = 0;
							err_content = "公開が正しくありません。";
						}else if (remarks.length >512 ){
							// 備考チェック
							validate_flg = 0;
							err_content = "備考が正しくありません。";
						}else if ((chk = characterCheck(remarks)) != null){
							validate_flg = 0;
							err_content = "備考" + chk;
						// 受講者ログインIDチェック
						}
						// エーラがある場合、
						if ( validate_flg == 0 ) {
							err_array.push(i+1," 行目の ", err_content , "<br/>");
						}
						//組織IDARR
						org_id_array.push(org_id);
					}
					console.log(err_array);
					// エクセルに重複したデータをチェックする
					var rowCount = less_data.length ;
					var name = '';
					var temp = [];
					var dup_err = [];
					var notSort = "";
					for ( i = 0; i < rowCount ; i++ ) {
						name = less_data[i][1].replace(/,/g , "escape comma");
						temp.push(name);
					}

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
					// エラーがある場合エーラメッセージを表す
					if ( err_array.length != 0 ) {
						for ( j = 0; j < err_array.length -1; j++ ) {
							$('#err_dis').show();
							$(".error_section").slideDown('slow');
							$(".error_msg").html(err_array);
							$(".divBody").scrollTop(0);
						}
						return false;
					}else if (org_id_array[0] !== $('#db_org_id').val()) {
						//組織IDは有効ではない場合、エラーメセッジを表示する。
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html("<?php echo @constant('E028');?>
");
						$(".divBody").scrollTop(0);
						return false;
					}else if ($.unique(org_id_array).length>1 ) {
						//組織IDは同一データにおいて同じでない場合、エラーメセッジを表示する。
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html("<?php echo @constant('E027');?>
");
						$(".divBody").scrollTop(0);
						return false;
					}else if ( dup_err.length != 0 ) {
						dup_errMsg = "登録ファイルの "+dup_err + " 行目が同じレッスン名になっています。";
						for ( j = 0; j < dup_err.length -1; j++ ) {
							$('#err_dis').show();
							$(".error_section").slideDown('slow');
							$(".error_msg").html(dup_errMsg);
							$(".divBody").scrollTop(0);
						}
						return false;
					}else {
						//登録ボタンの処理
						var action = '<?php echo @constant('HOME_DIR');?>
ExcelLessonList/duplicateCheckWoc';
						var rowCount = less_data.length ;

						console.log(less_data);
						for ( i = 0; i < rowCount ; i++ ) {
							// escape comma 処理
							less_data[i][0] = less_data[i][0].replace(/,/g , "escape comma");//組織ID
							less_data[i][1] = less_data[i][1].replace(/,/g , "escape comma");//レッスン名
							less_data[i][2] = less_data[i][2].replace(/,/g , "escape comma");//読み
							less_data[i][3] = less_data[i][3].replace(/,/g , "escape comma");//学年
							less_data[i][4] = less_data[i][4].replace(/,/g , "escape comma");//利用開始
							less_data[i][5] = less_data[i][5].replace(/,/g , "escape comma");//利用終了
							less_data[i][6] = less_data[i][6].replace(/,/g , "escape comma");//教科
							less_data[i][7] = less_data[i][7].replace(/,/g , "escape comma");//公開
							less_data[i][8] = less_data[i][8].replace(/,/g , "escape comma");//備考
							less_data[i][9] = less_data[i][9].replace(/,/g , "escape comma");//担当1
							less_data[i][10] = less_data[i][10].replace(/,/g , "escape comma");//担当2
							less_data[i][11] = less_data[i][11].replace(/,/g , "escape comma");//担当3
							less_data[i][12] = less_data[i][12].replace(/,/g , "escape comma");//担当4
							less_data[i][13] = less_data[i][13].replace(/,/g , "escape comma");//担当5
							less_data[i][14] = less_data[i][14].replace(/,/g , "escape comma");//担当6
							less_data[i][15] = less_data[i][15].replace(/,/g , "escape comma");//担当7
							less_data[i][16] = less_data[i][16].replace(/,/g , "escape comma");//担当8
							less_data[i][17] = less_data[i][17].replace(/,/g , "escape comma");//担当9
							less_data[i][18] = less_data[i][18].replace(/,/g , "escape comma");//担当10
							less_data[i][19] = less_data[i][19].replace(/,/g , "escape comma");//担当11
							less_data[i][20] = less_data[i][20].replace(/,/g , "escape comma");//担当12
							arr.push(less_data[i]);
						}
						console.log("save arr");
						console.log(arr);
						$("#main_form").attr("action", action);
						$("#less_data").val(arr);
						$("#main_form").submit();
					}
				});
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form action="<?php echo @constant('HOME_DIR');?>
ExcelLessonList/show" method="post" id="main_form">
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<div class="divHeader">
				<!--header-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--header-->
			</div>
			<div class="divBody">
				<div class="container">
					<div class="main">
						<div id="err_dis" tabindex="1">
							<section class="error_section">
								<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" style="width:15px;float:right" class="close_icon">
								<?php if (!empty($_smarty_tpl->tpl_vars['err_msg']->value)) {?>
									<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['err_msg']->value;?>
</div>
								<?php } else { ?>
									<div  class="error_msg"></div>
								<?php }?>
							</section>
						</div>
						<section class="content">
							<br/>
							<p>
								> <span class="title">データ登録 / レッスン登録</span>
							</p>
							<br/>
							<!-- hidden field area -->
							<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
							<input type="hidden" id="db_org_id" name="db_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->db_org_id;?>
" />
							<input type="hidden" id="db_org_name" name="db_org_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->db_org_name;?>
" />
							<input type="hidden" id="db_subject_no" value="<?php echo $_smarty_tpl->tpl_vars['db_subject_no']->value;?>
" />
							<input type="hidden" id="fileExt" value="<?php echo $_smarty_tpl->tpl_vars['fileExt']->value;?>
" />
							<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
							<input type="hidden" id="admin_no" name="admin_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->admin_no;?>
" />
							<input type="hidden" id="file" name="file" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->file;?>
"/>
							<input type="hidden" id="dataArray" value="<?php echo $_smarty_tpl->tpl_vars['dataArray']->value;?>
"/>
							<input type="hidden" id="choose" name="choose"/>
							<input type="hidden" id="org_id" name="org_id" />
							<input type="hidden" id="lesson_name" name="lesson_name" />
							<input type="hidden" id="less_data" name="less_data" />
							<input type="hidden" id="grade_data" name="grade_data" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->grade_data;?>
" />
							<input type="hidden" id="subject_data" name="subject_data" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->subject_data;?>
" />
							<input type="hidden" id="less_data_sm"  name="less_data_sm" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->less_data_sm;?>
" />
							<input type="hidden" id="lesson_name_kana" name="lesson_name_kana" />
							<input type="hidden" id="start_period" name="start_period" />
							<input type="hidden" id="end_period" name="end_period" />
							<input type="hidden" id="grade_no" name="grade_no" />
							<input type="hidden" id="subject_no" name="subject_no" />
							<input type="hidden" id="status" name="status" />
							<input type="hidden" id="remarks" name="remarks" />
							<input type="hidden" id="manager_no1" name="manager_no1" />
							<input type="hidden" id="manager_no2" name="manager_no2" />
							<input type="hidden" id="manager_no3" name="manager_no3" />
							<input type="hidden" id="manager_no4" name="manager_no4" />
							<input type="hidden" id="manager_no5" name="manager_no5" />
							<input type="hidden" id="manager_no6" name="manager_no6" />
							<input type="hidden" id="manager_no7" name="manager_no7" />
							<input type="hidden" id="manager_no8" name="manager_no8" />
							<input type="hidden" id="manager_no9" name="manager_no9" />
							<input type="hidden" id="manager_no10" name="manager_no10" />
							<input type="hidden" id="manager_no11" name="manager_no11" />
							<input type="hidden" id="manager_no12" name="manager_no12" />
							<input type="hidden" id="hint" name="hint" />
							<!-- for image -->
							<input type="hidden" id="image_ext" name="image_ext" value=""/>
							<input type="hidden" id="file_data" name="file_data" value=""/>
							<input type="hidden" id="img_flg" name="img_flg" value=""/>
							<input type="hidden" id="image_del_flg" name="image_del_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->image_del_flg;?>
"/>
							<input type="hidden" id="hddImage" name="hddImage" value=""/>
							<input type="hidden" id="btn_flg" name="btn_flg" value="<?php echo $_smarty_tpl->tpl_vars['btn_flg']->value;?>
" />
							<input type="hidden" id="less_max_count" name ="less_max_count" value = "<?php echo $_smarty_tpl->tpl_vars['less_max_count']->value;?>
">

							<!-- search table -->
							<div id="hidden">
								<table class="tsk_regist_tbl2" style="width:auto;">
									<tr height="45px;">
										<td id="tdImage" width="150px">ファイル</td>
										<td width="150px">
											<input type="text" id="file_name" name="file_name" readonly="readonly" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->file_name;?>
" class="task_file" style="height:25px;"/>
										</td>
										<td width="150px">
											<input id="input_file" name="input_file" class="input_file" type="file" name="image" accept=".xlsx, .xls, .csv">
											<button type="button" id="img_btn"  style="height:30px;width:120px;">ファイルを選択</button>
										</td>
										<td width="131px;" id="hide1">
											<input type="submit" name="insert" value="" class="btn_confirm" id="btn_upload" title="表示" onclick="javascript:upLoad('<?php echo @constant('HOME_DIR');?>
ExcelLessonList/show')">
										</td>
										<td width="400px;" id="hide2" align="right"><input type="button" id="btn_all_dl" name="btn_all_dl" class="btn_all_dl" title="フォーマットダウンロード" onclick="javascript:excelDl('<?php echo @constant('HOME_DIR');?>
ExcelLessonList/newExcelWoc')">
										</td>
									</tr>
									<tr>
									<?php if (!empty($_smarty_tpl->tpl_vars['dataArray']->value)) {?>
										<?php if (!empty($_smarty_tpl->tpl_vars['db_org_name']->value)) {?>
											<td>組織名</td>
											<td colspan="4"><?php echo $_smarty_tpl->tpl_vars['db_org_name']->value;?>
</td>
										<?php } else { ?>
											<td colspan="5"><font color="red">組織名はありません。</font></td>
										<?php }?>
									<?php }?>
									</tr>

								</table>
								<br />
							</div>
							<div class="excelDiv" style="display: none;">
								<table id="less_tbl" class="display" style="width:100%; border-collapse: collapse; font-size: 1.0em;">
								<?php if (!empty($_smarty_tpl->tpl_vars['dataArray']->value)) {?>
									<?php
$_from = $_smarty_tpl->tpl_vars['dataArray']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_datagrid_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid'] : false;
$__foreach_datagrid_0_saved_item = isset($_smarty_tpl->tpl_vars['rows']) ? $_smarty_tpl->tpl_vars['rows'] : false;
$_smarty_tpl->tpl_vars['rows'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['__smarty_foreach_datagrid'] = new Smarty_Variable(array('index' => -1));
$_smarty_tpl->tpl_vars['rows']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['rows']->value) {
$_smarty_tpl->tpl_vars['rows']->_loop = true;
$_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index']++;
$__foreach_datagrid_0_saved_local_item = $_smarty_tpl->tpl_vars['rows'];
?>
										<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index'] : null) == 0) {?>
											<thead style="background-color: #e6b9b8;">
										<?php } elseif ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index'] : null) == 1) {?>
											<tbody >
										<?php }?>
										<tr id="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index'] : null);?>
">
										<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index'] : null) == 0) {?>
											<th>No</th>
										<?php } else { ?>
											<td id="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index'] : null);?>
rno" ></td>
										<?php }?>
										<?php
$_from = $_smarty_tpl->tpl_vars['rows']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_datagrid1_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid1']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid1'] : false;
$__foreach_datagrid1_1_saved_item = isset($_smarty_tpl->tpl_vars['cols']) ? $_smarty_tpl->tpl_vars['cols'] : false;
$_smarty_tpl->tpl_vars['cols'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['__smarty_foreach_datagrid1'] = new Smarty_Variable(array('index' => -1));
$_smarty_tpl->tpl_vars['cols']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['cols']->value) {
$_smarty_tpl->tpl_vars['cols']->_loop = true;
$_smarty_tpl->tpl_vars['__smarty_foreach_datagrid1']->value['index']++;
$__foreach_datagrid1_1_saved_local_item = $_smarty_tpl->tpl_vars['cols'];
?>
											<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index'] : null) != 0) {?>
												<td id="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index'] : null);?>
r<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid1']->value['index'] : null);?>
c" style=" min-width: 60px;" contenteditable="false"><?php echo $_smarty_tpl->tpl_vars['cols']->value;?>
</td>
											<?php } else { ?>
												<th id="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index'] : null);?>
r<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid1']->value['index'] : null);?>
c" style=" min-width: 60px;" contenteditable="false"><?php echo $_smarty_tpl->tpl_vars['cols']->value;?>
</th>
											<?php }?>
										<?php
$_smarty_tpl->tpl_vars['cols'] = $__foreach_datagrid1_1_saved_local_item;
}
if ($__foreach_datagrid1_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_foreach_datagrid1'] = $__foreach_datagrid1_1_saved;
}
if ($__foreach_datagrid1_1_saved_item) {
$_smarty_tpl->tpl_vars['cols'] = $__foreach_datagrid1_1_saved_item;
}
?>
										</tr>
										<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index'] : null) == 0) {?>
											</thead>
										<?php }?>
									<?php
$_smarty_tpl->tpl_vars['rows'] = $__foreach_datagrid_0_saved_local_item;
}
if ($__foreach_datagrid_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_foreach_datagrid'] = $__foreach_datagrid_0_saved;
}
if ($__foreach_datagrid_0_saved_item) {
$_smarty_tpl->tpl_vars['rows'] = $__foreach_datagrid_0_saved_item;
}
?>
								<?php }?>

								</table>
								<?php if (!empty($_smarty_tpl->tpl_vars['dataArray']->value)) {?>
									<div id="hidden1" style="width:100%;text-align:right; padding-top: 5px;">
										<input type="button" name="insert" value="" id="btn_insert" class="btn_insert" title="登録">
									</div>
								<?php }?>
							</div>
						</section>
					</div>
				</div>
			</div>
			<div class="divFooter">
			<!--footer-->
				<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!--footer-->
			</div>
		</form>
		<?php echo '<script'; ?>
>

			//DL処理
			function excelDl(action){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#main_form").attr("action", action);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}

			//エクセルファイルアップロード処理
			function upLoad(action){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#main_form").attr("action", action);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
			}
		<?php echo '</script'; ?>
>
	</body>
</html><?php }
}
