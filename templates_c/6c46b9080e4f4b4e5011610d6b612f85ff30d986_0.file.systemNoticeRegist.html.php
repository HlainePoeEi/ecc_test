<?php
/* Smarty version 3.1.29, created on 2022-10-17 05:26:01
  from "D:\xampp\htdocs\eccadmin_dev\templates\systemNoticeRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_634ccb49e7b237_96739537',
  'file_dependency' => 
  array (
    '6c46b9080e4f4b4e5011610d6b612f85ff30d986' => 
    array (
      0 => 'D:\\xampp\\htdocs\\eccadmin_dev\\templates\\systemNoticeRegist.html',
      1 => 1547458228,
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
function content_634ccb49e7b237_96739537 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>お知らせ設定</title>
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
				$(".btn_insert").on('click', function(){

					$("#page").val(1);
					$(".error_section").hide();

					document.getElementById("target_Kbn").disabled = false;
					var start_period = document.getElementById('start_period').value;
					var end_period = document.getElementById('end_period').value;
					var description = document.getElementById('description').value;
					var target_Kbn = document.getElementById('target_Kbn').value;

					// 科目の必須チェック
					if ( target_Kbn == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("対象を一つ選択してください。");
						$('#err_dis')[0].focus();
						return false;
					}

					// 学年名の必須チェック
					if ( description == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("内容を入力してください。");
						$('#err_dis')[0].focus();
						return false;
					}

					// 利用開始日の必須チェック
					if ( start_period == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("利用開始日を入力してください。");
						$('#err_dis')[0].focus();
						return false;
					}

					// 利用終了日の必須チェック
					if ( end_period == "" ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("利用終了日を入力してください。");
						$('#err_dis')[0].focus();
						return false;
					}

					// 利用開始日 < 利用終了日チェック
					if ( start_period > end_period ){

						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("<?php echo @constant('W004');?>
");
						$('#err_dis')[0].focus();
						return false;
					}
					var isDisabled = $("#start_period").prop('disabled');
					var today = new Date();
					var dd = today.getDate();
					var mm = today.getMonth()+1; //January is 0!
					var yyyy = today.getFullYear();
					if ( dd < 10 ){
						dd = '0' + dd
					}
					if ( mm < 10 ){
						mm = '0' + mm
					}

					today = yyyy + '/' + mm + '/' + dd;
					if ( !isDisabled ){

						if ( start_period < today ){

							$('#err_dis').show();
							$(".error_section").slideToggle('slow');
							$(".error_msg").html("利用開始日は今日より以前の日付になっています。");
							$(".divBody").scrollTop(0);
							return false;
						}
					}
					document.getElementById("start_period").disabled = false;
					return true;
				});
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
SystemNoticeRegist/save" method="post">
			<input type="hidden" id="system_notice_no" name="system_notice_no" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->system_notice_no;?>
">
			<input type="hidden" id="system_kbn" name="system_kbn" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->system_kbn;?>
"/>
			<input type="hidden" id="reset_start_period" name="reset_start_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
">
			<input type="hidden" id="reset_end_period" name="reset_end_period" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
"/>
			<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
			<input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->page;?>
" />
			<input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->screen_mode;?>
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
				<div id="err_dis" tabindex="1">
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
						><span class="title">お知らせ / お知らせ設定</span>
					</p>
					<table class="main_tbl">
						<tr>
							<td>対象<span class="required">※</span></td>
							<td>
								<select name="target_Kbn" id="target_Kbn">
									<option value="">選択してください。</option>
									<?php if (!empty($_smarty_tpl->tpl_vars['targetKbn']->value)) {?>
										<?php
$_from = $_smarty_tpl->tpl_vars['targetKbn']->value;
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
											<?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['form']->value->system_kbn) {?>
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
								</select>
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td class="st_col">内容<span class="required">※</span></td>
							<td class="st_col" colspan="2">
								<textarea name="description" id="description" cols="40" maxlength = "1024" style="width : 100%; height : 60px; margin-top : 10px; overflow-y : scroll; resize : none;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->description, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
								<br>( 例：ただいまご利用できません。しばらくお待ちください。)
							</td>
							<td></td>
						</tr>
						<tr>
							<td class="st_col">利用開始日<span class="required">※</span></td>
							<td class="input" style="width:250px;"><input class="text" type="text" name="start_period" id="start_period"
									value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" maxlength="10" onchange="changeDateFormat(this)" style="height: 15px;"></td>
							<td class="st_col">利用終了日<span class="required">※</span></td>
							<td class="input"><input class="" type="text" name="end_period" id="end_period"
							 value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" maxlength="10" onchange="changeDateFormat(this)"></td>
						</tr>
					</table>
					<p style="text-align:right;">
						<input type="submit" name="btn_insert" title="登録" value="" class="btn_insert"  style="padding-right: 50px;">
						<input type="button" title="キャンセル" value="" class="btn_close" onclick="javascript:doClear()"  id="cancel" style="display:none">
					</p>
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
						<thead>
							<tr>
								<th width="100px">対象</th>
								<th width="300px">内容</th>
								<th width="200px">期間</th>
								<th width="150px">運用者名</th>
								<th class="td_img">編集</th>
							</tr>
						</thead>
						<tbody>
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
								<td width="100px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</td>
								<td width="300px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->description, ENT_QUOTES, 'UTF-8', true);?>
</td>
								<td width="200px"><?php echo $_smarty_tpl->tpl_vars['result']->value->start_period;?>
～<?php echo $_smarty_tpl->tpl_vars['result']->value->end_period;?>
</td>
								<td width="150px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value->admin_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
								<td class="td_edit">
									<input type="button" class="btn_edit" title="編集" onclick="edit_trans('<?php echo $_smarty_tpl->tpl_vars['result']->value->system_notice_no;?>
','<?php echo @constant('HOME_DIR');?>
SystemNoticeRegist/index')">
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
						</tbody>
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
			

			window.onload = function init() {

				var system_notice_no = document.getElementById('system_notice_no').value;

				var mode = document.getElementById('screen_mode').value;
				if( mode == 'update'){
					document.getElementById("target_Kbn").disabled = true;
					$("#cancel").css("display","none");
				}else{
					document.getElementById("target_Kbn").disabled = false;
					$("#cancel").css("display","");
				}

				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth()+1; //January is 0!
				var yyyy = today.getFullYear();
				if(dd<10) {
					dd = '0'+dd
				}
				if(mm<10) {
					mm = '0'+mm
				}
				today = yyyy + '/' + mm + '/' + dd;
				var start_period = document.getElementById('start_period').value;
				if(start_period < today){
					$( "#start_period" ).datepicker( "option", "disabled", true );
					document.getElementById("start_period").disabled = true;
				}
			}

			// ページング
			function doPage(pageNo){

				var home_dir = document.getElementById('home_dir').value;
				var screen_mode = document.getElementById('screen_mode').value;
				$("#screen_mode").val(screen_mode);
				$("#page").val(pageNo);
				$("#main_form").attr("action", home_dir+"SystemNoticeRegist/search");
				$("#main_form").submit();
			}

			// 編集ボタン処理
			function edit_trans(system_notice_no ,action){

				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;

				$("#main_form").attr("action", action);
				$("#menuOpen").val(menuOpen);
				$("#menuStatus").val(menuStatus);
				$("#system_notice_no").val(system_notice_no);

				$("#main_form").submit();
			}

			// キャンセルボタン処理
			function doClear(){

				var reset_start_period = document.getElementById('reset_start_period').value;
				var reset_end_period = document.getElementById('reset_end_period').value;

				$("#system_notice_no").val("");
				$("#target_Kbn").val("");
				$("#description").val("");
				$("#start_period").val(reset_start_period);
				$("#end_period").val(reset_end_period);
			}

		
		<?php echo '</script'; ?>
>
	</body>
</html><?php }
}
