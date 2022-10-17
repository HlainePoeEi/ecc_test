<?php
/* Smarty version 3.1.29, created on 2022-10-13 17:06:05
  from "/var/www/html/eccadmin_dev/templates/menu.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_6347c6ed7193a5_76764330',
  'file_dependency' => 
  array (
    'fdc0a415d91ca93e70b76474debd5171639f0042' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/menu.html',
      1 => 1542678722,
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
function content_6347c6ed7193a5_76764330 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>TOP</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="robots" content="noindex, nofollow">
	<meta name="googlebot" content="noindex, nofollow">
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('HOME_DIR');?>
/js/jquery.min.js"><?php echo '</script'; ?>
>
	<link href="<?php echo @constant('HOME_DIR');?>
/css/default.css" rel="stylesheet">
	<link href="<?php echo @constant('HOME_DIR');?>
/css/menu.css" rel="stylesheet">
	<title>ECC Intersection</title>
	<?php echo '<script'; ?>
>
		$(document).ready(function(){
			// MSGのあるなし
            if ( $(".error_msg").html() != "" ) {
                $(".error_section").slideToggle('slow')
            }
            $(".close_icon").on('click', function(){
                $(".error_section").slideToggle('slow')
                $('#err_dis').slideToggle('slow')
            });

			$('.systemNotice tr').each(function() {
				var system_kbn = $(this).find(".kbn").html();
				if (system_kbn == 001){
					$(this).addClass('incharge_color');
				} else if (system_kbn == 002) {
					$(this).addClass('student_color');
				}else {
					$(this).addClass('mark_color');
				}
			});
		});
	<?php echo '</script'; ?>
>
</head>

<body class="pushmenu-push" >
	<form id="main_form" action="<?php echo @constant('HOME_DIR');?>
Menu/menu" method="post">
	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<div class="container">
			<div class="main">
				<!--header-->
				<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<!--header-->
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

				<?php if (!empty($_smarty_tpl->tpl_vars['statusArr']->value)) {?>
				<section>
					<div id = "maintenace_div">
						<?php
$_from = $_smarty_tpl->tpl_vars['statusArr']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_0_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$__foreach_value_0_saved_key = isset($_smarty_tpl->tpl_vars['key']) ? $_smarty_tpl->tpl_vars['key'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['value']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$__foreach_value_0_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
						<?php ob_start();
echo count($_smarty_tpl->tpl_vars['statusArr']->value);
$_tmp1=ob_get_clean();
if ($_smarty_tpl->tpl_vars['key']->value == $_tmp1-1) {?>
						<label><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</label>
						<?php } else { ?>
						<label><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
,</label>
						<?php }?>
						<?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_0_saved_local_item;
}
if ($__foreach_value_0_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_0_saved_item;
}
if ($__foreach_value_0_saved_key) {
$_smarty_tpl->tpl_vars['key'] = $__foreach_value_0_saved_key;
}
?>
						<label>側がシステムメンテナンス中です。</label>
					</div>
				</section>
				<?php }?>

				<section class="content">

					<div>
						<p class="p_title">システムお知らせ
							<span style="margin-left:309px;"> ログイン時刻:</span>
							<span style="float:right;margin-top:4px;"> <?php echo $_smarty_tpl->tpl_vars['login_time']->value;?>
</span>
						</p>
						<div>
							<table class="systemNoticeHeader" style="width:100%;">
								<tr>
								    <th style="width:150px;">投稿日時</th>
								    <th style="width:620px;">タイトル</th>
								    <th style="">対象者</th>
								    <th style="display:none">科目</th>
								</tr>
							</table>
							<div style="overflow-y:auto;height:400px;">
								<table class="systemNotice" style="width:100%;">
									<?php
$_from = $_smarty_tpl->tpl_vars['noticeList']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_obj_1_saved_item = isset($_smarty_tpl->tpl_vars['obj']) ? $_smarty_tpl->tpl_vars['obj'] : false;
$_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['obj']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['obj']->value) {
$_smarty_tpl->tpl_vars['obj']->_loop = true;
$__foreach_obj_1_saved_local_item = $_smarty_tpl->tpl_vars['obj'];
?>
										<tr>
											<td style="width:150px;">
												<?php echo $_smarty_tpl->tpl_vars['obj']->value->start_period;?>

											</td>
											<td style="width:620px;">
												<?php echo $_smarty_tpl->tpl_vars['obj']->value->description;?>

											</td>
											<td style="">
												<?php echo $_smarty_tpl->tpl_vars['obj']->value->name;?>

											</td>
											<td class="kbn" style="display:none">
												<?php echo $_smarty_tpl->tpl_vars['obj']->value->system_kbn;?>

											</td>
										</tr>
									 <?php
$_smarty_tpl->tpl_vars['obj'] = $__foreach_obj_1_saved_local_item;
}
if ($__foreach_obj_1_saved_item) {
$_smarty_tpl->tpl_vars['obj'] = $__foreach_obj_1_saved_item;
}
?>
								</table>
							</div>
						</div>
					</div>
				</section><!-- End Content -->

			</div><!-- End Main -->
		</div><!-- End Container -->
	</form>
	<!--footer-->
	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<!--footer-->
</body>
</html><?php }
}
