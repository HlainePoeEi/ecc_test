<?php
/* Smarty version 3.1.29, created on 2022-10-17 05:25:14
  from "D:\xampp\htdocs\eccadmin_dev\templates\teacherList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_634ccb1a74c012_70366414',
  'file_dependency' => 
  array (
    '4367f55eab5bf1b8d5f17e6e5915562ab463c978' => 
    array (
      0 => 'D:\\xampp\\htdocs\\eccadmin_dev\\templates\\teacherList.html',
      1 => 1547458668,
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
function content_634ccb1a74c012_70366414 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>講師一覧</title>
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
		
		<link href="<?php echo @constant('HOME_DIR');?>
css/jquery-ui.css" rel="stylesheet">
		<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">

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

				$(function() {
					$('#start_period').datepicker({
						showOn : "button",
						buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
						dateFormat: 'yy/mm/dd',
						buttonImageOnly : true,

						beforeShow: function (input, inst) {
							setTimeout(function () {
								var leftWidth=($('.pushmenu-open').length>0)?$('#start_period').offset().left-$('.pushmenu-open')[0].offsetWidth
										:$('#start_period').offset().left;
								inst.dpDiv.css({
									top: $('#start_period').offset().top + 35,
									left: leftWidth
								});
							}, 0);
						}
					});

				});

				$(function() {
					$('#end_period').datepicker({
						showOn : "button",
						buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
						dateFormat: 'yy/mm/dd',
						buttonImageOnly : true,

						beforeShow: function (input, inst) {

							setTimeout(function () {
								var leftWidth=($('.pushmenu-open').length>0)?$('#end_period').offset().left-$('.pushmenu-open')[0].offsetWidth
										:$('#end_period').offset().left;
								inst.dpDiv.css({
									top: $('#end_period').offset().top + 35,
									left: leftWidth
								});
							}, 0);
						}
					});
				});

				// MSGのあるなし
				if ( $(".error_msg").html() != "" ){

					$(".error_section").slideToggle('slow')
				}

				$(".close_icon").on('click', function(){

					$(".error_section").slideToggle('slow')

					$('#err_dis').slideToggle('slow')

				});

				/* ラジオボタンのチェック変更イベント */
				$('#main_form input').on('change', function() {
					var status_val = $('input[name=chk_status]:checked', '#main_form').val();
					$("#status").val(status_val);
					$("#answer_flg").val(status_val);
				});

				 /**
				 *
				 *  検索ボタン押下、必須チェック処理
				 *
				 **/
				$("#btn_search").on('click', function(){

					$("#page").val(1);
					$(".error_section").hide();

					var start_period = document.getElementById('start_period').value;
					var end_period = document.getElementById('end_period').value;

					// 利用開始の必須チェック
					if ( start_period == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("利用開始日を入力してください。");
						return false;
					}

					// 利用終了の必須チェック
					if ( end_period == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("利用終了日を入力してください。");
						return false;
					}

					// 利用開始 < 利用終了チェック
					if ( start_period > end_period ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("<?php echo @constant('W004');?>
");
						return false;
					}

					prepareCheckboxData();
					return true;
			 	});

				$('.btn_add').on('click',function(){

					$(this).val('').attr('disabled','disabled');
					return true;
				});

				$('.btn_edit').on('click',function(){

					$(this).val('').attr('disabled','disabled');
					return true;
				});

				$('#btn_assign').on('click',function(){

					$(this).val('').attr('disabled','disabled');
					return true;
				});

			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
TeacherList/Search" method="post">
			<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
			<input type="hidden" id="offer_no" name="offer_no" />
			<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
			<input type="hidden" id="search_name" name="search_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_name;?>
" />
			<input type="hidden" id="search_start_dt" name="search_start_dt" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
" />
			<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
			<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
"/>
			<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
"/>
			<input type="hidden" id="search_school_kbn" name="search_school_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_school_kbn;?>
" />
			<input type="hidden" id="teacher_no" name="teacher_no" />
			<input type="hidden" id="login_id" name="login_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->login_id;?>
" />
			<input type="hidden" id="t_name" name="t_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->t_name;?>
" />
			<input type="hidden" id="nick_name" name="nick_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->nick_name;?>
" />
			<input type="hidden" id="display_name" name="display_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->display_name;?>
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
image/close_icon.png" style="width:15px;float:right" class="close_icon">
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
						><span class="title">講師 / 講師一覧</span>
					</p>
					<table class="main_tbl">
						<tr>
							<td class="st_col">利用開始日<span class="required">※</span></td>
							<td class="input" style="width:250px;"><input class="" type="text" name="start_period" id="start_period"
							value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
							<td width="10px"></td>
							<td class="st_col">利用終了日<span class="required">※</span></td>
							<td class="input"><input class="" type="text" name="end_period" id="end_period"
							value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
						</tr>
						<tr>
							<td>氏名</td>
							<td class="input">
								<input class="text" type="text" name="teacher_name" id="teacher_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->teacher_name;?>
" maxlength = "32" size="30">
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>所属校舎</td>
							<td class="input">
								<?php if (!empty($_smarty_tpl->tpl_vars['school_kbn']->value)) {?>
									<?php
$_from = $_smarty_tpl->tpl_vars['school_kbn']->value;
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
										<?php if ((in_array($_smarty_tpl->tpl_vars['item']->value->type,$_smarty_tpl->tpl_vars['search_school_kbn']->value))) {?>
											<label><input type="checkbox" class="school_kbn" name="school_kbn" value='<?php echo $_smarty_tpl->tpl_vars['item']->value->type;?>
' checked><?php echo $_smarty_tpl->tpl_vars['item']->value->name;?>
</label>
										<?php } else { ?>
											<label><input type="checkbox" class="school_kbn" name="school_kbn" value='<?php echo $_smarty_tpl->tpl_vars['item']->value->type;?>
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
							<td></td>
							<td></td>
						</tr>
					</table>
					<br/>
					<div align="right" style="width:100%">
						<input type="submit" id="btn_search" name="search" title="検索" class="btn_search" alt="search" value="" style="padding-right:50px;">
						<input type="button" id="add" name="add_test" class="btn_add" value="" title="新規登録" onclick="javascript:doInsert('<?php echo @constant('HOME_DIR');?>
TeacherRegist/index')">
					</div>
					<div class="pagging" align="right">
						<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
							<?php if ($_smarty_tpl->tpl_vars['form']->value->max_page >= 4) {?>
								<?php if ($_smarty_tpl->tpl_vars['form']->value->page > 1) {?>
									<a href="javascript:doPage(1);">&lt;&lt;</a>
									<a href="javascript:doPage(<?php echo $_smarty_tpl->tpl_vars['form']->value->page-1;?>
);">&lt;</a>
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
);">&gt;</a>
									<a href="javascript:doPage(<?php echo $_smarty_tpl->tpl_vars['form']->value->max_page;?>
);">&gt;&gt;</a>
								<?php }?>
							<?php } else { ?>
								<?php if ($_smarty_tpl->tpl_vars['form']->value->page > 1) {?>
									<a href="javascript:doPage(1);">&lt;&lt;</a>
									<a href="javascript:doPage(<?php echo $_smarty_tpl->tpl_vars['form']->value->page-1;?>
);">&lt;</a>
								<?php } else { ?>
									<a class="disable_link">&lt;</a>
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
);">&gt;</a>
									<a href="javascript:doPage(<?php echo $_smarty_tpl->tpl_vars['form']->value->max_page;?>
);">&gt;&gt;</a>
								<?php } else { ?>
									<a class="disable_link">&gt;</a>
								<?php }?>
							<?php }?>
						<?php }?>
					</div>
						<table class="tbl_search">
							<tr>
								<th width="100px">講師コード</th>
								<th width="130px">氏名</th>
								<th width="130px">ニックネーム</th>
								<th width="130px">講師表示名</th>
								<th width="130px">所属校舎</th>
								<th class="td_period">利用期間</th>
								<th class="td_img">コース詳細割当</th>
								<th class="td_img">編集</th>
							</tr>
							<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
								<?php
$_from = $_smarty_tpl->tpl_vars['list']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_result_1_saved_item = isset($_smarty_tpl->tpl_vars['result']) ? $_smarty_tpl->tpl_vars['result'] : false;
$_smarty_tpl->tpl_vars['result'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['result']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['result']->value) {
$_smarty_tpl->tpl_vars['result']->_loop = true;
$__foreach_result_1_saved_local_item = $_smarty_tpl->tpl_vars['result'];
?>
								<tr>
									<td width="100px"><?php echo $_smarty_tpl->tpl_vars['result']->value->login_id;?>
</td>
									<td width="130px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</td>
									<td width="130px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->nickname, ENT_QUOTES, 'UTF-8', true);?>
</td>
									<td width="130px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->display_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
									<td width="130px"><?php echo $_smarty_tpl->tpl_vars['result']->value->school_kbn;?>
</td>
									<td class="td_period"><?php echo $_smarty_tpl->tpl_vars['result']->value->start_period;?>
 ~ <?php echo $_smarty_tpl->tpl_vars['result']->value->end_period;?>
</td>
									<td class="td_img">
										<input type="button" class="btn_qa_assign" id ="btn_assign" title="コース詳細割当" name="btn_quizassign" onclick="assign('<?php echo $_smarty_tpl->tpl_vars['result']->value->teacher_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->login_id;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->name;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->nickname;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->display_name;?>
','<?php echo @constant('HOME_DIR');?>
TeacherCourseDetailAssignment/index')">
									</td>
									<td class="td_img">
										<input type="button" class="btn_edit" title="編集" name="edit" onclick="edit_trans('<?php echo $_smarty_tpl->tpl_vars['result']->value->teacher_no;?>
','<?php echo @constant('HOME_DIR');?>
TeacherRegist/index')">
									</td>
								</tr>
								<?php
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_1_saved_local_item;
}
if ($__foreach_result_1_saved_item) {
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_1_saved_item;
}
?>
							<?php }?>
						</table>
						<br>
				</section>
			</div>
			<!--footer-->
				<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!--footer-->
		</form>

		<?php echo '<script'; ?>
>
			

				function prepareCheckboxData(){

					var school_kbn_list = '';
					var school_kbn_count = $("input.school_kbn:checked").length;
					var count = 0;
					$("#search_school_kbn").val("");

					$('input.school_kbn:checked').each(function() {
						count++;
						school_kbn_list += $(this).val();

						if ( count < school_kbn_count ){
							school_kbn_list += ",";
						}
					});
					$("#search_school_kbn").val(school_kbn_list);
				}

				// ページング
				function doPage(pageNo){

					prepareCheckboxData();

					$("#page").val(pageNo);
					$("#main_form").submit();
				}

				// コース詳細割当ボタン処理
				function assign(teacher_no, login_id, name, nickname,display_name, action){

					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;

					$("#search_page").val($("#page").val());
					$("#search_start_period").val($("#start_period").val());
					$("#search_end_period").val($("#end_period").val());
					$("#search_name").val($("#teacher_name").val());

					prepareCheckboxData();

					$("#menuOpen").val(menuOpen);
					$("#menuStatus").val(menuStatus);
					$("#teacher_no").val(teacher_no);
					$("#login_id").val(login_id);
					/* $("#teacher_name").val(name); */
					$("#nickname").val(nickname);
					$("#t_name").val(name);
					$("#nick_name").val(nickname);
					$("#display_name").val(display_name);
					$("#main_form").attr("action", action);
					$("#main_form").submit();
				}

				// 編集ボタン処理
				function edit_trans(teacher_no, action){

					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;


					$("#search_page").val($("#page").val());
					$("#search_start_period").val($("#start_period").val());
					$("#search_end_period").val($("#end_period").val());
					$("#search_name").val($("#teacher_name").val());

					prepareCheckboxData();

					$("#main_form").attr("action", action);
					$("#menuOpen").val(menuOpen);
					$("#menuStatus").val(menuStatus);
					$("#teacher_no").val(teacher_no);
					$("#main_form").submit();
				}

				// 登録ボタン処理
				function doInsert(action){

					prepareCheckboxData();

					var menuOpen = document.getElementById('menuOpen').value;
					var menuStatus = document.getElementById('menuStatus').value;

					$("#search_page").val($("#page").val());
					$("#search_start_period").val($("#start_period").val());
					$("#search_end_period").val($("#end_period").val());
					$("#search_name").val($("#teacher_name").val());
					$("#teacher_no").val("");
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
