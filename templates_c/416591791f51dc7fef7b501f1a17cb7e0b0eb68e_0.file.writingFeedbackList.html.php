<?php
/* Smarty version 3.1.29, created on 2022-06-08 16:59:28
  from "/var/www/html/eccadmin_dev/templates/writingFeedbackList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_62a056e0f0a661_56274578',
  'file_dependency' => 
  array (
    '416591791f51dc7fef7b501f1a17cb7e0b0eb68e' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/writingFeedbackList.html',
      1 => 1595210857,
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
function content_62a056e0f0a661_56274578 ($_smarty_tpl) {
?>
<html>
<head>
<title>受講結果確認</title>
<meta charset="UTF-8">
	
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
js/loader.js"><?php echo '</script'; ?>
>
	
	<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
css/style.css" rel="stylesheet">
	<?php echo '<script'; ?>
 type="text/javascript">
	<?php echo '</script'; ?>
>
</head>

<body class="pushmenu-push">
	<form id="main_form" action="" method="post">

		<div class="divLeftMenu">
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		</div>
		<div class="divHeader" style="display: none;">
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		</div>
		<div class="divBody" style="top:0px;">
			<div class="main">
				<div id="err_dis">
					<section class="error_section">
						<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" class="err_img" class="close_icon">
							<?php if (!empty($_smarty_tpl->tpl_vars['err_msg']->value)) {?>
								<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['err_msg']->value;?>
</div>
							<?php } else { ?>
								<div class="error_msg"></div>
							<?php }?>
					</section>
				</div>
				<section class="content" style="display: none;">
					<p>
						<span class="title" style="margin-top:30px;">受講結果確認（FB）</span>
					<p>
					<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
					<input type="hidden" id="course_detail_no" name="course_detail_no" />
					<input type="hidden" id="course_id" name="course_id"  />
					<input type="hidden" id="offer_no" name="offer_no" />
					<input type="hidden" id="org_no" name="org_no" />
					<input type="hidden" id="student_no" name="student_no" />
					<input type="hidden" id="cdno" name="cdno" value="<?php echo $_smarty_tpl->tpl_vars['course_detail_no']->value;?>
" />
					<input type="hidden" id="cid" name="cid"  value="<?php echo $_smarty_tpl->tpl_vars['course_id']->value;?>
" />
					<input type="hidden" id="ofno" name="ofno" value="<?php echo $_smarty_tpl->tpl_vars['offer_no']->value;?>
" />
					<input type="hidden" id="stuno" name="stuno" value="<?php echo $_smarty_tpl->tpl_vars['student_no']->value;?>
" />
					<input type="hidden" id="cnt" value="<?php echo $_smarty_tpl->tpl_vars['cnt']->value;?>
" />
					<input type="hidden" id="back_flg" name="back_flg" value="false" />
					<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
					<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
"/>
					<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
"/>
					<input type="hidden" id="search_detail_name" name="search_detail_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_detail_name, ENT_QUOTES, 'UTF-8', true);?>
"/>
					<input type="hidden" id="search_student_name" name="search_student_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_student_name, ENT_QUOTES, 'UTF-8', true);?>
"/>
					<input type="hidden" id="search_login_id" name="search_login_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_login_id;?>
" />
					<input type="hidden" id="search_chk_status" name="search_chk_status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status;?>
" />
					<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
" />
					<div align="right" style="width:auto; float: right;">
						<input type="button" id="back" title="戻る" value="" class="btn_back" style="display: none;" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
SpeakingFeedbackList/back')">
					</div>

					<div style=" width: 100%; display: block; overflow-y: auto; margin:auto;">
						<?php if (!empty($_smarty_tpl->tpl_vars['courseData']->value)) {?>

						<div class="comment_pattern_1" style="margin: auto;">
							<div align="left" style="margin: 10px;border-style: none; margin-bottom: 20px;">
								<label id="login_id" style="width: 100%;">組織名　　　: <?php echo $_smarty_tpl->tpl_vars['form']->value->org_name;?>
</label>
								<br> <label style="width: 100%;">ログインID　: <?php echo $_smarty_tpl->tpl_vars['form']->value->stu_login_in;?>
</label>
								<br> <label style="width: 100%;">氏名　　　　: <?php echo $_smarty_tpl->tpl_vars['form']->value->student_name;?>
</label>
							</div>
							<div class="title" style=" background-color: #6f99db; margin: 10px;border-style: none; border-radius: 5px; margin-bottom: 20px; padding: 12px;">
								<label class="title" style="font-size: 18px; margin-top: 6px; color: #fff">総評</label>
							</div>

							<div id="linechart" style="width:450px; height: 270px; margin:auto;margin-bottom: 20px;"></div>
							<div class="course_btns" id="course_btns" style="display: flex; align-items: center; padding: auto;  justify-content: center;">
								<?php $_smarty_tpl->tpl_vars['color'] = new Smarty_Variable(array('red','orange','blue','black','green'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'color', 0);?>

								<?php if (($_smarty_tpl->tpl_vars['cfinish']->value > 1)) {?>

									<?php $_smarty_tpl->tpl_vars['turns'] = new Smarty_Variable(1, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'turns', 0);?><!-- ボタン番号 -->

									<!-- 回答されたコースのボタン番号 -->

									<?php $_smarty_tpl->tpl_vars['flag'] = new Smarty_Variable(0, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'flag', 0);?> <!-- コースは採点されるかどうか -->
									<?php
$_from = $_smarty_tpl->tpl_vars['cfinish']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_j_0_saved_item = isset($_smarty_tpl->tpl_vars['j']) ? $_smarty_tpl->tpl_vars['j'] : false;
$__foreach_j_0_saved_key = isset($_smarty_tpl->tpl_vars['fid']) ? $_smarty_tpl->tpl_vars['fid'] : false;
$_smarty_tpl->tpl_vars['j'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['fid'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['j']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['fid']->value => $_smarty_tpl->tpl_vars['j']->value) {
$_smarty_tpl->tpl_vars['j']->_loop = true;
$__foreach_j_0_saved_local_item = $_smarty_tpl->tpl_vars['j'];
?>

											<?php if ($_smarty_tpl->tpl_vars['turns']->value == 1) {?>
												<?php $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable(((string)$_smarty_tpl->tpl_vars['turns']->value)."st", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 't', 0);?>
											<?php } elseif ($_smarty_tpl->tpl_vars['turns']->value == 2) {?>
												<?php $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable(((string)$_smarty_tpl->tpl_vars['turns']->value)."nd", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 't', 0);?>
											<?php } elseif ($_smarty_tpl->tpl_vars['turns']->value == 3) {?>
												<?php $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable(((string)$_smarty_tpl->tpl_vars['turns']->value)."rd", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 't', 0);?>
											<?php } elseif ($_smarty_tpl->tpl_vars['turns']->value == 4) {?>
												<?php $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable(((string)$_smarty_tpl->tpl_vars['turns']->value)."th", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 't', 0);?>
											<?php } else { ?>
												<?php $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable(((string)$_smarty_tpl->tpl_vars['turns']->value)."th", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 't', 0);?>
											<?php }?>

											<?php if ($_smarty_tpl->tpl_vars['turns']->value%5 == 1) {?>
												<?php if ($_smarty_tpl->tpl_vars['org_no']->value == $_smarty_tpl->tpl_vars['j']->value->org_no && $_smarty_tpl->tpl_vars['offer_no']->value == $_smarty_tpl->tpl_vars['j']->value->offer_no && $_smarty_tpl->tpl_vars['course_id']->value == $_smarty_tpl->tpl_vars['j']->value->course_id && $_smarty_tpl->tpl_vars['course_detail_no']->value == $_smarty_tpl->tpl_vars['j']->value->course_detail_no && $_smarty_tpl->tpl_vars['student_no']->value == $_smarty_tpl->tpl_vars['j']->value->student_no) {?>
												<!-- ボタンを無効にする -->
												<input type="button" class="course_buttons btn_one" name="course_btn" value='<?php echo $_smarty_tpl->tpl_vars['t']->value;?>
' onclick="changeCourse('<?php echo $_smarty_tpl->tpl_vars['j']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->offer_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_id;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_detail_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->student_no;?>
','<?php echo @constant('HOME_DIR');?>
WritingFeedbackList/index')" disabled="disabled" style="opacity: .5;">

												<?php } else { ?>
													<input type="button" class="course_buttons btn_one" name="course_btn" value='<?php echo $_smarty_tpl->tpl_vars['t']->value;?>
' onclick="changeCourse('<?php echo $_smarty_tpl->tpl_vars['j']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->offer_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_id;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_detail_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->student_no;?>
','<?php echo @constant('HOME_DIR');?>
WritingFeedbackList/index')">
												<?php }?>
											<?php } elseif ($_smarty_tpl->tpl_vars['turns']->value%5 == 2) {?>
												<?php if ($_smarty_tpl->tpl_vars['org_no']->value == $_smarty_tpl->tpl_vars['j']->value->org_no && $_smarty_tpl->tpl_vars['offer_no']->value == $_smarty_tpl->tpl_vars['j']->value->offer_no && $_smarty_tpl->tpl_vars['course_id']->value == $_smarty_tpl->tpl_vars['j']->value->course_id && $_smarty_tpl->tpl_vars['course_detail_no']->value == $_smarty_tpl->tpl_vars['j']->value->course_detail_no && $_smarty_tpl->tpl_vars['student_no']->value == $_smarty_tpl->tpl_vars['j']->value->student_no) {?>
												<!-- ボタンを無効にする -->
													<input type="button" class="course_buttons btn_two" name="course_btn" value='<?php echo $_smarty_tpl->tpl_vars['t']->value;?>
' onclick="changeCourse('<?php echo $_smarty_tpl->tpl_vars['j']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->offer_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_id;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_detail_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->student_no;?>
','<?php echo @constant('HOME_DIR');?>
WritingFeedbackList/index')" disabled="disabled" style="opacity: .5;">
												<?php } else { ?>
													<input type="button" class="course_buttons btn_two" name="course_btn" value='<?php echo $_smarty_tpl->tpl_vars['t']->value;?>
' onclick="changeCourse('<?php echo $_smarty_tpl->tpl_vars['j']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->offer_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_id;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_detail_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->student_no;?>
','<?php echo @constant('HOME_DIR');?>
WritingFeedbackList/index')" >
												<?php }?>
											<?php } elseif ($_smarty_tpl->tpl_vars['turns']->value%5 == 3) {?>
												<?php if ($_smarty_tpl->tpl_vars['org_no']->value == $_smarty_tpl->tpl_vars['j']->value->org_no && $_smarty_tpl->tpl_vars['offer_no']->value == $_smarty_tpl->tpl_vars['j']->value->offer_no && $_smarty_tpl->tpl_vars['course_id']->value == $_smarty_tpl->tpl_vars['j']->value->course_id && $_smarty_tpl->tpl_vars['course_detail_no']->value == $_smarty_tpl->tpl_vars['j']->value->course_detail_no && $_smarty_tpl->tpl_vars['student_no']->value == $_smarty_tpl->tpl_vars['j']->value->student_no) {?>
												<!-- ボタンを無効にする -->
													<input type="button" class="course_buttons btn_three" name="course_btn" value='<?php echo $_smarty_tpl->tpl_vars['t']->value;?>
' onclick="changeCourse('<?php echo $_smarty_tpl->tpl_vars['j']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->offer_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_id;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_detail_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->student_no;?>
','<?php echo @constant('HOME_DIR');?>
WritingFeedbackList/index')" disabled="disabled" style="opacity: .5;">
												<?php } else { ?>
													<input type="button" class="course_buttons btn_three" name="course_btn" value='<?php echo $_smarty_tpl->tpl_vars['t']->value;?>
' onclick="changeCourse('<?php echo $_smarty_tpl->tpl_vars['j']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->offer_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_id;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_detail_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->student_no;?>
','<?php echo @constant('HOME_DIR');?>
WritingFeedbackList/index')" >
												<?php }?>
											<?php } elseif ($_smarty_tpl->tpl_vars['turns']->value%5 == 4) {?>
												<?php if ($_smarty_tpl->tpl_vars['org_no']->value == $_smarty_tpl->tpl_vars['j']->value->org_no && $_smarty_tpl->tpl_vars['offer_no']->value == $_smarty_tpl->tpl_vars['j']->value->offer_no && $_smarty_tpl->tpl_vars['course_id']->value == $_smarty_tpl->tpl_vars['j']->value->course_id && $_smarty_tpl->tpl_vars['course_detail_no']->value == $_smarty_tpl->tpl_vars['j']->value->course_detail_no && $_smarty_tpl->tpl_vars['student_no']->value == $_smarty_tpl->tpl_vars['j']->value->student_no) {?>
												<!-- ボタンを無効にする -->
													<input type="button" class="course_buttons btn_four" name="course_btn" value='<?php echo $_smarty_tpl->tpl_vars['t']->value;?>
' onclick="changeCourse('<?php echo $_smarty_tpl->tpl_vars['j']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->offer_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_id;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_detail_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->student_no;?>
','<?php echo @constant('HOME_DIR');?>
WritingFeedbackList/index')" disabled="disabled" style="opacity: .5;">
												<?php } else { ?>
													<input type="button" class="course_buttons btn_four" name="course_btn" value='<?php echo $_smarty_tpl->tpl_vars['t']->value;?>
' onclick="changeCourse('<?php echo $_smarty_tpl->tpl_vars['j']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->offer_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_id;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_detail_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->student_no;?>
','<?php echo @constant('HOME_DIR');?>
WritingFeedbackList/index')">
												<?php }?>
											<?php } else { ?>
												<?php if ($_smarty_tpl->tpl_vars['org_no']->value == $_smarty_tpl->tpl_vars['j']->value->org_no && $_smarty_tpl->tpl_vars['offer_no']->value == $_smarty_tpl->tpl_vars['j']->value->offer_no && $_smarty_tpl->tpl_vars['course_id']->value == $_smarty_tpl->tpl_vars['j']->value->course_id && $_smarty_tpl->tpl_vars['course_detail_no']->value == $_smarty_tpl->tpl_vars['j']->value->course_detail_no && $_smarty_tpl->tpl_vars['student_no']->value == $_smarty_tpl->tpl_vars['j']->value->student_no) {?>
												<!-- ボタンを無効にする -->
													<input type="button" class="course_buttons btn_five" name="course_btn" value='<?php echo $_smarty_tpl->tpl_vars['t']->value;?>
' onclick="changeCourse('<?php echo $_smarty_tpl->tpl_vars['j']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->offer_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_id;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_detail_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->student_no;?>
','<?php echo @constant('HOME_DIR');?>
WritingFeedbackList/index')"disabled="disabled" style="opacity: .5;">
												<?php } else { ?>
													<input type="button" class="course_buttons btn_five" name="course_btn" value='<?php echo $_smarty_tpl->tpl_vars['t']->value;?>
' onclick="changeCourse('<?php echo $_smarty_tpl->tpl_vars['j']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->offer_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_id;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->course_detail_no;?>
','<?php echo $_smarty_tpl->tpl_vars['j']->value->student_no;?>
','<?php echo @constant('HOME_DIR');?>
WritingFeedbackList/index')" >
												<?php }?>
											<?php }?>

											<?php $_smarty_tpl->tpl_vars['turns'] = new Smarty_Variable($_smarty_tpl->tpl_vars['turns']->value+1, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'turns', 0);?>
											<?php $_smarty_tpl->tpl_vars['flag'] = new Smarty_Variable(1, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'flag', 0);?>

									<?php
$_smarty_tpl->tpl_vars['j'] = $__foreach_j_0_saved_local_item;
}
if ($__foreach_j_0_saved_item) {
$_smarty_tpl->tpl_vars['j'] = $__foreach_j_0_saved_item;
}
if ($__foreach_j_0_saved_key) {
$_smarty_tpl->tpl_vars['fid'] = $__foreach_j_0_saved_key;
}
?>
								<?php }?>
							</div>


							<!-- コースが1つしかない場合 -->
							<div style="margin:auto; height:270px; width: auto; margin-bottom: 10px;max-width: 850px; ">
								<div id="columnchart" style="height: 250px; width: 40%; float: left; margin:auto; "></div>

							<!-- コースのマーク -->
								<div class="div_cmtForm1" id="div_cmtForm1" style="display: inline-block;height: auto;overflow: auto;padding: 15px;margin-top: 10px;width: 40%;float: right;">
									<label id="course_title" style="font-size: 16px; font-weight: 3em; font-style: bold;">
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->course_name, ENT_QUOTES, 'UTF-8', true);?>
 - <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->course_detail_name, ENT_QUOTES, 'UTF-8', true);?>

									</label>

									<table>
										<tr>
											<td><label class="fb_label">テスト受講日</label></td>
											<td>: <label id="answer_date"></label></td>
										</tr>
										<tr>
											<td><label class="fb_label">総合評価</label></td>
											<td>: <label id = "total_marks"></label>
												<span> / </span>
												<label id="max_marks" class="fb_label"></label>
											</td>
										</tr>
										<tr>
											<td><label class="fb_label">内容</label></td>
											<td>: <label id = "content" class="fb_label"></label></td>
										</tr>
										<tr>
											<td><label class="fb_label">構成</label></td>
											<td>: <label id = "compos" class="fb_label"></label></td>
										</tr>
										<tr>
											<td><label class="fb_label">語彙</label></td>
											<td>: <label id = "vocub" class="fb_label"></label></td>
										</tr>
										<tr>
											<td><label class="fb_label">文法</label></td>
											<td>: <label id = "grammar" class="fb_label"></label></td>
										</tr>
									</table>
								</div>
							</div>
							<?php if (!empty($_smarty_tpl->tpl_vars['quiz_data']->value)) {?>
							<!-- 質問番号 1, 2, 3 -->
							<?php $_smarty_tpl->tpl_vars['qNo'] = new Smarty_Variable(1, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'qNo', 0);?>
							<?php
$_from = $_smarty_tpl->tpl_vars['quiz_data']->value;
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
							<?php if ($_smarty_tpl->tpl_vars['key']->value == 0) {?>
								<?php $_smarty_tpl->tpl_vars['qa_no'] = new Smarty_Variable($_smarty_tpl->tpl_vars['result']->value->question_no, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'qa_no', 0);?>
							<?php }?>
							<?php if ($_smarty_tpl->tpl_vars['qa_no']->value != $_smarty_tpl->tpl_vars['result']->value->question_no) {?>
								<?php $_smarty_tpl->tpl_vars['qa_no'] = new Smarty_Variable($_smarty_tpl->tpl_vars['result']->value->question_no, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'qa_no', 0);?>
								<?php $_smarty_tpl->tpl_vars['qNo'] = new Smarty_Variable($_smarty_tpl->tpl_vars['qNo']->value+1, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'qNo', 0);?>
							<?php }?>
							<div class="div_one_rewiew" id="div_quiz" >
								<div class="title" style=" margin-top: 20px;background-color: #6f99db;margin: 10px; border-style: none; border-radius: 5px; margin-bottom: 15px; color: #fff; padding: 12px;">
									<label id="description" style="font-size: 18px; margin-top: 6px;"><?php echo $_smarty_tpl->tpl_vars['qNo']->value;?>
.<?php echo $_smarty_tpl->tpl_vars['result']->value->description[0];?>
 </label>
								</div>
								<div style="width: 100%; margin:auto; overflow: auto;">
									<div class="div_cmtForm2" style="height: auto; padding: 15px; background-color: none; margin: 20px; margin-top: 0px; ">
										<label id="lbl_mark" style="font-size: 40px; font-style: bold; margin: auto;">
											<?php echo $_smarty_tpl->tpl_vars['result']->value->rule_result_marks;?>
/<?php echo $_smarty_tpl->tpl_vars['result']->value->rule_total_marks;?>
点
										</label>

										<label id="lbl_cause" style="float: right; width: 75%;">
										<?php $_smarty_tpl->tpl_vars['count'] = new Smarty_Variable(count($_smarty_tpl->tpl_vars['result']->value->reply_comment), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'count', 0);?>
											<?php
$_smarty_tpl->tpl_vars['sub_loop'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['sub_loop']->step = 1;$_smarty_tpl->tpl_vars['sub_loop']->total = (int) ceil(($_smarty_tpl->tpl_vars['sub_loop']->step > 0 ? $_smarty_tpl->tpl_vars['count']->value-1+1 - (0) : 0-($_smarty_tpl->tpl_vars['count']->value-1)+1)/abs($_smarty_tpl->tpl_vars['sub_loop']->step));
if ($_smarty_tpl->tpl_vars['sub_loop']->total > 0) {
for ($_smarty_tpl->tpl_vars['sub_loop']->value = 0, $_smarty_tpl->tpl_vars['sub_loop']->iteration = 1;$_smarty_tpl->tpl_vars['sub_loop']->iteration <= $_smarty_tpl->tpl_vars['sub_loop']->total;$_smarty_tpl->tpl_vars['sub_loop']->value += $_smarty_tpl->tpl_vars['sub_loop']->step, $_smarty_tpl->tpl_vars['sub_loop']->iteration++) {
$_smarty_tpl->tpl_vars['sub_loop']->first = $_smarty_tpl->tpl_vars['sub_loop']->iteration == 1;$_smarty_tpl->tpl_vars['sub_loop']->last = $_smarty_tpl->tpl_vars['sub_loop']->iteration == $_smarty_tpl->tpl_vars['sub_loop']->total;?>
													<span style="font-style: bold;font-size:20px;"><?php if (!empty($_smarty_tpl->tpl_vars['result']->value->sub_description[$_smarty_tpl->tpl_vars['sub_loop']->value])) {?>	<?php echo $_smarty_tpl->tpl_vars['result']->value->sub_description[$_smarty_tpl->tpl_vars['sub_loop']->value];?>
 <?php }?><br/></span>
												<ul class="spk_mark_ul">
												<li class="spk_description_li"><?php if (!empty($_smarty_tpl->tpl_vars['result']->value->reply_comment[$_smarty_tpl->tpl_vars['sub_loop']->value])) {
echo $_smarty_tpl->tpl_vars['result']->value->reply_comment[$_smarty_tpl->tpl_vars['sub_loop']->value];?>
 <?php }?><br/></li>
												</ul>
											<?php }
}
?>

										</label>
									</div>
								</div>
								<?php if ($_smarty_tpl->tpl_vars['qa_no']->value != $_smarty_tpl->tpl_vars['quiz_data']->value[$_smarty_tpl->tpl_vars['key']->value+1]->question_no) {?>
								<div class="title" style=" margin-top: 20px;background-color: #6f99db;margin: 10px; border-style: none; border-radius: 5px; margin-bottom: 15px; color: #fff; padding: 12px;">
									<label id="sample_answer" style="font-size: 18px; margin-top: 6px;">あなたの解答</label>
								</div>
								<div style="width: 92%; margin:auto;padding-left:20px;margin-bottom:20px;">
										<label><?php echo $_smarty_tpl->tpl_vars['result']->value->answer_contents;?>
</label>
								</div>
								<div class="title" style=" margin-top: 20px;background-color: #6f99db;margin: 10px; border-style: none; border-radius: 5px; margin-bottom: 15px; color: #fff; padding: 12px;">
									<label id="sample_answer" style="font-size: 18px; margin-top: 6px;">模範解答</label>
								</div>
								<div style="width: 92%; margin:auto;padding-left:20px;margin-bottom:20px;">
										<label style="align-left:50px; align-right:20px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->sample_answer;?>
</label>
								</div>
								<div class="title" style=" margin-top: 20px;background-color: #6f99db;margin: 10px; border-style: none; border-radius: 5px; margin-bottom: 15px; color: #fff; padding: 12px;">
									<label id="sample_answer" style="font-size: 18px; margin-top: 6px;">描写ポイント</label>
								</div>
								<div style="width: 92%; margin:auto;padding-left:20px;margin-bottom:20px;">
										<?php echo $_smarty_tpl->tpl_vars['result']->value->byosha_point;?>

								</div>
								<?php }?>
							</div>
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
						</div>
						<?php }?>
					</div>
				</section>
			</div>
		</div>
		<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	</form>

	<?php echo '<script'; ?>
 type="text/javascript">
		$(document).ready(function() {
			var cdno = document.getElementById('cdno').value;
			var ofno = document.getElementById('ofno').value;
			var cid = document.getElementById('cid').value;
			var cnt = document.getElementById('cnt').value;

			col_charts(ofno, cid, cdno);
			line_chart();
			if ( cnt <= 1 ){
				document.getElementById('linechart').style.display = 'none';
				document.getElementById('columnchart').style.cssFloat = "left";
				//document.getElementById('div_cmtForm1').style.paddingLeft='100px';
			}
		});
	<?php echo '</script'; ?>
>

	<?php echo '<script'; ?>
>
	 	
	 	var datas = [];
	 	var mark_total;
	 	
		<?php
$_from = $_smarty_tpl->tpl_vars['courseData']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_data_2_saved_item = isset($_smarty_tpl->tpl_vars['data']) ? $_smarty_tpl->tpl_vars['data'] : false;
$_smarty_tpl->tpl_vars['data'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['data']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
$__foreach_data_2_saved_local_item = $_smarty_tpl->tpl_vars['data'];
?>
			
				datas.push(JSON.parse('<?php echo json_encode($_smarty_tpl->tpl_vars['data']->value,JSON_HEX_APOS);?>
'));
			
		<?php
$_smarty_tpl->tpl_vars['data'] = $__foreach_data_2_saved_local_item;
}
if ($__foreach_data_2_saved_item) {
$_smarty_tpl->tpl_vars['data'] = $__foreach_data_2_saved_item;
}
?>
		

		function line_chart() {

			google.charts.load("current", {packages:['corechart']});
			google.charts.load('current', {'packages':['line']});
			google.charts.setOnLoadCallback(drawChart);

			// 折れ線グラフデータ入力
			var line_data=[];

		 	var Header=  ['Content', '内容', '構成' , '語彙', '文法'];
		 	line_data.push(Header);

		 	var dt = datas[0].answer_dt;
			// テスト受講日表示不正ので修正　2019/09/13 Cherry
		 	// document.getElementById("answer_date").innerHTML =  dt;

		 	var f = 0;
		 	var ofno = datas[0].offer_no;
		 	var cid = datas[0].course_id;
		 	var cdno = datas[0].course_detail_no;
		 	var temp = [];
			var one = 0, two = 0, three = 0, four = 0;

			temp.push("1st");

			for (var j = 0; j < datas.length; j++){

				if ((datas[j].offer_no == ofno) && (datas[j].course_id == cid) && (datas[j].course_detail_no == cdno) && (datas[j].test_kbn == '002')){

					if (datas[j].result_kbn == '001'){

						a = Number(datas[j].detail_result_marks);
						one += a;
					}else if (datas[j].result_kbn == '002'){

						b = Number( datas[j].detail_result_marks);
						two += b;
					}else if (datas[j].result_kbn == '003'){

						c = Number(datas[j].detail_result_marks);
						three += c;
					}else if (datas[j].result_kbn == '004'){

						d = Number(datas[j].detail_result_marks);
						four += d;
					}
				}
			}
			temp.push(one);
			temp.push(two);
			temp.push(three);
			temp.push(four);
			line_data.push(temp);
			temp = [];
			f = 1;

		 	for (var i = 1; i < datas.length; i++) {
		 		temp = [];

		 		//次のコース
				if (datas[i].course_detail_no != cdno){

					one = 0;
					two = 0;
					three = 0;
					four = 0;
					f++;

					// コース 1st, 2nd ,。。 を作成する
					if (f == 1){
						temp.push( f + "st");
					}else if (f == 2){
						temp.push( f+ "nd");
					}else if (f == 3){
						temp.push( f + "rd");
					}else {
						temp.push( f + "th");
					}

					for (var j = i; j < datas.length; j++){

						if ((datas[i].offer_no == datas[j].offer_no) && (datas[i].course_id == datas[j].course_id) && (datas[i].course_detail_no == datas[j].course_detail_no)){

							if (datas[j].result_kbn == '001'){
								a = Number(datas[j].detail_result_marks);
								one += a;

							}else if (datas[j].result_kbn == '002'){
								b = Number( datas[j].detail_result_marks);
								two += b;

							}else if (datas[j].result_kbn == '003'){
								c = Number(datas[j].detail_result_marks);
								three += c;
							}else if (datas[j].result_kbn == '004'){
								d = Number(datas[j].detail_result_marks);
								four += d;
							}
						}
					}
					temp.push(one);
					temp.push(two);
					temp.push(three);
					temp.push(four);
					line_data.push(temp);
					temp = [];
				}
				ofno = datas[i].offer_no;
				cid = datas[i].course_id;
				cdno = datas[i].course_detail_no;
			}

			<!-- 20190626-全部の点数が【0】になる場合、Y-axisに【-】が出ないように修正 -->
			function drawChart() {
				var data = google.visualization.arrayToDataTable(line_data);
				var options = {
					title: '',
					selectionMode: 'multiple',
					tooltip: {"trigger": 'both'},
					legend: { position: 'bottom' },
					vAxis: { 
						viewWindow: {
							min: 0
						}
					}
				};

				var chart = new google.visualization.LineChart(document.getElementById('linechart'));
				chart.draw(data, options);
			}
		}
		//縦棒グラフ
		var col_data=[];

		function col_charts(val1, val2, val3) {
			var a, b, c, d;
			var m1 = 0, m2 = 0, m3 = 0, m4 = 0;
			var x1, x2, x3;
			var one = 0, two = 0, three = 0, four = 0;
			var dt;
			var course_name;
			var course_detail_name;
			var course_detail_no = val3;

			for (var i = 0; i < datas.length; i++) {
				//縦棒グラフのため値でデータを取得する
				if ((datas[i].offer_no == val1) && (datas[i].course_id == val2) && (datas[i].course_detail_no == val3)){

					if ((datas[i].answer_dt != "") && (datas[i].answer_dt != null ) && (dt == null)){
						dt = datas[i].answer_dt;
					}
					course_name=datas[0].course_name;
					course_detail_name=datas[0].course_detail_name;
					if (datas[i].result_kbn == '001'){
						a = Number(datas[i].detail_result_marks);
						m1 += Number(datas[i].detail_total_marks);
						one += a;
					}else if (datas[i].result_kbn == '002'){
						b = Number(datas[i].detail_result_marks);
						m2 += Number(datas[i].detail_total_marks);
						two += b;
					}else if (datas[i].result_kbn == '003'){
						c = Number(datas[i].detail_result_marks);
						m3 +=Number(datas[i].detail_total_marks);
						three += c;
					}else if (datas[i].result_kbn == '004'){
						d = Number(datas[i].detail_result_marks);
						m4 +=Number(datas[i].detail_total_marks);
						four += d;
					}
				}
			}

			per1=(one / m1) * 100;
			per2=(two / m2) * 100;
			per3=(three / m3) * 100;
			per4=(four / m4) * 100;

			//合計得点
			mark_total = +one + +two + +three + +four;
			//各マークを担当する
			document.getElementById("total_marks").innerHTML = mark_total ;
			document.getElementById("content").innerHTML = one + ' / ' + m1 + ' 点';
			document.getElementById("compos").innerHTML = two + ' / ' + m2 + ' 点';
			document.getElementById("vocub").innerHTML = three + ' / ' + m3 + ' 点';
			document.getElementById("grammar").innerHTML = four + ' / ' + m4 + ' 点';

			var e = +m1 + +m2 + +m3+ +m4;
	 		document.getElementById("max_marks").innerHTML = e + ' 点' ;
		 	document.getElementById("answer_date").innerHTML =  dt;

			google.charts.load("current", {packages:['corechart']});
			google.charts.setOnLoadCallback(drawChart1);

			function drawChart1() {
				var dataTable = new google.visualization.DataTable();
				dataTable.addColumn('string', 'Part');
				dataTable.addColumn('number', 'Marks');
				// A column for custom tooltip content
				dataTable.addColumn({type: 'string', role: 'tooltip'});
				dataTable.addColumn({type: 'string', role: 'style'});
				dataTable.addRows([
					['内容', per1 ,one+ '点',"color:#5e5899"],
					['構成', per2 ,two + '点',"color:#d83c3c"],
					['語彙', per3,three+ '点',"color:#f2cb1f" ],
					['文法', per4,four + '点',"color:#9ACD32" ]
				]);

				var options = { legend: { position: "none" },
								bar: {groupWidth: "50%"},
								vAxis: {
								tooltip: {isHtml: true},
								minValue: 0,
								maxValue: 100,
								format: '#\'%\''
								} };
				var chart = new google.visualization.ColumnChart(document.getElementById('columnchart'));
				chart.draw(dataTable, options);
			}
		}
	
	<?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript">
		

		function changeCourse( org_no, offer_no, course_id, course_detail_no, student_no, action){

			var menuOpen = document.getElementById('menuOpen').value;
			var menuStatus = document.getElementById('menuStatus').value;
			var home_dir = document.getElementById('home_dir').value;

			$("#main_form").attr("action", action);
			$("#offer_no").val(offer_no);
			$("#org_no").val(org_no);
			$("#course_id").val(course_id);
			$("#course_detail_no").val(course_detail_no);
			$("#student_no").val(student_no);
			$("#menuOpen").val(menuOpen);
			$("#menuStatus").val(menuStatus);
			$("#main_form").submit();
		}

		
	<?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
>
			$(document).ready(function(){

				var title=document.getElementsByClassName("content");
				title[0].style.display="";

				//バックボタンを消す
				document.getElementById("back").style.display="";
				var divBody=document.getElementsByClassName("divBody");
				divBody[0].style.top="70px";

				//画面上のマインタイトルを消す
				var divHeader=document.getElementsByClassName("divHeader");
				divHeader[0].style.display="";

			});
	<?php echo '</script'; ?>
>
</body>
</html><?php }
}
