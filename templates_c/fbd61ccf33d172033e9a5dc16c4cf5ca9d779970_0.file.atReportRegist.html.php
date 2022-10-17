<?php
/* Smarty version 3.1.29, created on 2022-10-13 11:46:08
  from "/var/www/html/eccadmin_dev/templates/atReportRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_63477bf04ed355_67640766',
  'file_dependency' => 
  array (
    'fbd61ccf33d172033e9a5dc16c4cf5ca9d779970' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/atReportRegist.html',
      1 => 1662093271,
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
function content_63477bf04ed355_67640766 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Online Practice 登録</title>
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
		<style>
			#tbl_1, th, td {
			  border: 0px solid black;
			  border-collapse: collapse;
			}
		</style>
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
				
				// DatePicker
				
				var date = new Date();
				var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();

				$(function() {
					$('.start_period').datepicker({
						showOn : "button",
						buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
						dateFormat: 'yy/mm/dd',
						buttonImageOnly : true,
						beforeShow: function (input, inst) {
							 var id = $(this).attr("id");
							 id = id.split("start_period")[1];
							 //開始日時二つの中で最初の date Picker の設定
							 if ( id == "0"){
								 setTimeout(function () {
									 var leftWidth=($('.pushmenu-open').length>0)?$('.start_period').offset().left-$('.pushmenu-open')[0].offsetWidth
											 :$('.start_period').offset().left;
									inst.dpDiv.css({
										top: $('.start_period').offset().top + 35,
										left: leftWidth
									});
								 }, 0);
							 }else {
								//次の date Picker の設定
								 setTimeout(function () {
										 var leftWidth=($('.pushmenu-open').length>0)?$('.start_period').offset().left-$('.pushmenu-open')[0].offsetWidth
												 :$('.start_period').offset().left;
										inst.dpDiv.css({
											top: $("#start_period"+id).offset().top + 35,
											left: leftWidth
										});
									 }, 0);
							 }
						 }
					});
				});

				$(function() {
					$('.end_period').datepicker({
						showOn : "button",
						buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
						dateFormat: 'yy/mm/dd',
						buttonImageOnly : true,
						beforeShow: function (input, inst) {
							var id = $(this).attr("id");
							id = id.split("end_period")[1];
							//終了日時二つの中で最初の date Picker の設定
							if ( id == "0" ){
								 setTimeout(function () {
									 var leftWidth=($('.pushmenu-open').length>0)?$('.end_period').offset().left-$('.pushmenu-open')[0].offsetWidth
											 :$('.end_period').offset().left;
									inst.dpDiv.css({
										top: $('.end_period').offset().top + 35,
										left: leftWidth
									});
								 }, 0);
							 }else{
								 setTimeout(function () {
									 var leftWidth=($('.pushmenu-open').length>0)?$('.end_period').offset().left-$('.pushmenu-open')[0].offsetWidth
											 :$('.end_period').offset().left;
									inst.dpDiv.css({
										top: $("#end_period"+id).offset().top + 35,
										left: leftWidth
									});
								}, 0);
							 }
						 }
					});
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
					var fileExtension = ['xlsx','xls','xlsm'];//'xlsm'
					
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
					
						 // 画像ファイル拡張子設定
						if ( input_file.value != "" ){
							file_ext = "." + input_file.value.split('.').pop();
							$("#file_ext").val(file_ext);
						}
					}
					return true;
				});

				// イベントを隠しボタンに変更する
				document.getElementById('img_btn').addEventListener('click',function(){
					document.getElementById('input_file').click();
				});

				//登録ボタンを押すと、画面での項目チェック
				$("#btn_insert").on('click',function(e) {
					var at_report_name = $('#at_report_name').val();
					var file_name = $("#file_name").val();
					var org_id=$('#org_id').val();
					var start_period = document.getElementById('start_period').value;
					var end_period = document.getElementById('end_period').value;
					var result_start_period = document.getElementById('result_start_period').value;
					var result_end_period = document.getElementById('result_end_period').value;
						
					if (org_id == "" ) {
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html(" 組織を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
					if (at_report_name == "" ) {
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html(" ATレポート名を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}	

					if ( at_report_name.length > 64 ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("ATレポート名を64字で入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					//インプットファイル必須チェック
					if ( file_name == "" ) {
						error_msg = "レポートファイルを選択してください。";
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html(error_msg);
						$(".divBody").scrollTop(0);
						return false;
					}	

					var file_flg =$('input[name="chk_status2"]:checked').val();
					if ( file_flg == 1 ){
						var file =  $('#input_file').val();
						if ( file == "" ){
							document.getElementById("file_chk_del").value =1;
							alert(document.getElementById("file_chk_del").value)
						}else {
							$('#err_dis').show();
							$(".error_section").slideToggle('slow');
							$(".error_msg").html("ファイル削除をチェックされた状態で、ファイルの変更は同時に出来ません。");
							$(".divBody").scrollTop(0);
							return false;
						}
					}
					$("#org_id").attr( "disabled", false );
					
					// 公開状況設定
					var status = $('input[name="rdo_status"]:checked').val();
					$("#status").val(status);
					
					// プレビュー表示設定
					 var r = $('input[name="rptPreview"]:checked').val();
					$("#preview_flg").val(r);
					
					// テスト期間チェック
					if ( start_period == "" || end_period == "") {
						error_msg = "テスト期間を選択してください。";
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html(error_msg);
						$(".divBody").scrollTop(0);
						return false;
					}
					
					// 結果表示期間チェック
					if ( result_start_period == "" || result_end_period == "") {
						error_msg = "結果表示期間を選択してください。";
						$('#err_dis').show();
						$(".error_section").slideDown('slow');
						$(".error_msg").html(error_msg);
						$(".divBody").scrollTop(0);
						return false;
					}
					
					// テスト期間チェック
					if ( start_period > end_period ){
						error_msg = "テスト開始日 ≦ テスト終了日 を正しく入力ください。";
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html(error_msg);
						return false;
					}
					
					// 結果表示期間チェック
					if ( result_start_period > result_end_period ){
						error_msg = "結果表示開始日 ≦ 結果表示終了日 を正しく入力ください。";
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html(error_msg);
						return false;
					}
					
					return ;
				});
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form action="<?php echo @constant('HOME_DIR');?>
AtReportRegist/save" method="post" id="main_form">
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
								<?php if (!empty($_smarty_tpl->tpl_vars['error_msg']->value)) {?>
								<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['error_msg']->value;?>
</div>
								<?php } else { ?>
								<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['info_msg']->value;?>
</div>
								<?php }?>
							</section>
						</div>
						<section class="content">
							<br/>
							<p>
								&gt;<span class="title">Online Practice 登録</span>
							</p>
							<p style="text-align:right;width:100%;">
								<input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
AtReportRegist/back')">
							</p>
							<br/>
							<!-- hidden field area -->
							<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
							<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
							<input type="hidden" id="file" name="file" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->file;?>
"/>
							<input type="hidden" id="file_data" name="file_data" value=""/>
							<input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
" />
							<input type="hidden" id="file_ext" name="file_ext" value=""/>
							<input type="hidden" id="status" name="status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->status;?>
"/>
							<input type="hidden" id="preview_flg" name="preview_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->preview_flg;?>
"/>
							<input type="hidden" id="back_gamen" name="back_gamen" value="at_report"/>
							<input type="hidden" id="at_report_no" name="at_report_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->at_report_no;?>
"/>
							<input type="hidden" id="test_info_no" name="test_info_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_info_no;?>
"/>
							<input type="hidden" id="test_info_no1" name="test_info_no1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_info_no1;?>
"/>
							<input type="hidden" id="test_info_no2" name="test_info_no2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_info_no2;?>
"/>
							<input type="hidden" id="test_info_name" name="test_info_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_info_name;?>
"/>
							<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
" />
							<input type="hidden" id="search_at_report_name" name="search_at_report_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_at_report_name, ENT_QUOTES, 'UTF-8', true);?>
"/>
							<input type="hidden" id="search_test_info_name" name="search_test_info_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_test_info_name, ENT_QUOTES, 'UTF-8', true);?>
"/>
							<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
" />
							<input type="hidden" id="search_page_row" name="search_page_row" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_row;?>
" />
							<input type="hidden" id="search_page_order_column" name="search_page_order_column" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_column;?>
" />
							<input type="hidden" id="search_page_order_dir" name="search_page_order_dir" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_dir;?>
" />
							<input type="hidden" id="file_chk_del" name="file_chk_del" />
							<!-- search table -->
							<div id="hidden">
								<table id="tbl_1" style="width:100%;line-height:45px;">
									<tr>
										
										<td style="width:150px;">組織ログインID<span class="required">※</span></td>
										<td width="20%">
											<?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode != 'update') {?>
												<input id="org_id" name="org_id" type="text" class="text" maxlength="10" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
" >
											<?php } else { ?>
												<input id="org_id" name="org_id" type="text" class="text" maxlength="10" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
" readonly>
											<?php }?>
											
										</td>
										<td width="70px">
										<?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode != 'update') {?>
											<input type="button" class="btn_preview_list" name="btn_qa_assign" id="org_display" onclick="javascript:showOrg('<?php echo @constant('HOME_DIR');?>
AtReportRegist/orgShow')" >
										<?php }?>
										</td>
										<td id="abc" width="25%">
											<label class="lbl_name" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_name, ENT_QUOTES, 'UTF-8', true);?>
</label>
											<label class="lbl_name" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_no, ENT_QUOTES, 'UTF-8', true);?>
</label>
										</td>
										<td id="abc" width="25%">
											<label class="lbl_name" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_name_official, ENT_QUOTES, 'UTF-8', true);?>
</label>
										</td>
									</tr>
									<tr>
										<td style="width:200px;">AT レポート名<span class="required">※</span></td>
										<td colspan="3"><input type="text" class="text" id="at_report_name" name="at_report_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->at_report_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "100" size = "100"></td>
									</tr>
									<tr>
										<td>結果表示</td>
										<td>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->show_flg == '1') {?>
										<input type="radio" name="show_flg" value="1" id="status1" checked />
										<label for="status1">しない </label></input>
										<input type="radio" name="show_flg" value="0" id="status2" />
										<label for="status2">する</label></input>
										<?php } else { ?>
										<input type="radio" name="show_flg" value="1" id="status1" />
										<label for="status1">しない </label></input>
										<input type="radio" name="show_flg" value="0" id="status2" checked />
										<label for="status2">する</label>
										</input>
										<?php }?>
										</td>
									</tr>
									<tr height="45px;">
										<td id="tdImage" width="150px">テンプレート<span class="required">※</span></td>
										<td width="150px">
											<input type="text" id="file_name" name="file_name" readonly="readonly" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->file_name;?>
" class="task_file" style="height:25px;"/>
										</td>
										<td width="150px" colspan="2">
											<input id="input_file" name="input_file" class="input_file" type="file" name="image" accept=".xlsx, .xls, .xlsm">
											<button type="button" id="img_btn"  style="height:30px;width:120px;">ファイルを選択</button>
										</td>
										<td width="150px">
											<?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode == 'update') {?>
												<input type="checkbox" id="chk_status2" name="chk_status2" value="1"><label for="chk_status2">ファイル削除</label>
											<?php }?>
										</td>
									</tr>
									<tr>
										<td id="tdImage" width="150px">テスト期間</td>
										<td >
											<input type="text" class="start_period" id="start_period" name="start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10" onchange="">
										</td>
										<td style="width:50px;padding-left:40px"> <span>  ～  </span> </td>
										<td>
											<input type="text" class="end_period" id="end_period" name="end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" maxlength="10" onchange="">
										</td>
									</tr>
									<tr>
										<td id="tdImage" width="150px">結果表示期間</td>
										<td >
											<input type="text" class="start_period" id="result_start_period" name="result_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->result_start_period;?>
" maxlength="10" onchange="">
										</td>
										<td style="width:50px;padding-left:40px"> <span>  ～  </span> </td>
										<td>
											<input type="text" class="end_period" id="result_end_period" name="result_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->result_end_period;?>
" maxlength="10" onchange="">
										</td>
									</tr>
									<tr>
										<td>公開</td>
										<td>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->status == '1') {?>
											<input type="radio" name="rdo_status" value="1" id="rpt_status1" checked />
											<label for="rpt_status1">する </label></input>
											<input type="radio" name="rdo_status" value="0" id="rpt_status2" />
											<label for="rpt_status2">しない</label></input>
										<?php } else { ?>
											<input type="radio" name="rdo_status" value="1" id="rpt_status1" />
											<label for="rpt_status1">する </label></input>
											<input type="radio" name="rdo_status" value="0" id="rpt_status2" checked />
											<label for="rpt_status2">しない</label>
											</input>
										<?php }?>
										</td>
									</tr>
									<tr>
										<td>プレビュー表示</td>
										<td>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->preview_flg == '1') {?>
											<input type="radio" name="rptPreview" value="1" id="rpt_PreviewFlg1" checked />
											<label for="rpt_PreviewFlg1">する </label></input>
											<input type="radio" name="rptPreview" value="0" id="rpt_PreviewFlg2" />
											<label for="rpt_PreviewFlg2">しない</label></input>
										<?php } else { ?>
											<input type="radio" name="rptPreview" value="1" id="rpt_PreviewFlg1" />
											<label for="rpt_PreviewFlg1">する </label></input>
											<input type="radio" name="rptPreview" value="0" id="rpt_PreviewFlg2" checked />
											<label for="rpt_PreviewFlg2">しない</label>
											</input>
										<?php }?>
										</td>
									</tr>
								</table>
								<br />
								<div width="60%" style="margin-top:50px;margin-left:0px" >
								<?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode == 'update') {?>
									<td style="width:70px;"> <input type="button" class="btn_test_info_assign" style="background-size:35px 35px;width:35px;height:35px;" title="試験設定" onclick="javascript:reportsetting('<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
','<?php echo $_smarty_tpl->tpl_vars['form']->value->at_report_no;?>
','<?php echo $_smarty_tpl->tpl_vars['form']->value->at_report_name;?>
','<?php echo @constant('HOME_DIR');?>
AtReportTestRegist/index')">
									<?php if ($_smarty_tpl->tpl_vars['form']->value->test_info_no1 != '') {?>
									<input type="button"
										class="btn_preview_list" name="preview" title="確認" style="margin-left:50px;" 
										onclick="doPreview('<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['form']->value->test_info_no1;?>
','<?php echo @constant('HOME_DIR');?>
TestInfoPreview/index')"/>
									<?php }?>
									<?php if ($_smarty_tpl->tpl_vars['form']->value->test_info_no2 != '') {?>
									<input type="button"
										class="btn_preview_list" name="preview" title="確認" style="margin-left:50px;" 
										onclick="doPreview('<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['form']->value->test_info_no2;?>
','<?php echo @constant('HOME_DIR');?>
TestInfoPreview/index')"/>
									<?php }?>
									</td>
								<?php }?>
									<td style="width:70px; "><input type="submit" name="insert" value="" id="btn_insert" class="btn_insert" title="登録" style="padding-right:20px;float: right;"></td>
									</tr>
								</div>
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

			window.onload = function init() {
			
				var org_no = document.getElementById('org_no').value;
				var screen_mode = document.getElementById('screen_mode').value;
			}

			// 組織情報表示ボタン
			function showOrg(action){

				var org_id = document.getElementById('org_id').value;

				if ( org_id == "" ) {

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("組織ログインIDを入力してください。");
					return false;
				}else{
					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;
					$("#org_id").css("display","");
					$("#main_form").attr("action", action);
					$("#menuOpen").val(menuOpen);
					$("#menuStatus").val(menuStatus);
					$("#main_form").submit();
				}
			}

			//テスト登録機能
			function reportsetting(org_no,org_id,at_report_no,at_report_name,action) {
				setFormData();
				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;
				
				$("#org_id").attr( "disabled", false );
				$("#main_form").attr("action", action);
				$("#org_no").val(org_no);
				$("#org_id").val(org_id);
				$("#at_report_no").val(at_report_no);
				$("#main_form").submit();
			}
			
			function doBack(action) {
			
				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#main_form").attr("action", action);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#search_test_info_name").val($("#search_test_info_name").val());
				$("#search_at_report_name").val($("#search_at_report_name").val());
				$("#search_page").val(document.getElementById('search_page').value);
				$("#back_flg").val("true");
				$("#main_form").submit();
			}
			function setFormData(){

				$("#org_no").val($("#org_no").val());
				$("#org_id").val($("#org_id").val());
				$("#at_report_no").val($("#at_report_no").val());
				$("#show_flg").val($("#show_flg").val());
				$("#screen_mode").val($("#screen_mode").val());
				$("#input_file").val($("#input_file").val());
				$("#file_chk_del").val($("#file_chk_del").val());
		   }
		   
			// プレビューボタン処理
			function doPreview(org_no ,test_info_no, action){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;
				var at_report_no = $('#at_report_no').val();

				$("#main_form").attr("action", action);
				$("#screen_mode").val("preview");
				$("#org_no").val(org_no);
				$("#at_report_no").val(at_report_no);
				$("#back_gamen").val("at_report");
				$("#test_info_no").val(test_info_no);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}
		<?php echo '</script'; ?>
>
	</body>
</html><?php }
}
