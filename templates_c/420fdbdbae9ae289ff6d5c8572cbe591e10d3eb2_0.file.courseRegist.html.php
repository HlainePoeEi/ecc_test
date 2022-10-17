<?php
/* Smarty version 3.1.29, created on 2022-06-08 17:36:33
  from "/var/www/html/eccadmin_dev/templates/courseRegist.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_62a05f91490866_57938924',
  'file_dependency' => 
  array (
    '420fdbdbae9ae289ff6d5c8572cbe591e10d3eb2' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/courseRegist.html',
      1 => 1550571134,
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
function content_62a05f91490866_57938924 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>コース登録</title>
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
									left: leftWidth
								});
							}, 0);
						}
					});
				});

				var mode = document.getElementById('screen_mode').value;
				if( mode == 'update'){
					document.getElementById("course_level").disabled = true;
					document.getElementById("test_kbn").disabled = true;
				}else{
					document.getElementById("course_level").disabled = false;
					document.getElementById("test_kbn").disabled = false;
				}

				$(".btn_insert").on('click', function() {

					$(".error_section").hide();
					$('#err_dis').hide();
					document.getElementById("course_level").disabled = false;
					document.getElementById("test_kbn").disabled = false;
					var course_name = document.getElementById('course_name').value;
					var course_name_romaji = document.getElementById('course_name_romaji').value;
					var start_period = document.getElementById('start_period').value;
					var end_period = document.getElementById('end_period').value;
					var courseLevel = document.getElementById('course_level').value;
					var testKbn = document.getElementById('test_kbn').value;

					// コース名の必須チェック
					if ( course_name == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("コース名を入力してください。");
						return false;
					}

					// コース名の文字数チェック
					if ( course_name.length > 32 ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("コース名は32字で入力してください。");
						return false;
					}

					// 読みの必須チェック
					if ( course_name_romaji == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("コース名（英語）を入力してください。");
						return false;
					}

					// 読みの文字数チェック
					if ( course_name_romaji.length > 32 ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("コース名（英語）は32字で入力してください。");
						return false;
					}

					// 科目の必須チェック
					if ( courseLevel == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("コースレベルを一つ選択してください。");
						return false;
					}

					// テスト区分の必須チェック
					if ( testKbn == "" ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("テスト区分を一つ選択してください。");
						return false;
					}

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

					// 利用開始 < 利用終了 をチェック
					if ( start_period > end_period ){
						$('#err_dis').show();
						$(".error_section").slideToggle('slow');
						$(".error_msg").html("<?php echo @constant('W004');?>
");
						return false;
					}

					return true;
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
CourseRegist/save" method="post">
			<input type="hidden" id="back_flg" name="back_flg" value="false" />
			<input type="hidden" id="course_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->course_id;?>
" name="course_id"/>
			<input type="hidden" id="search_page" name="search_page" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_page;?>
"/>
			<input type="hidden" id="search_end_period" name="search_end_period" value="<?php echo $_smarty_tpl->tpl_vars['search_end_period']->value;?>
"/>
			<input type="hidden" id="search_start_period" name="search_start_period" value="<?php echo $_smarty_tpl->tpl_vars['search_start_period']->value;?>
"/>
			<input type="hidden" id="reset_end_period" name="reset_end_period" value="<?php echo $_smarty_tpl->tpl_vars['reset_end_period']->value;?>
"/>
			<input type="hidden" id="reset_start_period" name="reset_start_period" value="<?php echo $_smarty_tpl->tpl_vars['reset_start_period']->value;?>
"/>
			<input type="hidden" id="search_course_name" name="search_course_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['search_course_name']->value, ENT_QUOTES, 'UTF-8', true);?>
"/>
			<input type="hidden" id="search_status" name="search_status" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->search_status;?>
" />
			<input type="hidden" id="error_msg" name="error_msg" value="<?php echo $_smarty_tpl->tpl_vars['error_msg']->value;?>
"/>
			<input type="hidden" id="info_msg" name="info_msg" value="<?php echo $_smarty_tpl->tpl_vars['info_msg']->value;?>
"/>
			<input type="hidden" id="type" name="type" value="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
"/>
			<input type="hidden" id="ctype" name="ctype" value="<?php echo $_smarty_tpl->tpl_vars['ctype']->value;?>
"/>
			<input type="hidden" id="screen_mode" name="screen_mode" value="<?php echo $_smarty_tpl->tpl_vars['screen_mode']->value;?>
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
					<p>><span class="title">コース /コース登録</span></p>
					<p style="text-align:right"><input type="button" title="戻る" value="" class="btn_back" onclick="javascript:doBack('<?php echo @constant('HOME_DIR');?>
CourseList/search')"></p>
				<table class="lessonRegist">
					<?php if (!empty($_smarty_tpl->tpl_vars['form']->value->course_id)) {?>
					<tr>
						<td style="width:240px;">
							<label class="lbl_name" >コースID<span class="required">※</span></label>
						</td>
						<td>
							<input id="course_id" name="course_id" type="text" class="text" maxlength="32" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->course_id;?>
" disabled="disabled">
						</td>
					</tr>
					<?php }?>
					<tr>
						<td>
							<label class="lbl_name" >コース名<span class="required">※</span></label>
						</td>
						<td>
							<input id="course_name" name="course_name" type="text" class="text" maxlength="32" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->course_name, ENT_QUOTES, 'UTF-8', true);?>
" >
						</td>
					</tr>
					<tr>
						<td>
							<label class="lbl_name">コース名（英語）<span class="required">※</span></label>
						</td>
						<td>
							<input id="course_name_romaji" name="course_name_romaji" type="text" class="text" maxlength="32" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->course_name_romaji, ENT_QUOTES, 'UTF-8', true);?>
">
						</td>
					</tr>
					<tr>
						<td>
							<label class="lbl_name">レベル<span class="required">※</span></label>
						</td>
						<td>
							<select name="course_level" id="course_level">
								<option value="">選択してください。</option>
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
										<?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['ctype']->value) {?>
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
					</tr>
					<tr>
						<td>
							<label class="lbl_name">SW<span class="required">※</span></label>
						</td>
						<td>
							<select name="test_kbn" id="test_kbn">
								<option value="">選択してください。</option>
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
										<label><?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
</label>
										<label><?php echo $_smarty_tpl->tpl_vars['form']->value->type;?>
</label>
										<?php if ($_smarty_tpl->tpl_vars['value']->value->type == $_smarty_tpl->tpl_vars['type']->value) {?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
" selected><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
										<?php } else { ?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['value']->value->type;?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value->name;?>
 </option>
										<?php }?>
									<?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_1_saved_local_item;
}
if ($__foreach_value_1_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_1_saved_item;
}
?>
								<?php }?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<label class="lbl_name">利用開始日<span class="required">※</span></label>
						</td>
						<td>
							<input id="start_period" name="start_period" type="text" maxlength="10" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period;?>
" onchange="changeDateFormat(this)">
						</td>
					</tr>
					<tr>
						<td>
							<label class="lbl_name">利用終了日<span class="required">※</span></label>
						</td>
						<td>
							<input id="end_period" name="end_period" type="text" maxlength="10" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period;?>
" onchange="changeDateFormat(this)">
						</td>
					</tr>
					<tr>
						<td>
							<label class="lbl_name">更新備考</label>
						</td>
						<td>
							<input id="remarks" name="remarks" type="text" class="text" maxlength="512" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->remarks, ENT_QUOTES, 'UTF-8', true);?>
">
						</td>
					</tr>
					<tr>
						<td>
							<label class="lbl_name">公開</label>
						</td>
						<td>
							<?php if ($_smarty_tpl->tpl_vars['status']->value == '0') {?>
								<label><input type="radio" name="status" value="0" id="status1" checked/>しない</label>
								<label><input type="radio" name="status" value="1" id="status2" />する</label>
							<?php }?>
							<?php if ($_smarty_tpl->tpl_vars['status']->value == '1') {?>
								<label><input type="radio" name="status" value="0" id="status1" />しない</label>
								<label><input type="radio" name="status" value="1" id="status2" checked/>する</label>
							<?php }?>
						</td>
					</tr>
				</table>
				<p style="text-align:right; padding-top: 70px;">
					<input type="submit" name="insert" title="登録" value="" class="btn_insert" style="padding-right: 50px;">
				</p>
				<input type="hidden" id="home_dir" value="<?php echo @constant('HOME_DIR');?>
" />
			</section>
			</div>
			<!--footer-->
				<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<!--footer-->
		</form>

		<?php echo '<script'; ?>
>
			

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
