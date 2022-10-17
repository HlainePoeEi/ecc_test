<?php
/* Smarty version 3.1.29, created on 2022-10-17 05:26:57
  from "D:\xampp\htdocs\eccadmin_dev\templates\quizInfoRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_634ccb812f4846_26326290',
  'file_dependency' => 
  array (
    'd99b00ec58e3c0b34ca161903a33d8b908d94dc8' => 
    array (
      0 => 'D:\\xampp\\htdocs\\eccadmin_dev\\templates\\quizInfoRegist.html',
      1 => 1650338224,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:leftMenu.html' => 1,
    'file:header.html' => 1,
    'file:footer.html' => 2,
  ),
),false)) {
function content_634ccb812f4846_26326290 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
	<title>クイズ登録</title>
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
js/nicEdit-latest.js"><?php echo '</script'; ?>
>
	
	<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/quizregist.css" rel="stylesheet">

	<?php echo '<script'; ?>
 type="text/javascript">
			
			bkLib.onDomLoaded(function() {
				new nicEditor({buttonList : ['fontSize','forecolor','bold','italic','underline','strikeThrough','subscript','superscript','html','upload', 'xhtml']}).panelInstance('long_description');
			});
			 
			// inputにエンターキー押下時のsubmitを無効化
			$(document).on("keypress", "input:not(.allow_submit)", function(event) {
				return event.which !== 13;
			});
			// selectにエンターキー押下時のsubmitを無効化
			$(document).on("keypress", "select:not(.allow_submit)", function(event) {
				return event.which !== 13;
			});

			//表示再現
			$(document).ready(function() {

				//新規登録の場合、
				var screen_mode = $("#screen_mode").val();
				//複写のためアップロードの名を入れる事
				var fname=document.getElementById("audio_file").value;
				if(fname !="" && screen_mode == "update"){
					$(".file_placeholder").empty();
					$('#input_audio_file').removeClass('vendo04r_logo').addClass('vendor_logo_hide');
				}

				// MSGのあるなし
				if ( $(".error_msg").html() != "" ){

					$(".error_section").slideDown('slow')
				}

				var quiz_name = document.getElementById("quiz_name").value;
				if (screen_mode != "update") {
					if ( quiz_name == "") {
						document.getElementById("btn_add").style.display = "none";
						document.getElementById("btn_add_name").style.display = "none";
						document.getElementById("btn_preview").style.display = "none";
						document.getElementById("btn_preview_name").style.display = "none";
					}else {
						document.getElementById("btn_insert").style.visibility = "hidden";
					}

				}

				$(".close_icon").on('click', function(){

					$(".error_section").slideUp('slow')

				});

			var input_audio_file = document.getElementById("input_audio_file");
			var audio_data = "";
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

			$("input[type=file]#input_file").on('click',function(){

				var reply_flg = $('input[name="chk_status1"]:checked').val();

				if ( reply_flg == 1 ){

					error_msg = "ファイル削除をチェックされた状態で、ファイルの変更は同時に出来ません。";
					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html(error_msg);
					$(".divBody").scrollTop(0);
					return false;
				}
			});

			$("input[type=file]#input_audio_file").on('click',function(){

				var audio_flg =$('input[name="chk_status2"]:checked').val();

				if ( audio_flg == 1 ){

					error_msg = "ファイル削除をチェックされた状態で、ファイルの変更は同時に出来ません。";
					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html(error_msg);
					$(".divBody").scrollTop(0);
					return false;
				}
			});

			// ------------------------------------------------------------
			// 値が変化した時に実行されるイベント
			// ------------------------------------------------------------
			$("input[type=file]#input_audio_file").on("change", function () {
				// File Type チェック
				var audio_ext = "." + input_audio_file.value.split('.').pop();
				if ( audio_ext != ".mp3" ){
					$('#input_audio_file').val('');
					$("#audio_file").val('');
					//複写のためアップロードの名を入れる事をクリア
					$(".file_placeholder").empty();
					$('#input_audio_file').removeClass('vendor_logo_hide').addClass('vendor_logo');
					error_msg = "正しくフィルを選択してください。";
					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html(error_msg);
					$(".divBody").scrollTop(0);
					return false;
				} else {
					var selectedFile = this.files[0];

					console.log(selectedFile);

					if (selectedFile != null){
						selectedFile.convertToBase64(function(base64) {
							audio_data = base64;
							   document.getElementById("audio_data").value = base64;
						});
					}else {
						audio_data = "";
						document.getElementById("audio_data").value = "";
					}
				}

				console.log(audio_data);

				var fileName = $("input[type=file]#input_audio_file").val();
				var clean = fileName.split('\\').pop();

				$("#audio_file").val(clean);
				//複写のためアップロードの名を入れる事
				$(".file_placeholder").empty();
				$('#input_audio_file').removeClass('vendor_logo_hide').addClass('vendor_logo');
			});

			/**
			 *
			 *  登録ボタン押下、必須チェック処理
			 *
			 **/
			 $(".btn_insert").on('click',function() {

				$(".error_section").hide();

				var nicE = new nicEditors.findEditor('long_description');
				var long_description = nicE.getContent();
				var quiz_name = $('#quiz_name').val();
				var remarks = $('#remarks').val();



				// クイズ名の必須チェック
				if ( quiz_name == "" ) {

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("クイズ名を入力してください。");
					$(".divBody").scrollTop(0);
					return false;
				}

				if ( (err_msg = characterCheck(quiz_name)) != null ){

					error_msg = "クイズ名"+ err_msg;
					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html(error_msg);
					$(".divBody").scrollTop(0);
					return false;
				}

				if ( (err_msg = characterCheck(remarks)) != null ){

					error_msg = "備考"+ err_msg;
					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html(error_msg);
					$(".divBody").scrollTop(0);
					return false;
				}

				// テスト内容の文字数チェック
				if ( long_description == "<br>" || long_description == "" ) {

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("クイズ内容を入力してください。");
					$(".divBody").scrollTop(0);
					return false;
				}

				if ( long_description.length > 4096 ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("クイズ内容を4096字で入力してください。");
					$(".divBody").scrollTop(0);
					return false;
				}

				var audio_flg =$('input[name="chk_status2"]:checked').val();

				if ( audio_flg == 1 ){

					var audio_file =  $('#input_audio_file').val();

					if ( audio_file == "" ){

						document.getElementById("audio_chk_del").value =1;

					}else {

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("ファイル削除をチェックされた状態で、ファイルの変更は同時に出来ません。");
						$(".divBody").scrollTop(0);
						return false;
					}
				}

				//フィルタ
				if ( !document.getElementById("filter") ){
					$("body").append("<div id=\"filter\"></div>");
				}else {
					$("#filter").show();
				}

				return true;
			});
		});

			//戻るボタン処理
			function doBack(action){

				$("#main_form").attr("action", action);
				$("#main_form").submit();
			}

		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" name="main_form1" action="<?php echo @constant('HOME_DIR');?>
QuizInfoRegist/Save" method="post">
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<div class="divHeader">
				<!--header-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--header-->
			</div>
			<div class="divBody">
				<div class="main">
					<section class="error_section">
						<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" style="width:15px;float:right" class="close_icon">

							<?php if (!empty($_smarty_tpl->tpl_vars['msg']->value)) {?>
							<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</div>
							<?php } else { ?>
							 <div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['info_msg']->value;?>
</div>
							<?php }?>

					</section>

					<section class="content" >
						<p>
							&gt;<span class="title">テスト情報 / クイズ登録</span>
						</p>

						<p style="text-align:right;width:100%;">
							<input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
QuizInfoRegist/back')">
						</p>
						<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
" />
						<input type="hidden" id="search_page_qil" name="search_page_qil" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_qil;?>
" />
						<input type="hidden" id="search_page_row_qil" name="search_page_row_qil" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_row_qil;?>
" />
						<input type="hidden" id="search_page_order_column_qil" name="search_page_order_column_qil" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_column_qil;?>
" />
						<input type="hidden" id="search_page_order_dir_qil" name="search_page_order_dir_qil" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_dir_qil;?>
" />

						<input type="hidden" id="quiz_info_no" name="quiz_info_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_info_no;?>
">
						<input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
" />
						<input type="hidden" id="audio_del_flg" name="audio_del_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->audio_del_flg;?>
">
						<input type="hidden" id="audio_chk_del" name="audio_chk_del"/>
						<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
						<!-- 画像保存用 -->
						<input type="hidden" id="orgNo" name="orgNo" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
						<input type="hidden" id="gamen_name" name="gamen_name" value="quizInfo"/>
						<input type="hidden" id="audio_data" name="audio_data" value=""/>
						<input type="hidden" id="search_quiz_name" name="search_quiz_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_quiz_name, ENT_QUOTES, 'UTF-8', true);?>
" />
						<input type="hidden" id="search_long_description" name="search_long_description" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_long_description;?>
" />
						<input type="hidden" id="search_remark" name="search_remark" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_remark;?>
" />
						<input type="hidden" id="search_rd_status1" name="search_rd_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rd_status1;?>
" />

						<div width="100%">
							<table width="100%">
									<tr>
										<td style="width:240px;">クイズ名<span class="required">※</span></td>
										<td><input type="text" class="text" id="quiz_name" name="quiz_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->quiz_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "100" size="30"></td>
									</tr>
									<tr><td></td>
									</tr>
								 <tr>
								<td>クイズ内容 <span class="required">※</span></td>
									<td><textarea name="long_description" id="long_description" rows="2" class="txtarea"
									cols="40" maxlength = "4096" style="width:800px"><?php echo $_smarty_tpl->tpl_vars['form']->value->long_description;?>
</textarea>
									</td>
								</tr>
								<tr height="45px;">
									<td id="tdAudio">ファイル（音声）
										<?php if ($_smarty_tpl->tpl_vars['form']->value->audio_file != '') {?>
											<a href="<?php echo @constant('ADMIN_HOME_DIR');?>
files/<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
/QuizInfo/audio/<?php echo $_smarty_tpl->tpl_vars['form']->value->audio_file;?>
" download> download</a>
										<?php }?></td>
									<td>
										<div style="display:flex;">
											<input type="text" class="text" id="audio_file" name="audio_file" readonly="readonly" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->audio_file;?>
" style="width:200px;height:25px;"/>
											<div style="width:350px;height:22px;margin-left:10px;">
											<input type="file" id="input_audio_file" name="input_audio_file" class="vendor_logo" style="height:30px;padding: 3px 0px;" accept="audio/mp3"/>
											<?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode == 'update') {?>
											<?php if ($_smarty_tpl->tpl_vars['form']->value->disable_mode == '') {?>
												<input type="checkbox" id="chk_status2" name="chk_status2" value="1"><label for="chk_status2">音声ファイル削除</label>
											<?php }?>
				 						<?php }?>
				 						</div>
				 						</div>
				 					</td>

								</tr>
								 <tr>
									<td>備考</td>
									<td><input type="text" class="text" id="remarks" name="remarks" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->remarks;?>
" size="30" maxlength = "512"></td>
								</tr>
							</table>
							<br/>
							<br/>
							<br/>
							<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
							<input type="hidden" name="manager_noString" id="manager_noString" value="" />
							<table class="tbl_botton">
								<tr>
									<td>
									<?php if ($_smarty_tpl->tpl_vars['form']->value->disable_mode == '') {?>
										<input class="btn_add" type="button" value=""  id="btn_add"
										onclick="quizItemDetail('<?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_info_no;?>
','<?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_name;?>
','<?php echo @constant('HOME_DIR');?>
QuizDetailsRegist/index');"/></td>
									<?php }?>
									<td id="btn_add_name"><?php if ($_smarty_tpl->tpl_vars['form']->value->disable_mode == '') {?>クイズアイテム登録<?php }?></td>
									<td class="space"></td>
									<td>
										<input class="btn_preview_list" type="button" value="" id="btn_preview"
										onclick="preview('<?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_info_no;?>
','<?php echo @constant('HOME_DIR');?>
QuizDetailsPreview/index');"/></td>
									<td id="btn_preview_name">プレビュー</td>
									<td class="space"></td>
									<?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode == 'update') {?>
										<td>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->disable_mode == '') {?>
											<input class="btn_delete" type="button" name="btn_del" onclick="checkDelete('<?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_info_no;?>
','<?php echo @constant('HOME_DIR');?>
QuizInfoRegist/delete');" id="btn_del">
										<?php }?>
										</td>
								</tr>
									<?php }?>
									<?php if ($_smarty_tpl->tpl_vars['form']->value->disable_mode == '') {?>
									<tr>
										<input type="submit" name="submit_add" id="btn_insert" value="" class="btn_insert" style="padding-right:20px;float: right;">
									</tr>
									<?php }?>
							</table>
						</div>
					</section><!-- End Content -->
				</div><!-- End Main -->
			</div><!-- End divBody -->
			<div class="divFooter">
				<!--footer-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--footer-->
			</div>
		</form>
			<?php echo '<script'; ?>
>
				

				//削除 ボタン押下処理
				function checkDelete(quiz_info_no,action){

					alertDialog = confirm('Are you sure to delete this quiz?');

					if ( alertDialog == false ) {

						return false;
					}else {

						var menuOpen = document.getElementById('menuOpen').value;
						var menuStatus = document.getElementById('menuStatus').value;

						$("#main_form").attr("action", action);
						$("#quiz_info_no").val(quiz_info_no);
						$("#menuOpen").val(menuOpen);
						$("#menuStatus").val(menuStatus);
						$("#main_form").submit();
					}
				}

				// プレビューボタン処理
				function preview(quiz_info_no, action){

					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;

					$("#search_page_qil").val($("#search_page_qil").val());
					$("#search_page_row_qil").val($("#search_page_row_qil").val());
					$("#search_page_order_column_qil").val($("#search_page_order_column_qil").val());
					$("#search_page_order_dir_qil").val($("#search_page_order_dir_qil").val());
					$("#search_quiz_name").val($("#search_quiz_name").val());
					$("#search_long_description").val($("#search_long_description").val());
					$("#search_remark").val($("#remark").val());
					$("#search_rd_status1").val($('input[name=rd_status1]:checked').val());
					$("#search_org_id").val($('#search_org_id').val());
					$("#screen_mode").val($("#screen_mode").val());

					$("#main_form").attr("action", action);
		            $("#quiz_info_no").val(quiz_info_no);
		            $("#menuOpen").val(menuOpen);
		            $("#menuStatus").val(menuStatus);
		            $("#main_form").submit();
					}

				//クイズアイテム登録
				function quizItemDetail(quiz_info_no,quiz_name, action){
					console.log("quizItemDetail");
					setFormData();

					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;

					$("#search_page_qil").val($("#search_page_qil").val());
					$("#search_page_row_qil").val($("#search_page_row_qil").val());
					$("#search_page_order_column_qil").val($("#search_page_order_column_qil").val());
					$("#search_page_order_dir_qil").val($("#search_page_order_dir_qil").val());
					
					$("#search_quiz_name").val($("#search_quiz_name").val());
					$("#search_long_description").val($("#search_long_description").val());
					$("#search_remark").val($("#search_remark").val());
					$("#search_rd_status1").val($('#search_rd_status1').val());
					$("#search_org_id").val($('#search_org_id').val());

					$("#main_form").attr("action", action);
					$("#screen_mode").val($("#screen_mode").val());
					$("#quiz_name").val(quiz_name);
		            $("#quiz_info_no").val(quiz_info_no);
		            $("#menuOpen").val(menuOpen);
		            $("#menuStatus").val(menuStatus);
		            $("#main_form").submit();
					}
				//slpp
				function setFormData(){

					 $("#org_no").val($("#org_no").val());
					 $("#long_description").val($("#long_description").val());
					 $("#remarks").val($("#remarks").val());
					 $("#audio_file").val($("#audio_file").val());
					 $("#input_audio_file").val($("#input_audio_file").val());
					 $("#audio_del_flg ").val($("#audio_del_flg").val());
					 $("#audio_chk_del").val($("#audio_chk_del").val());
				}

				
			<?php echo '</script'; ?>
>
		<!--footer-->
		<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

		<!--footer-->
	</body>
</html><?php }
}
