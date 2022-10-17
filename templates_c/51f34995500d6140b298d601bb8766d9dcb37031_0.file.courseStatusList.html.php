<?php
/* Smarty version 3.1.29, created on 2022-10-17 05:24:32
  from "D:\xampp\htdocs\eccadmin_dev\templates\courseStatusList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_634ccaf053a752_89011945',
  'file_dependency' => 
  array (
    '51f34995500d6140b298d601bb8766d9dcb37031' => 
    array (
      0 => 'D:\\xampp\\htdocs\\eccadmin_dev\\templates\\courseStatusList.html',
      1 => 1567676359,
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
function content_634ccaf053a752_89011945 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>コース受講状況一覧</title>
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
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
CourseStatusList/Search" method="post">
			<input type="hidden" id="student_no" name="student_no"/>
			<input type="hidden" id="course_id" name="course_id" />
			<input type="hidden" id="course_detail_no" name="course_detail_no" />
			<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
			<input type="hidden" id="org_no" name="org_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_no;?>
" />
			<input type="hidden" id="offer_no" name="offer_no" />
			<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
			<input type="hidden" id="search_start_dt" name="search_start_dt" value="" />
			<input type="hidden" id="answer_flg" name="answer_flg" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->answer_flg;?>
" />
			<input type="hidden" id="status" name="status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->status;?>
" />
			<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
			<input type="hidden" id="search_org_id" name="search_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_org_id;?>
"/>
			<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
"/>
			<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
"/>
			<input type="hidden" id="search_detail_name" name="search_detail_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_detail_name, ENT_QUOTES, 'UTF-8', true);?>
"/>
			<input type="hidden" id="search_org_name" name="search_org_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->search_org_name, ENT_QUOTES, 'UTF-8', true);?>
"/>
			<input type="hidden" id="search_chk_status" name="search_chk_status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->chk_status;?>
"/>
			<input type="hidden" id="search_student_name" name="search_student_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->student_name;?>
"/>
			<input type="hidden" id="search_login_id" name="search_login_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->login_id;?>
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
				<div id="err_dis">
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
				</div>
				<section class="content">
					<p>
						><span class="title">SW 状況 / コース受講状況一覧</span>
					</p>
					<table class="main_tbl">
								<tr>
									<td class="st_col">受講者名</td>
									<td class="input"><input class="text" type="text" name="student_name" id="student_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->student_name;?>
" maxlength = "32" size="30"></td>
									<td width="10px"></td>
									<td>コース詳細名</td>
									<td class="input">
										<input class="text" type="text" name="detail_name" id="detail_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->detail_name;?>
" maxlength = "32" size="30">
									</td>
								</tr>
								<tr>
									<td>ログインID</td>
									<td class="input">
										<input class="text" type="text" name="login_id" id="login_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->login_id;?>
" maxlength = "20" size="30">
									</td>
									<td width="10px"></td>
									 <td>組織ID</td>
								    <td class="input">
                                        <input class="text" type="text" name="org_id" id="org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_id;?>
" maxlength = "10" size="10">
                                    </td>
								</tr>
								<tr>
									<td>状況</td>
									<td width="300px">
										<?php if ($_smarty_tpl->tpl_vars['form']->value->status == '0' || $_smarty_tpl->tpl_vars['form']->value->status == '') {?>
											<label><input type="radio" name="chk_status" value="3" id="chk_status" />未受講</label>
											<label><input type="radio" name="chk_status" value="0" id="chk_status" checked />未採点</label>
											<label><input type="radio" name="chk_status" value="1" id="chk_status" />採点済</label>
											<label><input type="radio" name="chk_status" value="2" id="chk_status" />すべて</label>
										<?php }?>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->status == 1) {?>
											<label><input type="radio" name="chk_status" value="3" id="chk_status" />未受講</label>
											<label><input type="radio" name="chk_status" value="0" id="chk_status" />未採点</label>
											<label><input type="radio" name="chk_status" value="1" id="chk_status" checked />採点済</label>
											<label><input type="radio" name="chk_status" value="2" id="chk_status" />すべて</label>
										<?php }?>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->status == 2) {?>
											<label><input type="radio" name="chk_status" value="3" id="chk_status" />未受講</label>
											<label><input type="radio" name="chk_status" value="0" id="chk_status" />未採点</label>
											<label><input type="radio" name="chk_status" value="1" id="chk_status" />採点済</label>
											<label><input type="radio" name="chk_status" value="2" id="chk_status" checked/>すべて</label>
										<?php }?>
										<?php if ($_smarty_tpl->tpl_vars['form']->value->status == 3) {?>
											<label><input type="radio" name="chk_status" value="3" id="chk_status" checked/>未受講</label>
											<label><input type="radio" name="chk_status" value="0" id="chk_status" />未採点</label>
											<label><input type="radio" name="chk_status" value="1" id="chk_status" />採点済</label>
											<label><input type="radio" name="chk_status" value="2" id="chk_status" />すべて</label>
										<?php }?>
									</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td class="st_col">コース詳細開始日</td>
									<td class="input" style="width:250px;"><input class="" type="text" name="start_period" id="start_period"
											value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
									<td width="10px"></td>
									<td class="st_col">コース詳細終了日</td>
									<td class="input"><input class="" type="text" name="end_period" id="end_period"
									 value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
								</tr>
							</table>
					<br/>
					<div align="right" style="width:100%">
					<input type="button" class="btn_search" onclick="doSearch()" title="検索" style="padding-right:50px;">
					</div>
					<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
						<div class="pagging" align="right">
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
						</div>

					<?php }?>
						<table class="tbl_search">
							<tr>
								<th width="150px">組織</th>
								<th width="100px">受講日</th>
								<th width="200px">コース名</th>
								<th width="200px">コース詳細名</th>
								<th width="100px">ログインID</th>
								<th width="150px">受講者名</th>
								<th width="100px">結果</th>
								<th class="td_img">Feedback</th>
							</tr>
							<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
								<?php
$_from = $_smarty_tpl->tpl_vars['list']->value;
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
									<td width="150px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->org_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
									<?php if (empty($_smarty_tpl->tpl_vars['result']->value->answer_dt)) {?>
										<td width="100px">-</td>
									<?php } else { ?>
										<td width="100px"><?php echo $_smarty_tpl->tpl_vars['result']->value->answer_dt;?>
</td>
									<?php }?>
									<td width="200px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->course_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
									<td width="200px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->course_detail_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
									<td width="100px"><?php echo $_smarty_tpl->tpl_vars['result']->value->login_id;?>
</td>
									<td width="150px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->student_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
									<td width="100px">
									<?php if ($_smarty_tpl->tpl_vars['result']->value->result_marks != '') {?>
										<?php echo $_smarty_tpl->tpl_vars['result']->value->result_marks;?>
/<?php echo $_smarty_tpl->tpl_vars['result']->value->total_marks;?>

									<?php } else { ?>
										-/<?php echo $_smarty_tpl->tpl_vars['result']->value->total_marks;?>

									<?php }?>
									</td>
									<td class="td_img">
										<?php if ($_smarty_tpl->tpl_vars['result']->value->result_marks != null && $_smarty_tpl->tpl_vars['result']->value->total_marks != 0) {?>
											<?php if ($_smarty_tpl->tpl_vars['result']->value->test_kbn == '001') {?>
												<input type="button" class="btn_confirm"
												onclick="marks('<?php echo $_smarty_tpl->tpl_vars['result']->value->course_id;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->course_detail_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->student_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->offer_no;?>
','<?php echo @constant('HOME_DIR');?>
SpeakingFeedbackList/index')">
											<?php } else { ?>
												<input type="button" class="btn_confirm"
												onclick="marks('<?php echo $_smarty_tpl->tpl_vars['result']->value->course_id;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->course_detail_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->student_no;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->offer_no;?>
','<?php echo @constant('HOME_DIR');?>
WritingFeedbackList/index')">
											<?php }?>
										<?php }?>
									</td>
								</tr>
								<?php
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_0_saved_local_item;
}
if ($__foreach_result_0_saved_item) {
$_smarty_tpl->tpl_vars['result'] = $__foreach_result_0_saved_item;
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
			

			//検索ボタン
			function doSearch(){

				var checkValue = checkValidation();

				if ( checkValue ){
					$("#page").val(1);
					$("#main_form").submit();
				}
			}

			function checkValidation(){

				$(".error_section").hide();
				$('#err_dis').hide();
				var end_period = document.getElementById('end_period').value;
				var start_period = document.getElementById('start_period').value;

				// 利用終了の必須チェック
				<!-- if ( end_period == "" ){ -->

					<!-- $('#err_dis').show(); -->
					<!-- $(".error_section").slideToggle('slow'); -->
					<!-- $(".error_msg").html("コース詳細終了日を入力してください。"); -->
					<!-- return false; -->
				<!-- } -->

				<!-- if ( start_period == "" ){ -->

					<!-- $('#err_dis').show(); -->
					<!-- $(".error_section").slideToggle('slow'); -->
					<!-- $(".error_msg").html("コース詳細開始日を入力してください。"); -->
					<!-- return false; -->
				<!-- } -->
			
				if ( start_period != "" &&  end_period != "" ){
					// 利用開始日 < 利用終了日チェック
					if ( start_period > end_period ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("コース詳細開始日 ≦ コース詳細終了日を正しく入力してください。");
						return false;
					}
				}
				return true;
			}

			//ページング
			function doPage(pageNo){

				var end_period = document.getElementById('end_period').value;
				var detail_name = document.getElementById('detail_name').value;
				var chk_status = document.getElementById('chk_status').value;
				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#page").val(pageNo);
				$("#detail_name").val(detail_name);
				$("#chk_status").val(chk_status);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}

			//フィードバックボタン処理
			function marks(course_id, course_detail_no, org_no, student_no, offer_no,  action){

				setSearchFormData();

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;
				$("#main_form").attr("action", action);
				$("#course_id").val(course_id);
				$("#course_detail_no").val(course_detail_no);
				$("#student_no").val(student_no);
				$("#org_no").val(org_no);
				$("#offer_no").val(offer_no);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}

			/**
			**  検索条件セットとフォーム
			**/
			function setSearchFormData(){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);

				$("#search_page").val($("#page").val());
				$("#search_org_id").val($("#org_id").val());
				$("#search_start_period").val($("#start_period").val());
				$("#search_end_period").val($("#end_period").val());
				$("#search_detail_name").val($("#detail_name").val());
				$("#search_chk_status").val("");

				var status_val = $('input[name=chk_status]:checked', '#main_form').val();
				$("#search_chk_status").val(status_val);
				$("#main_form").submit();
			}
		
	<?php echo '</script'; ?>
>
	</body>
</html><?php }
}
