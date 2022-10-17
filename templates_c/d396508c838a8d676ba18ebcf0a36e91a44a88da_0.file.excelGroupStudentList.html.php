<?php
/* Smarty version 3.1.29, created on 2022-03-29 18:22:58
  from "/var/www/html/eccadmin_dev/templates/excelGroupStudentList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_6242cff2235742_48893106',
  'file_dependency' => 
  array (
    'd396508c838a8d676ba18ebcf0a36e91a44a88da' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/excelGroupStudentList.html',
      1 => 1553225616,
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
function content_6242cff2235742_48893106 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
	<title>グループ：受講者エクセル登録</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta name="googlebot" content="noindex, nofollow">
		<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/style.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/excelstudentlist.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/datatables.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/datatables.min.css" rel="stylesheet">
		
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/jquery.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
	src="<?php echo @constant('HOME_DIR');?>
js/jquery-1.11.0.min.js"><?php echo '</script'; ?>
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
js/datatables.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/datatables.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
js/moment.js"><?php echo '</script'; ?>
>
		
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

				function getFile(filePath) {
				return filePath.substr(filePath.lastIndexOf('\\') + 1).split('.')[0];
				}

				// イベントを隠しボタンに変更する
				document.getElementById('img_btn').addEventListener('click',function(){
					document.getElementById('input_file').click();
				});

				// ------------------------------------------------------------
				// ファイルを選択した時に実行されるイベント
				// ------------------------------------------------------------
				$("input[type=file]#input_file").on("change", function () {
					$('#db_org_name').html('');
					var file_name = getFile(input_file.value);
					// ファイルのタイプチェック
					var fileExtension = ['xlsx','xls','csv'];
					if ( $.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1 ) {

						$('#input_file').val('');
						$("#file_name").val('');
						$("#img_flg").val(0);

						error_msg = "正しくフィルを選択してください。";
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html(error_msg);
						return false;

					} else {
						var image_data = "";
						var selectedFile = this.files[0];
						// 画像ファイルデータ設定
						if ( selectedFile != null ) {

							selectedFile.convertToBase64(function(base64){
								image_data = base64;
									$("#image_data").val(base64);
							});

						}else{
							image_data = "";
							$("#image_data").val("");
						}

						var fileName = $('input[type=file]').val();
						var clean = fileName.split('\\').pop();
						$("#file_name").val(clean);
						$("#img_flg").val(1);
						$('#copy_image_file').val('');

						// 画像ファイル拡張子設定
						if ( input_file.value != "" ) {

							image_ext = "." + input_file.value.split('.').pop();
							$("#image_ext").val(image_ext);
						}
					}

					$('.display').hide();
					$('#grpstu_tbl_wrapper').hide();
					$('#hidden1').hide();
					$('#hide1').show();
					$('#hide2').show();
					return true;
				});

				//データテーブルを表示する
				var dataArray = $("#dataArray").val();
				if ( dataArray != "" ) {

					var t = $('#grpstu_tbl').DataTable({
						"scrollY": 300,
						"scrollX": true,
						"ordering": false,
						"pageLength": 500,//デフォルトの件表示
						"lengthMenu": [ 100, 300, 500, 1000 ],
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
						var PageInfo = $('#grpstu_tbl').DataTable().page.info();
						t.column(0, { page: 'current' }).nodes().each( function (cell, i) {
							cell.innerHTML = i+1+ PageInfo.start;
						});
					});
				}

				var rowCount = $('#grpstu_tbl tr').length - 1;
				var colCount = $('#grpstu_tbl th').length - 1;

				var org_id;
				var group_name;
				var login_id;
				var student_name;

				var grpstu_data = [];

				for ( var h = 0; h <= colCount - 1; h++ ) {

					var header = document.getElementById("0r"+ h + "c").innerHTML;

					if ( header == "組織ID" ) {

						org_id = h + "c";
					}else if ( header == "グループ名" ) {

						group_name = h + "c";
					}else if ( header == "受講者ログインID" ) {

						login_id = h + "c";
					}else if ( header == "受講者名" ) {

						student_name = h + "c";
					}
				}

				document.getElementById("org_id").setAttribute('value',org_id);
				document.getElementById("group_name").setAttribute('value',group_name);
				document.getElementById("login_id").setAttribute('value',login_id);
				document.getElementById("student_name").setAttribute('value',student_name);

				for ( var k = 1; k <= rowCount; k++ ) {

					var table = $('#grpstu_tbl').dataTable();

					var rowOrg_id = document.getElementById(""+k+"r"+org_id).innerHTML;
					var rowGroup_name = document.getElementById(""+k+"r"+group_name).innerHTML;
					var rowLogin_id = document.getElementById(""+k+"r"+login_id).innerHTML;
					var rowStudent_name = document.getElementById(""+k+"r"+student_name).innerHTML;

					if ( rowOrg_id == "" && rowGroup_name == "" && rowLogin_id == "" && rowStudent_name == "" ) {

						table.fnDeleteRow( table.$('#'+k)[0], null, false );
					}else {

						array = [rowOrg_id,rowGroup_name,rowLogin_id,rowStudent_name];
						grpstu_data.push(array);
					}
				}
				$('.display').show();
				if ( $("#btn_flg").val() == 1 ) {
					$('#hide1').hide();
					$('#hide2').hide();
				}

				//登録ボタンを押すと、画面でのグループ・受講者項目のチェック
				$("#btn_insert").on('click',function(e) {

					var err_array = [];
					var validate_flg = 1;
					var err_content;
					if ( $(".error_msg").html() != "" ) {

						$(".error_section").slideToggle('slow')
					}

					var table = $('#grpstu_tbl').DataTable();
					var rowCount = table.rows().data();
					if ( rowCount.length == 0 ){

						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html(" エクセルファイルにデータを記入してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					//　最大登録できる件数より多い場合、エラー
					var groupstu_max_count = $("#groupstu_max_count").val();

					if ( grpstu_data.length > groupstu_max_count ){
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html("登録件数は"+groupstu_max_count+"件以内です。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// グループ・受講者情報チェック
					for ( var i = 0; i < grpstu_data.length ; i++ ) {
						validate_flg = 1;
						var temp_subject = [];
						var gs_org_id = grpstu_data[i][0] ;
						var gs_group_name = grpstu_data[i][1] ;
						var gs_login_id = grpstu_data[i][2] ;
						var gs_student_name = grpstu_data[i][3] ;

						// 組織IDチェック
						if ( gs_org_id == "" ){

							validate_flg = 0;
							err_content = "組織IDが正しくありません。";
							// グループ名チェック
						}else if ( gs_group_name == "" ){

							validate_flg = 0;
							err_content = "グループ名が正しくありません。";
						// 使用できない文字をチェック
						}else if ((chk = characterCheck(gs_group_name)) != null){
							validate_flg = 0;
							err_content = "グループ名" + chk;
						// 受講者ログインIDチェック
						}else if ( gs_login_id == ""  || gs_login_id.match(/[^0-9a-zA-Z]/) ){
							validate_flg = 0;
							err_content = "受講者ログインIDが正しくありません。";
						// 使用できない文字をチェック
						}else if ((chk = characterCheck(gs_student_name)) != null){
							validate_flg = 0;
							err_content = "受講者名" + chk;
						}
						// エーラがある場合、
						if ( validate_flg == 0 ) {
							err_array.push(i+1," 行目の ", err_content , "<br/>");
						}
					}

					// エクセルに重複したデータをチェックする
					var rowCount = grpstu_data.length ;

					var org_id = '';
					var login_id = '';
					var group_name = '';

					var temp_org_id = [];
					var temp_id = [];
					var temp_gl = [];

					var diff_err_org_id = [];
					var dup_err_id = [];
					var dup_err_gl = [];

					var notSort = "";
					var apk = [];
					var arr = [];
					for ( i = 0; i < rowCount; i++ ) {

						org_id = grpstu_data[i][0].replace(/,/g , "escape comma");
						login_id = grpstu_data[i][2].replace(/,/g , "escape comma");
						group_name = grpstu_data[i][1].replace(/,/g , "escape comma");

						temp_org_id.push(org_id);

						grp_login = group_name + login_id;
						temp_gl.push(grp_login);
					}

					for ( var i = 0; i < temp_org_id.length-1; i++ ){

						if ( temp_org_id[i] != temp_org_id[i+1] ){
							diff_err_org_id.push("Different");
						}
					}

					dup_err_gl = dupCheck(temp_gl);

					// エラーがある場合エーラメッセージを表す
					if ( err_array.length != 0 ) {

						for ( j = 0; j < err_array.length -1; j++ ) {

							$('#err_dis').show();
							$(".error_section").slideDown('slow');
							$(".error_msg").html(err_array);
							$(".divBody").scrollTop(0);
						}
						return false;
					}else if ( diff_err_org_id.length != 0 ) {
						//エクセルファイル内で、組織IDが同一でない場合、
						dup_errMsg = "<?php echo @constant('E027');?>
";

						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html(dup_errMsg);
						$(".divBody").scrollTop(0);
						return false;
					}else if ( gs_org_id !== $('#db_org_id').val() ){
						//エクセルファイルの組織IDとDBの組織IDが同じでない場合、
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html("組織IDが正しくありません。");
						$(".divBody").scrollTop(0);
						return false;
					}else if ( dup_err_gl.length != 0 ) {
						//エクセルファイル内で、グループ名と受講者ログインIDが同じの場合、
						dup_errMsg = "登録ファイルの "+dup_err_gl + " 行目の行が重複しています。";

						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html(dup_errMsg);
						$(".divBody").scrollTop(0);
						return false;
					}else {

						//以上のエラーでない場合、登録処理
						var action = '<?php echo @constant('HOME_DIR');?>
ExcelGroupStudentList/duplicateCheckWoc';
						var rowCount = grpstu_data.length ;

						for ( i = 0; i < rowCount ; i++ ) {

							// escape comma 処理
							grpstu_data[i][0] = grpstu_data[i][0].replace(/,/g , "escape comma");//組織ID
							grpstu_data[i][1] = grpstu_data[i][1].replace(/,/g , "escape comma");//グループ名
							grpstu_data[i][2] = grpstu_data[i][2].replace(/,/g , "escape comma");//受講者ロクインID
							grpstu_data[i][3] = grpstu_data[i][3].replace(/,/g , "escape comma");//受講者名

							arr.push(grpstu_data[i]);
						}

						$("#main_form").attr("action", action);
						$("#group_student_data").val(arr);
						$("#main_form").submit();
					}
				});
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form action="<?php echo @constant('HOME_DIR');?>
ExcelGroupStudentList/save" method="post" id="main_form">
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
								> <span class="title">データ登録 / グループ：受講者登録</span>
							</p>
							<br/>
							<!-- hidden field area -->
							<input type="hidden" id="fileExt" value="<?php echo $_smarty_tpl->tpl_vars['fileExt']->value;?>
" />
							<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
							<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
" />
							<input type="hidden" id="dataArray" value="<?php echo $_smarty_tpl->tpl_vars['dataArray']->value;?>
"/>

							<!-- for image -->

							<input type="hidden" id="image_ext" name="image_ext" value=""/>
							<input type="hidden" id="image_data" name="image_data" value=""/>
							<input type="hidden" id="img_flg" name="img_flg" value=""/>
							<input type="hidden" id="image_del_flg" name="image_del_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->image_del_flg;?>
"/>
							<input type="hidden" id="hddImage" name="hddImage" value=""/>
							<input type="hidden" id="group_student_data" name="group_student_data" />
							<input type="hidden" id="grpNoList" name="grpNoList" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->grpNoList;?>
"/>
							<input type="hidden" id="stuNoList" name="stuNoList" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->stuNoList;?>
"/>
							<input type="hidden" id="org_id" name="org_id" />
							<input type="hidden" id="group_name" name="group_name" />
							<input type="hidden" id="login_id" name="login_id" />
							<input type="hidden" id="student_name" name="student_name" />

							<input type="hidden" id="btn_flg" name="btn_flg" value="<?php echo $_smarty_tpl->tpl_vars['btn_flg']->value;?>
" />
							<input type="hidden" id="groupstu_max_count" name ="groupstu_max_count" value = "<?php echo $_smarty_tpl->tpl_vars['form']->value->groupstu_max_count;?>
">
							<input type="hidden" id="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
							<input type="hidden" id="org_name_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_name_flg;?>
"/>
							<input type="hidden" id="db_org_id" name="db_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->db_org_id;?>
" />
							<!-- search table -->
							<div id="hidden">
							<table class="tsk_regist_tbl2">
								<tr height="45px;">
									<td id="tdImage" width="100px">ファイル</td>
									<td>
										<!-- <label id="file_name" name="file_name"><?php echo $_smarty_tpl->tpl_vars['form']->value->file_name;?>
</label> -->
										<input type="text" id="file_name" name="file_name" readonly="readonly" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->file_name;?>
" class="task_file" style="height:25px;"/>
									</td>
									<td width="150px">
										<?php if ($_smarty_tpl->tpl_vars['form']->value->date_flg != "1") {?>
											<input type="file" id="input_file" name="input_file" accept=".xlsx, .xls, .csv"/>
											<button type="button" id="img_btn" style="height:30px;width:120px;">ファイルを選択</button>
										<?php }?>
									</td>
									<td width="131px;" id="hide1">
										<input type="button" name="btn_upload" title="表示" class="btn_confirm" id="btn_upload" onclick="javascript:show('<?php echo @constant('HOME_DIR');?>
ExcelGroupStudentList/show')">
									</td>
									<td width="400px;" align="right" id="hide2">
										<input type="button" id="btn_all_dl" name="btn_all_dl" title="フォーマットダウンロード" class="btn_all_dl" onclick="javascript:excelDl('<?php echo @constant('HOME_DIR');?>
ExcelGroupStudentList/newExcel')">
									</td>
								</tr>
							</table>
							</div>

							<div class="display">
							<div style= 'padding:5px' >
							<?php if ($_smarty_tpl->tpl_vars['form']->value->org_name_flg == '0') {?>
								<label id="db_org_name" name="db_org_name" style='color:red'><?php echo $_smarty_tpl->tpl_vars['form']->value->db_org_name;?>
</label></div>
							<?php } else { ?>
								<label id="db_org_name" name="db_org_name" style='color:black'><?php echo $_smarty_tpl->tpl_vars['form']->value->db_org_name;?>
</label></div>
							<?php }?>
							</div>
							<table id="grpstu_tbl" class="display" style="width:100%; border-collapse: collapse; font-size: 1.0em; display: none;">
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
										<tbody>
									<?php }?>
									<tr id="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index'] : null);?>
">
									<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index'] : null) == 0) {?>
										<th style=" min-width: 30px;" >No</th>
									<?php } else { ?>
										<td id="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index'] : null);?>
rno"></td>
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
											<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid1']->value['index'] : null) > 0) {?>
												<td id="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index'] : null);?>
r<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid1']->value['index'] : null);?>
c" style=" min-width: 60px; word-break: break-all;" contenteditable="false"><?php echo $_smarty_tpl->tpl_vars['cols']->value;?>
</td>
											<?php } else { ?>
												<td id="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index'] : null);?>
r<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid1']->value['index'] : null);?>
c" style=" min-width: 60px; word-break: break-all;" contenteditable="false"><?php echo $_smarty_tpl->tpl_vars['cols']->value;?>
</td>
											<?php }?>
										<?php } else { ?>
											<th id="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid']->value['index'] : null);?>
r<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_datagrid1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_datagrid1']->value['index'] : null);?>
c" style=" min-width: 60px; align: left;" ><?php echo $_smarty_tpl->tpl_vars['cols']->value;?>
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
							</tbody>
							</table>
							<?php if (!empty($_smarty_tpl->tpl_vars['dataArray']->value)) {?>
							<div id="hidden1" style="width:100%;text-align:right; padding-top: 5px;">
								<input type="button" name="insert" value="" class="btn_insert" id="btn_insert" >
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
 type="text/javascript">
			//アップロードボタン処理
			function show(action){

				var input_file = $("#input_file").val();

				//インプットファイル必須チェック
				if ( input_file == "" ) {

					error_msg = "ファイルを選択してください。";
					$('#err_dis').show();
					$(".error_section").slideDown('slow');
					$(".error_msg").html(error_msg);
					$('#err_dis')[0].focus();
					return false;
				}else {

					$("#main_form").attr("action", action);
					$("#main_form").submit();
				}
			}

			//DLボタンを押す処理
			function excelDl(action){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#main_form").attr("action", action);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}
		<?php echo '</script'; ?>
>
	</body>
</html><?php }
}
