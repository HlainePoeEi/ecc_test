<?php
/* Smarty version 3.1.29, created on 2022-10-16 05:50:23
  from "/var/www/html/eccadmin_dev/templates/login.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_634b1d0f89bba6_73905101',
  'file_dependency' => 
  array (
    'b7290120707a21c60ab6e52dab2e7e97ae05fee7' => 
    array (
      0 => '/var/www/html/eccadmin_dev/templates/login.html',
      1 => 1531219039,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:footer.html' => 1,
  ),
),false)) {
function content_634b1d0f89bba6_73905101 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<title>ログイン</title>
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

		<div id="divTitle" style="height:50px;padding-top:12px;">
			<div align="left" style="width: 50%; float:left;">
				&emsp;<span class="title"><font size="5"><b>運用管理用</b></font></span>
			</div>
			<div align="right" style="width: 50%; float:right;">
				<image src="<?php echo @constant('HOME_DIR');?>
image/top_logo.svg">
			</div>
		</div>
		<div id="login" align="center" >
			<table>
				<tr height="100px;">
					<td>
						<img src="<?php echo @constant('HOME_DIR');?>
image/login_id.svg" style="width:40px;height:40px;">
					</td>
					<td>
						<input id="login_id" name="login_id" type="text" autocomplete="off" width="250px;" value="<?php echo $_smarty_tpl->tpl_vars['login_id']->value;?>
" maxlength="20" placeholder="Login ID" style="ime-mode: disabled;">
					</td>
				</tr>
				<tr height="100px;">
					<td>
						<img src="<?php echo @constant('HOME_DIR');?>
image/pw.svg" style="width:40px;height:40px;">
					</td>
					<td>
						<input id="password" name="password" type="password" autocomplete="off" width="250px;" value="<?php echo $_smarty_tpl->tpl_vars['password']->value;?>
" maxlength="20" placeholder="Password" style="ime-mode: disabled;">
					</td>
				</tr>
			</table>
			<div style=" padding-top:20px;">
				<span style="text-align: center;"><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</span>
				</br></br>
				<!-- <input name="submit" type="submit" value="LOGIN" id="btnLogin" style="margin-left:10px;background-image:url(<?php echo @constant('HOME_DIR');?>
image/login.svg);background-size:35px 35px;"> -->
				<div>
					<input name="submit" type="submit" value="" id="btnLogin" style="background-image:url(<?php echo @constant('HOME_DIR');?>
image/login.svg);">
					<!-- <a href="" style="border-bottom: solid 1px #8eafd5; color: black; padding: 10px 0;">パスワード再発行はこちら</a> -->
				</div>

			</div>
		</div>
	</div>
	</form>
	<!--footer-->
		<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<!--footer-->
</body>
</html><?php }
}
