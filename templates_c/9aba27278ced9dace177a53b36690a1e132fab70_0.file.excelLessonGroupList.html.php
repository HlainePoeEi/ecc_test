<?php
/* Smarty version 3.1.29, created on 2022-03-29 18:22:55
  from "/var/www/html/eccadmin_dev/templates/excelLessonGroupList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_6242cfef40b4b4_92176048',
  'file_dependency' => 
  array (
    '9aba27278ced9dace177a53b36690a1e132fab70' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/excelLessonGroupList.html',
      1 => 1553225750,
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
function content_6242cfef40b4b4_92176048 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>レッスン：グループエクセル登録</title>
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

					$(".error_section").slideToggle('slow')
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
					var t = $('#lessGp_tbl').DataTable({
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
						var PageInfo = $('#lessGp_tbl').DataTable().page.info();
						t.column(0, { page: 'current' }).nodes().each( function (cell, i) {
							cell.innerHTML = i+1+ PageInfo.start;
						});
					});
				}
				var rowCount = $('#lessGp_tbl tr').length - 1;
				var colCount = $('#lessGp_tbl th').length - 1;
				var org_id;
				var lesson_name;
				var group_name;
				var lessgp_data = [];
				var arr = [];
				for ( var h = 0; h <= colCount-1; h++ ) {
					var header = document.getElementById("0r"+ h + "c").innerHTML;
					if ( header == "組織ID" ) {
						org_id = h + "c";
					} else if ( header == "レッスン名" ) {
						lesson_name = h + "c";
					} else if ( header == "グループ名" ) {
						group_name = h + "c";
					}
				}
				document.getElementById("org_id").setAttribute('value',org_id);
				document.getElementById("lesson_name").setAttribute('value',lesson_name);
				document.getElementById("group_name").setAttribute('value',group_name);

				for ( var k = 1; k <= rowCount; k++ ) {
					var table = $('#lessGp_tbl').dataTable();
					var rowOrg_id = document.getElementById(""+k+"r"+org_id).innerHTML;
					var rowLesson_name = document.getElementById(""+k+"r"+lesson_name).innerHTML;
					var rowGroup_name = document.getElementById(""+k+"r"+group_name).innerHTML;
					if ( rowOrg_id == "" && rowLesson_name == "" && rowGroup_name == "") {
						table.fnDeleteRow( table.$('#'+k)[0], null, false );
					}else{
						array = [rowOrg_id,rowLesson_name,rowGroup_name];
						lessgp_data.push(array);
					}
					console.log("array");
					console.log(lessgp_data);
					console.log("count array :" + lessgp_data.length);
					$('.display').show();
				}
				$('.excelDiv').show();
				if ( $("#btn_flg").val() == 1 ) {
					$('#hide1').hide();
					$('#hide2').hide();
				}

				//登録ボタンを押すと、画面でのレッスン・グループ項目のチェック
				$("#btn_insert").on('click',function(e) {
					console.log("check arry count " + lessgp_data.length);
					var err_array = [];
					var org_id_array = [];
					var validate_flg = 1;
					var err_content;
					if ( $(".error_msg").html() != "" ) {
						$(".error_section").slideToggle('slow')
					}
					var table = $('#lessGp_tbl').DataTable();
					var rowCount = table.rows().data();
					if ( rowCount.length == 0 ){
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html(" エクセルファイルにデータを記入してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					//　最大登録できる件数より多い場合、エラー
					var lessgp_max_count = $("#lessgp_max_count").val();
					if ( lessgp_data.length > lessgp_max_count ){
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html("登録件数は"+lessgp_max_count+"件以内です。");
						$(".divBody").scrollTop(0);
						return false;
					}
					// レッスン・グループ情報チェック
					var allOrg_Id;
					for ( i = 0; i < lessgp_data.length ; i++ ) {
						validate_flg = 1;
						//組織ID
						var org_id = lessgp_data[i][0] ;
						//レッスン名
						var less_name = lessgp_data[i][1] ;
						//グループ名
						var group_name = lessgp_data[i][2] ;
						// 組織IDチェック
						if ( org_id == ""){
							validate_flg = 0;
							err_content = "組織IDが正しくありません。";
						}else if ( less_name == "" ){
							// レッスン名チェック
							validate_flg = 0;
							err_content = "レッスン名が正しくありません。";
						}else if (group_name == "" ){
							// グループ名チェック
							validate_flg = 0;
							err_content = "グループ名が正しくありません。";
						}else if ((chk = characterCheck(less_name)) != null){
							// 使用できない文字をチェック
							validate_flg = 0;
							err_content = "レッスン名" + chk;
						}else if ((chk = characterCheck(group_name)) != null){
							// 使用できない文字をチェック
							validate_flg = 0;
							err_content = "グループ名" + chk;
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
					var rowCount = lessgp_data.length ;
					var name = '';
					var temp = [];
					var dup_err = [];
					var notSort = "";
					for ( i = 0; i < rowCount ; i++ ) {
						lname = lessgp_data[i][1].replace(/,/g , "escape comma");
						gname = lessgp_data[i][2].replace(/,/g , "escape comma");
						name=lname+gname;
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
						dup_errMsg = "登録ファイルの "+dup_err + " 行目の行が重複しています。";
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
ExcelLessonGroupList/duplicateCheckWoc';
						var rowCount = lessgp_data.length ;

						console.log(lessgp_data);
						for ( i = 0; i < rowCount ; i++ ) {
							// escape comma 処理
							lessgp_data[i][0] = lessgp_data[i][0].replace(/,/g , "escape comma");//組織ID
							lessgp_data[i][1] = lessgp_data[i][1].replace(/,/g , "escape comma");//レッソン名
							lessgp_data[i][2] = lessgp_data[i][2].replace(/,/g , "escape comma");//グループ名
							arr.push(lessgp_data[i]);
						}
						console.log("save arr");
						console.log(arr);
						$("#main_form").attr("action", action);
						$("#lessgp_data").val(arr);
						$("#main_form").submit();
					}
				});
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form action="<?php echo @constant('HOME_DIR');?>
ExcelLessonGroupList/show" method="post" id="main_form">
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
								> <span class="title">データ登録 / レッスン：グループ登録</span>
							</p>
							<br/>
							<!-- hidden field area -->
							<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
							<input type="hidden" id="db_org_id" name="db_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->db_org_id;?>
" />
							<input type="hidden" id="db_org_name" name="db_org_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->db_org_name;?>
" />
							<input type="hidden" id="db_group_no" value="<?php echo $_smarty_tpl->tpl_vars['db_group_no']->value;?>
" />
							<input type="hidden" id="db_lesson_no" value="<?php echo $_smarty_tpl->tpl_vars['db_lesson_no']->value;?>
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
							<input type="hidden" id="group_name" name="group_name" />
							<input type="hidden" id="lessgp_data" name="lessgp_data" />
							<input type="hidden" id="group_data" name="group_data" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->group_data;?>
" />
							<input type="hidden" id="less_data" name="less_data" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->less_data;?>
" />
							<!-- for image -->
							<input type="hidden" id="image_ext" name="image_ext" value=""/>
							<input type="hidden" id="file_data" name="file_data" value=""/>
							<input type="hidden" id="img_flg" name="img_flg" value=""/>
							<input type="hidden" id="image_del_flg" name="image_del_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->image_del_flg;?>
"/>
							<input type="hidden" id="hddImage" name="hddImage" value=""/>
							<input type="hidden" id="btn_flg" name="btn_flg" value="<?php echo $_smarty_tpl->tpl_vars['btn_flg']->value;?>
" />
							<input type="hidden" id="lessgp_max_count" name ="lessgp_max_count" value = "<?php echo $_smarty_tpl->tpl_vars['lessgp_max_count']->value;?>
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
ExcelLessonGroupList/show')">
										</td>
										<td width="400px;" id="hide2" align="right"><input type="button" id="btn_all_dl" name="btn_all_dl" class="btn_all_dl" title="フォーマットダウンロード" onclick="javascript:excelDl('<?php echo @constant('HOME_DIR');?>
ExcelLessonGroupList/newExcelWoc')">
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
								<table id="lessGp_tbl" class="display" style="width:100%; border-collapse: collapse; font-size: 1.0em;">
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
