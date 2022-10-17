<?php
/* Smarty version 3.1.29, created on 2022-05-09 11:35:30
  from "/var/www/html/eccadmin_dev/templates/swCourseDetailRef.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_62787df2465154_18478642',
  'file_dependency' => 
  array (
    '42e671086317f97a15646ddeff8d8ff8f4a4801b' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/swCourseDetailRef.html',
      1 => 1652063194,
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
function content_62787df2465154_18478642 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>SW Practice　コース詳細参照</title>
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
		
		<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet" >
		<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/style.css" rel="stylesheet">
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
CourseContractRegist/save" method="post">
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<div class="divHeader">
				<!--header-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--header-->
			</div>
			<div class="divBody">
				<input type="hidden" id="search_test_kbn" name="search_test_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_test_kbn;?>
" />
				<input type="hidden" id="search_course_level" name="search_course_level" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_course_level;?>
" />
				<input type="hidden" id="search_name" name="search_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_name;?>
" />
				<input type="hidden" id="search_remarks" name="search_remarks" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_remarks;?>
" />
				<!-- <input type="text" id="search_status" name="search_status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_status;?>
" /> -->
				<input type="hidden" id="status" name="status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->status;?>
" />
				<input type="hidden" id="btn_flg" name="btn_flg" value="1" />
				<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
" />
				<input type="hidden" id="back_flg" name="back_flg" value="false" />
				<div id="err_dis">
					<section class="error_section">
						<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" style="width:15px;float:right" class="close_icon">
						<?php if (!empty($_smarty_tpl->tpl_vars['error_msg']->value)) {?>
							<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['error_msg']->value;?>
</div>
						<?php } else { ?>
							<div class="error_msg"></div>
						<?php }?>
					</section>
				</div>
				<section class="content">
					<p>><span class="title">SW Practice　コース詳細参照</span></p>
					<p style="text-align:right"><input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
SWPracticeReferenceList/search')"></p>
					<?php if (!empty($_smarty_tpl->tpl_vars['course_detail']->value)) {?>
					<table>
						<tr>
							<td width="200px;">コースID </td>
							<td width="400px;">： <?php echo $_smarty_tpl->tpl_vars['course_detail']->value->course_id;?>
</td>
							<td width="200px;">SW </td>
							<td width="400px;">： <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['course_detail']->value->test_kbn_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
							<td width="200px;">レベル </td>
							<td width="400px;">： <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['course_detail']->value->course_level, ENT_QUOTES, 'UTF-8', true);?>
</td>
						</tr>
						<tr>
							<td width="200px;">コース名 </td>
							<td width="400px;">： <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['course_detail']->value->course_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
							<td width="200px;">コース詳細名 </td>
							<td width="400px;">： <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['course_detail']->value->course_detail_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
							<td width="200px;">コース備考 </td>
							<td width="400px;">： <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['course_detail']->value->remarks, ENT_QUOTES, 'UTF-8', true);?>
</td>
						</tr>
						<tr>
							<td width="200px;">コース名英字 </td>
							<td width="400px;">： <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['course_detail']->value->course_name_romaji, ENT_QUOTES, 'UTF-8', true);?>
</td>
							<td width="200px;">コース詳細名英字 </td>
							<td width="400px;">： <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['course_detail']->value->course_detail_romaji, ENT_QUOTES, 'UTF-8', true);?>
</td>
						</tr>
					</table>
					<?php }?>
					<?php if (!empty($_smarty_tpl->tpl_vars['question_data']->value)) {?>
						<div class="course_dt_question">
							<?php
$_from = $_smarty_tpl->tpl_vars['question_data']->value;
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
								<div class="course_dt_qrow">
									<div class="course_dt_q_title">
										<div style="width:150px;font-weight:bold;">No.<?php echo $_smarty_tpl->tpl_vars['result']->value->disp_no;?>
</div>
										<div style="width:150px;" title="問題名"><?php echo $_smarty_tpl->tpl_vars['result']->value->question_name;?>
</div>
										<div style="width:150px;">
											<img src="<?php echo @constant('HOME_DIR');?>
image/prepare_time.png"  title="準備時間" class="prepare_time" title="Prepare Time" style="width:20px;cursor:pointer;" class="clock_icon">
											<?php echo $_smarty_tpl->tpl_vars['result']->value->prepare_time;?>

										</div>
										<div>
											<img src="<?php echo @constant('HOME_DIR');?>
image/clock.png"  title="回答時間" class="answer_time" style="width:20px;cursor:pointer;" class="clock_icon">
											<?php echo $_smarty_tpl->tpl_vars['result']->value->answer_time;?>

										</div>
									</div><br/>
									<table class="question_tbl">
										<tr>
											<td style="width:150px;font-weight:bold;">問題パターン</td>
											<td width="150px;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->q_pattern, ENT_QUOTES, 'UTF-8', true);?>
</td>
											<td style="width:150px;font-weight:bold;">採点パターン</td>
											<td width="150px;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->sc_pattern, ENT_QUOTES, 'UTF-8', true);?>
</td>
										</tr>
									</table>
									<br>
									<?php if (!empty($_smarty_tpl->tpl_vars['result']->value->question_description)) {?>
										<div class="course_dt_q_desc" style="font-weight:bold;">問題説明</div><br/>
										<div class="course_dt_q_desc"><?php echo $_smarty_tpl->tpl_vars['result']->value->question_description;?>
</div><br/>
									<?php }?>
									<?php if (!empty($_smarty_tpl->tpl_vars['result']->value->description)) {?>
										<div class="course_dt_q_desc" style="font-weight:bold;">内容</div><br/>
										<div class="course_dt_q_desc"><?php echo $_smarty_tpl->tpl_vars['result']->value->description;?>
</div><br/>
									<?php }?>
									<?php if (!empty($_smarty_tpl->tpl_vars['result']->value->audio_name)) {?>

										<div class="course_dt_q_desc" style="font-weight:bold;">音声内容</div><br/>
										<?php ob_start();
echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->audio_name, ENT_QUOTES, 'UTF-8', true);
$_tmp1=ob_get_clean();
$_smarty_tpl->tpl_vars["audio_file"] = new Smarty_Variable(((string)$_smarty_tpl->tpl_vars['audio_folder']->value)."qa_".((string)$_smarty_tpl->tpl_vars['result']->value->question_no)."/".$_tmp1, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "audio_file", 0);?>

										<?php if (file_exists($_smarty_tpl->tpl_vars['audio_file']->value) && substr($_smarty_tpl->tpl_vars['audio_file']->value,-4) == '.mp3') {?>
											<div class="course_dt_q_audio">
												<audio id="myAudio" controlslist="nodownload" controls>
												  <source src="<?php echo @constant('STUDENT_HOME_DIR');?>
files/audio/qa_<?php echo $_smarty_tpl->tpl_vars['result']->value->question_no;?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->audio_name, ENT_QUOTES, 'UTF-8', true);?>
" type="audio/mpeg">
												</audio>
											</div>
										<?php } elseif (substr($_smarty_tpl->tpl_vars['result']->value->audio_name,-4) == '.mp4') {?>
											<div style="height:300px;align:center">
												<video id = "q_video" controls="controls" preload="none" style="height:300px;" controlslist="nodownload nofullscreen noplaybackrate" autoplay disablePictureInPicture>
													 <source src="<?php echo @constant('STUDENT_HOME_DIR');?>
files/audio/qa_<?php echo $_smarty_tpl->tpl_vars['result']->value->question_no;?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->audio_name, ENT_QUOTES, 'UTF-8', true);?>
" type="audio/mpeg">
												</video>
											</div>
											<br/>
										<?php } elseif (substr($_smarty_tpl->tpl_vars['audio_file']->value,-4) != '.mp3') {?>
											<div class="course_dt_q_desc"><?php echo $_smarty_tpl->tpl_vars['result']->value->audio_description;?>
</div><br/>
									
										<?php } else { ?>
											<!-- 回答音声ファイルがないの場合 -->
											<div class="div_noAudio" >
												<p class="no_audio">音声内容フィルを見つかりません。</p>
											</div>
										<?php }?>
									<?php }?>
									<?php if (!empty($_smarty_tpl->tpl_vars['result']->value->audio_yes)) {?>

										<div class="course_dt_q_desc" style="font-weight:bold;">yes音声内容</div><br/>
										<?php ob_start();
echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->audio_yes, ENT_QUOTES, 'UTF-8', true);
$_tmp2=ob_get_clean();
$_smarty_tpl->tpl_vars["audio_yes"] = new Smarty_Variable(((string)$_smarty_tpl->tpl_vars['audio_folder']->value)."qa_".((string)$_smarty_tpl->tpl_vars['result']->value->question_no)."/".$_tmp2, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "audio_yes", 0);?>
										<?php if (file_exists($_smarty_tpl->tpl_vars['audio_yes']->value) && substr($_smarty_tpl->tpl_vars['audio_yes']->value,-4) == '.mp3') {?>
											<div class="course_dt_q_audio">
												<audio id="myAudio" controlslist="nodownload" controls>
												  <source src="<?php echo @constant('STUDENT_HOME_DIR');?>
files/audio/qa_<?php echo $_smarty_tpl->tpl_vars['result']->value->question_no;?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->audio_yes, ENT_QUOTES, 'UTF-8', true);?>
" type="audio/mpeg">
												</audio>
											</div>
										<?php } elseif (substr($_smarty_tpl->tpl_vars['audio_yes']->value,-4) != '.mp3') {?>
											<div class="course_dt_q_desc"><?php echo $_smarty_tpl->tpl_vars['result']->value->yes_description;?>
</div><br/>
										<?php } else { ?>
											<!-- 回答音声ファイルがないの場合 -->
											<div class="div_noAudio" >
												<p class="no_audio">yes音声内容フィルを見つかりません。</p>
											</div>
										<?php }?>
									<?php }?>
									<?php if (!empty($_smarty_tpl->tpl_vars['result']->value->audio_no)) {?>

										<div class="course_dt_q_desc" style="font-weight:bold;">no音声内容</div><br/>
										<?php ob_start();
echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->audio_no, ENT_QUOTES, 'UTF-8', true);
$_tmp3=ob_get_clean();
$_smarty_tpl->tpl_vars["audio_no"] = new Smarty_Variable(((string)$_smarty_tpl->tpl_vars['audio_folder']->value)."qa_".((string)$_smarty_tpl->tpl_vars['result']->value->question_no)."/".$_tmp3, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "audio_no", 0);?>

										<?php if (file_exists($_smarty_tpl->tpl_vars['audio_no']->value) && substr($_smarty_tpl->tpl_vars['audio_no']->value,-4) == '.mp3') {?>
											<div class="course_dt_q_audio">
												<audio id="myAudio" controlslist="nodownload" controls>
												  <source src="<?php echo @constant('STUDENT_HOME_DIR');?>
files/audio/qa_<?php echo $_smarty_tpl->tpl_vars['result']->value->question_no;?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->audio_no, ENT_QUOTES, 'UTF-8', true);?>
" type="audio/mpeg">
												</audio>
											</div>
										<?php } elseif (substr($_smarty_tpl->tpl_vars['audio_no']->value,-4) != '.mp3') {?>
											<div class="course_dt_q_desc"><?php echo $_smarty_tpl->tpl_vars['result']->value->no_description;?>
</div><br/>
										<?php } else { ?>
											<!-- 回答音声ファイルがないの場合 -->
											<div class="div_noAudio" >
												<p class="no_audio">no音声内容フィルを見つかりません。</p>
											</div>
										<?php }?>
									<?php }?>
									<?php if (!empty($_smarty_tpl->tpl_vars['result']->value->sample_answer)) {?>
										<div class="course_dt_q_desc" style="font-weight:bold;">模範解答</div><br/>
										<?php ob_start();
echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->sample_answer, ENT_QUOTES, 'UTF-8', true);
$_tmp4=ob_get_clean();
$_smarty_tpl->tpl_vars["sample_file"] = new Smarty_Variable(((string)$_smarty_tpl->tpl_vars['audio_folder']->value)."qa_".((string)$_smarty_tpl->tpl_vars['result']->value->question_no)."/".$_tmp4, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "sample_file", 0);?>

										<?php if (file_exists($_smarty_tpl->tpl_vars['sample_file']->value) && substr($_smarty_tpl->tpl_vars['sample_file']->value,-4) == '.mp3') {?>
												<div class="course_dt_q_audio">
													<audio id="myAudio" controlslist="nodownload" controls>
													  <source src="<?php echo @constant('STUDENT_HOME_DIR');?>
files/audio/qa_<?php echo $_smarty_tpl->tpl_vars['result']->value->question_no;?>
/<?php echo $_smarty_tpl->tpl_vars['result']->value->sample_answer;?>
" type="audio/mpeg">
													</audio>
											</div>
										<?php } elseif (substr($_smarty_tpl->tpl_vars['sample_file']->value,-4) != '.mp3') {?>
											<div class="course_dt_q_desc"><?php echo $_smarty_tpl->tpl_vars['result']->value->sample_answer;?>
</div><br/>
										<?php } else { ?>
											<!-- 回答音声ファイルがないの場合 -->
											<div class="div_noAudio" >
												<p class="no_audio">模範解答音声フィルを見つかりません。</p>
											</div>
										<?php }?>
									<?php }?>
									<?php if (!empty($_smarty_tpl->tpl_vars['result']->value->byosha_point)) {?>
										<div class="course_dt_q_desc" style="font-weight:bold;">描写ポイント</div><br/>
										<div class="course_dt_q_desc"><?php echo $_smarty_tpl->tpl_vars['result']->value->byosha_point;?>
</div>
									<?php }?>
								</div>
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
						</div>
					<?php }?>
				</section>
			</div>
			<!--footer-->
				<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!--footer-->
		</form>
		<?php echo '<script'; ?>
 type="text/javascript">
			

			if ( $(".error_msg").html() != "" ) {

				$(".error_section").slideToggle('slow');
			}

			$(".close_icon").on('click',function(){

				$(".error_section").slideToggle('slow');

				$('#err_dis').slideToggle('slow');

			});
			function doBack(action){

				$("#main_form").attr("action", action);
				$("#back_flg").val("true");
				$("#main_form").submit();
			}
			
		<?php echo '</script'; ?>
>
	</body>
</html><?php }
}
