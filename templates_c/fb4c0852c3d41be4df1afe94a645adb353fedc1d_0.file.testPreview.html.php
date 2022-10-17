<?php
/* Smarty version 3.1.29, created on 2022-07-15 17:22:50
  from "/var/www/html/eccadmin_dev/templates/testPreview.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_62d123da933154_74964395',
  'file_dependency' => 
  array (
    'fb4c0852c3d41be4df1afe94a645adb353fedc1d' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/testPreview.html',
      1 => 1654845384,
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
function content_62d123da933154_74964395 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>テスト確認</title>
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
	
	<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/testlist.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/testpreview.css" rel="stylesheet">

		<?php echo '<script'; ?>
 type="text/javascript">

			var elem;
			var answer_time;
			var answer_start_time;
			var progress_interval = 1000;
			var progress_init = 100;
			var width ;
			var id;
			var result_list = [];

			function move_timer(){
				//プログレスバー初期値設定
				var listkey = $("#current_quiz").val();
				elem =  $("#quiz_"+listkey+" .answerBar");
				elem.css("width", progress_init + '%');
				element = document.getElementById('answer_time_' + listkey);
				if (element != null) {
					answer_time = element.value * 1000;
				}else {
					answer_time = null;
				}

				width = 0;
				answer_start_time = new Date().getTime();
				stopInterval();
				id = setInterval(frame, progress_interval);
				function frame() {
					var current_time = new Date().getTime();
					var time_gap = current_time - answer_start_time;

					width = progress_init - parseInt(time_gap * 100 / answer_time ) ;

					if (width > 0){
						elem.css("width", width + '%');
					    //document.getElementById("answerLabel").innerHTML = width * 1 + '%';
					}else{
						stopInterval();
						stopAnswer();
						audioStop();
					}
				}

			}
			function stopInterval(){

					clearInterval(id);
			}
			function stopAnswer(){
				elem.css("width", 0 + '%');
				process_quiz();
				$( "input:radio" ).prop( "disabled", true );
				$( "input:text" ).prop( "disabled", true );

			}
			function process_quiz(){

				var listkey = $("#current_quiz").val();
				var type = $("#quiz_type_"+listkey).val();

				var corr1 = "#cor_ans_"+listkey+"_1";
				var corr2 = "#cor_ans_"+listkey+"_2";

				if( type == 1){
					$( "input:radio" ).prop( "disabled", true );

					$("input:radio[name='ans_"+listkey+"']").each(function( index ) {
						if ($(this).val() == $(corr1).val()){
							var idx = index+1;
							$("#ans_img_"+listkey+"_"+idx).prop("src","<?php echo @constant('HOME_DIR');?>
image/quiz_answer_right.png").show();
						}else{
							var idx = index+1;
							$("#ans_img_"+listkey+"_"+idx).prop("src","<?php echo @constant('HOME_DIR');?>
/image/quiz_answer_wrong.png").show();
						}
					});
					// check

					if($('input[name=ans_'+listkey+']:checked').val() != ""){

						var answer = $('input[name=ans_'+listkey+']:checked').val();
						if (answer == $(corr1).val() || answer == $(corr2).val()){
							result_list[listkey] = 1;
						}else{
							 result_list[listkey] = 0;
						}
					}else{
						result_list[listkey] = 0;
					}

				}else{

					$( "input:text" ).prop( "disabled", true );
					var ans1 = false;
					var ans2 = false;
					var ans_id1 ="#ans_img_"+listkey+"_1";
					var ans_id2 ="#ans_img_"+listkey+"_2";

					var ans_1 ="#ans_"+listkey+"_1";
					var ans_2 ="#ans_"+listkey+"_2";

					if ( $( ans_1).length  &&  $( ans_2 ).length ) {
						if ($(ans_1).val() == $(corr1).val() && $(ans_2).val() == $(corr2).val()){
							result_list[listkey] = 1;
						}else{
					 	 	 result_list[listkey] = 0;
					    }
					}else if ( $( ans_1).length ){
						if ($(ans_1).val() == $(corr1).val()){
							result_list[listkey] = 1;
						}else{
					 	 	 result_list[listkey] = 0;
					    }
					}else if ( $( ans_2).length ){
						if ($(ans_2).val() == $(corr2).val()){
							result_list[listkey] = 1;
						}else{
							result_list[listkey] = 0;
						}
					}

					$(ans_id1).html($(corr1).val());
					$(ans_id2).html($(corr2).val());
				}

				var check_btn ="#check_"+listkey ;
				var next_btn ="#next_"+listkey ;
				var total = $("#total_quiz").val();

				if(listkey == parseInt(total)-1){

					$(".next_quiz").text('結果画面へ');
				}

				$(check_btn).hide();
				$(next_btn).show();
			}

			$(document).ready(function(){
				// MSGのあるなし
				if ( $(".error_msg").html() != "" ) {

					$(".error_section").slideToggle('slow')
				}

				$(".close_icon").on('click',function(){

					$(".error_section").slideToggle('slow')

				});

				$(".hintans").hide();

				$(".next_quiz").click(function(){

					$( "input:radio" ).prop( "disabled", false );
					$( "input:text" ).prop( "disabled", false );
					$(".hintans").hide();

					var current_id = this.id;
					var current_index = $("#"+current_id).data("currentid");
					var current_quiz = "quiz_"+current_index;
					var next_index = parseInt(current_index)+1;
					var next_quiz = "quiz_"+ next_index;
					var total = $("#total_quiz").val();

					if(parseInt(current_index) < parseInt(total)-1){
						$("#"+current_quiz).hide();
						$("#"+next_quiz).show();
					}else{
						$("#testlist").show();
						$("#divAnswer").hide();
						stopAnswer();
						$("#"+current_quiz).hide();
						$("#tbl_finalresult").show();

						for(var i = 0; i< total ; i++){
							var td_idx = "#final_result_"+i;
							var img = "";
							if(result_list[i] == 0){
								$("#correct_file_"+current_index).hide();
								$("#wrong_file_"+current_index).show();
								img += "<img src='"+<?php echo @constant('HOME_DIR');?>
+"image/quiz_answer_wrong.png' width='25px' height='25px'/>";
							}else{
								img += "<img src='"+<?php echo @constant('HOME_DIR');?>
+"image/quiz_answer_right.png' width='25px' height='25px'/>";
							}

							$(td_idx).html(img);
						}
					}
					var nxt_quiz = parseInt($("#current_quiz").val())+1;
					$("#current_quiz").val(nxt_quiz);
					move_timer();

				});

			$(".hintanswer").click(function(){

				$(".hintans").show();

			});
			$(".giveup").click(function(){
				stopInterval();
				audioStop();
				var id = this.id;
				var listkey = $("#"+id).data("listkey");
				var type = $("#"+id).data("type");

				var ans_id1 ="#ans_img_"+listkey+"_1";
				var ans_id2 ="#ans_img_"+listkey+"_2";

				var corr1 = "#cor_ans_"+listkey+"_1";
				var corr2 = "#cor_ans_"+listkey+"_2";

				$(ans_id1).html($(corr1).val());
				$(ans_id2).html($(corr2).val());

				result_list[listkey] = 0;

				var check_btn ="#check_"+listkey ;
				var next_btn ="#next_"+listkey ;
				$(check_btn).hide();

				var total = $("#total_quiz").val();

				if(listkey == parseInt(total)-1){

					$(".next_quiz").text('結果画面へ');
				}
				$(next_btn).show();

			});
			$(".check_quiz").click(function(){

				stopInterval();

				process_quiz();

				audioStop();
			});
			 $("audio").each(function(){
				$(this).attr('controlsList','nodownload');
				//$(this).load();
			});

			move_timer();

		});
		//for audio
		function audioStop(){
			$("audio").each(function(){
			    $(this).trigger('pause');
			});
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
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
TestPreview/index" method="post">
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<div class="divHeader">
				<!--header-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--header-->
			</div>
			<div class="divBody">
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
					<section class="content">
						<p>
							><span class="title">テスト / テストプレビュー</span>
						</p>
						<!-- 戻るボタンの事 -->
						<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
						<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
"/>
						<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
"/>
						<input type="hidden" id="search_test_name" name="search_test_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_test_name, ENT_QUOTES, 'UTF-8', true);?>
"/>
						<input type="hidden" id="search_remark" name="search_remark" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_remark, ENT_QUOTES, 'UTF-8', true);?>
"/>
						<input type="hidden" id="search_rd_status1" name="search_rd_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rd_status1;?>
"/>
						<input type="hidden" id="search_rd_status2" name="search_rd_status2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rd_status2;?>
"/>
						<input type="hidden" id="search_rdstatus" name="search_rdstatus" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_rdstatus;?>
"/>
						<input type="hidden" id="search_chk_status1" name="search_chk_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status1;?>
"/>
						<input type="hidden" id="search_chk_status2" name="search_chk_status2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status2;?>
"/>
						<input type="hidden" id="search_status" name="search_status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_status;?>
"/>
						<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
"/>

						<input type="hidden" id="search_page_row" name="search_page_row" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_row;?>
" />
						<input type="hidden" id="search_page_order_column" name="search_page_order_column" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_column;?>
" />
						<input type="hidden" id="search_page_order_dir" name="search_page_order_dir" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page_order_dir;?>
" />
					<div id="divQuiz" align="left">

						 <?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
							<input type="hidden" id="total_quiz" value="<?php echo count($_smarty_tpl->tpl_vars['list']->value);?>
" />

								<?php
$_from = $_smarty_tpl->tpl_vars['list']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_result_0_saved_item = isset($_smarty_tpl->tpl_vars['result']) ? $_smarty_tpl->tpl_vars['result'] : false;
$__foreach_result_0_saved_key = isset($_smarty_tpl->tpl_vars['key']) ? $_smarty_tpl->tpl_vars['key'] : false;
$_smarty_tpl->tpl_vars['result'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['result']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['result']->value) {
$_smarty_tpl->tpl_vars['result']->_loop = true;
$__foreach_result_0_saved_local_item = $_smarty_tpl->tpl_vars['result'];
?>
								<input id="cor_ans_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_1" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['result']->value->correct1;?>
">
								<input id="cor_ans_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_2" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['result']->value->correct2;?>
">
								<input id="quiz_type_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['result']->value->quiz_type;?>
">
								<input type="hidden" id="answer_time_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['result']->value->answer_time;?>
">

							<table <?php if ($_smarty_tpl->tpl_vars['key']->value != 0) {?>style="display: none;" <?php } else { ?> style="width: 100%;" <?php }?>>
								<tbody>
									<tr>
										<td class="testName"><?php echo $_smarty_tpl->tpl_vars['result']->value->test_name;?>

											<input type="button" id="testlist" class="testList" value="" title="テスト一覧画面へ" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
TestPreview/back')">
										</td>
									</tr>
									<tr>
										<td class="quizDescription"><?php echo $_smarty_tpl->tpl_vars['result']->value->description;?>
</td>
									</tr>
								</tbody>
							</table>
							<table  id="tbl_finalresult" class="tbl_search" cellpadding="10" style="display: none;" >
								<tr>
									<th class="resultQuizNo">No</th>
									<th class="resultQuestion">Question</th>
									<th class="resultAnswer">Result</th>
								</tr>
								<tbody>
									<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
									<?php
$_from = $_smarty_tpl->tpl_vars['list']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_result_1_saved_item = isset($_smarty_tpl->tpl_vars['result']) ? $_smarty_tpl->tpl_vars['result'] : false;
$__foreach_result_1_saved_key = isset($_smarty_tpl->tpl_vars['key']) ? $_smarty_tpl->tpl_vars['key'] : false;
$_smarty_tpl->tpl_vars['result'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['result']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['result']->value) {
$_smarty_tpl->tpl_vars['result']->_loop = true;
$__foreach_result_1_saved_local_item = $_smarty_tpl->tpl_vars['result'];
?>
									<tr>
										<td class="resultQuizNo"><?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
</td>
										<td class="resultQuestion"><span style="font-size: 18px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->quiz_content;?>
</span><br></br>
										<span class="cor"><?php echo $_smarty_tpl->tpl_vars['result']->value->correct1;?>
</span>
										<?php if (!empty($_smarty_tpl->tpl_vars['result']->value->correct2)) {?>
											<span class="cor">,<?php echo $_smarty_tpl->tpl_vars['result']->value->correct2;?>
</span>
										<?php }?>
										<!-- 20190709-クイズ・解説追加 -->
										<br>
										<?php if (!empty($_smarty_tpl->tpl_vars['result']->value->explanation)) {?>
											<?php echo $_smarty_tpl->tpl_vars['result']->value->explanation;?>

										<?php }?>
										<!-- <br></br> -->
										<?php if (!empty($_smarty_tpl->tpl_vars['result']->value->image_name)) {?>
										<?php $_smarty_tpl->tpl_vars["specialmsg"] = new Smarty_Variable(((string)$_smarty_tpl->tpl_vars['folder_check']->value)."/".((string)$_smarty_tpl->tpl_vars['image_file']->value)."/".((string)$_smarty_tpl->tpl_vars['result']->value->image_name), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "specialmsg", 0);?>
										<?php ob_start();
echo $_smarty_tpl->tpl_vars['specialmsg']->value;
$_tmp1=ob_get_clean();
if (file_exists($_tmp1)) {?>
										<span>
											<img id="image" type="image"
											src="<?php echo @constant('HOME_DIR');?>
/<?php echo $_smarty_tpl->tpl_vars['image_file']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['result']->value->image_name;?>
">
										</span>
										<?php }?>
										<?php }?>
										<br></br>
										<?php if (!empty($_smarty_tpl->tpl_vars['result']->value->audio_name)) {?>
										<?php $_smarty_tpl->tpl_vars["audiomsg"] = new Smarty_Variable(((string)$_smarty_tpl->tpl_vars['folder_check']->value)."/".((string)$_smarty_tpl->tpl_vars['audio_file']->value)."/".((string)$_smarty_tpl->tpl_vars['result']->value->audio_name), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "audiomsg", 0);?>
										<?php ob_start();
echo $_smarty_tpl->tpl_vars['audiomsg']->value;
$_tmp2=ob_get_clean();
if (file_exists($_tmp2)) {?>
										<span>
											<audio controls class="quiz_audio">
												<source src="<?php echo @constant('ADMIN_HOME_DIR');?>
/<?php echo $_smarty_tpl->tpl_vars['audio_file']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['result']->value->audio_name;?>
" type="audio/ogg">
											</audio>
										</span>
										<?php }?>
										<?php }?>
										</td>
										<td id="final_result_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" class="resultAnswer"></td>
									</tr>
									<?php
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_1_saved_local_item;
}
if ($__foreach_result_1_saved_item) {
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_1_saved_item;
}
if ($__foreach_result_1_saved_key) {
$_smarty_tpl->tpl_vars['key'] = $__foreach_result_1_saved_key;
}
?>
									<?php }?>
								</tbody>
							</table>

							<table id="quiz_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['key']->value != 0) {?>style="display: none;"<?php }?> cellspacing="20px;">
							    <tbody>
								<tr>
									<td class ="quizNo"><?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
/<?php echo count($_smarty_tpl->tpl_vars['list']->value);?>

									.<span class="quizContent" "><?php echo $_smarty_tpl->tpl_vars['result']->value->quiz_content;?>
</span></td>
								</tr>
								<?php if ($_smarty_tpl->tpl_vars['result']->value->quiz_type == 2) {?>
								<tr>
									<td>
										<label class="hintans"><?php echo $_smarty_tpl->tpl_vars['result']->value->hint;?>
</label>
									</td>
								</tr>
								<?php }?>
								<?php if (!empty($_smarty_tpl->tpl_vars['result']->value->image_name)) {?>
								<?php $_smarty_tpl->tpl_vars["specialmsg"] = new Smarty_Variable(((string)$_smarty_tpl->tpl_vars['folder_check']->value)."/".((string)$_smarty_tpl->tpl_vars['image_file']->value)."/".((string)$_smarty_tpl->tpl_vars['result']->value->image_name), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "specialmsg", 0);?>
								<?php ob_start();
echo $_smarty_tpl->tpl_vars['specialmsg']->value;
$_tmp3=ob_get_clean();
if (file_exists($_tmp3)) {?>
								<tr>
									<td>
										<img id="image" type="image"
											src="<?php echo @constant('ADMIN_HOME_DIR');?>
/<?php echo $_smarty_tpl->tpl_vars['image_file']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['result']->value->image_name;?>
">
									</td>
								</tr>
								<?php } else { ?>
								<tr>
									<td>
										<label>画像ファイルを見つかりません</label>
									</td>
								</tr>
								<?php }?>
								<?php }?>
								<?php if (!empty($_smarty_tpl->tpl_vars['result']->value->audio_name)) {?>
								<?php $_smarty_tpl->tpl_vars["audiomsg"] = new Smarty_Variable(((string)$_smarty_tpl->tpl_vars['folder_check']->value)."/".((string)$_smarty_tpl->tpl_vars['audio_file']->value)."/".((string)$_smarty_tpl->tpl_vars['result']->value->audio_name), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "audiomsg", 0);?>
								<?php ob_start();
echo $_smarty_tpl->tpl_vars['audiomsg']->value;
$_tmp4=ob_get_clean();
if (file_exists($_tmp4)) {?>
								<tr>
									<td>
										<audio controls class="quiz_audio">
											<source src="<?php echo @constant('ADMIN_HOME_DIR');?>
/<?php echo $_smarty_tpl->tpl_vars['audio_file']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['result']->value->audio_name;?>
" type="audio/ogg" >
										</audio>
									</td>
								</tr>
								<?php } else { ?>
								<tr>
									<td>
										<label>音声ファイルを見つかりません</label>
									</td>
								</tr>
								<?php }?>
								<?php }?>
								<tr>
									<td>
										<div class="divProgress" >
											<div class="divAnswer">
												<label class="lblAnswerTime">AnswerTime:<?php echo $_smarty_tpl->tpl_vars['result']->value->answer_time;?>
秒</label>
												<div>
													<div class="answerProgress">
							 							<div class="answerBar"><div class="answerLabel"></div></div>
													</div>
												</div>
											</div>
										 </div>
									</td>
								</tr>
								<?php if ($_smarty_tpl->tpl_vars['result']->value->quiz_type == 1) {?>
									<?php
$_from = $_smarty_tpl->tpl_vars['quiz_answer']->value[$_smarty_tpl->tpl_vars['key']->value];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_q_2_saved_item = isset($_smarty_tpl->tpl_vars['q']) ? $_smarty_tpl->tpl_vars['q'] : false;
$__foreach_q_2_saved_key = isset($_smarty_tpl->tpl_vars['k']) ? $_smarty_tpl->tpl_vars['k'] : false;
$_smarty_tpl->tpl_vars['q'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['q']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['q']->value) {
$_smarty_tpl->tpl_vars['q']->_loop = true;
$__foreach_q_2_saved_local_item = $_smarty_tpl->tpl_vars['q'];
?>
									<tr>
										<td>
											<table id="tblanswer_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['k']->value+1;?>
">
												<tr>
													<td width="500px">
														<label ><input type="radio" name="ans_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['q']->value;?>
"> <?php echo $_smarty_tpl->tpl_vars['q']->value;?>
</label>
													</td>
													<td><img class="radioImg" src="" id="ans_img_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['k']->value+1;?>
" /></td>
												</tr>
											</table>
										</td>
									</tr>
									<?php
$_smarty_tpl->tpl_vars['q'] = $__foreach_q_2_saved_local_item;
}
if ($__foreach_q_2_saved_item) {
$_smarty_tpl->tpl_vars['q'] = $__foreach_q_2_saved_item;
}
if ($__foreach_q_2_saved_key) {
$_smarty_tpl->tpl_vars['k'] = $__foreach_q_2_saved_key;
}
?>
								<?php } else { ?>
									<tr>
										<td>
											<table id="tblanswer_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
												<tr>
													<td><button type="button" id="giveup_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" data-listkey="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" data-type="<?php echo $_smarty_tpl->tpl_vars['result']->value->quiz_type;?>
" class="giveup">ギブアップ</button></td>
													<td><button type="button"  class="hintanswer">ヒント</button></td>
												</tr>
												<tr>
													<td><input type="text" class="answertext" id="ans_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_1"  value="" size="30" maxlength="512" autocomplete="off" autofocus>	</td>
													<td id="ans_img_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_1" style="color: red;"></td>
												</tr>
												<?php if (!empty($_smarty_tpl->tpl_vars['result']->value->correct2)) {?>
												<tr>
													<td><input type="text" class="answertext" id="ans_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_2"  value="" size="30" maxlength="512" autocomplete="off" autofocus></td>
													<td id="ans_img_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
_2"  style="color: red;"></td>
												</tr>
												<?php }?>
											</table>
										</td>
									</tr>
								<?php }?>
								<tr>
									<td >
										<button type="button" id="next_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" data-currentid=<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 class="next_quiz">Quiz No <?php echo $_smarty_tpl->tpl_vars['key']->value+2;?>
へ</button>
										<button type="button" id="check_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" data-currentid=<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 class="check_quiz">チェック</button>
									</td>
								</tr>
							</tbody>
							</table>
							<?php
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_0_saved_local_item;
}
if ($__foreach_result_0_saved_item) {
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_0_saved_item;
}
if ($__foreach_result_0_saved_key) {
$_smarty_tpl->tpl_vars['key'] = $__foreach_result_0_saved_key;
}
?>
							<input id="current_quiz" type="hidden" value="0">
						<?php }?>
					</div>
					</section>
			</div>
			<!--footer-->
				<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!--footer-->
		</form>
	</body>
</html><?php }
}
