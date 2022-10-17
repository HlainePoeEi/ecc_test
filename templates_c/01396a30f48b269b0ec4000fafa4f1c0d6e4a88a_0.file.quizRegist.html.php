<?php
/* Smarty version 3.1.29, created on 2022-10-13 11:42:28
  from "/var/www/html/eccadmin_dev/templates/quizRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_63477b1409a446_04196080',
  'file_dependency' => 
  array (
    '01396a30f48b269b0ec4000fafa4f1c0d6e4a88a' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/quizRegist.html',
      1 => 1658283702,
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
function content_63477b1409a446_04196080 ($_smarty_tpl) {
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
				new nicEditor({buttonList : ['fontSize','forecolor','bold','italic','underline','strikeThrough','subscript','superscript','html','upload', 'xhtml']}).panelInstance('quiz_content');
				
				new nicEditor({buttonList : ['fontSize','forecolor','bold','italic','underline','strikeThrough','subscript','superscript','html', 'xhtml']}).panelInstance('explanation');
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
					$('#input_audio_file').removeClass('vendor_logo').addClass('vendor_logo_hide');
					$("#input_audio_file").after("<span class='file_placeholder'>"+fname+"</span>");
				}

				//新規登録の場合
				if(screen_mode != "update") {

					changeQuizTypeDropDown('001');
					document.getElementById("answer_time").value =10;

				}

				// MSGのあるなし
				if ( $(".error_msg").html() != "" ){

					$(".error_section").slideDown('slow')
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

				var quiz_name = $('#quiz_name').val();
				var remarks = $('#remarks').val();
				var quiz_type =  $('#cmb_quiz_type').val();

				$('#quiz_type').val(quiz_type);

				var nicE = new nicEditors.findEditor('quiz_content');
				var quiz_content = nicE.getContent();
				
				var nicEx = new nicEditors.findEditor('explanation');
				var txtExp = nicEx.getContent();
				
				var answer_time =  $('#answer_time').val();
				var choice_correct1 =  $('#choice_correct1').val();
				var blank_correct1 =  $('#blank_correct1').val();
				var incorrect1 =  $('#incorrect1').val();

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

				// クイズタイプの必須チェック
				if ( quiz_type == "" ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("クイズタイプを入力してください。");
					$(".divBody").scrollTop(0);
					return false;
				}

				// 回答時間の必須チェック
				if ( answer_time == "" ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("回答時間を入力してください。");
					$(".divBody").scrollTop(0);
					return false;
				}

				// 回答時間をの数字チェック
				if ( isNaN(answer_time) ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("回答時間を数字で入力してください。");
					$(".divBody").scrollTop(0);
					return false;
				}

				 // 回答時間チェック
				if ( answer_time.length != 2 ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("回答時間を10～99の値を入力してください。");
					$(".divBody").scrollTop(0);
					return false;
				}

				if ( answer_time < 10 || answer_time > 99 ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("回答時間を10～99の値を入力してください。");
					$(".divBody").scrollTop(0);
					return false;
				}

				// 問題の必須チェック
				if ( quiz_content == "<br>" || quiz_content == "" ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("問題を入力してください。");
					$(".divBody").scrollTop(0);
					return false;
				}

				// テスト内容の文字数チェック
				if ( quiz_content.length > 2000 ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("問題を2000字で入力してください。");
					$(".divBody").scrollTop(0);
					return false;
				}

				if ( quiz_type == "001" ){

					if ( choice_correct1 == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("正解を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}

					if ( incorrect1 == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("不正解1を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
				}

				if ( quiz_type == "002" ){

					if ( blank_correct1 == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("正解1を入力してください。");
						$(".divBody").scrollTop(0);
						return false;
					}
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
				
				// テスト内容の文字数チェック
				if ( txtExp.length > 4096 ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("解説を4096字で入力してください。");
					$(".divBody").scrollTop(0);
					return false;
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
			// ------------------------------------------------------------
			// クイズタイプのChangeイベント
			// ------------------------------------------------------------
			  function changeQuizTypeDropDown(type_obj) {

				var type = $('#cmb_quiz_type :selected').val();

				 if(type == '001') {

					$("#blank_type1").hide();
					$("#blank_type2").hide();
					$("#blank_type3").hide();
					$("#choice_type1").show();
					$("#choice_type2").show()
					$("#choice_type3").show()
					$("#choice_type4").show()

					} else {

					$("#blank_type1").show();
					$("#blank_type2").show();
					$("#blank_type3").show();
					$("#choice_type1").hide();
					$("#choice_type2").hide();
					$("#choice_type3").hide();
					$("#choice_type4").hide();
				}
			}

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
QuizRegist/Save" method="post">
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
							 <div class="error_msg"></div>
							<?php }?>
					</section>
					<section class="content" >
						<p>
							&gt;<span class="title">テスト / クイズ登録</span>
						</p>

						<p style="text-align:right;width:100%;">
							<input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
QuizRegist/back')">
						</p>

						<input type="hidden" id="quiz_no" name="quiz_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_no;?>
">
						<input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
" />
						<input type="hidden" id="quiz_type" name="quiz_type" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_type;?>
" />
						<input type="hidden" id="type_name" name="type_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->type_name;?>
" />
						<input type="hidden" id="audio_del_flg" name="audio_del_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->audio_del_flg;?>
">
						<input type="hidden" id="audio_chk_del" name="audio_chk_del"/>
						<input type="hidden" id="orgNo" name="orgNo" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>
						<input type="hidden" id="gamen_name" name="gamen_name" value="quiz"/>
						<input type="hidden" id="audio_data" name="audio_data" value=""/>
						<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
"/>

						<input type="hidden" id="search_quiz_name" name="search_quiz_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_quiz_name, ENT_QUOTES, 'UTF-8', true);?>
" />
						<input type="hidden" id="search_quiz_content" name="search_quiz_content" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_quiz_content;?>
" />
						<input type="hidden" id="search_remark" name="search_remark" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_remark;?>
" />
						<input type="hidden" id="search_rd_status1" name="search_rd_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rd_status1;?>
" />
						<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
" />
						
						<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
" />
						<input type="hidden" id="search_page_row" name="search_page_row" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_row;?>
" />
						<input type="hidden" id="search_page_order_column" name="search_page_order_column" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_column;?>
" />
						<input type="hidden" id="search_page_order_dir" name="search_page_order_dir" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_dir;?>
" />

						<div width="100%">
							<table width="100%">
									<tr>
										<td style="width:240px;">クイズ名<span class="required">※</span></td>
										<td><input type="text" class="text" id="quiz_name" name="quiz_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->quiz_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30"></td>
									</tr>
									<tr>
									<td>タイプ</td>
									<td>
									<?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode == 'update') {?>
									   <select id="cmb_quiz_type" name="cmb_quiz_type" onchange="changeQuizTypeDropDown(this)" disabled="disabled">
												<option value = "<?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_type;?>
" selected><?php echo $_smarty_tpl->tpl_vars['form']->value->type_name;?>
</option>
											<?php } else { ?>
											<select id="cmb_quiz_type" name="cmb_quiz_type" onchange="changeQuizTypeDropDown(this)">
											<?php if (!empty($_smarty_tpl->tpl_vars['quizType']->value)) {?>
												<?php
$_from = $_smarty_tpl->tpl_vars['quizType']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_0_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$__foreach_value_0_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
													<?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['form']->value->quiz_type) {?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
" selected><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
											  		<?php } else { ?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
											 		 <?php }?>
												<?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_0_saved_local_item;
}
if ($__foreach_value_0_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_0_saved_item;
}
?>
											<?php }?>
									<?php }?>
										</select>
									</td>
								</tr>
								<tr style="height:50px;">
									<td>回答時間<span class="required">※</span></td>
									<td><input type="text" class="text" id="answer_time" name="answer_time" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->answer_time;?>
" maxlength = "2" size="30"> 秒</td>
								</tr>
								 <tr>
								<td>問題 <span class="required">※</span></td>
									<td><textarea name="quiz_content" id="quiz_content" rows="2" class="txtarea"
									cols="40" maxlength = "2000" style="width:800px"><?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_content;?>
</textarea>
									</td>
								</tr>
								<tr height="45px;">
									<td id="tdAudio">ファイル（音声）</td>
									<td style="">
										<div style="display:flex;">
											<input type="text" id="audio_file" name="audio_file" readonly="readonly" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->audio_file;?>
" style="width:200px;height:25px;"/>
											<div style="width:350px;height:22px;margin-left:10px;">
											<input type="file" id="input_audio_file" name="input_audio_file" class="vendor_logo" style="height:30px;padding: 3px 0px;" accept="audio/mp3"/>
											</div>
										</div>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode == 'update') {?>
											<br/>
				 							<input type="checkbox" id="chk_status2" name="chk_status2" value="1"><label for="chk_status2">音声ファイル削除</label>
				 						<?php }?>
				 					</td>
								</tr>
								<tr id="choice_type1">
								 	 <?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode == 'update') {?>
									   <?php if ($_smarty_tpl->tpl_vars['form']->value->quiz_type == '001') {?>
										<td>正解<span class="required">※</span></td>
										<td><input type="text" class="text" id="choice_correct1" name="choice_correct1" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->correct1, ENT_QUOTES, 'UTF-8', true);?>
" size="30" maxlength = "512"></td>
										<?php }?>
									<?php } else { ?>
										<td>正解<span class="required">※</span></td>
										<td><input type="text" class="text" id="choice_correct1" name="choice_correct1" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->correct1, ENT_QUOTES, 'UTF-8', true);?>
" size="30" maxlength = "512"></td>
									<?php }?>
								</tr>
								 <tr id="choice_type2">
								 	<?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode == 'update') {?>
									   <?php if ($_smarty_tpl->tpl_vars['form']->value->quiz_type == '001') {?>
										<td>不正解1<span class="required">※</span></td>
										<td><input type="text" class="text" id="incorrect1" name="incorrect1" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->incorrect1, ENT_QUOTES, 'UTF-8', true);?>
" size="30" maxlength = "512"></td>
										<?php }?>
									<?php } else { ?>
										<td>不正解1<span class="required">※</span></td>
										 <td><input type="text" class="text" id="incorrect1" name="incorrect1" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->incorrect1, ENT_QUOTES, 'UTF-8', true);?>
" size="30" maxlength = "512"></td>
									<?php }?>

								</tr>
								<tr id="choice_type3">
									<?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode == 'update') {?>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->quiz_type == '001') {?>
											<td>不正解2</td>
											<td><input type="text" class="text" id="incorrect2" name="incorrect2" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->incorrect2, ENT_QUOTES, 'UTF-8', true);?>
" size="30" maxlength = "512"></td>
										<?php }?>
									<?php } else { ?>
											<td>不正解2</td>
											<td><input type="text" class="text" id="incorrect2" name="incorrect2" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->incorrect2, ENT_QUOTES, 'UTF-8', true);?>
" size="30" maxlength = "512"></td>
									<?php }?>
								</tr>
								<tr id="choice_type4">
									 <?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode == 'update') {?>
											<?php if ($_smarty_tpl->tpl_vars['form']->value->quiz_type == '001') {?>
											<td>不正解3</td>
											<td><input type="text" class="text" id="incorrect3" name="incorrect3" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->incorrect3, ENT_QUOTES, 'UTF-8', true);?>
" size="30" maxlength = "512"></td>
											<?php }?>
									 <?php } else { ?>
											<td>不正解3</td>
											<td><input type="text" class="text" id="incorrect3" name="incorrect3" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->incorrect3, ENT_QUOTES, 'UTF-8', true);?>
" size="30" maxlength = "512"></td>
									<?php }?>

								</tr>
								 <tr id="blank_type1">
									<?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode == 'update') {?>
											<?php if ($_smarty_tpl->tpl_vars['form']->value->quiz_type == '002') {?>
											<td>正解1<span class="required">※</span></td>
											<td><input type="text" class="text" id="blank_correct1" name="blank_correct1" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->correct1, ENT_QUOTES, 'UTF-8', true);?>
" size="30" maxlength = "512"> </td>
											<?php }?>
									<?php } else { ?>
											<td>正解1<span class="required">※</span></td>
											<td><input type="text" class="text" id="blank_correct1" name="blank_correct1" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->correct1, ENT_QUOTES, 'UTF-8', true);?>
" size="30" maxlength = "512"> </td>
									<?php }?>
								</tr>
								<tr id="blank_type2">
									<?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode == 'update') {?>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->quiz_type == '002') {?>
											<td>正解2</td>
											<td><input type="text" class="text" id="correct2" name="correct2" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->correct2, ENT_QUOTES, 'UTF-8', true);?>
" size="30" maxlength = "512"></td>
										<?php }?>
									<?php } else { ?>
											<td>正解2</td>
											<td><input type="text" class="text" id="correct2" name="correct2" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->correct2, ENT_QUOTES, 'UTF-8', true);?>
" size="30" maxlength = "512"></td>
									<?php }?>

								</tr>
								<tr id="blank_type3">
									<?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode == 'update') {?>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->quiz_type == '002') {?>
											<td>ヒント</td>
											<td><input type="text" class="text" id="hint" name="hint" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->hint, ENT_QUOTES, 'UTF-8', true);?>
" size="30" maxlength = "512"></td>
										<?php }?>
										<?php } else { ?>
											<td>ヒント</td>
											<td><input type="text" class="text" id="hint" name="hint" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->hint, ENT_QUOTES, 'UTF-8', true);?>
" size="30" maxlength = "512"></td>
									<?php }?>
								</tr>
								<tr>
									<td>解説</td>
									<td><textarea name="explanation" id="explanation" rows="3" class="txtarea" maxlength="4096"
										cols="40" style="margin-top:10px;width:800px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->explanation, ENT_QUOTES, 'UTF-8', true);?>
</textarea></td>
								</tr>
								 <tr>
									<td>備考</td>
									<td><input type="text" class="text" id="remarks" name="remarks" maxlength = "255" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->remarks;?>
" size="30" maxlength = "512"></td>
								</tr>
							</table>
							<br/>
							<div style="width:100%;" >
								<?php if ($_smarty_tpl->tpl_vars['form']->value->screen_mode == 'update') {?>
									<input id="btn_del" type="button" name="btn_del" class="btn_delete" onclick="checkDelete('<?php echo $_smarty_tpl->tpl_vars['form']->value->quiz_no;?>
','<?php echo @constant('HOME_DIR');?>
QuizRegist/delete');" style="text-align:left;">
								<?php }?>
								<input type="submit" name="submit_add" id="btn_insert" name="btn_insert" value="" class="btn_insert" style="padding-right:20px;float: right;">
							</div>
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
				function checkDelete(quiz_no,action){

					alertDialog = confirm('Are you sure to delete this quiz?');

					if ( alertDialog == false ) {

						return false;
					}else {

						var menuOpen = document.getElementById('menuOpen').value;
						var menuStatus = document.getElementById('menuStatus').value;

						$("#main_form").attr("action", action);
						$("#quiz_no").val(quiz_no);
						$("#menuOpen").val(menuOpen);
						$("#menuStatus").val(menuStatus);
						$("#main_form").submit();
					}
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
