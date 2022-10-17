<?php
/* Smarty version 3.1.29, created on 2022-10-13 11:46:26
  from "/var/www/html/eccadmin_dev/templates/lessonDataExport.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_63477c027dda27_73798891',
  'file_dependency' => 
  array (
    'f1efd54c3568de07eb51186961a0c4f695ed6902' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/lessonDataExport.html',
      1 => 1553488182,
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
function content_63477c027dda27_73798891 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title>レッスンデータ抽出</title>
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
				// MSGのあるなし
				if ( $(".error_msg").html() != "" ){
					$(".error_section").slideDown('slow')
				}
				$(".close_icon").on('click', function(){
					$(".error_section").slideUp('slow')
				});
				$(function() {
					//レッスン利用開始
					$('#start_period_start').datepicker({
						showOn : "button",
						buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
						dateFormat: 'yy/mm/dd',
						buttonImageOnly : true,
						beforeShow: function (input, inst) {
							setTimeout(function () {
								var leftWidth=($('.pushmenu-open').length>0)?$('#start_period_start').offset().left-$('.pushmenu-open')[0].offsetWidth
														:$('#start_period_start').offset().left;
								inst.dpDiv.css({
									top: $('#start_period_start').offset().top + 35,
									left: leftWidth
								});
							}, 0);
						}
					});
					$('#start_period_end').datepicker({
						showOn : "button",
						buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
						dateFormat: 'yy/mm/dd',
						buttonImageOnly : true,
						beforeShow: function (input, inst) {
							setTimeout(function () {
								var leftWidth=($('.pushmenu-open').length>0)?$('#start_period_end').offset().left-$('.pushmenu-open')[0].offsetWidth
														:$('#start_period_end').offset().left;
								inst.dpDiv.css({
									top: $('#start_period_end').offset().top + 35,
									left: leftWidth
								});
							}, 0);
						}
					});
					//レッスン利用終了
					$('#end_period_start').datepicker({
						showOn : "button",
						buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
						dateFormat: 'yy/mm/dd',
						buttonImageOnly : true,
						beforeShow: function (input, inst) {
							setTimeout(function () {
								var leftWidth=($('.pushmenu-open').length>0)?$('#end_period_start').offset().left-$('.pushmenu-open')[0].offsetWidth
														:$('#end_period_start').offset().left;
								inst.dpDiv.css({
									top: $('#end_period_start').offset().top + 35,
									left: leftWidth
								});
							}, 0);
						}
					});
					$('#end_period_end').datepicker({
						showOn : "button",
						buttonImage : "<?php echo @constant('HOME_DIR');?>
image/calendar.svg",
						dateFormat: 'yy/mm/dd',
						buttonImageOnly : true,
						beforeShow: function (input, inst) {
							setTimeout(function () {
								var leftWidth=($('.pushmenu-open').length>0)?$('#end_period_end').offset().left-$('.pushmenu-open')[0].offsetWidth
														:$('#end_period_end').offset().left;
								inst.dpDiv.css({
									top: $('#end_period_end').offset().top + 35,
									left: leftWidth
								});
							}, 0);
						}
					});
					//csvダウンロード処理
					$(".btn_csv_dl").on('click',function(e) {
						var org_id = document.getElementById('org_id').value;
						if ( $(".error_msg").html() != "" ){
							$(".error_section").slideUp('slow');
						}
						//組織IDチェック
						if ( org_id == "" ){
							$('#err_dis').show();
							$(".error_section").slideDown('slow');
							$(".error_msg").html("組織IDを入力してください。");
							$(".divBody").scrollTop(0);
							return false;
						}else if ( $('#start_period_start').val() != "" && $('#start_period_end').val() != "" && ($('#start_period_start').val() > $('#start_period_end').val() )) {
							$('#err_dis').show();
							$(".error_section").slideDown('slow');
							$(".error_msg").html("レッスン<?php echo @constant('W007');?>
");
							$(".divBody").scrollTop(0);
							return false;
						}else if ( ($('#start_period_start').val() != "" && !changeDateFormat(document.getElementById('start_period_start'))) || ($('#start_period_end').val() != "" && !changeDateFormat(document.getElementById('start_period_end'))) ) {
							$('#err_dis').show();
							$(".error_section").slideDown('slow');
							$(".error_msg").html("レッスン<?php echo @constant('W007');?>
");
							$(".divBody").scrollTop(0);
							return false;
						}else if ( $('#end_period_start').val() != "" && $('#end_period_end').val() != "" && ( $('#end_period_start').val() > $('#end_period_end').val() )) {
							$('#err_dis').show();
							$(".error_section").slideDown('slow');
							$(".error_msg").html("レッスン<?php echo @constant('W008');?>
");
							$(".divBody").scrollTop(0);
							return false;
						}else if ( ($('#end_period_start').val() != "" && !changeDateFormat(document.getElementById('end_period_start'))) || ($('#end_period_end').val() != "" && !changeDateFormat(document.getElementById('end_period_end'))) ) {
							$('#err_dis').show();
							$(".error_section").slideDown('slow');
							$(".error_msg").html("レッスン<?php echo @constant('W008');?>
");
							$(".divBody").scrollTop(0);
							return false;
						}
						return true;
					});
				});
			});
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
LessonDataExport/csvWoc" method="post">
			<!-- hidden start  -->
			<input type="hidden" name="org_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_name;?>
"/>
			<input type="hidden" id="db_org_id" name="db_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->db_org_id;?>
" />
			<!-- hidden end  -->
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
						><span class="title">データ抽出 / レッスン</span>
					</p>
					<table class="main_tbl" style="width:640px;">
						<tr>
							<td>組織ID<span class="required">※</span></td>
							<td colspan="3" class="input">
								<input class="text" type="text" name="org_id" id="org_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form']->value->org_id, ENT_QUOTES, 'UTF-8', true);?>
" maxlength = "10" size="10">
							</td>
						</tr>
						<tr>
							<td class="st_col">レッスン利用開始</td>
							<td class="input" >
								<input class="" type="text" name="start_period_start" id="start_period_start" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period_start;?>
" maxlength="10" />
							</td>
							<td width="10px">　～　</td>
							<td class="input">
								<input class="" type="text" name="start_period_end" id="start_period_end" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->start_period_end;?>
" maxlength="10" />
							</td>
						</tr>
						<tr>
							<td class="st_col">レッスン利用終了</td>
							<td class="input">
								<input class="" type="text" name="end_period_start" id="end_period_start" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period_start;?>
" maxlength="10" />
							</td>
							<td width="10px">　～　</td>
							<td class="input">
								<input class="" type="text" name="end_period_end" id="end_period_end" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->end_period_end;?>
" maxlength="10" />
							</td>
						</tr>
						<tr>
							<td colspan="3">
							</td>
							<td class="td-csv">
								<div style="float: right;padding-top:30px;">
									<input type="submit" value=""  class="btn_csv_dl" name="csv" title="抽出">
								</div>
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
			
		<?php echo '</script'; ?>
>
	</body>
</html><?php }
}
