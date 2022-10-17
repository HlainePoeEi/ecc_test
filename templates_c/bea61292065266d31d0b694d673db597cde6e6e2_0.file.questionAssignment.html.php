<?php
/* Smarty version 3.1.29, created on 2022-04-15 19:01:12
  from "/var/www/html/eccadmin_dev/templates/questionAssignment.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_62594268e667f1_27168371',
  'file_dependency' => 
  array (
    'bea61292065266d31d0b694d673db597cde6e6e2' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/questionAssignment.html',
      1 => 1552895749,
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
function content_62594268e667f1_27168371 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/var/www/html/eccadmin_dev/libs/smarty/libs/plugins/modifier.truncate.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>問題割当</title>
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
js/questionAssignment.js"><?php echo '</script'; ?>
>
		
		<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/assignment.css" rel="stylesheet">
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
QuestionAssignmentList/save" method="post">
			<input type="hidden" id ="admin_no" name="admin_no"/>
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<div class="divHeader">
				<!--header-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--header-->
			</div>
			<div class="divBody">
				<!-- エラーセクション -->
				<section class="error_section">
					<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" style="width:15px;float:right" class="close_icon">
					<?php if (!empty($_smarty_tpl->tpl_vars['err_msg']->value)) {?>
						<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['err_msg']->value;?>
</div>
					<?php } else { ?>
						<div class="error_msg"></div>
					<?php }?>
				</section>
				<section class="content">
					<p>
						><span class="title"> コース詳細 / 問題割当 </span>
					</p>
					<p style="text-align:right;width:100%;">
						<!-- 戻るボタン -->
						<input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
CourseDetailList/search')">
					</p>
					<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
					<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
					<input type="hidden" id="entryList" name="entryList"/>
					<input type="hidden" id="back_flg" name="back_flg" value="true" />
					<input type="hidden" name="course_detail_no" id="course_detail_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->course_detail_no;?>
"/>
					<input type="hidden" name="course_level" id="course_level" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->course_level;?>
"/>
					<input type="hidden" name="test_kbn" id="test_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_kbn;?>
"/>
					<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
					<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
"/>
					<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
"/>
					<input type="hidden" id="search_status" name="search_status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_status;?>
"/>
					<input type="hidden" id="search_course_detail_name" name="search_course_detail_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_course_detail_name;?>
"/>
					<input type="hidden" id="search_test_kbn" name="search_test_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_test_kbn;?>
" />
					<input type="hidden" id="search_course_level" name="search_course_level" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_course_level;?>
" />
					<input type="hidden" id="status" name="status" />

					<table class="testAss_tbl">
						<!-- コース詳細のデータ -->
						<tr>
							<td class="td_two">コース詳細名</td>
							<td class="td_input"><?php echo $_smarty_tpl->tpl_vars['form']->value->course_detail_name;?>
</td>
						</tr>
						<tr>
							<td class="td_two">レベル</td>
							<td class="td_input"><?php echo $_smarty_tpl->tpl_vars['form']->value->course_level;?>
</td>
						</tr>
						<tr>
							<td class="td_two">SW</td>
					 		<td class="td_input"><?php echo $_smarty_tpl->tpl_vars['form']->value->test_kbn;?>
</td>
						</tr>
						<tr>
							<td class="td_two">利用期間</td>
					 		<td class="td_input"> <?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
 ~ <?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
 </td>
						</tr>
						<tr>
							<td></td>
							<td></td>
						</tr>

						<!-- 問題検索 -->
						<tr>
							<td>問題名</td>
							<td class="td_input"><input class="text" type="text"  name="question_name" id="question_name" maxlength="32" size="30"></td>
						</tr>
						<tr>
							<td>状況</td>
							<td class="input">
							<?php if (!empty($_smarty_tpl->tpl_vars['form']->value->chk_status2 != '')) {?>
								<label><input type="checkbox" id="chk_status2" name="chk_status2" value='0' checked>非公開</label>
							<?php } else { ?>
								<label><input type="checkbox" id="chk_status2" name="chk_status2" value='0'>非公開</label>
							<?php }?>
							<?php if (($_smarty_tpl->tpl_vars['form']->value->chk_status1 != '')) {?>
								<label><input type="checkbox" id="chk_status1" name="chk_status1" value='1' checked>公開</label>
							<?php } else { ?>
								<label><input type="checkbox" id="chk_status1" name="chk_status1" value='1'>公開</label>
							<?php }?>
							</td>
						</tr>
					</table>

					<!-- 検索ボータン -->
					<div class="pagging">
						<input type="button" value="" class="btn_search"
							onclick="javascript:questionSearch();" />
					</div>

					<!-- 上テーブル検索問題一覧 -->
					<table class="join_header_border" id="questionAss_uppertbl">
						<thead>
							<tr>
								<th style="width:50px; ">番号</th>
								<th style="width:290px; ">問題名</th>
								<th style="width:330px; ">問題説明</th>
								<th style="width:180px; ">SW</th>
								<th style="width:180px; ">レベル</th>
								<th style="width:180px; ">問題パターン</th>
								<th style="width:250px; ">採点アパターン</th>
								<th style="width:50px; ">追加</th>
								<th style="width:50px; "></th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
					<br>

					<!-- 下テーブル詳細の問題一覧 -->
					<table id="questionAss_lowertbl" class="myTable join_header_border">
						<thead>
							<tr>
								<th style="width:50px; ">番号</th>
								<th style="width:250px; ">問題名</th>
								<th style="width:400px; ">問題説明</th>
								<th style="width:200px; ">SW</th>
								<th style="width:200px; ">レベル</th>
								<th style="width:200px; ">問題パターン</th>
								<th style="width:200px; ">採点アパターン</th>
								<th style="width:200px; "></th>
								<th style="width:50px; text-align:center;">削除</th>
							</tr>
						</thead>
						<?php if (count($_smarty_tpl->tpl_vars['existlist']->value) == 1) {?>
							<tbody>
							<?php
$_from = $_smarty_tpl->tpl_vars['existlist']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_result_0_saved_item = isset($_smarty_tpl->tpl_vars['result']) ? $_smarty_tpl->tpl_vars['result'] : false;
$_smarty_tpl->tpl_vars['result'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['result']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['result']->value) {
$_smarty_tpl->tpl_vars['result']->_loop = true;
$__foreach_result_0_saved_local_item = $_smarty_tpl->tpl_vars['result'];
?>
								<tr>
									<td style="width:50px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
</td>
									<td style="width:200px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->question_name;?>
</td>
									<td style="width:250px;">
										<?php if ($_smarty_tpl->tpl_vars['result']->value->qa_description != '') {
echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['result']->value->qa_description,20,'...');
}?>
									</td>
									<td style="width:160px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->test_kbn;?>
</td>
									<td style="width:160px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_level;?>
</td>
									<td style="width:160px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->qa_pattern;?>
</td>
									<td style="width:180px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->score_pattern;?>
</td>
									<td style="width:90px; text-align:center;">
										<button style="background-color:transparent;border:0px;" disabled="disabled" onClick="MoveUp.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/up.svg" style="width: 25px;height:25px;"/></a>
										<button style="background-color:transparent;border:0px;" disabled="disabled" onClick="MoveDown.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/down.svg"  style="width: 25px;height:25px;"/></a>
									</td>
									<td style="width:50px; text-align:center;">
										<a href="javascript:moveToUpperTable('<?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
')">
										<img src="<?php echo @constant('HOME_DIR');?>
image/minus.svg" style="width:25px;height:25px;"/>
										</a>
									</td>
									<td style="display: none;" ><?php echo $_smarty_tpl->tpl_vars['result']->value->question_no;?>
</td>
								</tr>
							<?php
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_0_saved_local_item;
}
if ($__foreach_result_0_saved_item) {
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_0_saved_item;
}
?>
							</tbody>
						<?php } else { ?>
							<tbody>
								<?php
$_from = $_smarty_tpl->tpl_vars['existlist']->value;
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
										<tr>
											<td style="width:50px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
</td>
											<td style="width:200px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->question_name;?>
</td>
											<td style="width:250px;">
												<?php if ($_smarty_tpl->tpl_vars['result']->value->qa_description != '') {
echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['result']->value->qa_description,20,'...');
}?>
											</td>
											<td style="width:160px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->test_kbn;?>
</td>
											<td style="width:160px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_level;?>
</td>
											<td style="width:160px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->qa_pattern;?>
</td>
											<td style="width:180px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->score_pattern;?>
</td>
											<td style="width:90px; text-align:center;">
												<button style="background-color:transparent;border:0px;" disabled="disabled" onClick="MoveUp.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/up.svg" style="width: 25px;height:25px;"/></a>
												<button style="background-color:transparent;border:0px;" onClick="MoveDown.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/down.svg"  style="width: 25px;height:25px;"/></a>
											</td>
											<td style="width:50px; text-align:center;">
												<a href="javascript:moveToUpperTable('<?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
')">
												<img src="<?php echo @constant('HOME_DIR');?>
image/minus.svg" style="width:25px;height:25px;"/> </a>
											</td>
											<td style="display: none;" ><?php echo $_smarty_tpl->tpl_vars['result']->value->question_no;?>
</td>
										</tr>
									<?php } elseif ($_smarty_tpl->tpl_vars['key']->value == count($_smarty_tpl->tpl_vars['existlist']->value)-1) {?>
										<tr>
											<td style="width:50px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
</td>
											<td style="width:200px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->question_name;?>
</td>
											<td style="width:250px;">
												<?php if ($_smarty_tpl->tpl_vars['result']->value->qa_description != '') {
echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['result']->value->qa_description,20,'...');
}?>
											</td>
											<td style="width:160px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->test_kbn;?>
</td>
											<td style="width:160px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_level;?>
</td>
											<td style="width:160px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->qa_pattern;?>
</td>
											<td style="width:180px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->score_pattern;?>
</td>
											<td style="width:90px; text-align:center;">
												<button style="background-color:transparent;border:0px;" onClick="MoveUp.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/up.svg" style="width: 25px;height:25px;"/></a>
												<button style="background-color:transparent;border:0px;" disabled="disabled"  onClick="MoveDown.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/down.svg"  style="width: 25px;height:25px;"/></a>
												</td>
												<td style="width:50px; text-align:center;">
												<a href="javascript:moveToUpperTable('<?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
')">
												<img src="<?php echo @constant('HOME_DIR');?>
image/minus.svg" style="width:25px;height:25px;"/> </a>
											</td>
											<td style="display: none;" ><?php echo $_smarty_tpl->tpl_vars['result']->value->question_no;?>
</td>
										</tr>
									<?php } else { ?>
										<tr>
											<td style="width:50px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
</td>
											<td style="width:200px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->question_name;?>
</td>
											<td style="width:250px;">
												<?php if ($_smarty_tpl->tpl_vars['result']->value->qa_description != '') {
echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['result']->value->qa_description,20,'...');
}?>
											</td>
											<td style="width:160px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->test_kbn;?>
</td>
											<td style="width:160px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_level;?>
</td>
											<td style="width:160px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->qa_pattern;?>
</td>
											<td style="width:180px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->score_pattern;?>
</td>
											<td style="width:90px; text-align:center;">
												<button style="background-color:transparent;border:0px;" onClick="MoveUp.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/up.svg" style="width: 25px;height:25px;"/></a>
												<button style="background-color:transparent;border:0px;" onClick="MoveDown.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/down.svg"  style="width: 25px;height:25px;"/></a>
											</td>
											<td style="width:50px; text-align:center;">
												<a href="javascript:moveToUpperTable('<?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
')">
												<img src="<?php echo @constant('HOME_DIR');?>
image/minus.svg" style="width:25px;height:25px;"/> </a>
												</td>
											<td style="display: none;" ><?php echo $_smarty_tpl->tpl_vars['result']->value->question_no;?>
</td>
										</tr>
									<?php }?>
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
							</tbody>
						<?php }?>
					</table>
					<!-- ボタンのdiv -->
					<table class="btn_div">
						<tr>
							<td>
							<input type="button" value="" class="btn_resetbtn" title="リセット"
								onclick="javascript:cancel('<?php echo $_smarty_tpl->tpl_vars['form']->value->course_detail_no;?>
','<?php echo @constant('HOME_DIR');?>
QuestionAssignmentList/index');">
							<input type="button" name="insert" value="" class="btn_insert" title="登録"
								onclick="javascript:insertQuestionAssignmentData();" />
							</td>
						</tr>
					</table>
				</section>
			</div>
		</form>

		<?php echo '<script'; ?>
>
		
			//リセット
			function cancel(course_detail_no, action){

				$("#main_form").attr("action", action);
				$("#course_detail_no").val(course_detail_no);
				$("#main_form").submit();
			}

			//戻るボタン処理
			function doBack(action){
				$("#main_form").attr("action", action);
				$("#main_form").submit();
			}
		
		<?php echo '</script'; ?>
>
		<!--footer-->
		<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<!--footer-->
	</body>
</html><?php }
}
