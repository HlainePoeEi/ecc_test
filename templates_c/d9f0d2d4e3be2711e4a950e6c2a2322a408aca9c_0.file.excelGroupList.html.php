<?php
/* Smarty version 3.1.29, created on 2022-10-17 05:25:55
  from "D:\xampp\htdocs\eccadmin_dev\templates\excelGroupList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_634ccb43533741_25309452',
  'file_dependency' => 
  array (
    'd9f0d2d4e3be2711e4a950e6c2a2322a408aca9c' => 
    array (
      0 => 'D:\\xampp\\htdocs\\eccadmin_dev\\templates\\excelGroupList.html',
      1 => 1553225323,
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
function content_634ccb43533741_25309452 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
	<title>グループエクセル登録</title>
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
					var file_name = getFile(input_file.value);
					// ファイルのタイプチェック
					var fileExtension = ['xlsx','xls','csv'];

					//document.getElementById('*spaM4').textContent
					if ( $.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1 ) {

						$('#input_file').val('');
						$("#file_name").val('');
						$("#img_flg").val(0);

						error_msg = "正しくフィルを選択してください。";
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html(error_msg);
						return false;

					}else {
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

					document.getElementById('div_org_name').style.display= "none";
					$('.display').hide();
					$('#hide1').show();
					$('#hide2').show();
					return true;
				});

				//データテーブルを表示する
				var dataArray = $("#dataArray").val();
				if ( dataArray != "" ) {

					var t = $('#gp_tbl').DataTable({
						"scrollY": 300,
						"scrollX": true,
						"ordering": false,
						"pageLength": 100,//デフォルトの件表示
						"oLanguage": {
							"sUrl": "<?php echo @constant('HOME_DIR');?>
files/japanese.json"
						}
					});
					t.on( 'draw.dt', function () {
						var PageInfo = $('#gp_tbl').DataTable().page.info();
						t.column(0, { page: 'current' }).nodes().each( function (cell, i) {
							cell.innerHTML = i+1+ PageInfo.start;
						});
					});
				}

				var rowCount = $('#gp_tbl tr').length - 1;
				var colCount = $('#gp_tbl th').length - 1;
				var no;
				var org_id;
				var gp_name;
				var gp_name_kana;
				var grade_name;
				var start_period;
				var end_period;
				var remarks;
				var gp_data = [];

				for ( var h = 0; h <= colCount - 1; h++ ) {

					var header = document.getElementById("0r"+ h + "c").innerHTML;

					if ( header == "組織ID" ) {

						org_id = h + "c";
					}else if ( header == "グループ名" ) {

						gp_name = h + "c";
					}else if ( header == "読み" ) {

						gp_name_kana = h + "c";
					}else if ( header == "学年" ) {

						grade_name = h + "c";
					}else if ( header == "利用開始" ) {

						start_period = h + "c";
					}else if ( header == "利用終了" ) {

						end_period = h + "c";
					}else if ( header == "備考" ) {

						remarks = h + "c";
					}
				}

				document.getElementById("gp_name").setAttribute('value',gp_name);
				document.getElementById("gp_name_kana").setAttribute('value',gp_name_kana);
				document.getElementById("grade_name").setAttribute('value',grade_name);
				document.getElementById("start_period").setAttribute('value',start_period);
				document.getElementById("end_period").setAttribute('value',end_period);
				document.getElementById("remarks").setAttribute('value',remarks);

				for ( var k = 1; k <= rowCount; k++ ) {

					var table = $('#gp_tbl').dataTable();

					var rowOrg_id = document.getElementById(""+k+"r"+org_id).innerHTML;
					var rowGroup_name = document.getElementById(""+k+"r"+gp_name).innerHTML;
					var rowGroup_name_kana = document.getElementById(""+k+"r"+gp_name_kana).innerHTML;
					var rowGrade_name = document.getElementById(""+k+"r"+grade_name).innerHTML;
					var rowStart_period = document.getElementById(""+k+"r"+start_period).innerHTML;
					var rowEnd_period = document.getElementById(""+k+"r"+end_period).innerHTML;
					var rowRemarks = document.getElementById(""+k+"r"+remarks).innerHTML;
					if ( rowOrg_id == "" && rowGroup_name == "" && rowGroup_name_kana == "" && rowGrade_name == "" && rowStart_period == "" && rowEnd_period == "" && rowRemarks == "" ) {

						table.fnDeleteRow( table.$('#'+k)[0], null, false );
					}else {
						array = [rowOrg_id,rowGroup_name,rowGroup_name_kana,rowGrade_name,rowStart_period,rowEnd_period,rowRemarks];
						gp_data.push(array);
					}
				}

				$('.display').show();
				if ( $("#btn_flg").val() == 1 ) {
					$('#hide1').hide();
					$('#hide2').hide();
				}

				//登録ボタンを押すと、画面でのグループ項目のチェック
				$("#btn_insert").on('click',function(e) {

					var err_array = [];
					var org_id_array=[];
					var gp_name_array=[];
					var dup_err = [];
					var chk_org_id;
					var err_content;

					if ( $(".error_msg").html() != "" ) {

						$(".error_section").slideToggle('slow')
					}

					var table = $('#gp_tbl').DataTable();
					var rowCount = table.rows().data();
					if ( rowCount.length == 0 ){

						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html(" エクセルファイルにデータを記入してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					//　最大登録できる件数より多い場合、エラー
					var gp_max_count = $("#gp_max_count").val();
					if ( gp_data.length > gp_max_count ){

						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html("登録件数は"+gp_max_count+"件以内です。");
						$(".divBody").scrollTop(0);
						return false;
					}

					// グループ情報チェック
					for ( var i = 0; i < gp_data.length ; i++ ) {

						var gp_org_id = gp_data[i][0] ;
						var gp_name = gp_data[i][1] ;
						var gp_name_kana = gp_data[i][2] ;
						var gp_grade_name = gp_data[i][3] ;
						var gp_start_period = gp_data[i][4] ;
						var gp_end_period = gp_data[i][5] ;
						var gp_remarks = gp_data[i][6] ;
						var st_dt = new Date(gp_start_period);
						var ed_dt = new Date(gp_end_period);

						var d = new Date();
						var todayDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate();

						if( gp_org_id != "" ){
							org_id_array.push(gp_org_id);
						}

						if( gp_name != "" ){
							gp_name_array.push(gp_name);
						}

						if ( gp_org_id == "" ){

							err_content = "組織IDが正しくありません。";
							addErr(i+1,err_content);
							continue;
							// グループ名チェック
						}else if ( gp_name == "" || gp_name.length > 32 ){

							err_content = "グループ名が正しくありません。";
							addErr(i+1,err_content);
							continue;
						 // グループ名チェック
						}else if ((chk = characterCheck(gp_name)) != null){

							err_content = "グループ名" + chk;
							addErr(i+1,err_content);
							continue;
						// 読みチェック
						}else if ( gp_name_kana.length > 32 ){

							err_content = "読みが正しくありません。";
							addErr(i+1,err_content);
							continue;
							// 読みチェック
						}else if ((chk = characterCheck(gp_name_kana)) != null){

							err_content = "読み" + chk;
							addErr(i+1,err_content);
							continue;
						// 利用開始チェック
						}else if ( gp_start_period == "" || gp_start_period.length > 10 ||　!dateFormat(moment(gp_start_period).format('Y-MM-DD'))　|| Date.parse(st_dt) < Date.parse(todayDate) ){

							err_content = "利用開始が正しくありません。";
							addErr(i+1,err_content);
							continue;
						// 利用終了チェック
						}else if ( gp_end_period == "" || gp_end_period.length > 10 || !dateFormat(moment(gp_end_period).format('Y-MM-DD')) || Date.parse(gp_end_period) < Date.parse(todayDate) || Date.parse(gp_start_period) > Date.parse(gp_end_period) ){

							err_content = "利用終了が正しくありません。";
							addErr(i+1,err_content);
							continue;
						// 備考チェック
						}else if ( gp_remarks.length > 512 ){

							err_content = "備考が正しくありません。";
							addErr(i+1,err_content);
						// 備考チェック
						}else if ((chk = characterCheck(gp_remarks)) != null){

							err_content = "備考" + chk;
							addErr(i+1,err_content);
							continue;
						}
					}

					if ( err_array.length == 0 ){

						dup_err = dupCheck(gp_name_array);
					}

					// エーラがある場合、
					function addErr(index,err_content){
						err_array.push(index," 行目の ", err_content , "<br/>");
					}

					function isIdentity(org_id) {
						return (org_id === org_id_array[0]);
					}

					function onlyUnique(value, index, self) {
						return self.indexOf(value) === index;
					}

					// エラーがある場合エーラメッセージを表す
					if ( err_array.length != 0 ) {

						 $('#err_dis').show();
						 $(".error_section").slideDown('slow');

						 for ( j = 0; j < err_array.length -1; j++ ) {
							 $(".error_msg").html(err_array);
						 }
						 $(".divBody").scrollTop(0);

						return false;
					}else if( !org_id_array.every (isIdentity) ){
						//エクセルファイル内で、組織IDが同一でない場合、
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html("<?php echo @constant('E027');?>
");
						$(".divBody").scrollTop(0);

						return false;
					}else if ( dup_err.length != 0 ) {
						//エクセルファイル内で、ログインIDが同一でない場合、
						dup_errMsg = "登録ファイルの "+dup_err + " 行目が同じグループ名になっています。";

						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html(dup_errMsg);
						$(".divBody").scrollTop(0);

						return false;
					}else {

						//以上のエラーで無い場合、登録処理
						var action = '<?php echo @constant('HOME_DIR');?>
ExcelGroupList/isValid';
						var rowCount = gp_data.length ;
						var org_name_flg = $("#org_name_flg").val();
						var db_org_name = $("#db_org_name").val();
						var arr = [];

						for ( i = 0; i < rowCount ; i++ ) {

							// escape comma 処理
							gp_data[i][0] = gp_data[i][0].replace(/,/g , "escape comma");//組織ID
							gp_data[i][1] = gp_data[i][1].replace(/,/g , "escape comma");//グループ名
							gp_data[i][2] = gp_data[i][2].replace(/,/g , "escape comma");//読み
							gp_data[i][3] = gp_data[i][3].replace(/,/g , "escape comma");//学年
							gp_data[i][4] = gp_data[i][4].replace(/,/g , "escape comma");//利用開始
							gp_data[i][5] = gp_data[i][5].replace(/,/g , "escape comma");//利用終了
							gp_data[i][6] = gp_data[i][6].replace(/,/g , "escape comma");//備考
							arr.push(gp_data[i]);
						}

						$("#main_form").attr("action", action);
						$("#org_name_flg").val(org_name_flg);
						$("#db_org_name").val(db_org_name);
						$("#group_data").val(arr);
						$("#main_form").submit();
					}
				});
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form action="<?php echo @constant('HOME_DIR');?>
ExcelGroupList/save" method="post" id="main_form">
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
								> <span class="title">データ登録/  グループ登録</span>
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
							<input type="hidden" id="group_data" name="group_data" />
							<input type="hidden" id="gp_name" name="gp_name" />
							<input type="hidden" id="gp_name_kana" name="gp_name_kana" />
							<input type="hidden" id="grade_name" name="grade_name" />
							<input type="hidden" id="start_period" name="start_dt" />
							<input type="hidden" id="end_period" name="end_dt" />
							<input type="hidden" id="remarks" name="remarks" />
							<input type="hidden" id="btn_flg" name="btn_flg" value="<?php echo $_smarty_tpl->tpl_vars['btn_flg']->value;?>
" />
							<input type="hidden" id="gp_max_count" name ="gp_max_count" value = "<?php echo $_smarty_tpl->tpl_vars['gp_max_count']->value;?>
">
							<input type="hidden" id="org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
"/>
							<input type="hidden" id="org_name_flg" name ="org_name_flg" value="<?php echo $_smarty_tpl->tpl_vars['org_name_flg']->value;?>
"/>
							<input type="hidden" id="db_org_name" name ="db_org_name" value="<?php echo $_smarty_tpl->tpl_vars['db_org_name']->value;?>
"/>
							<!-- search table -->
							<div id="hidden">
							<table class="tsk_regist_tbl2">
								<tr height="45px;">
									<td id="tdImage" width="100px">ファイル</td>
									<td>
										<!-- <label id="file_name" name="file_name"><?php echo $_smarty_tpl->tpl_vars['form']->value->file_name;?>
</label> -->
										<input type="text" id="file_name" name="file_name" readonly="readonly" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->file_name1;?>
" class="task_file" style="height:25px;"/>
									</td>
									<td width="150px">
										<?php if ($_smarty_tpl->tpl_vars['form']->value->date_flg != "1") {?>
											<input type="file" id="input_file" name="input_file" accept=".xlsx, .xls, .csv"/>
											<button type="button" id="img_btn" style="height:30px;">ファイルを選択</button>
										<?php }?>
									</td>
									<td width="131px;" id="hide1">
										<input type="button" name="btn_upload" title="表示" class="btn_confirm" id="btn_upload" onclick="javascript:show('<?php echo @constant('HOME_DIR');?>
ExcelGroupList/show')" >
									</td>
									<td width="400px;" align="right" id="hide2">
										<input type="button" id="btn_all_dl" name="btn_all_dl" title="フォーマットダウンロード" class="btn_all_dl" onclick="javascript:excelDl('<?php echo @constant('HOME_DIR');?>
ExcelGroupList/newExcel')">
									</td>
								</tr>
							</table>
							<div id="div_org_name" style= 'padding:5px' >
							<?php if ($_smarty_tpl->tpl_vars['org_name_flg']->value == '0') {?>
								<label id="db_org_name" name="db_org_name" style='color:red'><?php echo $_smarty_tpl->tpl_vars['db_org_name']->value;?>
</label>
							<?php } else { ?>
								<label id="db_org_name" name="db_org_name" style='color:black'><?php echo $_smarty_tpl->tpl_vars['db_org_name']->value;?>
</label>
							<?php }?>
							</div>
							<div class="display">
							<table id="gp_tbl" class="display" style="width:100%; border-collapse: collapse; font-size: 1.0em; display: none;">
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
										<thead style="background-color: #B7DEE8;">
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
			} else {
				 $("#main_form").attr("action", action);
				 $("#main_form").submit();
			}
		}
		//DL処理
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
