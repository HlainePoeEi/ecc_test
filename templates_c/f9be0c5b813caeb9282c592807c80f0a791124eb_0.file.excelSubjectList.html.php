<?php
/* Smarty version 3.1.29, created on 2022-10-13 11:47:02
  from "/var/www/html/eccadmin_dev/templates/excelSubjectList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_63477c260b0ed9_07503954',
  'file_dependency' => 
  array (
    'f9be0c5b813caeb9282c592807c80f0a791124eb' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/excelSubjectList.html',
      1 => 1553235333,
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
function content_63477c260b0ed9_07503954 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>科目エクセル登録</title>
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

					$(".error_section").slideToggle('slow')

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
					var t = $('#subj_tbl').DataTable({
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
						var PageInfo = $('#subj_tbl').DataTable().page.info();
						t.column(0, { page: 'current' }).nodes().each( function (cell, i) {
							cell.innerHTML = i+1+ PageInfo.start;
						});
					});
				}
				var rowCount = $('#subj_tbl tr').length - 1;
				var colCount = $('#subj_tbl th').length - 1;
				var org_id;
				var subject_name;
				var subject_name_kana;
				var subject_area_name;
				var start_period;
				var end_period;
				var disp_no;
				var remarks;
				var subj_data = [];
				var arr = [];
				for ( var h = 0; h <= colCount-1; h++ ) {
					var header = document.getElementById("0r"+ h + "c").innerHTML;
					if ( header == "組織ID" ) {
						org_id = h + "c";
					} else if ( header == "科目名" ) {
						subject_name = h + "c";
					} else if ( header == "読み" ) {
						subject_name_kana = h + "c";
					} else if ( header == "教科" ) {
						subject_area_name = h + "c";
					} else if ( header == "利用開始" ) {
						start_period = h + "c";
					} else if ( header == "利用終了" ) {
						end_period = h + "c";
					} else if ( header == "表示順" ) {
						disp_no = h + "c";
					}else if ( header == "備考" ) {
						remarks = h + "c";
					}
				}
				document.getElementById("org_id").setAttribute('value',org_id);
				document.getElementById("subject_name").setAttribute('value',subject_name);
				document.getElementById("subject_name_kana").setAttribute('value',subject_name_kana);
				document.getElementById("subject_area_name").setAttribute('value',subject_area_name);
				document.getElementById("start_period").setAttribute('value',start_period);
				document.getElementById("end_period").setAttribute('value',end_period);
				document.getElementById("disp_no").setAttribute('value',disp_no);
				document.getElementById("remarks").setAttribute('value',remarks);
				for ( var k = 1; k <= rowCount; k++ ) {
					var table = $('#subj_tbl').dataTable();
					var rowOrg_id = document.getElementById(""+k+"r"+org_id).innerHTML;
					var rowSubject_name = document.getElementById(""+k+"r"+subject_name).innerHTML;
					var rowSubject_name_kana = document.getElementById(""+k+"r"+subject_name_kana).innerHTML;
					var rowSubject_area_name = document.getElementById(""+k+"r"+subject_area_name).innerHTML;
					var rowStart_period = document.getElementById(""+k+"r"+start_period).innerHTML;
					var rowEnd_period = document.getElementById(""+k+"r"+end_period).innerHTML;
					var rowDisp_no = document.getElementById(""+k+"r"+disp_no).innerHTML;
					var rowRemarks = document.getElementById(""+k+"r"+remarks).innerHTML;
					if ( rowOrg_id == "" && rowSubject_name == "" && rowSubject_name_kana == "" &&
							rowSubject_area_name == "" && rowStart_period == "" && rowEnd_period == "" &&
							rowDisp_no == "" && rowRemarks == "" ) {
						table.fnDeleteRow( table.$('#'+k)[0], null, false );
					}else{
						array = [rowOrg_id,rowSubject_name,rowSubject_name_kana,rowSubject_area_name,
							rowStart_period,rowEnd_period,rowDisp_no,rowRemarks];
						subj_data.push(array);
					}
					console.log("array");
					console.log(subj_data);
					console.log("count array :" + subj_data.length);
					$('.display').show();
				}
				$('.excelDiv').show();
				if ( $("#btn_flg").val() == 1 ) {
					$('#hide1').hide();
					$('#hide2').hide();
				}

				//登録ボタンを押すと、画面での科目項目のチェック
				$("#btn_insert").on('click',function(e) {
					console.log("check arry count " + subj_data.length);
					var err_array = [];
					var org_id_array = [];
					var validate_flg = 1;
					var err_content;
					if ( $(".error_msg").html() != "" ) {
						$(".error_section").slideDown('slow')
					}
					var table = $('#subj_tbl').DataTable();
					var rowCount = table.rows().data();
					if ( rowCount.length == 0 ){
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html(" エクセルファイルにデータを記入してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					//　最大登録できる件数より多い場合、エラー
					var subj_max_count = $("#subj_max_count").val();
					if ( subj_data.length > subj_max_count ){
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html("登録件数は"+subj_max_count+"件以内です。");
						$(".divBody").scrollTop(0);
						return false;
					}
					// 科目情報チェック
					var allOrg_Id;
					for ( i = 0; i < subj_data.length ; i++ ) {
						validate_flg = 1;
						//組織ID
						var org_id = subj_data[i][0] ;
						//科目名
						var subj_name = subj_data[i][1] ;
						//読み
						var subj_name_kana = subj_data[i][2] ;
						//教科
						var subj_area_name = subj_data[i][3] ;
						//利用開始日
						var s_start_period = subj_data[i][4] ;
						//利用終了日
						var s_end_period = subj_data[i][5] ;
						var st_dt = new Date(s_start_period);
						var ed_dt = new Date(s_end_period);
						var d = new Date();
						var todayDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate();
						var disp_no = subj_data[i][6] ;
						var remarks = subj_data[i][7] ;

						// 組織IDチェック
						if ( org_id == "" || org_id.length > 10 ){
							validate_flg = 0;
							err_content = "組織IDが正しくありません。";
						}else if ( subj_name == "" || subj_name.length > 32 ){
							// 科目名チェック
							validate_flg = 0;
							err_content = "科目名が正しくありません。";
						//科目名チェック
						}else if ((err_msg = characterCheck(subj_name)) != null){
                            validate_flg = 0;
                            err_content =  "科目名"+ err_msg;
						}else if (subj_name_kana.length > 32 ){
							// 科目名チェック
							validate_flg = 0;
							err_content = "読みが正しくありません。";
						}else if ((err_msg = characterCheck(subj_name_kana)) != null){
                            validate_flg = 0;
                            err_content =  "読みに「"+ err_msg;
						}else if ( s_start_period == "" || s_start_period.length > 10 || !dateFormat(moment(st_dt).format('Y-MM-DD')) ){
							//利用開始日チェック
							validate_flg = 0;
							err_content = "利用開始が正しくありません。";
						}else if ( s_end_period == "" || s_end_period.length > 10 || !dateFormat(moment(ed_dt).format('Y-MM-DD')) || Date.parse(s_start_period) > Date.parse(s_end_period) ){
							// 利用終了チェック
							validate_flg = 0;
							err_content = "利用終了が正しくありません。";
						}else if ( disp_no.length > 3 ){
							// 表示順チェック
							validate_flg = 0;
							err_content = "表示順が正しくありません。";
						}else if(isNaN(disp_no)) {
							//表示順チェック
							validate_flg = 0;
							err_content = "表示順が正しくありません。";
						}else if ((err_msg = characterCheck(remarks)) != null){
							//使用できない文字をチェック
							validate_flg = 0;
							err_content =  "備考"+ err_msg;
						}else if( remarks.length > 512 ){
							// 備考チェック
							validate_flg = 0;
							err_content = "備考が正しくありません。";
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
					var rowCount = subj_data.length ;
					var name = '';
					var temp = [];
					var dup_err = [];
					var notSort = "";
					for ( i = 0; i < rowCount ; i++ ) {
						name = subj_data[i][1].replace(/,/g , "escape comma");
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
						dup_errMsg = "登録ファイルの "+dup_err + " 行目が同じ科目名になっています。";
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
ExcelSubjectList/duplicateCheckWoc';
						var rowCount = subj_data.length ;

						console.log(subj_data);
						for ( i = 0; i < rowCount ; i++ ) {
							// escape comma 処理
							subj_data[i][0] = subj_data[i][0].replace(/,/g , "escape comma");//組織ID
							subj_data[i][1] = subj_data[i][1].replace(/,/g , "escape comma");//科目名
							subj_data[i][2] = subj_data[i][2].replace(/,/g , "escape comma");//読み
							subj_data[i][3] = subj_data[i][3].replace(/,/g , "escape comma");//教科
							subj_data[i][4] = subj_data[i][4].replace(/,/g , "escape comma");//利用開始
							subj_data[i][5] = subj_data[i][5].replace(/,/g , "escape comma");//利用終了
							subj_data[i][6] = subj_data[i][6].replace(/,/g , "escape comma");//表示順
							subj_data[i][7] = subj_data[i][7].replace(/,/g , "escape comma");//備考
							arr.push(subj_data[i]);
						}
						console.log("save arr");
						console.log(arr);
						$("#main_form").attr("action", action);
						$("#subj_data").val(arr);
						$("#main_form").submit();
					}
				});
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form action="<?php echo @constant('HOME_DIR');?>
ExcelSubjectList/show" method="post" id="main_form">
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
								> <span class="title">データ登録 / 科目登録</span>
							</p>
							<br/>
							<!-- hidden field area -->
							<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
							<input type="hidden" id="db_org_id" name="db_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->db_org_id;?>
" />
							<input type="hidden" id="db_org_name" name="db_org_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->db_org_name;?>
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
							<input type="hidden" id="org_id" name="org_id" /><!-- 組織ID -->
							<input type="hidden" id="subject_name" name="subject_name" /><!-- 科目名 -->
							<input type="hidden" id="subject_name_kana" name="subject_name_kana" /><!-- 読み -->
							<input type="hidden" id="subject_area_name" name="subject_area_name" /><!-- 教科 -->
							<input type="hidden" id="start_period" name="start_period" /><!-- 利用開始 -->
							<input type="hidden" id="end_period" name="end_period" /><!-- 利用終了 -->
							<input type="hidden" id="disp_no" name="disp_no" /><!-- 表示順 -->
							<input type="hidden" id="remarks" name="remarks" /><!-- 備考 -->
							<input type="hidden" id="subj_data" name="subj_data"/>
							<input type="hidden" id="subj_area_data" name="subj_area_data" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->subj_area_data;?>
"/>
							<!-- for image -->
							<input type="hidden" id="image_ext" name="image_ext" value=""/>
							<input type="hidden" id="file_data" name="file_data" value=""/>
							<input type="hidden" id="img_flg" name="img_flg" value=""/>
							<input type="hidden" id="image_del_flg" name="image_del_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->image_del_flg;?>
"/>
							<input type="hidden" id="hddImage" name="hddImage" value=""/>
							<input type="hidden" id="btn_flg" name="btn_flg" value="<?php echo $_smarty_tpl->tpl_vars['btn_flg']->value;?>
" />
							<input type="hidden" id="subj_max_count" name ="subj_max_count" value = "<?php echo $_smarty_tpl->tpl_vars['subj_max_count']->value;?>
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
										<td id="hide1" width="131px;">
											<input type="submit" name="insert" value="" class="btn_confirm" id="btn_upload" title="表示" onclick="javascript:upLoad('<?php echo @constant('HOME_DIR');?>
ExcelSubjectList/show')">
										</td>
										<td width="400px;" id="hide2" align="right"><input type="button" id="btn_all_dl" name="btn_all_dl" class="btn_all_dl" title="フォーマットダウンロード" onclick="javascript:excelDl('<?php echo @constant('HOME_DIR');?>
ExcelSubjectList/newExcelWoc')">
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
								<table id="subj_tbl" class="display" style="width:100%; border-collapse: collapse; font-size: 1.0em;">
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

			//DLボタンを押す処理
			function excelDl(action){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#main_form").attr("action", action);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}

			//アップ処理
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
