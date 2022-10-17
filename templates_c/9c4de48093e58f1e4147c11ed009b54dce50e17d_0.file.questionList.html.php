<?php
/* Smarty version 3.1.29, created on 2022-10-13 11:48:11
  from "/var/www/html/eccadmin_dev/templates/questionList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_63477c6b510fb2_56958419',
  'file_dependency' => 
  array (
    '9c4de48093e58f1e4147c11ed009b54dce50e17d' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/questionList.html',
      1 => 1543569579,
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
function content_63477c6b510fb2_56958419 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/var/www/html/eccadmin_dev/libs/smarty/libs/plugins/modifier.truncate.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title> 問題一覧</title>
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
css/style.css" rel="stylesheet">
		<?php echo '<script'; ?>
 type="text/javascript">
			// エンターキー押下時のsubmitを無効化
			$(document).on("keypress", "input:not(.allow_submit)", function(event) {
				return event.which !== 13;
			});
			// エンターキー押下時のsubmitを無効化
			$(document).on("keypress", "select:not(.allow_submit)", function(event) {
				return event.which !== 13;
			});
			//表示再現
			$(document).ready(function() {

				// MSGのあるなし
				if ( $(".error_msg").html() != "" ){

					$(".error_section").slideToggle('slow')
				}

				$(".close_icon").on('click', function(){

					$(".error_section").slideToggle('slow')

				});
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
QuestionList/Search" method="post">
			<input type="hidden" id="question_no" name="question_no"/>
			<input type="hidden" id="screen_mode" name="screen_mode"/>
			<input type="hidden" id="back_flg" name="back_flg" value="true" />
			<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
			<input type="hidden" id="search_question_name" name="search_question_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_question_name, ENT_QUOTES, 'UTF-8', true);?>
"/>
			<input type="hidden" id="search_test_kbn" name="search_test_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_test_kbn;?>
"/>
			<input type="hidden" id="search_status" name="search_status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_status;?>
"/>
			<input type="hidden" id="search_course_level" name="search_course_level" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_course_level;?>
"/>
			<input type="hidden" id="status" name="status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->status;?>
">
			<input type="hidden" id="test_kbn" name="test_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->test_kbn;?>
">
			<input type="hidden" id="course_level" name="course_level" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->course_level;?>
">
			<input type="hidden" id="search_chk_status1" name="search_chk_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status1;?>
"/>
			<input type="hidden" id="search_chk_status2" name="search_chk_status2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status2;?>
"/>

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
								><span class="title">設定 / 問題一覧</span>
							</p>
							<table class="main_tbl" style="width:100%">
								<tr>
									<td>問題名</td>
									<td class="input"><input class="text" type="text"
										name="question_name" id="question_name"
										value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->question_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30"></td>
									<td width="10px"></td>
									<td>レベル</td>
									<td class="input">
										<?php if (!empty($_smarty_tpl->tpl_vars['form']->value->course_level_list)) {?>
											<?php
$_from = $_smarty_tpl->tpl_vars['form']->value->course_level_list;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_item_0_saved_item = isset($_smarty_tpl->tpl_vars['item']) ? $_smarty_tpl->tpl_vars['item'] : false;
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$__foreach_item_0_saved_local_item = $_smarty_tpl->tpl_vars['item'];
?>
												<?php if ((in_array($_smarty_tpl->tpl_vars['item']->value->type,$_smarty_tpl->tpl_vars['search_course_level']->value))) {?>
													<label><input type="checkbox" class="course_level" name="course_level" value='<?php echo $_smarty_tpl->tpl_vars['item']->value->type;?>
' checked><?php echo $_smarty_tpl->tpl_vars['item']->value->name;?>
</label>
												<?php } else { ?>
													<label><input type="checkbox" class="course_level" name="course_level" value='<?php echo $_smarty_tpl->tpl_vars['item']->value->type;?>
' ><?php echo $_smarty_tpl->tpl_vars['item']->value->name;?>
</label>
												<?php }?>
											<?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_0_saved_local_item;
}
if ($__foreach_item_0_saved_item) {
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_0_saved_item;
}
?>
										<?php }?>
									</td>
								</tr>
								<tr>
									<td>SW</td>
									<td class="input">
										<?php if (!empty($_smarty_tpl->tpl_vars['form']->value->test_kbn_list)) {?>
											<?php
$_from = $_smarty_tpl->tpl_vars['form']->value->test_kbn_list;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_item_1_saved_item = isset($_smarty_tpl->tpl_vars['item']) ? $_smarty_tpl->tpl_vars['item'] : false;
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$__foreach_item_1_saved_local_item = $_smarty_tpl->tpl_vars['item'];
?>
												<?php if ((in_array($_smarty_tpl->tpl_vars['item']->value->type,$_smarty_tpl->tpl_vars['search_test_kbn']->value))) {?>
													<label><input type="checkbox" class="test_kbn" name="test_kbn" value='<?php echo $_smarty_tpl->tpl_vars['item']->value->type;?>
' checked><?php echo $_smarty_tpl->tpl_vars['item']->value->name;?>
</label>
												<?php } else { ?>
													<label><input type="checkbox" class="test_kbn" name="test_kbn" value='<?php echo $_smarty_tpl->tpl_vars['item']->value->type;?>
' ><?php echo $_smarty_tpl->tpl_vars['item']->value->name;?>
</label>
												<?php }?>
											<?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_1_saved_local_item;
}
if ($__foreach_item_1_saved_item) {
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_1_saved_item;
}
?>
										<?php }?>
									</td>
									<td width="10px"></td>
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
							<br>
							<div align="right" style="width:100%">
								<input type="submit" id="btn_search" name="search" title="検索" class="btn_search" alt="search" value="" style="padding-right:50px;">
								<input type="button" id="add" name="add_question" class="btn_add" value="" title="新規追加" onclick="javascript:doInsert('<?php echo @constant('HOME_DIR');?>
QuestionRegist/index')">
							</div>

							<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
							<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
							<div class="pagging" >
								<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
									<?php if ($_smarty_tpl->tpl_vars['form']->value->max_page >= 4) {?>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->page > 1) {?>
											<a href="javascript:doPage(1);">&lt;&lt;&nbsp;</a>
											<a href="javascript:doPage(<?php echo $_smarty_tpl->tpl_vars['form']->value->page-1;?>
);">&lt;&nbsp;</a>
										<?php }?>
										<?php if ((($_smarty_tpl->tpl_vars['form']->value->page+3) == $_smarty_tpl->tpl_vars['form']->value->max_page) || (($_smarty_tpl->tpl_vars['form']->value->page+3) >= $_smarty_tpl->tpl_vars['form']->value->max_page)) {?>
											<?php
$__section_i_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__smarty_section_i'] : false;
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['form']->value->max_page+1) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_start = (int)@$_smarty_tpl->tpl_vars['form']->value->max_page-3 < 0 ? max(0, (int)@$_smarty_tpl->tpl_vars['form']->value->max_page-3 + $__section_i_0_loop) : min((int)@$_smarty_tpl->tpl_vars['form']->value->max_page-3, $__section_i_0_loop);
$__section_i_0_total = min(($__section_i_0_loop - $__section_i_0_start), $__section_i_0_loop);
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total != 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = $__section_i_0_start; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
												<?php if ($_smarty_tpl->tpl_vars['form']->value->page == (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)) {?>
													<label><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
</label>
												<?php } else { ?>
													<a href="javascript:doPage(<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
);"><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
</a>
												<?php }?>
											<?php
}
}
if ($__section_i_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_0_saved;
}
?>
										<?php } else { ?>
											<?php
$__section_i_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__smarty_section_i'] : false;
$__section_i_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['form']->value->page+4) ? count($_loop) : max(0, (int) $_loop));
$__section_i_1_start = (int)@$_smarty_tpl->tpl_vars['form']->value->page < 0 ? max(0, (int)@$_smarty_tpl->tpl_vars['form']->value->page + $__section_i_1_loop) : min((int)@$_smarty_tpl->tpl_vars['form']->value->page, $__section_i_1_loop);
$__section_i_1_total = min(($__section_i_1_loop - $__section_i_1_start), $__section_i_1_loop);
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_1_total != 0) {
for ($__section_i_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = $__section_i_1_start; $__section_i_1_iteration <= $__section_i_1_total; $__section_i_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
												<?php if ($_smarty_tpl->tpl_vars['form']->value->page == (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)) {?>
													<label><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
</label>
												<?php } else { ?>
													<a href="javascript:doPage(<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
);"><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
</a>
												<?php }?>
											<?php
}
}
if ($__section_i_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_1_saved;
}
?>
										<?php }?>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->page <= $_smarty_tpl->tpl_vars['form']->value->max_page-1) {?>
											<a href="javascript:doPage(<?php echo $_smarty_tpl->tpl_vars['form']->value->page+1;?>
);">&nbsp;&gt;</a>
											<a href="javascript:doPage(<?php echo $_smarty_tpl->tpl_vars['form']->value->max_page;?>
);">&nbsp;&gt;&gt;</a>
										<?php }?>
									<?php } else { ?>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->page > 1) {?>
											<a href="javascript:doPage(1);">&nbsp;&lt;&lt;</a>
											<a href="javascript:doPage(<?php echo $_smarty_tpl->tpl_vars['form']->value->page-1;?>
);">&nbsp;&lt;</a>
										<?php } else { ?>
											<a class="disable_link">&nbsp;&lt;</a>
										<?php }?>
										<?php
$__section_i_2_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__smarty_section_i'] : false;
$__section_i_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['form']->value->max_page+1) ? count($_loop) : max(0, (int) $_loop));
$__section_i_2_start = min(1, $__section_i_2_loop);
$__section_i_2_total = min(($__section_i_2_loop - $__section_i_2_start), $__section_i_2_loop);
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_2_total != 0) {
for ($__section_i_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = $__section_i_2_start; $__section_i_2_iteration <= $__section_i_2_total; $__section_i_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
											<?php if ($_smarty_tpl->tpl_vars['form']->value->page == (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)) {?>
												<label><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
</label>
											<?php } else { ?>
												<a href="javascript:doPage(<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
);"><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null);?>
</a>
											<?php }?>
										<?php
}
}
if ($__section_i_2_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_2_saved;
}
?>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->page <= $_smarty_tpl->tpl_vars['form']->value->max_page-1) {?>
											<a href="javascript:doPage(<?php echo $_smarty_tpl->tpl_vars['form']->value->page+1;?>
);">&nbsp;&gt;</a>
											<a href="javascript:doPage(<?php echo $_smarty_tpl->tpl_vars['form']->value->max_page;?>
);">&nbsp;&gt;&gt;</a>
										<?php } else { ?>
											<a class="disable_link">&nbsp;&gt;</a>
										<?php }?>
									<?php }?>
								</div>
								<table class="tbl_search">
										<tr>
											<th width="600px;">問題名</th>
											<th width="600px;">問題説明</th>
											<th width="300px;">SW</th>
											<th width="300px;">レベル</th>
											<th width="300px;">問題パターン</th>
											<th width="300px;">採点パターン</th>
											<th width="200px;">状況</th>
											<th width="100px;">編集</th>
											<th class="td_scroll_col">削除</th>
										</tr>
									<tbody>
										<?php
$_from = $_smarty_tpl->tpl_vars['list']->value;
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
											<td width="600px;"><?php echo smarty_modifier_truncate(htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->question_name, ENT_QUOTES, 'UTF-8', true),20,'...');?>
</td>
											<td width="600px;"><?php echo smarty_modifier_truncate(htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->qa_description, ENT_QUOTES, 'UTF-8', true),20,'...');?>
</td>
											<td width="300px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->test_kbn;?>
</td>
											<td width="300px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->course_level;?>
</td>
											<td width="300px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->qa_pattern;?>
</td>
											<td width="200px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->score_pattern;?>
</td>
											<td width="100px;"><?php echo $_smarty_tpl->tpl_vars['result']->value->status;?>
</td>
											<td class="td_img">
												<input type="button" class="btn_edit" name="edit" onclick="trans('<?php echo $_smarty_tpl->tpl_vars['result']->value->question_no;?>
','<?php echo @constant('HOME_DIR');?>
QuestionRegist/index')">
											</td>
											<td class="td_img">
												<input type="button" class="btn_delete" title="削除" name="delete" onclick="delete_trans('<?php echo $_smarty_tpl->tpl_vars['result']->value->question_no;?>
','<?php echo @constant('HOME_DIR');?>
QuestionList/delete')">
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
								</table>
							<?php }?>
						</section>
					</div>
				</div>
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
		
			// ページング
			function doPage(pageNo){

				parameterAssign();
				$("#page").val(pageNo);
				$("#main_form").submit();
			}

			// 登録ボタン処理
			function doInsert(action){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;
				parameterAssign();
				$("#search_page").val($("#page").val());
				$("#search_question_name").val($("#question_name").val());
				$("#search_status").val($("#status").val());
				$("#search_chk_status1").val("");

				if ( $("#chk_status1").prop('checked') ){
					$("#search_chk_status1").val(1);
				}

				$("#search_chk_status2").val("");
				if ( $("#chk_status2").prop('checked') ){
					$("#search_chk_status2").val(1);
				}

				$("#main_form").attr("action", action);
				$("#screen_mode").val("update");
				$("#question_no").val(question_no);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#main_form").submit();

				$("#main_form").attr("action", action);
				$("#screen_mode").val("new");
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}

			// 更新ボタン処理
			function trans(question_no,action){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;
				
				$("#search_page").val($("#page").val());
				$("#search_question_name").val($("#question_name").val());
				$("#search_status").val($("#status").val());
				$("#search_chk_status1").val("");

				if ( $("#chk_status1").prop('checked') ){
					$("#search_chk_status1").val(1);
				}

				$("#search_chk_status2").val("");
				if ( $("#chk_status2").prop('checked') ){
					$("#search_chk_status2").val(1);
				}
				parameterAssign();
				$("#main_form").attr("action", action);
				$("#screen_mode").val("update");
				$("#question_no").val(question_no);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}

			// 削除ボタン処理
			function delete_trans(question_no, action){

				var result = confirm("削除します。よろしいでしょうか");
				if ( result ){
					//はいを選んだときの処理
					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;
					parameterAssign();
					$("#search_page").val($("#page").val());
					$("#search_question_name").val($("#question_name").val());
					$("#search_status").val($("#status").val());
					$("#search_chk_status1").val("");
					$("#main_form").attr("action", action);
					$("#menuOpen").val(menuOpen);
					$("#menuStatus").val(menuStatus);
					$("#question_no").val(question_no);
					$("#main_form").submit();
				}
			}

			// パラメータを設定する
			function parameterAssign(){
				var $status = "";

				if ( $('#chk_status1').prop('checked') === true ){

					if ( $status == "" ){
						$status = $('#chk_status1').attr('value');
					}else {
						$status += $('#chk_status1').attr('value');
					}
				}

				if ( $('#chk_status2').prop('checked') === true ){

					if ( $status == "" ){
						$status = $('#chk_status2').attr('value');
					}else {
						$status += ',' + $('#chk_status2').attr('value');
					}
				}

				$('#status').val($status);

				var test_kbn_list = '';
				var test_kbn_count = $("input.test_kbn:checked").length;
				var count = 0;
				$("#search_test_kbn").val("");
				$("#search_course_level").val("");

				$('input.test_kbn:checked').each(function() {
					count++;
					test_kbn_list += $(this).val();

					if ( count < test_kbn_count ){
						test_kbn_list += ",";
					}
				});
				$("#search_test_kbn").val(test_kbn_list);

				count = 0;
				var course_level_count = $("input.course_level:checked").length;
				var course_level_list = '';

				$('input.course_level:checked').each(function() {
					count++;
					course_level_list += $(this).val();

					if ( count < course_level_count ){
						course_level_list += ",";
					}
				});
				$("#search_course_level").val(course_level_list);
				$('#page').val(1);
			}

			$("#btn_search").on('click',function(){
					parameterAssign();
					return true;
			});

		
	<?php echo '</script'; ?>
>

	<!--footer-->
	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	<!--footer-->

	</body>
</html><?php }
}
