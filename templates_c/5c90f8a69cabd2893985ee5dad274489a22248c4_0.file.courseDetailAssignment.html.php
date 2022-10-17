<?php
/* Smarty version 3.1.29, created on 2022-06-24 15:39:25
  from "/var/www/html/eccadmin_dev/templates/courseDetailAssignment.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_62b55c1d258f18_54161330',
  'file_dependency' => 
  array (
    '5c90f8a69cabd2893985ee5dad274489a22248c4' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/courseDetailAssignment.html',
      1 => 1655785214,
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
function content_62b55c1d258f18_54161330 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>コース詳細割当</title>
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
js/courseDetailAssignment.js"><?php echo '</script'; ?>
>
		
		<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/assignment.css"	rel="stylesheet">
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
CourseDetailAssignment/save" method="post">
			<input type="hidden" id="course_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->course_id;?>
" name="course_id"/>
			<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
			<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
			<input class="text" type="hidden"  name="rd_status" id="rd_status" >
			<input type="hidden" id="entryList" name="entryList" value=""/>
			<input type="hidden" id="back_flg" name="back_flg" value="false" />
			<input type="hidden" id="clevel" name="clevel" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->clevel;?>
"/>
			<input type="hidden" id="ckbn" name="ckbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->ckbn;?>
" />
			<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
			<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['search_end_period']->value;?>
"/>
			<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['search_start_period']->value;?>
"/>
			<input type="hidden" id="search_course_name" name="search_course_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['search_course_name']->value, ENT_QUOTES, 'UTF-8', true);?>
"/>
			<input type="hidden" id="search_status" name="search_status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_status;?>
" />
			<input type="hidden" id="error_msg" name="error_msg" value="<?php echo $_smarty_tpl->tpl_vars['error_msg']->value;?>
"/>
			<input type="hidden" id="search_test_kbn" name="search_test_kbn" value="<?php echo $_smarty_tpl->tpl_vars['search_test_kbn']->value;?>
" />
			<input type="hidden" id="search_course_level" name="search_course_level" value="<?php echo $_smarty_tpl->tpl_vars['search_course_level']->value;?>
" />
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<div class="divHeader">
				<!--header-->
					<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--header-->
			</div>
			<div class="divBody">
				<div id="err_dis">
					<section class="error_section">
						<img src="<?php echo @constant('HOME_DIR');?>
image/close_icon.png" style="width:15px;float:right;" class="close_icon">
						<?php if (!empty($_smarty_tpl->tpl_vars['error_msg']->value)) {?>
							<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['error_msg']->value;?>
</div>
						<?php } elseif (!empty($_smarty_tpl->tpl_vars['info_msg']->value)) {?>
							<div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['info_msg']->value;?>
</div>
						<?php } else { ?>
							<div class="error_msg"></div>
						<?php }?>
					</section>
				</div>
				<section class="content">
					<p>
						><span class="title">コース / コース詳細割当</span>
					</p>
					<p style="text-align:right;width:100%;">
						<input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
CourseList/search')">
					</p>
					<table class="testAss_tbl">
						<tr>
							<td class="td_two">コース名</td>
							<td class="td_input"><?php echo $_smarty_tpl->tpl_vars['form']->value->course_name;?>
</td>
						</tr>
						<tr>
							<td class="td_two">レベル</td>
							 <td class="td_input">
								<?php if (!empty($_smarty_tpl->tpl_vars['courseLevel']->value)) {?>
									<?php
$_from = $_smarty_tpl->tpl_vars['courseLevel']->value;
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
										<?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['clevel']->value) {?>
											<label><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
</label>
										<?php }?>
									<?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_0_saved_local_item;
}
if ($__foreach_value_0_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_0_saved_item;
}
?>
								<?php }?>
							 </td>
						</tr>
						<tr>
							<td class="td_two">SW</td>
							<td class="td_input">
								<?php if (!empty($_smarty_tpl->tpl_vars['testKbn']->value)) {?>
									<?php
$_from = $_smarty_tpl->tpl_vars['testKbn']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_1_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$__foreach_value_1_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
										<?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['ckbn']->value) {?>
											<label><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
</label>
										<?php }?>
									<?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_1_saved_local_item;
}
if ($__foreach_value_1_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_1_saved_item;
}
?>
								<?php }?>
							</td>
						<tr>
						<tr>
							<td class="td_two">利用期間</td>
							<td class="td_input"><?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
 ~ <?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>コース詳細名</td>
							<td class="td_input"><input class="text" type="text"  name="course_detail_name" id="course_detail_name" maxlength="32" size="30"></td>
						</tr>
						<tr>
							<td>
								<label class="lbl_name">公開</label>
							</td>
							<td>
								<label><input type="radio" name="rd_status1" value="0" id="rd_status1" />しない</label>
								<label><input type="radio" name="rd_status1" value="1" id="rd_status1" checked/>する</label>
							</td>
						</tr>
					</table>
					<br/>
					<div align="right" style="width:100%">
						<input type="button" id="btn_search" name="search" title="検索" class="btn_search" alt="search" value="" style="padding-right:50px;" onclick="javascript:detailSearch();" >
					</div>

					<table class="join_header_border" id="testAss_uppertbl">
						<thead>
							<tr>
								<th style="width:100px; ">番号</th>
								<th style="width:100px; ">コース詳細番号</th>
								<th style="width:330px; ">コース詳細名</th>
								<th style="width:330px; ">コース詳細ローマ字</th>
								<th style="width:220px; ">レベル</th>
								<th style="width:220px; ">SW</th>
								<th style="width:260px; ">利用期間</th>
								<th style="width:50px; ">追加</th>
							</tr>
						</thead>

						<tbody>
							<div style="width:100%; display: block;">
							</div>
						</tbody>

					</table>

					<br>
					<table id="testAss_lowertbl1" class="myTable join_header_border" >
						<thead>
							<tr>
								<th style="width:70px; ">番号</th>
								<th style="width:70px; ">コース詳細番号</th>
								<th style="width:300px; ">コース詳細名</th>
								<th style="width:300px; ">コース詳細ローマ字</th>
								<th style="width:200px; ">レベル</th>
								<th style="width:200px; ">SW</th>
								<th style="width:200px; ">利用期間</th>
								<th style="width:170px;"></th>
								<th style="width:50px; text-align:center;">削除</th>
							</tr>
						</thead>
						 <?php if (count($_smarty_tpl->tpl_vars['addlist']->value) == 1) {?>
						 <tbody>
							<?php
$_from = $_smarty_tpl->tpl_vars['addlist']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_result_2_saved_item = isset($_smarty_tpl->tpl_vars['result']) ? $_smarty_tpl->tpl_vars['result'] : false;
$_smarty_tpl->tpl_vars['result'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['result']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['result']->value) {
$_smarty_tpl->tpl_vars['result']->_loop = true;
$__foreach_result_2_saved_local_item = $_smarty_tpl->tpl_vars['result'];
?>
							<tr>
								<td style="width:150px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
</td>
								<td style="width:150px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_detail_no;?>
</td>
								<td width="350px"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_detail_name;?>
</td>
								<td width="350px"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_detail_romaji;?>
</td>
								<td width="250px"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_level;?>
</td>
								<td width="250px"><?php echo $_smarty_tpl->tpl_vars['result']->value->test_kbn;?>
</td>
								<td width="300px"><?php echo $_smarty_tpl->tpl_vars['result']->value->start_period;?>
 ~ <?php echo $_smarty_tpl->tpl_vars['result']->value->end_period;?>
</td>
								<td style="width:200px; text-align:center;">
									 <button style="  background-color: Transparent;border:0px;" disabled="disabled" onClick="MoveUp.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/up.svg" style="width: 25px;height:25px;"/>
									<button style="  background-color: Transparent;border:0px;"  disabled="disabled" onClick="MoveDown.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/down.svg"  style="width: 25px;height:25px;"/>
								</td>
								<td style="width:30px; text-align:center;">
									<a href="javascript:moveToUpperTable('<?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
')">
									<img src="<?php echo @constant('HOME_DIR');?>
image/minus.svg" style="width:25px;height:25px;"/> </a>
								</td>
							</tr>
							<?php
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_2_saved_local_item;
}
if ($__foreach_result_2_saved_item) {
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_2_saved_item;
}
?>
						</tbody>
						<?php } else { ?>
						<tbody>
							<?php
$_from = $_smarty_tpl->tpl_vars['addlist']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_result_3_saved_item = isset($_smarty_tpl->tpl_vars['result']) ? $_smarty_tpl->tpl_vars['result'] : false;
$__foreach_result_3_saved_key = isset($_smarty_tpl->tpl_vars['key']) ? $_smarty_tpl->tpl_vars['key'] : false;
$_smarty_tpl->tpl_vars['result'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['result']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['result']->value) {
$_smarty_tpl->tpl_vars['result']->_loop = true;
$__foreach_result_3_saved_local_item = $_smarty_tpl->tpl_vars['result'];
?>
							<?php if ($_smarty_tpl->tpl_vars['key']->value == 0) {?>
							<tr>
								<td style="width:150px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
</td>
								<td style="width:150px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_detail_no;?>
</td>
								<td width="350px"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_detail_name;?>
</td>
								<td width="350px"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_detail_romaji;?>
</td>
								<td width="250px"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_level;?>
</td>
								<td width="250px"><?php echo $_smarty_tpl->tpl_vars['result']->value->test_kbn;?>
</td>
								<td width="300px"><?php echo $_smarty_tpl->tpl_vars['result']->value->start_period;?>
 ~ <?php echo $_smarty_tpl->tpl_vars['result']->value->end_period;?>
</td>
								<td style="width:200px; text-align:center;">
									<button style="  background-color: Transparent;border:0px;" disabled="disabled" onClick="MoveUp.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/up.svg" style="width: 25px;height:25px;"/>
									<button style="  background-color: Transparent;border:0px;" onClick="MoveDown.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/down.svg"  style="width: 25px;height:25px;"/>
								</td>
								<td style="width:30px; text-align:center;">
									<a href="javascript:moveToUpperTable('<?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
')">
									<img src="<?php echo @constant('HOME_DIR');?>
image/minus.svg" style="width:25px;height:25px;"/> </a>
									</td>
							</tr>
							<?php } elseif ($_smarty_tpl->tpl_vars['key']->value == count($_smarty_tpl->tpl_vars['addlist']->value)-1) {?>
							<tr>
								<td style="width:150px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
</td>
								<td style="width:150px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_detail_no;?>
</td>
								<td width="350px"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_detail_name;?>
</td>
								<td width="350px"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_detail_romaji;?>
</td>
								<td width="250px"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_level;?>
</td>
								<td width="250px"><?php echo $_smarty_tpl->tpl_vars['result']->value->test_kbn;?>
</td>
								<td width="300px"><?php echo $_smarty_tpl->tpl_vars['result']->value->start_period;?>
 ~ <?php echo $_smarty_tpl->tpl_vars['result']->value->end_period;?>
</td>
								<td style="width:200px; text-align:center;">
									 <button style="background-color: Transparent;border:0px;" onClick="MoveUp.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/up.svg" style="width: 25px;height:25px;"/>
								   	 <button style="background-color: Transparent;border:0px;" disabled="disabled"  onClick="MoveDown.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/down.svg"  style="width: 25px;height:25px;"/>
								</td>
								<td style="width:30px; text-align:center;">
									<a href="javascript:moveToUpperTable('<?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
')">
									<img src="<?php echo @constant('HOME_DIR');?>
image/minus.svg" style="width:25px;height:25px;"/> </a>
								</td>
							</tr>
							<?php } else { ?>
							<tr>
								<td style="width:150px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
</td>
								<td style="width:150px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_detail_no;?>
</td>
								<td width="350px"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_detail_name;?>
</td>
								<td width="350px"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_detail_romaji;?>
</td>
								<td width="250px"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_level;?>
</td>
								<td width="250px"><?php echo $_smarty_tpl->tpl_vars['result']->value->test_kbn;?>
</td>
								<td width="300px"><?php echo $_smarty_tpl->tpl_vars['result']->value->start_period;?>
 ~ <?php echo $_smarty_tpl->tpl_vars['result']->value->end_period;?>
</td>
								<td style="width:200px; text-align:center;">
									 <button style="background-color: Transparent;border:0px;" onClick="MoveUp.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/up.svg" style="width: 25px;height:25px;"/>
									 <button style="background-color: Transparent;border:0px;" onClick="MoveDown.call(this);return false;"><img src="<?php echo @constant('HOME_DIR');?>
image/down.svg"  style="width: 25px;height:25px;"/>
								</td>
								<td style="width:30px; text-align:center;">
									<a href="javascript:moveToUpperTable('<?php echo $_smarty_tpl->tpl_vars['result']->value->rowno;?>
')">
									<img src="<?php echo @constant('HOME_DIR');?>
image/minus.svg" style="width:25px;height:25px;"/> </a>
									</td>
							</tr>
							<?php }?>
							<?php
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_3_saved_local_item;
}
if ($__foreach_result_3_saved_item) {
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_3_saved_item;
}
if ($__foreach_result_3_saved_key) {
$_smarty_tpl->tpl_vars['key'] = $__foreach_result_3_saved_key;
}
?>
						</tbody>
						<?php }?>
					</table>

					<table class="btn_div" style="text-align:right;width:100%;">
						<tr>
							<td>
								<input type="button" value="" class="btn_resetbtn" title="リセット"
								onclick="javascript:cancel('<?php echo $_smarty_tpl->tpl_vars['form']->value->course_detail_no;?>
','<?php echo @constant('HOME_DIR');?>
CourseDetailAssignment/index');">
								<input type="button" name="insert" value="" class="btn_insert" title="登録"
								onclick="javascript:insertCourseDetailAssignmentData();" />
							</td>
						</tr>
					</table>
				</section>
			</div>
			<!--footer-->
				<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!--footer-->
		</form>

		<?php echo '<script'; ?>
>
			

			//リセット
			function cancel(course_detail_no, action){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#main_form").attr("action", action);
				$("#course_detail_no").val(course_detail_no);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}

			//戻るボタン
			function doBack(action) {

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#main_form").attr("action", action);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#search_course_name").val(document.getElementById('search_course_name').value);
				$("#search_page").val(document.getElementById('search_page').value);
				$("#back_flg").val("true");

				$("#main_form").submit();
			}
			
		<?php echo '</script'; ?>
>
	</body>
</html><?php }
}
