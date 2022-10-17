<?php
/* Smarty version 3.1.29, created on 2022-10-13 11:40:45
  from "/var/www/html/eccadmin_dev/templates/organizationList.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_63477aad88f223_41667495',
  'file_dependency' => 
  array (
    '9bcf6e91e1539bec0874d315d276199e4e716cd9' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/organizationList.html',
      1 => 1654756097,
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
function content_63477aad88f223_41667495 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>組織一覧</title>
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

			function check(){

				if ( $('#chk_status1').is(':checked') ){

					$('#chk_status1').prop('checked', true);  // checked
				}else {
					$('#chk_status1').prop('checked', false);
				}

				if ( $('#chk_status2').is(':checked') ){
					$('#chk_status2').prop('checked', true);  // checked
				}else {
					$('#chk_status2').prop('checked', false);
				}

				if ( $('#chk_status3').is(':checked') ){
					$('#chk_status3').prop('checked', true);  // checked
				}else {
					$('#chk_status3').prop('checked', false);
				}
			}
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

				check();
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
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
OrganizationList/search" method="post">
			<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
			<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
			<input type="hidden" id="status" name="status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->status;?>
" />
			<input type="hidden" id="screen_mode" name="screen_mode"/>
			<input type="hidden" id="org_no" name="org_no"/>
			<input type="hidden" id="org_start_date" name="org_start_date"/>
			<input type="hidden" id="org_end_date" name="org_end_date"/>
			<input type="hidden" id="organization_no" name="organization_no"/>
			<input type="hidden" id="btn_flag" name="btn_flag"/>
			<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
			<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_end_period;?>
"/>
			<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_start_period;?>
"/>
			<input type="hidden" id="search_org_name" name="search_org_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_name, ENT_QUOTES, 'UTF-8', true);?>
"/>
			<input type="hidden" id="search_chk_status" name="search_chk_status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status;?>
"/>
			<input type="hidden" id="search_chk_status1" name="search_chk_status1" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status1;?>
"/>
			<input type="hidden" id="search_chk_status2" name="search_chk_status2" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status2;?>
"/>
			<input type="hidden" id="search_chk_status3" name="search_chk_status3" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_chk_status3;?>
"/>
			<input type="hidden" id="show_org_id" name="show_org_id"/>
			<input type="hidden" id="show_org_name" name="show_org_name"/>
			<input type="hidden" id="show_org_kana" name="show_org_kana"/>
			<input type="hidden" id="show_org_official" name="show_org_official"/>
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
						><span class="title">組織 / 組織一覧</span>
					</p>
					<table class="main_tbl">
						<tr>
							<td class="st_col">利用期間(From)<span class="required">※</span></td>
							<td class="input" style="width:250px;"><input class="" type="text" name="start_period" id="start_period"
									value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
							<td width="10px"></td>
							<td class="st_col">(To)<span class="required">※</span></td>
							<td class="input"><input class="" type="text" name="end_period" id="end_period"
									value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
						</tr>
						<tr>
							<td>組織名</td>
							<td class="input">
								<input class="text" type="text" name="org_name" id="org_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_name, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "32" size="30">
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>有償区分</td>
							<td width="300px">
								<?php if (($_smarty_tpl->tpl_vars['form']->value->chk_status1 != '')) {?>
		 						    <label><input type="checkbox" id="chk_status1" name="chk_status1" value="001" checked>有償</label>
								<?php } else { ?>
									<label><input type="checkbox" id="chk_status1" name="chk_status1" value="001">有償</label>
								<?php }?>
								<?php if (!empty($_smarty_tpl->tpl_vars['form']->value->chk_status2 != '')) {?>
		 							<label><input type="checkbox" id="chk_status2" name="chk_status2" value="002" checked>利益移動</label>
								<?php } else { ?>
									<label><input type="checkbox" id="chk_status2" name="chk_status2" value="002">利益移動</label>
								<?php }?>
								<?php if (!empty($_smarty_tpl->tpl_vars['form']->value->chk_status3 != '')) {?>
		 							<label><input type="checkbox" id="chk_status3" name="chk_status3" value="003" checked>無償</label>
								<?php } else { ?>
									<label><input type="checkbox" id="chk_status3" name="chk_status3" value="003">無償</label>
								<?php }?>
							</td>
							<td></td>
							<td></td>
						</tr>
					</table>
					<br/>
					<div align="right" style="width:100%">
						<input type="button" class="btn_search" onclick="doSearch()" title="検索" style="padding-right:50px;">
						<input type="button" id="add" name="add_org" title="新規追加" class="btn_add" onclick="javascript:doInsert('<?php echo @constant('HOME_DIR');?>
OrganizationRegist/index')">
					</div>
					<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
						<div class="pagging" align="right">
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
					<?php }?>
					<table class="tbl_search">
						<tr>
							<th width="150px">組織管理番号</th>
							<th width="140px">組織コード</th>
							<th width="305px">組織名</th>
							<th width="300px">ふりがな</th>
							<th width="100px">有償区分</th>
							<th width="250px">利用期間</th>
							<th width="90px">メニュー設定</th>
							<th width="90px">学年設定</th>
							<th width="80px">管理者</th>
							<th class="td_img">編集</th>
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
								<td width="150px"><?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
</td>
								<td width="140px"><?php echo $_smarty_tpl->tpl_vars['result']->value->org_id;?>
</td>
								<td width="300px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->org_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
								<td width="320px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->org_name_kana, ENT_QUOTES, 'UTF-8', true);?>
</td>
								<td width="100px"><?php echo $_smarty_tpl->tpl_vars['result']->value->org_kbn;?>
</td>
								<td width="250px"><?php echo $_smarty_tpl->tpl_vars['result']->value->start_period;?>
 ~ <?php echo $_smarty_tpl->tpl_vars['result']->value->end_period;?>
</td>
								<td class="td_img">
									<input type="button" class="btn_setting" title="メニュー設定" onclick="grade('<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
', '<?php echo @constant('HOME_DIR');?>
MenuSettingRegist/index')">
								</td>
								<td class="td_img">
									<input type="button" class="btn_setting" title="学年設定" onclick="grade('<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
', '<?php echo @constant('HOME_DIR');?>
GradeRegist/index')">
								</td>
								<td class="td_img">
									<input type="button" class="btn_mng_assign_list" title="管理者設定" onclick="admin('<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
', '<?php echo $_smarty_tpl->tpl_vars['result']->value->org_id;?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value->org_name;?>
', '<?php echo $_smarty_tpl->tpl_vars['result']->value->org_name_kana;?>
', '<?php echo $_smarty_tpl->tpl_vars['result']->value->org_name_official;?>
', '<?php echo $_smarty_tpl->tpl_vars['result']->value->start_period;?>
', '<?php echo $_smarty_tpl->tpl_vars['result']->value->end_period;?>
', '<?php echo @constant('HOME_DIR');?>
ManagerRegist/index')">
								</td>
								<td class="td_img">
									<input type="button" class="btn_edit" title="編集" onclick="edit('<?php echo $_smarty_tpl->tpl_vars['result']->value->org_no;?>
', '<?php echo @constant('HOME_DIR');?>
OrganizationRegist/index')">
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
			function doSearch() {

				var checkValue = checkValidation();

				if ( checkValue ){

					var $checked_status = "";
					if ($('#chk_status1').prop('checked') === true){

						if ($checked_status == ""){

							$checked_status = $('#chk_status1').attr('value');
						}else {

							$checked_status += $('#chk_status1').attr('value');
						}
					}

					if ($('#chk_status2').prop('checked') === true){

						if ( $checked_status == "" ){

							$checked_status = $('#chk_status2').attr('value');
						}else {

							$checked_status += ',' + $('#chk_status2').attr('value');
						}
					}

					if ( $('#chk_status3').prop('checked') === true ){

						if ( $checked_status == "" ){
							$checked_status = $('#chk_status3').attr('value');
						}else {
							$checked_status += ',' + $('#chk_status3').attr('value');
						}
					}

					$('#status').val($checked_status);
					$("#page").val(1);
					$("#main_form").submit();
				}
			}

			function checkValidation() {

				$(".error_section").hide();
				$('#err_dis').hide();
				var start_period = document.getElementById('start_period').value;
				var end_period = document.getElementById('end_period').value;

				// 利用期間(From)の必須チェック
				if ( start_period == "" ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("利用期間(From)を入力してください。");
					return false;
				}

				// 利用期間(To)の必須チェック
				if ( end_period == "" ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("利用期間(To)を入力してください。");
					return false;
				}

				// 利用期間(From) ≦ 利用期間(To)チェック
				if ( start_period > end_period ){

					$('#err_dis').show();
					$(".error_section").slideToggle('slow');
					$(".error_msg").html("<?php echo @constant('W004');?>
");
					return false;
				}

				return true;
			}

			//ページング
			function doPage(pageNo) {

				var end_period = document.getElementById('end_period').value;
				var org_name = document.getElementById('org_name').value;
				var status = document.getElementById('status').value;
				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#page").val(pageNo);
				$("#org_name").val(org_name);
				$("#status").val(status);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#main_form").submit();
			}

			// 編集ボタン処理
			function edit(org_no, action) {

				$("#main_form").attr("action", action);
				$("#screen_mode").val('update');
				$("#org_no").val(org_no);

				setSearchFormData();
			}

			// 新規登録ボタン処理
			function doInsert(action){

				$("#main_form").attr("action", action);
				$("#screen_mode").val('new');

				setSearchFormData();
			}

			/**
			**  検索条件セットとフォーム
			**/
			function setSearchFormData() {

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#search_page").val($("#page").val());
				$("#search_start_period").val($("#start_period").val());
				$("#search_end_period").val($("#end_period").val());
				$("#search_org_name").val($("#org_name").val());
				$("#search_chk_status").val($("#status").val());

				$("#search_chk_status1").val("");
				if ( $("#chk_status1").prop('checked') ){
					$("#search_chk_status1").val(1);
				}

				$("#search_chk_status2").val("");
				if ( $("#chk_status2").prop('checked') ){
					$("#search_chk_status2").val(1);
				}

				$("#search_chk_status3").val("");
				if ( $("#chk_status3").prop('checked') ){
					$("#search_chk_status3").val(1);
				}
				$("#main_form").submit();
			}

			// 管理者ボタン処理
			function admin(org_no, org_id, org_name, org_kana, org_off, start_period, end_period, action) {

				$("#main_form").attr("action", action);
				$("#organization_no").val(org_no);
				$("#show_org_id").val(org_id);
				$("#show_org_name").val(org_name);
				$("#show_org_kana").val(org_kana);
				$("#show_org_official").val(org_off);
				$("#org_start_date").val(start_period);
				$("#org_end_date").val(end_period);
				$("#btn_flag").val('1');

				setSearchFormData();
			}

			// 学年設定ボタン処理
			function grade(org_no, action) {

				$("#main_form").attr("action", action);
				$("#screen_mode").val('update');
				$("#org_no").val(org_no);

				setSearchFormData();
			}

			
		<?php echo '</script'; ?>
>
	</body>
</html><?php }
}
