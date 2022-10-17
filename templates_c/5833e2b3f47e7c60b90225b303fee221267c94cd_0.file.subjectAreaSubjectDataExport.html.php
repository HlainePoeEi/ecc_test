<?php
/* Smarty version 3.1.29, created on 2022-10-17 05:25:34
  from "D:\xampp\htdocs\eccadmin_dev\templates\subjectAreaSubjectDataExport.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_634ccb2e27f953_02066746',
  'file_dependency' => 
  array (
    '5833e2b3f47e7c60b90225b303fee221267c94cd' => 
    array (
      0 => 'D:\\xampp\\htdocs\\eccadmin_dev\\templates\\subjectAreaSubjectDataExport.html',
      1 => 1552638122,
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
function content_634ccb2e27f953_02066746 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
	<title>教科：科目データ抽出</title>
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
		<link href="<?php echo @constant('HOME_DIR');?>
css/style.css" rel="stylesheet">
		<?php echo '<script'; ?>
 type="text/javascript">
			$(document).ready(function() {
				// MSGのあるなし
				if ( $(".error_msg").html() != "" ){
					$(".error_section").slideDown('slow')
				}

				$(".close_icon").on('click', function(){
					$(".error_section").slideUp('slow')
				});
			});

			// csvダウンロード処理
			function csvDownload(){
				var menuOpen = document.getElementById('menuOpen').value;
				var menuStatus = document.getElementById('menuStatus').value;
				var org_id = document.getElementById('org_id').value;

				if ( $(".error_msg").html() != "" ){
					$(".error_section").slideUp('slow');
					$(".error_msg").html("");
				}

				if ( org_id == "" ){
					$('#err_dis').show();
					$(".error_section").slideDown('slow');
					$(".error_msg").html("組織IDを入力してください。");
					$(".divBody").scrollTop(0);
					return false;

				}else {
					$("#hidorg_id").val(org_id);
					$("#menuOpen").val(menuOpen);
					$("#menuStatus").val(menuStatus);
					$("#main_form").submit();
				}
			}
		<?php echo '</script'; ?>
>
	</head>
	<body class="pushmenu-push">
		<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
SubjectAreaSubjectDataExport/csvWoc" method="post">
			<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<div class="divHeader">
				<!--header-->
				<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--header-->
			</div>
			<div class="divBody">
				<input type="hidden" id="org_name" name="org_name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->org_name;?>
">
				<input type="hidden" id="db_org_id" name="db_org_id" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->db_org_id;?>
">
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
						><span class="title"> データ抽出 / 教科：科目 </span>
					</p>
					<table class="main_tbl" style="width:50%">
						<tr>
							<td>組織ID<span class="required">※</span></td>
							<td><input type="text" class="text" id="org_id" name="org_id" value="<?php echo $_smarty_tpl->tpl_vars['org_id']->value;?>
" size="30"/>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<div style="padding-left: 150px;padding-top:30px;">
									<input class="btn_csv_dl" name="csv" type="button" value="" title="抽出" onclick="csvDownload()">
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
	</body>
</html><?php }
}
