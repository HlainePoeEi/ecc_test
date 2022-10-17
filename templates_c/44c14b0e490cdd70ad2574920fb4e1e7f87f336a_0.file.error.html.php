<?php
/* Smarty version 3.1.29, created on 2022-10-13 17:04:46
  from "/var/www/html/eccadmin_dev/templates/error.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_6347c69e6f2e53_96440860',
  'file_dependency' => 
  array (
    '44c14b0e490cdd70ad2574920fb4e1e7f87f336a' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/error.html',
      1 => 1520035509,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:footer.html' => 1,
  ),
),false)) {
function content_6347c69e6f2e53_96440860 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>エラー</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href="<?php echo @constant('HOME_DIR');?>
css/login.css" rel="stylesheet" type="text/css"/>
	
	<?php echo '<script'; ?>
	src="<?php echo @constant('HOME_DIR');?>
js/jquery.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
	src="<?php echo @constant('HOME_DIR');?>
js/common.js"><?php echo '</script'; ?>
>
	
	<link href="<?php echo @constant('HOME_DIR');?>
css/default.css" rel="stylesheet">
</head>
<body id="body" class="pushmenu-push">
	<form action="<?php echo @constant('HOME_DIR');?>
Login/login" method="post" style="margin:0px;padding:0px">
		<div id="divOuterFrame" align="center" >
		
			<div id="divTitle" style="height:60px;padding-top:7px;">
				<image src="<?php echo @constant('HOME_DIR');?>
image/top_logo.svg">
			</div>
			<div id="msg" style="margin-top:30px;font-size: 20px;">
				<?php echo $_smarty_tpl->tpl_vars['data']->value['message'];?>

			</div>
			<div id="msg" style="margin-top:30px;font-size: 20px;">
				<a href="https://ecc-intersection.com<?php echo @constant('HOME_DIR');?>
Login">
				ログインページへ
				</a>
			</div>
		<!--footer-->
		<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<!--footer-->
		</div>
	</form>
</body>
</html><?php }
}
